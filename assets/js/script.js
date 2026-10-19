// 1. Defina a ordem das URLs (Light primeiro)
// const lightTileUrl = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
// const darkTileUrl = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
// Alterado para reduzir necessidade de utilização de API KEY
const lightTileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const darkTileUrl = 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png';

// Inicialização do Mapa
const map = L.map('map').setView([-23.55052, -46.633309], 12);

// 2. Carregue o 'lightTileUrl' ao iniciar o mapa
let currentTileLayer = L.tileLayer(lightTileUrl, {
    attribution: '&copy; OpenStreetMap &copy; CARTO',
    maxZoom: 19
}).addTo(map);
// Marcadores de Exemplo

/**
 * Marcadores reais de ocorrências do Alagaweb.
 * A variável "map" deve ter sido inicializada anteriormente.
 */

const camadaOcorrencias = L.layerGroup().addTo(map);

// Ajuste para o caminho real do endpoint no seu projeto.
const urlOcorrencias = 'controllers/ListarOcorrencias.php';

function obterCorRisco(nivelAgua) {
    const risco = String(nivelAgua || '')
        .trim()
        .toUpperCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');

    if (risco.includes('MEDIO')) {
        return '#ffc107'; // Amarelo
    }

    if (risco.includes('BAIXO')) {
        return '#198754'; // Verde
    }

    if (risco.includes('ALTO')) {
        return '#dc3545'; // Vermelho
    }

    return '#0d6efd'; // Azul: risco não informado ou desconhecido
}

function criarPopupOcorrencia(ocorrencia) {
    // Usar textContent evita interpretar a descrição como HTML.
    const container = document.createElement('div');

    const titulo = document.createElement('strong');
    titulo.textContent = 'Ocorrência #' + ocorrencia.id_ocorrencia;
    container.appendChild(titulo);

    const descricao = document.createElement('p');
    descricao.textContent =
        ocorrencia.descricao || 'Sem descrição informada';
    descricao.style.margin = '8px 0';
    container.appendChild(descricao);

    const status = document.createElement('p');
    status.textContent =
        'Status: ' + (ocorrencia.status || 'Não informado');
    status.style.margin = '4px 0';
    container.appendChild(status);

    const risco = document.createElement('p');
    risco.textContent =
        'Risco da região: ' +
        (ocorrencia.nivel_agua || 'Não informado');
    risco.style.margin = '4px 0';
    container.appendChild(risco);

    return container;
}

async function carregarOcorrenciasMapa() {
    try {
        const resposta = await fetch(urlOcorrencias, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            },
            cache: 'no-store'
        });

        if (!resposta.ok) {
            throw new Error(
                'O servidor respondeu com HTTP ' + resposta.status
            );
        }

        const dados = await resposta.json();

        if (!Array.isArray(dados)) {
            throw new Error(
                dados.erro || 'A resposta da API não é uma lista.'
            );
        }

        // Evita duplicar marcadores se a função for chamada novamente.
        camadaOcorrencias.clearLayers();

        dados.forEach(function (ocorrencia) {
            const lat = Number(ocorrencia.latitude);
            const lng = Number(ocorrencia.longitude);

            // Ignora registros com coordenadas inválidas.
            if (
                ocorrencia.latitude === null ||
                ocorrencia.longitude === null ||
                ocorrencia.latitude === '' ||
                ocorrencia.longitude === '' ||
                !Number.isFinite(lat) ||
                !Number.isFinite(lng) ||
                lat < -90 || lat > 90 ||
                lng < -180 || lng > 180
            ) {
                return;
            }

            const marcador = L.circleMarker([lat, lng], {
                radius: 8,
                color: '#ffffff',
                weight: 2,
                fillColor: obterCorRisco(ocorrencia.nivel_agua),
                fillOpacity: 0.9
            });

            marcador.bindPopup(criarPopupOcorrencia(ocorrencia));

            marcador.addTo(camadaOcorrencias);
        });

        console.info(
            'Ocorrências carregadas no mapa:',
            camadaOcorrencias.getLayers().length
        );

    } catch (erro) {
        console.error(
            'Erro ao carregar ocorrências do Alagaweb:',
            erro
        );
    }
}

// Carrega os registros quando o mapa já está inicializado.
carregarOcorrenciasMapa();

// Alternador de Tema
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    const themeIcon = document.getElementById('themeIcon');

    html.setAttribute('data-bs-theme', newTheme);

    // Atualiza o Ícone do Botão
    if (newTheme === 'dark') {
        themeIcon.className = 'bi bi-sun-fill';
        map.removeLayer(currentTileLayer);
        currentTileLayer = L.tileLayer(darkTileUrl, { attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 19 }).addTo(map);
    } else {
        themeIcon.className = 'bi bi-moon-stars-fill';
        map.removeLayer(currentTileLayer);
        currentTileLayer = L.tileLayer(lightTileUrl, { attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 19 }).addTo(map);
    }
}

// Geolocalização do Usuário
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 15);
            L.marker([lat, lng]).addTo(map).bindPopup("Você está aqui!").openPopup();
        }, () => {
            alert("Não foi possível obter sua localização.");
        });
    } else {
        alert("Navegador não suporta geolocalização.");
    }
}

// Pesquisa de Endereço via Nominatim
async function searchAddress() {

    const mensagem = document.getElementById("localizacaoMsg");

    const query = document.getElementById('addressInput').value;
    if (!query) return;

    map.eachLayer((layer) => {
        // Remove marcadores e círculos
        if (layer instanceof L.Marker || layer instanceof L.Circle) {
            map.removeLayer(layer);
        }
    });

    mensagem.textContent = "Consultando...";

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(async data => {
            if (data.length > 0) {
                const { lat, lon } = data[0];
                const risco = await calcRisco(lat, lon);
                map.setView([lat, lon], 15);
                L.marker([lat, lon]).addTo(map).bindPopup(query).openPopup();
                L.circle([lat, lon], { color: risco.cor, fillOpacity: 0.4, radius: 250 }).addTo(map).bindPopup(query).openPopup();
                mensagem.textContent =
                "Consultar";
            } else {
                mensagem.textContent = "Endereço não encontrado.";
            }
        });
}

function calcRisco(lat, long) {
    const formData = new FormData();
    formData.append('latitude', lat);
    formData.append('longitude', long);
    return fetch('controllers/OcorrenciaController.php', {
        method: 'POST',
        body: formData
    })
        .then(data => data.json())
        .then(data => {
            console.log("Risco calculado:", data);
            switch (data.risco) {
                case 'ALTO':
                    data.cor = '#ff4d4d';
                    break;
                case 'MEDIO':
                    data.cor = '#ffa64d';
                    break;
                default:
                    data.cor = '#2ed573';
            }
            return data;
        });
}


// Prepara os campos automáticos do formulário antes de abrir o modal
function prepareOccurrenceForm() {
    // Define a Data e Hora atual no formato aceito pelo input datetime-local
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('data_hora').value = now.toISOString().slice(0, 16);

}


// Localizar coordenadas ocorrência

document.getElementById("btnLocalizacao").addEventListener("click", function () {

    const mensagem = document.getElementById("localizacaoMensagem");

    if (!navigator.geolocation) {
        mensagem.textContent = "Seu navegador não oferece suporte à localização.";
        return;
    }

    mensagem.textContent = "Obtendo sua localização...";

    navigator.geolocation.getCurrentPosition(
        function (position) {
            document.getElementById("latitude").value =
                position.coords.latitude;

            document.getElementById("longitude").value =
                position.coords.longitude;

            mensagem.textContent =
                "Localização obtida com sucesso. Confirme o endereço antes de enviar.";
        },
        function () {
            mensagem.textContent =
                "Não foi possível obter sua localização. Informe o endereço manualmente.";
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
});


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
const points = [
    { lat: -23.55052, lng: -46.633309, title: "Rua XPTO", risk: "Alto Risco", color: "#dc3545" },
    { lat: -23.56152, lng: -46.655309, title: "Avenida Brasil", risk: "Atenção", color: "#ffc107" },
    { lat: -23.57052, lng: -46.623309, title: "Jardim América", risk: "Seguro", color: "#198754" }
];

points.forEach(point => {
    L.circleMarker([point.lat, point.lng], {
        color: point.color,
        fillColor: point.color,
        fillOpacity: 0.8,
        radius: 10
    }).addTo(map).bindPopup(`<b>${point.title}</b><br>Status: ${point.risk}`);
});

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
    const query = document.getElementById('addressInput').value;
    if (!query) return;

    map.eachLayer((layer) => {
        // Remove marcadores e círculos
        if (layer instanceof L.Marker || layer instanceof L.Circle) {
            map.removeLayer(layer);
        }
    });

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(async data => {
            if (data.length > 0) {
                const { lat, lon } = data[0];
                const risco = await calcRisco(lat, lon);
                map.setView([lat, lon], 15);
                L.marker([lat, lon]).addTo(map).bindPopup(query).openPopup();
                L.circle([lat, lon], { color: risco.cor, fillOpacity: 0.4, radius: 250 }).addTo(map).bindPopup(query).openPopup();
            } else {
                alert("Endereço não encontrado.");
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

    // Obtém o centro atual do mapa como referência inicial de coordenadas
    const center = map.getCenter();
    document.getElementById('latitude').value = center.lat.toFixed(6);
    document.getElementById('longitude').value = center.lng.toFixed(6);
}


// Manipula o envio do formulário simulando o envio para o banco de dados
function handleOccurrenceSubmit(event) {
    event.preventDefault();

    // Captura dos dados mapeados pela tabela
    const formData = {
        id_usuario: document.getElementById('id_usuario').value,
        id_regiao: document.getElementById('id_regiao').value,
        descricao: document.getElementById('descricao').value,
        latitude: parseFloat(document.getElementById('latitude').value),
        longitude: parseFloat(document.getElementById('longitude').value),
        nivel_agua: document.getElementById('nivel_agua').value,
        status: document.getElementById('status').value,
        data_hora: document.getElementById('data_hora').value
    };

    console.log("Objeto pronto para o Banco de Dados:", formData);

    // Adiciona o novo ponto no mapa dinamicamente
    const markerColor = formData.nivel_agua === 'alto' ? '#dc3545' : (formData.nivel_agua === 'medio' ? '#ffc107' : '#198754');

    L.circleMarker([formData.latitude, formData.longitude], {
        color: markerColor,
        fillColor: markerColor,
        fillOpacity: 0.8,
        radius: 12
    }).addTo(map).bindPopup(`<b>Ocorrência Registrada!</b><br>${formData.descricao}`).openPopup();

    // Fecha o modal e exibe mensagem
    const modalElement = document.getElementById('occurrenceModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    modal.hide();

    alert('Ocorrência registrada com sucesso!');
    document.getElementById('occurrenceForm').reset();
}
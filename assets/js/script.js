// 1. Defina a ordem das URLs (Light primeiro)
const lightTileUrl = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
const darkTileUrl = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';

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
function searchAddress() {
    const query = document.getElementById('addressInput').value;
    if(!query) return;

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            if(data.length > 0) {
                const { lat, lon } = data[0];
                map.setView([lat, lon], 14);
                L.marker([lat, lon]).addTo(map).bindPopup(query).openPopup();
            } else {
                alert("Endereço não encontrado.");
            }
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


document.addEventListener("DOMContentLoaded", function () {

    const detailsModal = document.getElementById("detailsOccurrenceModal");

    detailsModal.addEventListener("show.bs.modal", function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute("data-id");
        const regiao = button.getAttribute("data-regiao");
        const nivel = button.getAttribute("data-nivel");
        const data = button.getAttribute("data-data");
        const status = button.getAttribute("data-status");
        const descricao = button.getAttribute("data-descricao");
        const latitude = button.getAttribute("data-latitude");
        const longitude = button.getAttribute("data-longitude");

        document.getElementById("detailsId").textContent = "#" + id;
        document.getElementById("detailsRegiao").textContent = "Região #" + regiao;
        document.getElementById("detailsNivel").textContent = nivel;
        document.getElementById("detailsData").textContent = formatarData(data);
        document.getElementById("detailsStatus").textContent = status;
        document.getElementById("detailsDescricao").textContent = descricao;

        document.getElementById("detailsLatitude").textContent =
            latitude || "Não informada";

        document.getElementById("detailsLongitude").textContent =
            longitude || "Não informada";
    });

    function formatarData(data) {
        if (!data) {
            return "Não informada";
        }

        const dataFormatada = new Date(data);

        if (isNaN(dataFormatada.getTime())) {
            return data;
        }

        return dataFormatada.toLocaleString("pt-BR");
    }
});
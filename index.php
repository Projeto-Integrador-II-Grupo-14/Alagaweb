<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Monitoramento Inteligente de Alagamentos</title>
        <link rel="shortcut icon" href="https://s3.amazonaws.com/pix.iemoji.com/images/emoji/apple/ios-18/256/0894.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>

        <?php 
            if (isset($_SESSION['usuario'])) {
                include "includes/menu_usuario.php";
            } else {
                include "includes/menu_principal.php";
            }
        ?>

        <div class="container-fluid px-3 px-md-4">
            <div class="row justify-content-center my-4">
                <div class="col-lg-8 text-center">
                    <h1 class="fw-bold mb-3 display-6">🌧️ Monitoramento Inteligente de Alagamentos</h1>
                    <p class="opacity-75 mb-4">Acompanhe em tempo real a situação das vias e riscos de alagamento na sua região.</p>
                    
                    <div class="glass-card p-3 shadow-lg">
                        <div class="row g-2">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent custom-input">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="addressInput" class="form-control bg-transparent custom-input" placeholder="Pesquisar endereço ou bairro...">
                                </div>
                            </div>
                            <div class="col-md-5 d-flex gap-2">
                                <button class="btn btn-primary w-100 rounded-3" onclick="searchAddress()">
                                    Consultar
                                </button>
                                <button class="btn btn-outline-secondary w-100 rounded-3 d-flex align-items-center justify-content-center gap-1" onclick="getLocation()">
                                    <i class="bi bi-crosshair"></i> Minha localização
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                <span class="status-badge bg-success bg-opacity-20 text-success border border-success text-light">
                    🟢 Seguro
                </span>
                <span class="status-badge bg-warning bg-opacity-20 text-warning border border-warning text-light">
                    🟠 Atenção
                </span>
                <span class="status-badge bg-danger bg-opacity-20 text-danger border border-danger text-light">
                    🔴 Alto Risco
                </span>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="glass-card p-2 shadow">
                        <div id="map"></div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history text-primary"></i> Últimas Ocorrências
                        </h5>
                        <div class="list-group list-group-flush bg-transparent">
                            <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center border-bottom px-0">
                                <span><i class="bi bi-circle-fill text-danger me-2"></i> Rua XPTO - Ponto crítico de alagamento</span>
                                <small class="opacity-75">Há 5 min</small>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center border-bottom px-0">
                                <span><i class="bi bi-circle-fill text-warning me-2"></i> Avenida Brasil - Acúmulo de água na via</span>
                                <small class="opacity-75">Há 18 min</small>
                            </div>
                            <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center border-0 px-0">
                                <span><i class="bi bi-circle-fill text-success me-2"></i> Jardim América - Trânsito normalizado</span>
                                <small class="opacity-75">Há 42 min</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-5">
                <div class="col-6 col-md-3">
                    <div class="glass-card p-3 text-center">
                        <i class="bi bi-exclamation-triangle fs-3 text-warning"></i>
                        <h3 class="fw-bold my-1">24</h3>
                        <small class="opacity-75">Ocorrências</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-card p-3 text-center">
                        <i class="bi bi-map fs-3 text-info"></i>
                        <h3 class="fw-bold my-1">12</h3>
                        <small class="opacity-75">Regiões</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-card p-3 text-center">
                        <i class="bi bi-people fs-3 text-primary"></i>
                        <h3 class="fw-bold my-1">1.4k</h3>
                        <small class="opacity-75">Usuários</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-card p-3 text-center">
                        <i class="bi bi-bell fs-3 text-danger"></i>
                        <h3 class="fw-bold my-1">3</h3>
                        <small class="opacity-75">Alertas Ativos</small>
                    </div>
                </div>
            </div>
        </div>

        <?php include "includes/forms_cadastro.php"; ?>
        <?php include "includes/forms_login.php"; ?>
       
        <?php 
           if (isset($_SESSION['usuario'])) {

                include "includes/forms_ocorrencia.php"; 

            } else {
    
            };
        
        ?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="assets/js/script.js"></script>

        <?php include "includes/alerts.php"; ?>
        
    </body>
</html>
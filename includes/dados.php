<?php

require_once "config/database.php";
require_once "models/Ocorrencia.php";

$dashboardController = new Ocorrencia($pdo);

$indicadores = $dashboardController->obterIndicadores();

$totalOcorrencias = (int) ($indicadores['total_ocorrencias'] ?? 0);
$totalRegioes = (int) ($indicadores['total_regioes'] ?? 0);
$totalUsuarios = (int) ($indicadores['total_usuarios'] ?? 0);
$regioesAltoRisco = (int) ($indicadores['regioes_alto_risco'] ?? 0);


?>


<div class="row g-3 mb-5" id="estatisticas">

    <!-- Total de ocorrências -->
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center h-100">
            <i class="bi bi-exclamation-triangle fs-3 text-warning"></i>

            <h3 class="fw-bold my-1">
                <?= number_format($totalOcorrencias, 0, ',', '.') ?>
            </h3>

            <small class="opacity-75">Ocorrências registradas</small>
        </div>
    </div>

    <!-- Regiões monitoradas -->
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center h-100">
            <i class="bi bi-map fs-3 text-info"></i>

            <h3 class="fw-bold my-1">
                <?= number_format($totalRegioes, 0, ',', '.') ?>
            </h3>

            <small class="opacity-75">Regiões monitoradas</small>
        </div>
    </div>

    <!-- Usuários cadastrados -->
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center h-100">
            <i class="bi bi-people fs-3 text-primary"></i>

            <h3 class="fw-bold my-1">
                <?= number_format($totalUsuarios, 0, ',', '.') ?>
            </h3>

            <small class="opacity-75">Usuários cadastrados</small>
        </div>
    </div>

    <!-- Regiões de alto risco -->
    <div class="col-6 col-md-3">
        <div class="glass-card p-3 text-center h-100">
            <i class="bi bi-shield-exclamation fs-3 text-danger"></i>

            <h3 class="fw-bold my-1">
                <?= number_format($regioesAltoRisco, 0, ',', '.') ?>
            </h3>

            <small class="opacity-75">Regiões de alto risco</small>
        </div>
    </div>

</div>

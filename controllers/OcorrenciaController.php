<?php
require_once "../config/database.php";
require_once "../utils/GeoReferenciamento.php";
require_once "../utils/Clima.php";
require_once "../models/Ocorrencia.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php");
    exit;
}

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

$ocorrenciaModel = new Ocorrencia($pdo);

$metereologia = ClimaService::obterDadosMetereologicos($latitude, $longitude);
$riscoRegiao = $ocorrenciaModel->buscarRiscoRegiao($latitude, $longitude);

/************* RESULTADO FINAL *************/

// Multiplicador de acordo com o histórico do local
$multiplicadores = [
    'BAIXO'   => 1.0,
    'MEDIO'   => 1.2,
    'ALTO'    => 1.4,
    'CRITICO' => 1.6
    ];
$M = $multiplicadores[strtoupper($riscoRegiao['nivel_risco'])] ?? 1.0;
    
// Fator de retenção de água do solo de acordo com fundamentação teórica e utilizado para cáluclos gerais
$F = 0.85;
    
// IPA: Índice de Precipitação Antecedente
$ipa = (($metereologia['chuva_ontem'] * $F) + $metereologia['chuva_hoje']) * $M;

// Classificação do risco de alagamento com base no IPA
if ($ipa >= 90) {
    $nivel = 'ALTO';
} elseif ($ipa >= 60) {
    $nivel = 'MEDIO';
} elseif ($ipa >= 30) {
    $nivel = 'BAIXO';
} else {
    $nivel = 'NORMAL';
}

echo json_encode([
    'metereologia' => $metereologia,
    'risco' => $nivel
]);

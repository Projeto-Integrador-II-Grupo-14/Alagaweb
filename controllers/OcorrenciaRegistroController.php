<?php

session_start();

require_once "../config/database.php";
require_once "../models/Ocorrencia.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php?erro=nao_logado");
    exit;
}

$idUsuario = $_SESSION['usuario']['id'];

$idRegiao = $_POST['id_regiao'] ?? '';
$nivelAgua = $_POST['nivel_agua'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$dataHora = $_POST['data_hora'] ?? '';
$descricao = trim($_POST['descricao'] ?? '');

if (
    $idRegiao === '' ||
    $nivelAgua === '' ||
    $latitude === '' ||
    $longitude === '' ||
    $dataHora === '' ||
    $descricao === ''
) {
    header("Location: ../index.php?erro=ocorrencia_campos");
    exit;
}

if (!is_numeric($latitude) || !is_numeric($longitude)) {
    header("Location: ../index.php?erro=coordenadas_invalidas");
    exit;
}

if (!in_array($nivelAgua, ['baixo', 'medio', 'alto'], true)) {
    header("Location: ../index.php?erro=nivel_invalido");
    exit;
}

$ocorrenciaModel = new Ocorrencia($pdo);

$sucesso = $ocorrenciaModel->cadastrar(
    $idUsuario,
    $idRegiao,
    $nivelAgua,
    $latitude,
    $longitude,
    $dataHora,
    $descricao
);

if ($sucesso) {
    header("Location: ../index.php?ocorrencia=sucesso");
    exit;
}

header("Location: ../index.php?erro=ocorrencia");
exit;
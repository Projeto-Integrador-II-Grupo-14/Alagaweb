<?php

session_start();

require_once "../config/database.php";
require_once "../models/Ocorrencia.php";


header('Content-Type: application/json; charset=utf-8');

try {
    $ocorrenciaModel = new Ocorrencia($pdo);
    $ocorrencias = $ocorrenciaModel->listarOcorrenciasMapa();

    echo json_encode(
        $ocorrencias,
        JSON_UNESCAPED_UNICODE
        | JSON_UNESCAPED_SLASHES
        | JSON_THROW_ON_ERROR
    );

} catch (Throwable $e) {
    error_log(
        'Erro ao listar ocorrências no mapa: ' . $e->getMessage()
    );

    http_response_code(500);

    echo json_encode([
        'erro' => 'Não foi possível carregar as ocorrências.'
    ], JSON_UNESCAPED_UNICODE);
}


<?php

session_start();

require_once "../config/database.php";
require_once "../models/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php?erro=nao_logado");
    exit;
}

$id = $_SESSION['usuario']['id'];

$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$novaSenha = $_POST['nova_senha'] ?? '';

if ($nome === '') {
    header("Location: ../index.php?erro=nome_obrigatorio");
    exit;
}

if ($novaSenha !== '' && strlen($novaSenha) < 8) {
    header("Location: ../index.php?erro=senha_curta");
    exit;
}

$usuarioModel = new Usuario($pdo);

$atualizouCadastro = $usuarioModel->atualizar(
    $id,
    $nome,
    $telefone
);

$alterouSenha = true;

if ($novaSenha !== '') {
    $alterouSenha = $usuarioModel->atualizarSenha(
        $id,
        $novaSenha
    );
}

if ($atualizouCadastro && $alterouSenha) {
    // Atualiza os dados armazenados na sessão
    $_SESSION['usuario']['nome'] = $nome;
    $_SESSION['usuario']['telefone'] = $telefone;

    header("Location: ../index.php?perfil=sucesso");
    exit;
}

header("Location: ../index.php?erro=perfil");
exit;
<?php

session_start();

require_once "../config/database.php";
require_once "../models/Usuario.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php");
    exit;
}

$email = trim($_POST['email']);
$senha = $_POST['senha'];

$usuarioModel = new Usuario($pdo);
$usuario = $usuarioModel->buscarPorEmail($email);

if (!$usuario || !password_verify($senha, $usuario['senha'])) {

    $_SESSION['erro_login'] = "E-mail ou senha inválidos.";

    header("Location: ../index.php?erro_login=erro");
    exit;
}

// Login OK

$_SESSION['usuario'] = [
    'id' => $usuario['id_usuario'],
    'nome' => $usuario['nome'],
    'email' => $usuario['email'],
    'telefone' => $usuario['telefone'],
    'tipo' => $usuario['tipo'],
    'data_cadastro' => $usuario['data_cadastro']
];

header("Location: ../index.php?login=sucesso");
exit;
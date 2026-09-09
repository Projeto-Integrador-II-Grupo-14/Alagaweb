<?php

require_once "../config/database.php";
require_once "../models/Usuario.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$telefone = trim($_POST['telefone']);
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmarSenha'];


// Confirma senha
if ($senha !== $confirmarSenha) {
    header("Location: ../index.php?erro=senha");
    exit;
}

$usuario = new Usuario($pdo);

// Verifica se o e-mail já existe
if ($usuario->emailExiste($email)) {
    header("Location: ../index.php?email_existe=email_existe");
    exit;
}

if ($usuario->cadastrar($nome, $email, $senha, $telefone)) {

    header("Location: ../index.php?cadastro=sucesso");
    exit;

} else {

    echo "Erro ao cadastrar.";

}
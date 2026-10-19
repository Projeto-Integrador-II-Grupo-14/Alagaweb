<?php

class Usuario
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function cadastrar($nome, $email, $senha, $telefone)
    {
        $sql = "INSERT INTO usuarios
                (nome,email,senha,telefone)
                VALUES
                (:nome,:email,:senha,:telefone)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":nome" => $nome,
            ":email" => $email,
            ":senha" => password_hash($senha, PASSWORD_DEFAULT),
            ":telefone" => $telefone
        ]);
    }

    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":email", $email);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExiste($email)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function atualizar($id, $nome, $telefone)
    {
        $sql = "UPDATE usuarios
                SET nome = :nome,
                    telefone = :telefone
                WHERE id_usuario = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":nome" => $nome,
            ":telefone" => $telefone
        ]);
    }

    public function atualizarSenha($id, $novaSenha)
    {
        $sql = "UPDATE usuarios
                SET senha = :senha
                WHERE id_usuario = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":senha" => password_hash($novaSenha, PASSWORD_DEFAULT)
        ]);
    }

    
}
<?php

class Ocorrencia
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function cadastrar(
        $idUsuario,
        $idRegiao,
        $nivelAgua,
        $latitude,
        $longitude,
        $dataHora,
        $descricao
    ) {
        $sql = "INSERT INTO ocorrencias
                (
                    id_usuario,
                    id_regiao,
                    nivel_agua,
                    latitude,
                    longitude,
                    data_hora,
                    descricao,
                    status
                )
                VALUES
                (
                    :id_usuario,
                    :id_regiao,
                    :nivel_agua,
                    :latitude,
                    :longitude,
                    :data_hora,
                    :descricao,
                    :status
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id_usuario" => $idUsuario,
            ":id_regiao" => $idRegiao,
            ":nivel_agua" => $nivelAgua,
            ":latitude" => $latitude,
            ":longitude" => $longitude,
            ":data_hora" => $dataHora,
            ":descricao" => $descricao,
            ":status" => "Em Análise"
        ]);
    }

    public function listarPorUsuario($idUsuario)
    {
        $sql = "SELECT
                    id_ocorrencia,
                    id_regiao,
                    nivel_agua,
                    data_hora,
                    status,
                    descricao
                FROM ocorrencias
                WHERE id_usuario = :id_usuario
                ORDER BY data_hora DESC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ":id_usuario" => $idUsuario
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

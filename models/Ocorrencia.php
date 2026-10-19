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

    public function buscarRiscoRegiao($latitude, $longitude)
    {
        $sql = "SELECT nivel_risco FROM regioes r WHERE ST_Contains(poligono, ST_SetSRID(ST_Point(:longitude, :latitude), 4326))";
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":longitude", $longitude);
        $stmt->bindValue(":latitude", $latitude);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function listarOcorrenciasMapa(): array
    {
        $sql = "SELECT
                id_ocorrencia,
                descricao,
                latitude,
                longitude,
                status,
                nivel_agua
            FROM ocorrencias o
            LEFT JOIN regioes r
                ON id = id_regiao
            WHERE
                latitude IS NOT NULL
                AND longitude IS NOT NULL
                AND latitude BETWEEN -90 AND 90
                AND longitude BETWEEN -180 AND 180
            ORDER BY data_hora DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function listarUltimasOcorrencias(int $limite = 5): array
    {
        $sql = "SELECT
                id_ocorrencia,
                descricao,
                status,
                data_hora,
                nivel_agua
            FROM ocorrencias o
            LEFT JOIN regioes r
                ON id = id_regiao
            ORDER BY id_ocorrencia DESC
            LIMIT :limite";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterIndicadores(): array
    {
        $sql = "
            SELECT
                (SELECT COUNT(*)
                 FROM ocorrencias) AS total_ocorrencias,

                (SELECT COUNT(*)
                 FROM regioes) AS total_regioes,

                (SELECT COUNT(*)
                 FROM usuarios) AS total_usuarios,

                (SELECT COUNT(*)
                 FROM regioes
                 WHERE
                    UPPER(COALESCE(nivel_risco, '')) LIKE '%ALTO%'
                    OR UPPER(COALESCE(nivel_risco, '')) LIKE '%CRITICO%'
                    OR UPPER(COALESCE(nivel_risco, '')) LIKE '%CRÍTICO%'
                ) AS regioes_alto_risco
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }


}

<?php

class Ocorrencia
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function cadastrarOcorrencia()
    {
        return false;
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

}

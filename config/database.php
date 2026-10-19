<?php

$host = "db.vapquaogbccjekvlpzhg.supabase.co";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "alagaweb0111";

try {

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erro ao conectar: " . $e->getMessage());

}
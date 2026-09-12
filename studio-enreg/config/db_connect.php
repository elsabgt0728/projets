<?php


function getPDOConnection()
{
    static $pdo_instance;
    if (isset($pdo_instance)) {
        return $pdo_instance;
    }

    $host = "localhost" . ':' . 3306;
    $dbname = "studio_repetition";
    $user = "root";
    $pass = "";
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo_instance = $pdo;
        return $pdo_instance ;
    } catch (PDOException $e) {
        throw new Exception("Erreur de connexion SQL : " . $e->getMessage());
    }

}

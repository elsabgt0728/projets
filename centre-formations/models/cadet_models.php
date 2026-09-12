<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

    
function cadet_info($cadet_id) {
    global $pdo;
    $requete = $pdo ->prepare("SELECT * FROM cadet WHERE cadet_id = :id");
    $requete->execute([":id" => $cadet_id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}
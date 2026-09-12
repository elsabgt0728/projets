<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function date_jour_exists($date_jour, $id_ressource) {
    global $pdo;

    $requete = $pdo->prepare("
        SELECT 1 
        FROM reservation
        WHERE date_jour = :date_jour
        AND id_ressource = :id_ressource
        LIMIT 1
    ");

    $requete->execute([
        ':date_jour' => $date_jour,
        ':id_ressource' => $id_ressource
    ]);

    return $requete->fetch() ? true : false;
}


function add_reservation($date_jour, $id_ressource, $id_utilisateur) {
    global $pdo;

    $requete = $pdo->prepare("
        INSERT INTO reservation (date_jour, id_ressource, id_utilisateur )
        VALUES (:date_jour, :id_ressource, :id_utilisateur)
    ");

    $requete->execute([
        ':date_jour' => $date_jour,
        ':id_ressource' => $id_ressource,
        ':id_utilisateur' => $id_utilisateur
    ]);
}

function ressource($id_ressource){
    global $pdo;

    $requete = $pdo->prepare("
        SELECT nom
        FROM ressource
        WHERE  id_ressource = :id_ressource
        LIMIT 1
    ");

    $requete->execute([
        ':id_ressource' => $id_ressource,
    ]);
 $row = $requete->fetch();

return $row ? $row['nom'] : null;

}
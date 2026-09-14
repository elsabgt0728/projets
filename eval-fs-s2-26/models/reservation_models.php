<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function date_reservation_exists($date_reservation, $id_machine) {
    global $pdo;

    $requete = $pdo->prepare("
        SELECT 1 
        FROM reservation
        WHERE date_reservation = :date_reservation
        AND id_machine = :id_machine
        LIMIT 1
    ");

    $requete->execute([
        ':date_reservation' => $date_reservation,
        ':id_machine' => $id_machine
    ]);

    return $requete->fetch() ? true : false;
}


function add_reservation($date_reservation, $id_machine, $id_utilisateur) {
    global $pdo;

    $requete = $pdo->prepare("
        INSERT INTO reservation (date_reservation, id_machine, id_utilisateur )
        VALUES (:date_reservation, :id_machine, :id_utilisateur)
    ");

    $requete->execute([
        ':date_reservation' => $date_reservation,
        ':id_machine' => $id_machine,
        ':id_utilisateur' => $id_utilisateur
    ]);
}

function machine($id_machine){
    global $pdo;

    $requete = $pdo->prepare("
        SELECT nom
        FROM machine
        WHERE  id_machine = :id_machine
        LIMIT 1
    ");

    $requete->execute([
        ':id_machine' => $id_machine,
    ]);
 $row = $requete->fetch();

return $row ? $row['nom'] : null;

}
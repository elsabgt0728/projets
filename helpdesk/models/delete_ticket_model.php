<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();


function delete_ticket($id_ticket) {
    global $pdo;

    $requete = $pdo->prepare("
        DELETE FROM tickets
        WHERE id_ticket = :id_ticket
    ");

    $requete->execute([
        ':id_ticket' => $id_ticket,
    ]);
}
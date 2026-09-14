<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();


function delete_grade($id_book) {
    global $pdo;

    $requete = $pdo->prepare("
        DELETE FROM books
        WHERE id_book = :id_book
    ");

    $requete->execute([
        ':id_book' => $id_book,
    ]);
}
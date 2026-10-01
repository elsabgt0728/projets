<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function get_borrowed_book_by_name($namebook) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT id_book, statut, borrower_id 
        FROM Books 
        WHERE LOWER(TRIM(namebook)) = LOWER(TRIM(:namebook)) 
        FOR UPDATE
    ");
    $stmt->execute([":namebook" => $namebook]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        throw new Exception("Aucun livre trouvé avec le nom « $namebook ».");
    }
    if ($book['statut'] !== 'emprunté') {
        throw new Exception("Ce livre n'est pas actuellement emprunté (statut actuel : {$book['statut']}).");
    }

    return $book['id_book'];
}

function return_book($id_book) {
    global $pdo;

    $requete = $pdo->prepare("
        UPDATE Books 
        SET borrower_id = NULL, statut = 'stock' 
        WHERE id_book = :id_book
    ");
    $requete->execute([
        ":id_book" => $id_book
    ]);
}

function process_book_return($namebook) {
    global $pdo;

    try {
        $pdo->beginTransaction(); // Une transaction, c'est un moyen de dire à MySQL : "Je vais faire plusieurs opérations liées entre elles. Soit elles réussissent toutes, soit aucune ne doit avoir d'effet." 
         // Ouvre le brouillon

        $idBook = get_borrowed_book_by_name($namebook); // → si le livre n'existe pas, ça lève une exception ici, on ne va jamais plus loin

        return_book($idBook);   // UPDATE Books ... (encore "en brouillon")

        $pdo->commit();      // Valide définitivement le UPDATE
        return $idBook;

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
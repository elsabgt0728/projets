<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function add_borrower($last_name, $first_name) {
    global $pdo;

    $requete = $pdo->prepare("
        INSERT INTO `borrower` (`Last_name`, `First_name`) VALUES (:last_name, :first_name)
    ");
    $requete->execute([
        ":last_name"  => $last_name,
        ":first_name" => $first_name
    ]);

    return $pdo->lastInsertId();
}

function get_book_by_name($namebook) {
    global $pdo;

    // TRIM() ignore les espaces en début/fin, LOWER() ignore la casse
    $stmt = $pdo->prepare("
        SELECT id_book, statut 
        FROM Books 
        WHERE LOWER(TRIM(namebook)) = LOWER(TRIM(:namebook)) 
        FOR UPDATE
    ");
    $stmt->execute([":namebook" => $namebook]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        throw new Exception("Aucun livre trouvé avec le nom « $namebook ».");
    }
    if ($book['statut'] !== 'stock') {
        throw new Exception("Ce livre n'est pas disponible (statut actuel : {$book['statut']}).");
    }

    return $book['id_book'];
}

function assign_book_to_borrower($id_book, $borrower_id) {
    global $pdo;

    $requete = $pdo->prepare("
        UPDATE Books SET borrower_id = :borrower_id, statut = 'emprunté' WHERE id_book = :id_book
    ");
    $requete->execute([
        ":borrower_id" => $borrower_id,
        ":id_book"     => $id_book
    ]);
}

function add_borrower_and_assign_book($last_name, $first_name, $namebook) {
    global $pdo;

    try {
        $pdo->beginTransaction();

        $idBook     = get_book_by_name($namebook);
        $borrowerId = add_borrower($last_name, $first_name);
        assign_book_to_borrower($idBook, $borrowerId);

        $pdo->commit();
        return $borrowerId;

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
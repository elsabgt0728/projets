<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function list_book($recherche){
    global $pdo;
    $sql = "SELECT 
            Books.*,
            borrower.First_name,
            borrower.Last_name,
            borrower.borrower_id,                 
            Categorie.nom AS categorie_nom,
            Categorie.Categorie_id,
            book_categorie.categorie_id AS current_categorie  
        FROM Books
        LEFT JOIN borrower ON borrower.borrower_id = Books.borrower_id
        LEFT JOIN book_categorie ON book_categorie.id_book = Books.id_book
        LEFT JOIN Categorie ON Categorie.Categorie_id = book_categorie.categorie_id";
        
      $params = [];

    if ($recherche !== "") {
        $sql .= " WHERE Books.namebook LIKE :recherche1 OR Books.auteur LIKE :recherche2";
        $params[':recherche1'] = '%' . $recherche . '%';
        $params[':recherche2'] = '%' . $recherche . '%';
    }

    $requete = $pdo->prepare($sql);
    $requete->execute($params);

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


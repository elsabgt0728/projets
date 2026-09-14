<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function list_book(){
    global $pdo;
    $requete = $pdo ->prepare("SELECT 
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
        LEFT JOIN Categorie ON Categorie.Categorie_id = book_categorie.categorie_id ");

  $requete->execute();
  return $requete->fetchAll(PDO::FETCH_ASSOC);

}
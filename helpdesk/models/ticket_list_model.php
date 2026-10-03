<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function list_tickets($recherche){
    global $pdo;
   $sql = "SELECT 
            tickets.*,
            technicien.First_name,
            technicien.Last_name,
            technicien.technicien_id,                 
            Categorie.nom AS categorie_nom,
            Categorie.Categorie_id,
            ticket_categorie.categorie_id AS current_categorie  
        FROM tickets
        LEFT JOIN technicien ON technicien.technicien_id = tickets.technicien_id
        LEFT JOIN ticket_categorie ON ticket_categorie.id_ticket = tickets.id_ticket
        LEFT JOIN Categorie ON Categorie.Categorie_id = ticket_categorie.categorie_id";
        
      $params = [];

    if ($recherche !== "") {
        $sql .= " WHERE tickets.titre LIKE :recherche1 OR tickets.description LIKE :recherche2";
        $params[':recherche1'] = '%' . $recherche . '%';
        $params[':recherche2'] = '%' . $recherche . '%';
    }

    $requete = $pdo->prepare($sql);
    $requete->execute($params);

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


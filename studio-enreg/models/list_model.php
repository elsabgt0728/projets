<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();
 
function display_list(){
     global $pdo;
    $requete = $pdo ->prepare("SELECT ressource.nom AS instrument,
                categorie.nom AS categorie,
                formation.nom AS formation,
                ressource.id_ressource
    FROM ressource
    INNER JOIN categorie on ressource.id_categorie = categorie.id_categorie  
    INNER JOIN formation on ressource.id_formation_associee = formation.id_formation ");

    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function elsa_info(){
        global $pdo;
        $requete = $pdo ->prepare("SELECT nom, prenom FROM utilisateur where id_utilisateur = 6 ");
        $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();
 
function display_list(){
     global $pdo;
    $requete = $pdo ->prepare("SELECT machine.nom,
                machine.id_machine,
                categorie.nom,
                formation.nom
    FROM machine 
    INNER JOIN categorie on machine.id_categorie = categorie.id_categorie  
    INNER JOIN formation on machine.id_formation = formation.id_formation ");

    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function elsa_info(){
        global $pdo;
        $requete = $pdo ->prepare("SELECT nom, prenom FROM utilisateur where id_utilisateur = 7 ");
        $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
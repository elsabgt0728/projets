<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function each_cadet_cours($cadet_id) {
    global $pdo;
    $requete = $pdo ->prepare("SELECT cours.*, 
    cadet_grade.grade
    FROM cadet_grade
    INNER JOIN cours ON cadet_grade.cours_id = cours.cours_id
    WHERE cadet_grade.cadet_id = :id;");
    $requete->execute([":id" => $cadet_id]);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

  
function all_cours(){
    global $pdo;
    $requete = $pdo ->prepare("SELECT *
    FROM cours");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);

}

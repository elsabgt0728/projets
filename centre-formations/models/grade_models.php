<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function grade_cadet_cours() {
    global $pdo;
    $requete = $pdo ->prepare("SELECT cadet.nom,
    cadet.promo,
    cadet.cadet_id,
    SUM(cadet_grade.grade*cours.coefficient)/SUM(cours.coefficient) AS average_grade
    FROM cadet_grade
    INNER JOIN cours ON cadet_grade.cours_id = cours.cours_id
    RIGHT JOIN cadet ON cadet_grade.cadet_id = cadet.cadet_id
    GROUP BY cadet.cadet_id"); 

    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function each_cadet_result($cadet_id) {
    global $pdo;
    $requete = $pdo ->prepare("SELECT SUM(cadet_grade.grade*cours.coefficient)/SUM(cours.coefficient) AS average_grade 
    FROM cadet_grade 
    INNER JOIN cours ON cadet_grade.cours_id = cours.cours_id 
    WHERE cadet_grade.cadet_id = :id GROUP BY cadet_grade.cadet_id");
    $requete->execute([":id" => $cadet_id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}


function get_grade($cadet_id, $cours_id) {
    global $pdo;

    $requete = $pdo->prepare("
        SELECT grade
        FROM cadet_grade
        WHERE cadet_id = :cadet_id
        AND cours_id = :cours_id
        LIMIT 1
    ");

    $requete->execute([
        ':cadet_id' => $cadet_id,
        ':cours_id' => $cours_id
    ]);

    $row = $requete->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['grade'] : null;
}

function update_grade($cadet_id, $cours_id, $grade) {
    global $pdo;

    $requete = $pdo->prepare("
        UPDATE cadet_grade
        SET grade = :grade
        WHERE cadet_id = :cadet_id
        AND cours_id = :cours_id
    ");

    $requete->execute([
        ':grade' => $grade,
        ':cadet_id' => $cadet_id,
        ':cours_id' => $cours_id
    ]);
}

function delete_grade($cadet_id, $cours_id) {
    global $pdo;

    $requete = $pdo->prepare("
        DELETE FROM cadet_grade
        WHERE cadet_id = :cadet_id
        AND cours_id = :cours_id
    ");

    $requete->execute([
        ':cadet_id' => $cadet_id,
        ':cours_id' => $cours_id
    ]);
}

function grade_exists($cadet_id, $cours_id) {
    global $pdo;

    $requete = $pdo->prepare("
        SELECT 1 
        FROM cadet_grade
        WHERE cadet_id = :cadet_id
        AND cours_id = :cours_id
        LIMIT 1
    ");

    $requete->execute([
        ':cadet_id' => $cadet_id,
        ':cours_id' => $cours_id
    ]);

    return $requete->fetch() ? true : false;
}


function add_grade($cadet_id, $cours_id, $grade) {
    global $pdo;

    $requete = $pdo->prepare("
        INSERT INTO cadet_grade (cadet_id, cours_id, grade)
        VALUES (:cadet_id, :cours_id, :grade)
    ");

    $requete->execute([
        ':cadet_id' => $cadet_id,
        ':cours_id' => $cours_id,
        ':grade' => $grade
    ]);
}

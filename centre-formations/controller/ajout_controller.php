<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../models/grade_models.php';

    $cadet_id = $_POST['cadet_id'];
    $cours_id = $_POST['cours_id'];
    $grade = $_POST['grade'];

    // Vérifier si la note existe déjà
    if (grade_exists($cadet_id, $cours_id)) {
        header("Location: ../views/cadet_view.php?id=$cadet_id&error=exists");
        exit();
    }

    // Ajouter la note
    add_grade($cadet_id, $cours_id, $grade);

    header("Location: ../views/cadet_view.php?id=$cadet_id&success=added");
    exit();
}

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../models/grade_models.php';

    $cours_id = $_POST['cours_id'];
    $cadet_id = $_POST['cadet_id'];
    $grade = $_POST['grade'];

    // Update the grade in the database
    update_grade($cadet_id, $cours_id, $grade);

    // Redirect back to the cadet's course page or any other page
    header("Location: ../views/cadet_view.php?id=$cadet_id");
    exit();
}
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once '../models/grade_models.php';

    $cours_id = $_GET['id'];
    $cadet_id = $_GET['cadet_id'];
   

    delete_grade($cadet_id, $cours_id);

    header("Location: ../views/cadet_view.php?id=$cadet_id");
    exit();
}

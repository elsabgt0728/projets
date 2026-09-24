<?php

session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/delete_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id_book = $_GET["id"];

}

delete_grade($id_book);

    header("Location: ../views/menu.php");
    exit();
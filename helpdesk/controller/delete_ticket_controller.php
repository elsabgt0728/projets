<?php

session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/delete_ticket_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id_ticket = $_GET["id"];

}

delete_ticket($id_ticket);

    header("Location: ../views/dashboard.php");
    exit();
<?php
session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/cloture_ticket_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = htmlspecialchars(trim($_POST["titre"] ?? ""));
} else {
    $titre = "";
}

if ($titre === "") {
    echo "Le titre du ticket ne peut pas être vide.";
    exit;
}

try {
    process_ticket_resolution($titre);
    header("Location: ../views/dashboard.php");
    exit();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
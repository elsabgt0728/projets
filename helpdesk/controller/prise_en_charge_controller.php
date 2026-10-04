<?php
session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/prise_en_charge_model.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = htmlspecialchars(trim($_POST["titre"] ?? ""));
    $last_name  = htmlspecialchars(trim($_POST["nomtechnicien"] ?? ""));
    $first_name = htmlspecialchars(trim($_POST["prenomtechnicien"] ?? ""));
} else {
    $titre = $last_name = $first_name = "";
}

if ($titre === "" || $last_name === "" || $first_name === "") {
   echo "Le titre du ticket, le nom ou le prénom du technicien ne peuvent pas être vides.";
}

try {
   add_technicien_and_assign_ticket($last_name, $first_name, $titre);
    header("Location: ../views/dashboard.php");
    exit();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
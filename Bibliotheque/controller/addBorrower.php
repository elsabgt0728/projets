<?php
session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/addborrower_model.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namebook   = htmlspecialchars(trim($_POST["namebook"] ?? ""));
    $last_name  = htmlspecialchars(trim($_POST["nameborrower"] ?? ""));
    $first_name = htmlspecialchars(trim($_POST["surnameborrower"] ?? ""));
} else {
    $namebook = $last_name = $first_name = "";
}

if ($namebook === "" || $last_name === "" || $first_name === "") {
    echo "Le nom du livre, le nom ou le prénom de l'emprunteur ne peuvent pas être vides.";
    exit;
}

try {
    add_borrower_and_assign_book($last_name, $first_name, $namebook);
    header("Location: ../views/menu.php");
    exit();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
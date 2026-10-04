<?php
session_start();
require_once '../models/edit_ticket_model.php';

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/dashboard.php");
    exit;
}

$id         = (int) ($_POST["id"] ?? 0);
$titre   = trim($_POST["titre"] ?? "");
$description      = trim($_POST["description"] ?? "");
$categories = $_POST["categories"] ?? [];

$formulaire = "../views/formulaireModificationTicket.php?id=" . $id;

// Le livre doit exister
if ($id <= 0 || !get_ticket($id)) {
    header("Location: ../views/dashboard.php");
    exit;
}

// Nettoyage : tableau d'entiers positifs uniquement
if (!is_array($categories)) {
    $categories = [];
}
$categories = array_values(array_filter(array_map('intval', $categories), fn($c) => $c > 0));

// Validation
$erreurs = [];
if ($titre === "") {
    $erreurs[] = "Le titre est obligatoire.";
}
if ($description === "") {
    $erreurs[] = "La description est obligatoire.";
}
if (empty($categories)) {
    $erreurs[] = "Choisissez au moins une catégorie.";
}

if (!empty($erreurs)) {
    $_SESSION['erreurs']   = $erreurs;
    $_SESSION['anciennes'] = ['titre' => $titre, 'description' => $description, 'categories' => $categories];
    header("Location: $formulaire");
    exit;
}

// Modification
try {
    update_ticket($id, $titre, $description, $categories);
} catch (Throwable $e) {
    error_log($e->getMessage());
    $_SESSION['erreurs']   = ["Une erreur est survenue lors de la modification."];
    $_SESSION['anciennes'] = ['titre' => $titre, 'description' => $description, 'categories' => $categories];
    header("Location: $formulaire");
    exit;
}

header("Location: ../views/dashboard.php");
exit;
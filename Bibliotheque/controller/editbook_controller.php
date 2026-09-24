<?php
session_start();
require_once '../models/editbook_model.php';

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/menu.php");
    exit;
}

$id         = (int) ($_POST["id"] ?? 0);
$namebook   = trim($_POST["namebook"] ?? "");
$autor      = trim($_POST["auteur"] ?? "");
$categories = $_POST["categories"] ?? [];

$formulaire = "../views/formulaireModification.php?id=" . $id;

// Le livre doit exister
if ($id <= 0 || !get_book($id)) {
    header("Location: ../views/menu.php");
    exit;
}

// Nettoyage : tableau d'entiers positifs uniquement
if (!is_array($categories)) {
    $categories = [];
}
$categories = array_values(array_filter(array_map('intval', $categories), fn($c) => $c > 0));

// Validation
$erreurs = [];
if ($namebook === "") {
    $erreurs[] = "Le titre est obligatoire.";
}
if ($autor === "") {
    $erreurs[] = "L'auteur est obligatoire.";
}
if (empty($categories)) {
    $erreurs[] = "Choisissez au moins une catégorie.";
}

if (!empty($erreurs)) {
    $_SESSION['erreurs']   = $erreurs;
    $_SESSION['anciennes'] = ['namebook' => $namebook, 'auteur' => $autor, 'categories' => $categories];
    header("Location: $formulaire");
    exit;
}

// Modification
try {
    update_book($id, $namebook, $autor, $categories);
} catch (Throwable $e) {
    error_log($e->getMessage());
    $_SESSION['erreurs']   = ["Une erreur est survenue lors de la modification."];
    $_SESSION['anciennes'] = ['namebook' => $namebook, 'auteur' => $autor, 'categories' => $categories];
    header("Location: $formulaire");
    exit;
}

header("Location: ../views/menu.php");
exit;
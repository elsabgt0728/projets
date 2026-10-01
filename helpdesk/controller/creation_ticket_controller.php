
<?php
session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/addbook_model.php';

$formulaire = "../views/formulaireAjout.php"; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: $formulaire");
    exit;
}

$namebook   = htmlspecialchars(trim($_POST["namebook"] ?? ""));
$autor      = htmlspecialchars(trim($_POST["auteur"] ?? ""));
$categories = $_POST["categories"] ?? [];

// Nettoyage : tableau d'entiers positifs uniquement
if (!is_array($categories)) {
    $categories = [];
}
$categories = array_values(array_filter(array_map('intval', $categories), fn($id) => $id > 0));

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

// Insertion
try {
    add_book($namebook, $autor, $categories);
} catch (Throwable $e) {
    error_log($e->getMessage()); // détail dans les logs, pas à l'écran (C:/xamp/apache/logs/error.log)
    $_SESSION['erreurs']   = ["Une erreur est survenue lors de l'enregistrement."];
    $_SESSION['anciennes'] = ['namebook' => $namebook, 'auteur' => $autor, 'categories' => $categories];
    header("Location: $formulaire");
    exit;
}

header("Location: ../views/menu.php");
exit;

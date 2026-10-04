
<?php
session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/ticket_model.php';

$formulaire = "../views/formulaireCreationTicket.php"; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: $formulaire");
    exit;
}

$titre   = htmlspecialchars(trim($_POST["titre"] ?? ""));
$description     = htmlspecialchars(trim($_POST["description"] ?? ""));
$categories = $_POST["categories"] ?? [];

// Nettoyage : tableau d'entiers positifs uniquement
if (!is_array($categories)) {
    $categories = [];
}
$categories = array_values(array_filter(array_map('intval', $categories), fn($id) => $id > 0));

// Validation
$erreurs = [];
if ($titre === "") {
    $erreurs[] = "Le titre est obligatoire.";
}
if ($description=== "") {
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

// Insertion
try {
    create_ticket($titre, $description, $categories);
} catch (Throwable $e) {
    error_log($e->getMessage()); // détail dans les logs, pas à l'écran (C:/xamp/apache/logs/error.log)
    $_SESSION['erreurs']   = ["Une erreur est survenue lors de l'enregistrement."];
    $_SESSION['anciennes'] = ['titre' => $titre, 'description' => $description, 'categories' => $categories];
    header("Location: $formulaire");
    exit;
}

header("Location: ../views/dashboard.php");
exit;

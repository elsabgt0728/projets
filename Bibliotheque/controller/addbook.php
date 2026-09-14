<?php

require_once '../models/addbook_model.php';

//$namebook = trim($_POST["namebook"] ?? "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namebook = htmlspecialchars($_POST["namebook"]);
    $autor = htmlspecialchars($_POST["auteur"]);
}

if ($namebook === "" || $autor === "" ) {
    echo "Le nom du livre ou celui de l'auteur ne peut pas être vide.";
    exit;
}

add_book($namebook, $autor);

header("Location: ../views/menu.php");
exit();

<?php

require_once '../models/returnbook_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namebook = htmlspecialchars(trim($_POST["namebook"] ?? ""));
} else {
    $namebook = "";
}

if ($namebook === "") {
    echo "Le nom du livre ne peut pas être vide.";
    exit;
}

try {
    process_book_return($namebook);
    header("Location: ../views/menu.php");
    exit();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
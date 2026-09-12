<?php

session_start();
require_once '../models/user_model.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email === "" || $password === "") {
        $erreur = "Veuillez remplir tous les champs.";
        include "../views/login.php";
        exit;
    }

    // Vérification via le modèle
    $user = getUserByEmailAndPassword($email, $password);

    if ($user) {

        // Création de la session
        $_SESSION["user_id"] = $user["id_utilisateur"];
        $_SESSION["user_email"] = $user["email"];
        $_SESSION["user_nom"] = $user["nom"];
        $_SESSION["user_prenom"] = $user["prenom"];
        $_SESSION["user_statut"] = $user["statut"];

        // Redirection vers le catalogue des machines
        header("Location: ../views/machines.php");
        exit;

    } else {
        $erreur = "Identifiants incorrects.";
        include "../views/login.php";
        exit;
    }
}

// Si on arrive ici sans POST → afficher le formulaire
include "../views/login.php";

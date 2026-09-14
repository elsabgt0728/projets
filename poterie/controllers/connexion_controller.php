<?php

session_start();
$erreur = "";


require_once '../models/connexion_model.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $mdp = $_POST["password"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    $_SESSION["nom"] = $_POST["nom"] ;
    $_SESSION["prenom"] = $_POST["prenom"];


    if (isset($email) && isset($mdp) && isset($nom) && isset($prenom)) {
        if (adherent_exits($nom, $prenom, $email, $mdp)) {

            $_SESSION["isAuthenticated"] =true;
            

        // Création du cookie APRÈS la session et APRÈS la validations
            $nb_secondes_24h = 60 * 60 * 24 * 7 ;
            $nom_complet = $_SESSION["nom"] . ' ' . $_SESSION["prenom"];
            setcookie("dernier_adherent", $nom_complet , time() + $nb_secondes_24h, "/");

            header("Location: ../views/equipements.php");
            exit();
        }
        else
            {
                $erreur = "Nope !";
                include "../views/connexion.php";
            }
    }

}



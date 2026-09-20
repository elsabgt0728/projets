<?php

session_start();
$erreur = "";


require_once '../models/connexion_model.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $mdp = $_POST["password"];


    if (isset($email) && isset($mdp)) {
        if (adherent_exits( $email, $mdp)) {

            $_SESSION["isAuthenticated"] =true;

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



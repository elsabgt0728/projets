<?php

session_start();
$erreur = "";


require_once '../models/connexion_model.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $mdp = $_POST["password"];


    if (isset($email) && isset($mdp)) {

            $utilisateur = adherent_exits($email, $mdp);

        if ($utilisateur) {

            $_SESSION["isAuthenticated"] =true;
            $_SESSION["id_utilisateur"] =  $utilisateur['id_utilisateur'];  

            header("Location: ../views/menu.php");
            exit();
        }
        else
            {
                $erreur = "Nope !";
                include "../views/connexion.php";
            }
    }

}



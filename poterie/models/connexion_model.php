<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function adherent_exits($nom, $prenom, $email,$mdp)
{
     global $pdo;

    $requete = $pdo->prepare("
        SELECT mot_de_passe
        FROM utilisateur
        WHERE nom = :nom
        AND prenom = :prenom
        AND email = :email
        LIMIT 1
    ");

    $requete->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
    ]);

   $utilisateur = $requete->fetch();

    // 2. Si aucun utilisateur trouvé, on arrête là
    if (!$utilisateur) {
        return false;
    }

    // 3. On compare le mot de passe en clair avec le hash stocké, EN PHP
    return password_verify($mdp, $utilisateur['mot_de_passe']);
}

/* <?php
$mdp1 = password_hash('motdepasse1', PASSWORD_DEFAULT);
$mdp2 = password_hash('motdepasse2', PASSWORD_DEFAULT);
$mdp3 = password_hash('motdepasse3', PASSWORD_DEFAULT);
$mdp4 = password_hash('motdepasse4', PASSWORD_DEFAULT);

echo $mdp1 . "<br>";
echo $mdp2 . "<br>";
echo $mdp3 . "<br>";
echo $mdp4 . "<br>";*/
<?php
require_once '../config/db_connect.php';

$pdo = getPDOConnection();


function email_dispo($email)
{
     global $pdo;

    $requete = $pdo->prepare("
        SELECT 1 
        FROM utilisateur
        WHERE email = :email
        LIMIT 1
    ");

    $requete->execute([
        ':email' => $email,
    ]);

    return $requete->fetch() ? true : false;
}


function creer_user($nom, $prenom, $statut, $mdp, $email )
{
    global $pdo;
     // Hash sécurisé
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    $requete = $pdo->prepare('
    INSERT INTO utilisateur (nom, prenom, statut,  mot_de_passe, email) 
    VALUES (:nom, :prenom, :statut, :password, :email)');
    $requete->execute([
       ':nom' => $nom, 
       ':prenom' => $prenom, 
       ':statut' => $statut, 
       ':password' => $hash, 
       ':email' => $email
       ]);
}

function get_statuts_possibles()
{
    global $pdo;

    $sql = "
        SELECT COLUMN_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = 'utilisateur'
        AND COLUMN_NAME = 'statut'
        AND TABLE_SCHEMA = 'studiophoto_db'
    ";

    $stmt = $pdo->query($sql);
    $columnType = $stmt->fetchColumn(); // enum('membre','regisseur')

    preg_match("/^enum\((.*)\)$/", $columnType, $matches);

    $enumValues = explode(",", str_replace("'", "", $matches[1]));

    return $enumValues;
}

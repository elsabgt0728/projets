<?php

require_once '../config/db.php'; // ton fichier de connexion PDO

function getUserByEmailAndPassword(string $email, string $password)
{
    global $pdo;

    $sql = "
        SELECT id_utilisateur, prenom, nom, email, statut
        FROM utilisateur
        WHERE email = :email
        AND mot_de_passe = SHA2(:password, 256)
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password' => $password
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

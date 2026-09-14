<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function add_book($namebook, $autor){
 global $pdo;

    $requete = $pdo->prepare("
    INSERT INTO `Books` (`namebook`, `auteur`) VALUES ( :namebook, :auteur)
    ");
    $requete->execute([
        ":namebook" =>  $namebook,
        ":auteur" => $autor
    ]);
}
<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function add_book($namebook, $autor, array $categories) //un livre peut avoir plusieurs categories
{
    global $pdo;

    if (empty($categories)) {
        throw new InvalidArgumentException('Au moins une catégorie est requise.'); // ERREUR : Uncaught InvalidArgumentException: Au moins une catégorie est requise.
    }

    $pdo->beginTransaction(); // Soit toutes les requêtes réussissent, soit aucune n'est enregistrée.
    try {
        // 1. Le livre (sans la colonne categorie)
        $requete = $pdo->prepare("
            INSERT INTO `Books` (`namebook`, `auteur`)
            VALUES (:namebook, :auteur)
        ");
        $requete->execute([
            ":namebook" => $namebook,
            ":auteur"   => $autor
        ]);

        $bookId = (int) $pdo->lastInsertId(); // ID du dernier livre inséré (livre)

        // 2. Une ligne par catégorie dans la table d'association
        $liaison = $pdo->prepare("
            INSERT INTO `book_categorie` (`id_book`, `Categorie_id`)
            VALUES (:livre, :categorie)
        ");
        foreach (array_unique($categories) as $catId) {
            $liaison->execute([
                ":livre"     => $bookId,
                ":categorie" => (int) $catId
            ]);
        }

        $pdo->commit();
        return $bookId;
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function get_categories()
{
    global $pdo;
    return $pdo->query("SELECT Categorie_id, Nom FROM Categorie ORDER BY Nom")->fetchAll(PDO::FETCH_ASSOC);
}
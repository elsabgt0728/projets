<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

 function create_ticket($titre, $description, array $categories) //un ticket peut avoir plusieurs categories
{
    global $pdo; 

    if (empty($categories)) {
        throw new InvalidArgumentException('Au moins une catégorie est requise.'); // ERREUR : Uncaught InvalidArgumentException: Au moins une catégorie est requise.
    }

    $pdo->beginTransaction(); // Soit toutes les requêtes réussissent, soit aucune n'est enregistrée.
    try {
        // 1. Le livre (sans la colonne categorie)
        $requete = $pdo->prepare("
            INSERT INTO `tickets` (`titre`, `description`)
        VALUES (:titre, :description)
        ");
        $requete->execute([
            ":titre"       => $titre,
            ":description" => $description
        ]);

        $ticketId = (int) $pdo->lastInsertId(); // ID du dernier livre inséré (livre)

        // 2. Une ligne par catégorie dans la table d'association
        $liaison = $pdo->prepare("
            INSERT INTO `ticket_categorie` (`id_ticket`, `Categorie_id`)
            VALUES (:ticket, :categorie)
        ");
        foreach (array_unique($categories) as $catId) {
            $liaison->execute([
                ":ticket"    => $ticketId,
                ":categorie" => (int) $catId
            ]);
        }

        $pdo->commit();
        return $ticketId;
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
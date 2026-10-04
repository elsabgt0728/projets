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

    $priorite = determine_priority($categories);
        // 1. Le livre (sans la colonne categorie)
        $requete = $pdo->prepare("
            INSERT INTO `tickets` (`titre`, `description`, `priorite`)
        VALUES (:titre, :description, :priorite)
        ");
        $requete->execute([
            ":titre"       => $titre,
            ":description" => $description,
            ":priorite"    => $priorite
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

function determine_priority(array $categoryIds)
{
    global $pdo;

    // Barème de gravité par catégorie (1 = basse, 2 = moyenne, 3 = haute)
    $baremes = [
        'Sécurité' => 3,
        'Réseau'   => 2,
        'Matériel' => 2,
        'Compte'   => 2,
        'Logiciel' => 1,
        'Autre'    => 1,
    ];

    $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
    $requete = $pdo->prepare("SELECT Nom FROM Categorie WHERE Categorie_id IN ($placeholders)");
    $requete->execute($categoryIds);
    $noms = $requete->fetchAll(PDO::FETCH_COLUMN);

    $niveauMax = 1; // basse par défaut si aucune catégorie ne matche le barème
    foreach ($noms as $nom) {
        $niveauMax = max($niveauMax, $baremes[$nom] ?? 1);
    }

    return match ($niveauMax) {
        3 => 'haute',
        2 => 'moyenne',
        default => 'basse',
    };
}
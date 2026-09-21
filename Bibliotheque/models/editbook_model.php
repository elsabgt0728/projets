<?php
require_once __DIR__ . '/addbook_model.php'; // réutilise $pdo et get_categories()

// Récupère un livre par son id (ou false s'il n'existe pas)
function get_book($id)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT `id_book`, `namebook`, `auteur` FROM `Books` WHERE `id_book` = :id");
    $requete->execute([":id" => $id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

// Récupère les ids des catégories d'un livre, ex : [1, 3]
function get_book_categories($id)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT `Categorie_id` FROM `book_categorie` WHERE `id_book` = :id");
    $requete->execute([":id" => $id]);
    return array_map('intval', $requete->fetchAll(PDO::FETCH_COLUMN));
}

// Modifie le livre et remplace ses catégories
function update_book($id, $namebook, $autor, array $categories)
{
    global $pdo;

    $pdo->beginTransaction();
    try {
        // 1. Mise à jour du livre
        $requete = $pdo->prepare("
            UPDATE `Books`
            SET `namebook` = :namebook, `auteur` = :auteur
            WHERE `id_book` = :id
        ");
        $requete->execute([
            ":namebook" => $namebook,
            ":auteur"   => $autor,
            ":id"       => $id
        ]);

        // 2. On supprime les anciennes liaisons
        $requete = $pdo->prepare("DELETE FROM `book_Categorie` WHERE `id_book` = :id");
        $requete->execute([":id" => $id]);

        // 3. On recrée les liaisons cochées
        $liaison = $pdo->prepare("
            INSERT INTO `book_categorie` (`id_book`, `Categorie_id`)
            VALUES (:livre, :categorie)
        ");
        foreach (array_unique($categories) as $catId) {
            $liaison->execute([
                ":livre"     => $id,
                ":categorie" => (int) $catId
            ]);
        }

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
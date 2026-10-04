<?php
require_once __DIR__ . '/ticket_model.php'; // réutilise $pdo et get_categories()

// Récupère un ticket par son id (ou false s'il n'existe pas)
function get_ticket($id)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT `id_ticket`, `titre`, `description` FROM `tickets` WHERE `id_ticket` = :id");
    $requete->execute([":id" => $id]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

// Récupère les ids des catégories d'un ticket, ex : [1, 3]
function get_ticket_categories($id)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT `Categorie_id` FROM `ticket_categorie` WHERE `id_ticket` = :id");
    $requete->execute([":id" => $id]);
    return array_map('intval', $requete->fetchAll(PDO::FETCH_COLUMN));
} 

// Modifie le ticket et remplace ses catégories
function update_ticket($id, $titre, $description, array $categories)
{
    global $pdo;

    $priorite = determine_priority($categories);

    $pdo->beginTransaction();
    try {
        $requete = $pdo->prepare("
            UPDATE `tickets`
            SET `titre` = :titre, `description` = :description, `priorite` = :priorite
            WHERE `id_ticket` = :id
        ");
        $requete->execute([
            ":titre"       => $titre,
            ":description" => $description,
            ":priorite"    => $priorite,
            ":id"          => $id
        ]);

        // 2. On supprime les anciennes liaisons
        $requete = $pdo->prepare("DELETE FROM `ticket_categorie` WHERE `id_ticket` = :id");
        $requete->execute([":id" => $id]);

        // 3. On recrée les liaisons cochées
        $liaison = $pdo->prepare("
            INSERT INTO `ticket_categorie` (`id_ticket`, `Categorie_id`)
            VALUES (:ticket, :categorie)
        ");
        foreach (array_unique($categories) as $catId) {
            $liaison->execute([
                ":ticket"     => $id,
                ":categorie" => (int) $catId
            ]);
        }

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
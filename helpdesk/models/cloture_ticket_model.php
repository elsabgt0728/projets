<?php

require_once '../config/db_connect.php';

$pdo = getPDOConnection();

function get_assigned_ticket_by_titre($titre) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT id_ticket, statut, technicien_id 
        FROM tickets 
        WHERE LOWER(TRIM(titre)) = LOWER(TRIM(:titre)) 
        FOR UPDATE
    ");
    $stmt->execute([":titre" => $titre]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        throw new Exception("Aucun ticket trouvé avec le nom « $titre ».");
    }
    if ($book['statut'] !== 'en_cours') {
        throw new Exception("Ce ticket n'est pas actuellement en cours de resolution (statut actuel : {$book['statut']}).");
    }

    return $book['id_ticket'];
}

function resolve_ticket($id_ticket) {
    global $pdo;

    $requete = $pdo->prepare("
        UPDATE tickets 
        SET statut = 'resolu' 
        WHERE id_ticket = :id_ticket
    ");
    $requete->execute([
        ":id_ticket" => $id_ticket
    ]);
}

function process_ticket_resolution($titre) {
    global $pdo;

    try {
        $pdo->beginTransaction(); // Une transaction, c'est un moyen de dire à MySQL : "Je vais faire plusieurs opérations liées entre elles. Soit elles réussissent toutes, soit aucune ne doit avoir d'effet." 
         // Ouvre le brouillon

        $idTicket = get_assigned_ticket_by_titre($titre);
        
        resolve_ticket($idTicket);

        $pdo->commit();

        return $idTicket;

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
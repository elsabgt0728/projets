<?php

require_once '../config/db_connect.php';
require_once 'ticket_model.php';

$pdo = getPDOConnection();

function add_technicien($last_name, $first_name) {
    global $pdo;

    $requete = $pdo->prepare("
        INSERT INTO `technicien` (`Last_name`, `First_name`) VALUES (:last_name, :first_name)
    ");
    $requete->execute([
        ":last_name"  => $last_name,
        ":first_name" => $first_name
    ]);

    return $pdo->lastInsertId();
}

function get_ticket_by_titre($titre) {
    global $pdo;

    // TRIM() ignore les espaces en début/fin, LOWER() ignore la casse
    $stmt = $pdo->prepare("
        SELECT id_ticket, statut 
        FROM tickets 
        WHERE LOWER(TRIM(titre)) = LOWER(TRIM(:titre)) 
        FOR UPDATE
    ");
    $stmt->execute([":titre" => $titre]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        throw new Exception("Aucun livre trouvé avec le nom « $titre ».");
    }
    if ($book['statut'] !== 'ouvert') {
        throw new Exception("Ce livre n'est pas disponible (statut actuel : {$book['statut']}).");
    }

    return $book['id_ticket'];
}

function assign_ticket_to_technicien($id_ticket, $technicien_id) {
    global $pdo;

    $requete = $pdo->prepare("
        UPDATE tickets SET technicien_id = :technicien_id, statut = 'emprunté' WHERE id_ticket = :id_ticket
    ");
    $requete->execute([
        ":technicien_id" => $technicien_id,
        ":id_ticket"     => $id_ticket
    ]);
}

function add_technicien_and_assign_ticket($last_name, $first_name, $titre) {
    global $pdo;

    try {
        $pdo->beginTransaction();

         $idTicket     = get_ticket_by_titre($titre);
        $technicienId = add_technicien($last_name, $first_name);
        assign_ticket_to_technicien($idTicket, $technicienId);
        log_historique($idTicket, "prise_en_charge");

        $pdo->commit();
        return $technicienId;

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
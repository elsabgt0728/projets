-- =========================================================
--  HelpDesk IT — Script de création de base de données
--  Création complète (pas de migration) + données de démo
-- =========================================================

DROP DATABASE IF EXISTS helpdesk;
CREATE DATABASE helpdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE helpdesk;

-- =========================================================
-- 1. TABLE utilisateur — comptes de connexion des techniciens
-- =========================================================

CREATE TABLE utilisateur (
    id_utilisateur  INT AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR(190) NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- =========================================================
-- 2. TABLE technicien — technicien assigné à un ticket
-- =========================================================

CREATE TABLE technicien (
    technicien_id   INT AUTO_INCREMENT PRIMARY KEY,
    Last_name       VARCHAR(100) NOT NULL,
    First_name      VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- =========================================================
-- 3. TABLE Categorie — type d'incident
-- =========================================================

CREATE TABLE Categorie (
    Categorie_id    INT AUTO_INCREMENT PRIMARY KEY,
    Nom             VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- =========================================================
-- 4. TABLE tickets — les incidents
-- =========================================================

CREATE TABLE tickets (
    id_ticket       INT AUTO_INCREMENT PRIMARY KEY,
    titre           VARCHAR(255) NOT NULL,
    description     TEXT NOT NULL,
    statut          ENUM('ouvert', 'en_cours', 'resolu') NOT NULL DEFAULT 'ouvert',
    priorite        ENUM('basse', 'moyenne', 'haute') NOT NULL DEFAULT 'moyenne',
    date_creation   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    technicien_id   INT NULL,
    CONSTRAINT fk_tickets_technicien
        FOREIGN KEY (technicien_id) REFERENCES technicien(technicien_id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================================================
-- 5. TABLE ticket_categorie — association many-to-many
-- =========================================================

CREATE TABLE ticket_categorie (
    id_ticket       INT NOT NULL,
    Categorie_id    INT NOT NULL,
    PRIMARY KEY (id_ticket, Categorie_id),
    CONSTRAINT fk_tc_ticket
        FOREIGN KEY (id_ticket) REFERENCES tickets(id_ticket)
        ON DELETE CASCADE,
    CONSTRAINT fk_tc_categorie
        FOREIGN KEY (Categorie_id) REFERENCES Categorie(Categorie_id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================
-- 6. TABLE ticket_historique — journal des actions (bonus portfolio)
-- =========================================================

CREATE TABLE ticket_historique (
    id_historique   INT AUTO_INCREMENT PRIMARY KEY,
    id_ticket       INT NOT NULL,
    action          ENUM('creation', 'prise_en_charge', 'cloture') NOT NULL,
    date_action     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_historique_ticket
        FOREIGN KEY (id_ticket) REFERENCES tickets(id_ticket)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================
-- 7. PEUPLEMENT — données de démonstration
-- =========================================================

-- Comptes techniciens (connexion). Mots de passe en clair pour la démo :
--   admin@helpdesk.fr      → motdepasse1
--   j.martin@helpdesk.fr   → motdepasse2
--   s.dupuis@helpdesk.fr   → motdepasse3
-- (hashés avec password_hash() / bcrypt, compatibles password_verify() en PHP)

INSERT INTO utilisateur (email, mot_de_passe) VALUES
('admin@helpdesk.fr',    '$2b$10$ceQxF7y.gof0MPQvQeLk1.3XPXOj8vF//87j66zjKxdUoV2M4XHCC'),
('j.martin@helpdesk.fr', '$2b$10$ackRcrOzut3oamYA24dJbuw9zBgXL.9K63aKgb8R4Ges21FFY5Pii'),
('s.dupuis@helpdesk.fr', '$2b$10$Kmo.OrTYvtyDp7HnHT4Fge/.7Awdhlg9vr3.gMM/P23E0B7kTIYlG');

-- Techniciens (peuvent être les mêmes personnes que ci-dessus)
INSERT INTO technicien (Last_name, First_name) VALUES
('Martin', 'Julie'),
('Dupuis', 'Sacha'),
('Nguyen', 'Thomas');

-- Catégories d'incidents IT
INSERT INTO Categorie (Nom) VALUES
('Matériel'),
('Réseau'),
('Logiciel'),
('Compte'),
('Sécurité'),
('Autre');

-- Tickets de démonstration (mélange de statuts et priorités)
INSERT INTO tickets (titre, description, statut, priorite, date_creation, technicien_id) VALUES
('Imprimante RH hors service', 'L''imprimante du service RH affiche un bourrage papier permanent malgré plusieurs tentatives de nettoyage.', 'ouvert', 'haute', '2026-09-28 09:14:00', NULL),
('Accès VPN refusé', 'Impossible de se connecter au VPN depuis hier soir, message "certificat invalide".', 'en_cours', 'moyenne', '2026-09-27 16:40:00', 1),
('Réinitialisation mot de passe', 'L''utilisateur a oublié son mot de passe Active Directory.', 'resolu', 'basse', '2026-09-20 11:05:00', 2),
('Écran externe non détecté', 'Le second écran ne s''allume plus après mise à jour Windows.', 'ouvert', 'moyenne', '2026-09-29 08:02:00', NULL),
('Lenteur anormale du poste', 'Le PC met plus de 10 minutes à démarrer depuis la dernière mise à jour.', 'en_cours', 'moyenne', '2026-09-26 14:22:00', 3),
('Compte verrouillé après tentative suspecte', 'Alerte de sécurité : plusieurs tentatives de connexion échouées sur le compte.', 'ouvert', 'haute', '2026-09-29 10:50:00', NULL),
('Licence Office expirée', 'Le message "licence Office non valide" apparaît au lancement de Word.', 'resolu', 'basse', '2026-09-18 09:30:00', 1),
('Partage réseau inaccessible', 'Le dossier partagé "Comptabilité" n''apparaît plus dans l''explorateur.', 'en_cours', 'haute', '2026-09-28 15:12:00', 2);

-- Association tickets ↔ catégories (many-to-many)
INSERT INTO ticket_categorie (id_ticket, Categorie_id) VALUES
(1, 1),                 -- Imprimante → Matériel
(2, 2),                 -- VPN → Réseau
(2, 5),                 -- VPN → Sécurité
(3, 4),                 -- Mot de passe → Compte
(4, 1),                 -- Écran → Matériel
(5, 3),                 -- Lenteur → Logiciel
(6, 4),                 -- Compte verrouillé → Compte
(6, 5),                 -- Compte verrouillé → Sécurité
(7, 3),                 -- Licence Office → Logiciel
(8, 2);                 -- Partage réseau → Réseau

-- Historique (cohérent avec les statuts ci-dessus)
INSERT INTO ticket_historique (id_ticket, action, date_action) VALUES
(1, 'creation', '2026-09-28 09:14:00'),
(2, 'creation', '2026-09-27 16:40:00'),
(2, 'prise_en_charge', '2026-09-27 17:05:00'),
(3, 'creation', '2026-09-20 11:05:00'),
(3, 'prise_en_charge', '2026-09-20 11:40:00'),
(3, 'cloture', '2026-09-20 13:15:00'),
(4, 'creation', '2026-09-29 08:02:00'),
(5, 'creation', '2026-09-26 14:22:00'),
(5, 'prise_en_charge', '2026-09-26 15:00:00'),
(6, 'creation', '2026-09-29 10:50:00'),
(7, 'creation', '2026-09-18 09:30:00'),
(7, 'prise_en_charge', '2026-09-18 10:00:00'),
(7, 'cloture', '2026-09-18 11:20:00'),
(8, 'creation', '2026-09-28 15:12:00'),
(8, 'prise_en_charge', '2026-09-28 15:45:00');

-- =====================================================================
-- Script de création et de remplissage de la base de données
-- Contexte : Studio photo et vidéo associatif
-- =====================================================================

CREATE DATABASE IF NOT EXISTS studiophoto_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studiophoto_db;

-- ---------------------------------------------------------------------
-- Structure des tables
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS formation_suivie;
DROP TABLE IF EXISTS materiel;
DROP TABLE IF EXISTS formation;
DROP TABLE IF EXISTS categorie_materiel;
DROP TABLE IF EXISTS utilisateur;

CREATE TABLE categorie_materiel (
    id_categorie_materiel INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie          VARCHAR(100) NOT NULL,
    description_categorie  TEXT NULL
);

CREATE TABLE materiel (
    id_materiel            INT AUTO_INCREMENT PRIMARY KEY,
    nom_materiel           VARCHAR(100) NOT NULL,
    description_materiel   TEXT NULL,
    id_categorie_materiel  INT NOT NULL,
    CONSTRAINT fk_materiel_categorie
        FOREIGN KEY (id_categorie_materiel) REFERENCES categorie_materiel(id_categorie_materiel)
);

CREATE TABLE formation (
    id_formation            INT AUTO_INCREMENT PRIMARY KEY,
    nom_formation           VARCHAR(100) NOT NULL,
    duree_minutes           INT NOT NULL,
    id_materiel             INT NULL,
    id_formation_prerequis  INT NULL,
    CONSTRAINT fk_formation_materiel
        FOREIGN KEY (id_materiel) REFERENCES materiel(id_materiel),
    CONSTRAINT fk_formation_prerequis
        FOREIGN KEY (id_formation_prerequis) REFERENCES formation(id_formation)
);

CREATE TABLE utilisateur (
    id_utilisateur   INT AUTO_INCREMENT PRIMARY KEY,
    prenom           VARCHAR(50) NOT NULL,
    nom              VARCHAR(50) NOT NULL,
    statut           ENUM('membre', 'regisseur') NOT NULL DEFAULT 'membre',
    mot_de_passe     VARCHAR(255) NOT NULL,
    email            VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE formation_suivie (
    id_utilisateur INT NOT NULL,
    id_formation   INT NOT NULL,
    PRIMARY KEY (id_utilisateur, id_formation),
    CONSTRAINT fk_fs_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    CONSTRAINT fk_fs_formation FOREIGN KEY (id_formation) REFERENCES formation(id_formation)
);

CREATE TABLE reservation (
    id_reservation   INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur   INT NOT NULL,
    id_materiel      INT NOT NULL,
    date_reservation DATE NOT NULL,
    CONSTRAINT fk_reservation_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    CONSTRAINT fk_reservation_materiel FOREIGN KEY (id_materiel) REFERENCES materiel(id_materiel),
    CONSTRAINT uq_reservation_materiel_date UNIQUE (id_materiel, date_reservation)
);

-- ---------------------------------------------------------------------
-- Remplissage
-- ---------------------------------------------------------------------

INSERT INTO categorie_materiel (nom_categorie, description_categorie) VALUES
('Studio', 'Espace de prise de vue équipé'),
('Éclairage', 'Projecteurs et flashs de studio'),
('Caméra', 'Caméras et appareils photo');

INSERT INTO materiel (nom_materiel, description_materiel, id_categorie_materiel) VALUES
('Studio photo 1', 'Studio avec fond blanc', 1),
('Studio vidéo 1', 'Studio équipé pour la vidéo', 1),
('Kit éclairage A', 'Deux projecteurs sur pied', 2),
('Kit éclairage B', 'Flash annulaire', 2),
('Caméra Sony A7', 'Appareil photo hybride', 3);

-- La formation "Prise de vue en studio" nécessite la formation "Utilisation de l éclairage"
INSERT INTO formation (nom_formation, duree_minutes, id_materiel, id_formation_prerequis) VALUES
('Utilisation de l éclairage', 30, 3, NULL),
('Prise de vue en studio', 45, 1, 1),
('Prise en main caméra', 25, 5, NULL),
('Tournage vidéo studio', 50, 2, 1);

INSERT INTO utilisateur (prenom, nom, statut, mot_de_passe, email) VALUES
('Elsa', 'Martin', 'membre', 'motdepasse1', 'elsa.martin@example.com'),
('Karim', 'Benali', 'membre', 'motdepasse2', 'karim.benali@example.com'),
('Lucie', 'Girard', 'regisseur', 'motdepasse3', 'lucie.girard@example.com'),
('Hugo', 'Petit', 'membre', 'motdepasse4', 'hugo.petit@example.com');

INSERT INTO formation_suivie (id_utilisateur, id_formation) VALUES
(1, 1), (1, 2),
(2, 3),
(3, 1), (3, 2), (3, 3), (3, 4),
(4, 1);

INSERT INTO reservation (id_utilisateur, id_materiel, date_reservation) VALUES
(1, 1, '2026-09-01'),
(2, 5, '2026-09-01'),
(1, 3, '2026-09-02'),
(4, 3, '2026-09-03'),
(2, 5, '2026-09-04'),
(3, 2, '2026-09-05');

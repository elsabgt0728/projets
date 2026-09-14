DROP DATABASE IF EXISTS openlab;

CREATE DATABASE openlab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE openlab;

SET foreign_key_checks = 0;


CREATE TABLE categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT NULL
);

CREATE TABLE machine (
    id_machine INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    id_categorie INT NOT NULL,
    id_formation INT NOT NULL
);

CREATE TABLE formation (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    duree_minutes INT NOT NULL,
    id_prerequis INT NULL
);

CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(60) NOT NULL,
    nom VARCHAR (60) NOT NULL,
    statut ENUM('utilisateur', 'technicien') NOT NULL DEFAULT 'utilisateur',
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE utilisateur_formation (
    id_utilisateur INT NOT NULL,
    id_formation INT NOT NULL,
    date_validation DATE NOT NULL,
    PRIMARY KEY (id_utilisateur, id_formation)
);

CREATE TABLE reservation (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_machine INT NOT NULL,
    date_reservation DATE NOT NULL
);


-- CONSTRAINTS
ALTER TABLE machine
ADD CONSTRAINT fk_machine_categorie FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie) ON UPDATE CASCADE ON DELETE RESTRICT,
ADD CONSTRAINT fk_machine_formation FOREIGN KEY (id_formation) REFERENCES formation (id_formation) ON UPDATE CASCADE ON DELETE RESTRICT ;

ALTER TABLE formation
ADD CONSTRAINT fk_formation_prerequis FOREIGN KEY (id_prerequis) REFERENCES formation (id_formation) ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE utilisateur_formation
ADD CONSTRAINT fk_uf_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT fk_uf_formation FOREIGN KEY (id_formation) REFERENCES formation (id_formation) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE reservation
ADD CONSTRAINT fk_resa_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT fk_resa_machine FOREIGN KEY (id_machine) REFERENCES machine (id_machine) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT uq_machine_jour UNIQUE (id_machine, date_reservation);

SET foreign_key_checks = 1;
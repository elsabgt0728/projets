DROP DATABASE IF EXISTS studio_repetition;
CREATE DATABASE studio_repetition CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studio_repetition;

CREATE TABLE categorie (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE ressource (
    id_ressource INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    id_categorie INT NOT NULL,
    id_formation_associee INT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie)
) ENGINE=InnoDB;

CREATE TABLE formation (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    duree_minutes INT NOT NULL,
    id_ressource_associe INT NULL,
    id_formation_prerequis INT NULL,
    FOREIGN KEY (id_ressource_associe) REFERENCES ressource(id_ressource),
    FOREIGN KEY (id_formation_prerequis) REFERENCES formation(id_formation)
) ENGINE=InnoDB;

ALTER TABLE ressource
    ADD FOREIGN KEY (id_formation_associee) REFERENCES formation(id_formation);

CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(100) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    statut ENUM('musicien','technicien') NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE utilisateur_formation (
    id_utilisateur INT NOT NULL,
    id_formation INT NOT NULL,
    date_validation DATE NOT NULL,
    PRIMARY KEY (id_utilisateur, id_formation),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_formation) REFERENCES formation(id_formation)
) ENGINE=InnoDB;

CREATE TABLE reservation (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_ressource INT NOT NULL,
    date_jour DATE NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_ressource) REFERENCES ressource(id_ressource),
    UNIQUE (id_ressource, date_jour)
) ENGINE=InnoDB;


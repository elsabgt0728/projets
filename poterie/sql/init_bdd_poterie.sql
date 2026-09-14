
DROP DATABASE IF EXISTS  poterie_db;
CREATE DATABASE IF NOT EXISTS poterie_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE poterie_db;

CREATE TABLE categorie_equipement (
    id_categorie_equipement INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie            VARCHAR(100) NOT NULL,
    description_categorie    TEXT NULL
);

CREATE TABLE equipement (
    id_equipement            INT AUTO_INCREMENT PRIMARY KEY,
    nom_equipement           VARCHAR(100) NOT NULL,
    description_equipement   TEXT NULL,
    id_categorie_equipement  INT NOT NULL,
    CONSTRAINT fk_equipement_categorie
        FOREIGN KEY (id_categorie_equipement) REFERENCES categorie_equipement(id_categorie_equipement)
);

CREATE TABLE formation (
    id_formation            INT AUTO_INCREMENT PRIMARY KEY,
    nom_formation           VARCHAR(100) NOT NULL,
    duree_minutes           INT NOT NULL,
    id_equipement           INT NULL,
    id_formation_prerequis  INT NULL,
    CONSTRAINT fk_formation_equipement
        FOREIGN KEY (id_equipement) REFERENCES equipement(id_equipement),
    CONSTRAINT fk_formation_prerequis
        FOREIGN KEY (id_formation_prerequis) REFERENCES formation(id_formation)
);

CREATE TABLE utilisateur (
    id_utilisateur   INT AUTO_INCREMENT PRIMARY KEY,
    prenom           VARCHAR(50) NOT NULL,
    nom              VARCHAR(50) NOT NULL,
    statut           ENUM('adherent', 'animateur') NOT NULL DEFAULT 'adherent',
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
    id_equipement    INT NOT NULL,
    date_reservation DATE NOT NULL,
    CONSTRAINT fk_reservation_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    CONSTRAINT fk_reservation_equipement FOREIGN KEY (id_equipement) REFERENCES equipement(id_equipement),
    CONSTRAINT uq_reservation_equipement_date UNIQUE (id_equipement, date_reservation)
);



INSERT INTO categorie_equipement (nom_categorie, description_categorie) VALUES
('Tour', 'Tour de potier électrique ou à pied'),
('Four', 'Four de cuisson céramique'),
('Table de modelage', 'Table équipée pour le modelage à la main');

INSERT INTO equipement (nom_equipement, description_equipement, id_categorie_equipement) VALUES
('Tour électrique 1', 'Tour de potier électrique réglable', 1),
('Tour électrique 2', 'Tour de potier électrique réglable', 1),
('Four céramique A', 'Four grande capacité', 2),
('Four céramique B', 'Four petite capacité', 2),
('Table modelage 1', 'Table avec réserve d argile', 3);


INSERT INTO formation (nom_formation, duree_minutes, id_equipement, id_formation_prerequis) VALUES
('Sécurité four', 20, NULL, NULL),
('Cuisson au four', 40, 3, 1),
('Tournage au tour', 60, 1, NULL),
('Modelage à la main', 30, 5, NULL);

INSERT INTO utilisateur (prenom, nom, statut, mot_de_passe, email) VALUES
('Elsa', 'Martin', 'adherent', '$2y$10$FaiQUEp255oeLwHqsya5L.7e1SPjsXrKqAymM52Yo4nyr7PPLNjoO', 'elsa.martin@example.com'), // motdepasse1
('Karim', 'Benali', 'adherent', '$2y$10$88WpoChiXSbTAPZQbHGr7.ouzIWP9vLGQnQMlhftijfv/D2g3nmHO', 'karim.benali@example.com'), //motdepasse2
('Lucie', 'Girard', 'animateur', '$2y$10$pL105cYZUryQyE.l48lMqOFYkZLiRs3sVwr3K55LwgO20j.wRi/Xy', 'lucie.girard@example.com'), //motdepasse3
('Hugo', 'Petit', 'adherent', '$2y$10$ptRoWPRNBatQIPGa2Nt9XuM9ezViWhmxwPFNbooLX3rFAkNXyun0O', 'hugo.petit@example.com'); //motdepasse4

INSERT INTO formation_suivie (id_utilisateur, id_formation) VALUES
(1, 3),
(2, 1), (2, 2),
(3, 1), (3, 2), (3, 3), (3, 4),
(4, 4);

INSERT INTO reservation (id_utilisateur, id_equipement, date_reservation) VALUES
(1, 1, '2026-09-01'),
(2, 3, '2026-09-01'),
(1, 1, '2026-09-02'),
(4, 5, '2026-09-03'),
(2, 3, '2026-09-04'),
(3, 2, '2026-09-05');

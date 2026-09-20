DROP DATABASE IF EXISTS library;
CREATE DATABASE IF NOT EXISTS library ;
USE library;

CREATE TABLE borrower(
     Last_name VARCHAR(255),
     First_name VARCHAR(255),
     borrower_id  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE Books(
    id_book INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    namebook VARCHAR(255) UNIQUE ,
    auteur VARCHAR(255),
    borrower_id  INT UNSIGNED,
    statut ENUM('stock','emprunté','maintenance'),
    Foreign Key (borrower_id) REFERENCES borrower(borrower_id)
);

CREATE TABLE utilisateur (
    id_utilisateur   INT AUTO_INCREMENT PRIMARY KEY,
    prenom           VARCHAR(50) NOT NULL,
    nom              VARCHAR(50) NOT NULL,
    mot_de_passe     VARCHAR(255) NOT NULL,
    email            VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE Categorie(
    Categorie_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) UNIQUE
);

CREATE TABLE Book_categorie (
    id_book INT UNSIGNED,
    Categorie_id INT UNSIGNED,
    PRIMARY KEY (Categorie_id, id_book),
    FOREIGN KEY (Categorie_id) REFERENCES Categorie(Categorie_id) ON DELETE CASCADE ,
    FOREIGN KEY (id_book) REFERENCES Books(id_book)
);

INSERT INTO utilisateur (prenom, nom, mot_de_passe, email) VALUES
('Elsa', 'Martin', '$2y$10$FaiQUEp255oeLwHqsya5L.7e1SPjsXrKqAymM52Yo4nyr7PPLNjoO', 'elsa.martin@example.com'), // motdepasse1
('Karim', 'Benali', '$2y$10$88WpoChiXSbTAPZQbHGr7.ouzIWP9vLGQnQMlhftijfv/D2g3nmHO', 'karim.benali@example.com'), //motdepasse2
('Lucie', 'Girard', '$2y$10$pL105cYZUryQyE.l48lMqOFYkZLiRs3sVwr3K55LwgO20j.wRi/Xy', 'lucie.girard@example.com'), //motdepasse3
('Hugo', 'Petit',  '$2y$10$ptRoWPRNBatQIPGa2Nt9XuM9ezViWhmxwPFNbooLX3rFAkNXyun0O', 'hugo.petit@example.com'); //motdepasse4
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

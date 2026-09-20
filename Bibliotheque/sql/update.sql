USE library;
ALTER TABLE Books
ADD COLUMN Categorie_id INT UNSIGNED,
ADD CONSTRAINT fk_categorie
    FOREIGN KEY (Categorie_id) REFERENCES Categorie(Categorie_id);

SHOW CREATE TABLE book_categorie;

ALTER TABLE book_categorie
DROP FOREIGN KEY book_categorie_ibfk_1;

ALTER TABLE Categorie
ADD COLUMN id_book INT UNSIGNED,


-- 1. Convertir l'encodage et la collation
ALTER TABLE Categorie
  CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Rendre Nom obligatoire et réduire sa taille
ALTER TABLE Categorie
  MODIFY Nom VARCHAR(100) NOT NULL;

-- 3. Remplacer l'index UNIQUE automatique par une contrainte nommée
ALTER TABLE Categorie DROP INDEX Nom;
ALTER TABLE Categorie ADD CONSTRAINT uq_categorie_nom UNIQUE (Nom);
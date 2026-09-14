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



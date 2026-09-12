DROP DATABASE IF EXISTS centre_formation;
CREATE DATABASE IF NOT EXISTS centre_formation;

CREATE TABLE cadet(
    cadet_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    promo VARCHAR(255) NOT NULL
);

CREATE TABLE cours(
    cours_id INT AUTO_INCREMENT PRIMARY KEY,
    nom_cours VARCHAR(255) UNIQUE NOT NULL,
   coefficient TINYINT UNSIGNED CHECK (coefficient BETWEEN 1 AND 5)
);

CREATE TABLE cadet_grade(
    grade FLOAT UNSIGNED CHECK (grade <= 20),
    cadet_grade_id INT AUTO_INCREMENT PRIMARY KEY,
    cours_id INT,
    cadet_id INT,
    Foreign Key (cours_id) REFERENCES cours(cours_id),
    Foreign Key (cadet_id) REFERENCES cadet(cadet_id)
);









INSERT INTO cadet (nom, promo) VALUES
('Dupont', 'S1-2024m'),
('Martin', 'S2-2025m'),
('Durand', 'S1-2025f'),
('Bernard', 'S2-2024f'),
('Petit', 'S1-2026m');

INSERT INTO cours (nom_cours, coefficient) VALUES
('Mathématiques', 5),
('Physique', 4),
('Informatique', 5),
('Histoire', 2),
('Sport', 1);

INSERT INTO cadet_grade (grade, cadet_id, cours_id) VALUES

-- Cadet 1
(15.5, 1, 1),
(12.0, 1, 2),
(18.0, 2, 3),
(9.5, 3, 4),
(14.0, 4, 5),
(19.0, 5, 1);
(15.5, 1, 1), (12.0, 1, 1), (18.0, 1, 1),
(16.5, 1, 2),(10.0, 1, 3), (13.5, 1, 3),
(17.0, 1, 4),(18.5, 1, 5),

-- Cadet 2
(11.0, 2, 1), (14.5, 2, 1),
(9.0, 2, 2), (12.0, 2, 2), (15.0, 2, 2),
(16.0, 2, 3),
(13.0, 2, 4), (14.0, 2, 4),
(18.0, 2, 5),

-- Cadet 3
(8.0, 3, 1), (10.5, 3, 1),
(12.0, 3, 2),
(17.5, 3, 3), (19.0, 3, 3),
(11.0, 3, 4),
(14.0, 3, 5), (15.5, 3, 5),

-- Cadet 4
(16.0, 4, 1),
(13.0, 4, 2), (14.5, 4, 2),
(9.5, 4, 3),
(18.0, 4, 4), (17.0, 4, 4),
(12.0, 4, 5),

-- Cadet 5
(19.0, 5, 1), (18.0, 5, 1),
(15.0, 5, 2),
(13.5, 5, 3), (14.0, 5, 3),
(16.0, 5, 4),
(17.5, 5, 5), (18.0, 5, 5);




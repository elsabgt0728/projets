-- ESIEA - Openlab : peuplement (a executer apres create_db.sql)

USE openlab;

SET foreign_key_checks = 0;

INSERT INTO categorie (id_categorie, nom, description) VALUES
(1, 'Impression 3D', 'Imprimantes a depot de filament'),
(2, 'Decoupe',       'Decoupe laser et vinyle'),
(3, 'Soudure',       NULL),
(4, 'Electronique',  'Instruments de mesure et prototypage');

INSERT INTO formation (id_formation, nom, duree_minutes, id_prerequis) VALUES
(1, 'Premiers secours',              120, NULL),
(2, 'Utilisation imprimante 3D',      90, NULL),
(3, 'Utilisation decoupeuse laser',   60,    1),  
(4, 'Utilisation station de soudure', 45, NULL),
(5, 'Securite generale Openlab',      30, NULL);

INSERT INTO machine (id_machine, nom, description, id_categorie, id_formation) VALUES
(1, 'Prusa MK4',           'Imprimante 3D FDM, volume 250x210x220 mm',   1,    2),
(2, 'Bambu Lab X1-Carbon', 'Imprimante 3D FDM rapide multi-materiaux',   1,    2),
(3, 'Trotec Speedy 100',   'Decoupeuse / graveuse laser CO2 60W',        2,    3),
(4, 'Roland CAMM-1',       'Decoupeuse vinyle',                          2,    5),
(5, 'Station JBC CD-2BE',  'Station de soudure a air chaud et fer',      3,    4),
(6, 'Poste de soudure MIG','Poste de soudure a l''arc semi-automatique', 3,    4),
(7, 'Oscilloscope Rigol',  'Oscilloscope numerique 100 MHz',             4,    5);

INSERT INTO utilisateur (id_utilisateur, prenom, nom, statut, mot_de_passe, email) VALUES
(1, 'Alice', 'Martin',  'technicien',  (SHA2(CONCAT("azerty123"), 256)), 'alice.martin@esiea.fr'),
(2, 'Bob',   'Durand',  'utilisateur', (SHA2(CONCAT("azerty123"), 256)), 'bob.durand@esiea.fr'),
(3, 'Chloe', 'Bernard', 'utilisateur', (SHA2(CONCAT("azerty123"), 256)), 'chloe.bernard@esiea.fr'),
(4, 'David', 'Yoshef',   'utilisateur', (SHA2(CONCAT("azerty123"), 256)), 'david.yoshef@esiea.fr'),
(5, 'Emma',  'Lu',   'technicien',  (SHA2(CONCAT("azerty123"), 256)), 'emma.lu@esiea.fr'),
(6, 'Fares', 'Malik',  'utilisateur', (SHA2(CONCAT("azerty123"), 256)), 'fares.malik@esiea.fr');

INSERT INTO utilisateur_formation (id_utilisateur, id_formation, date_validation) VALUES
(1, 1, '2025-09-15'),  
(1, 2, '2025-09-15'),
(1, 3, '2025-09-16'),
(1, 4, '2025-09-16'),
(2, 2, '2025-10-01'),  
(3, 1, '2025-10-02'),  
(3, 3, '2025-10-05'),
(4, 4, '2025-10-10'),  
(5, 1, '2025-09-20'),  
(5, 4, '2025-09-20');

INSERT INTO reservation (id_reservation, id_utilisateur, id_machine, date_reservation) VALUES
(1, 2, 1, '2026-06-20'), 
(2, 2, 4, '2026-06-20'),  
(3, 3, 3, '2026-06-20'),  
(4, 4, 5, '2026-06-20'),  
(5, 6, 7, '2026-06-20'),  
(6, 1, 3, '2026-06-21'),  
(7, 1, 1, '2026-06-21'),  
(8, 5, 2, '2026-06-21');  

SET foreign_key_checks = 1;
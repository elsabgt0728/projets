USE studio_repetition;

INSERT INTO categorie (nom, description) VALUES
('Salle de répétition', NULL),
('Instrument', NULL),
('Matériel son', NULL);

INSERT INTO ressource (nom, description, id_categorie, id_formation_associee) VALUES
('Salle A', 'Grande salle acoustique', 1, NULL),
('Salle B', 'Petite salle pour répétitions individuelles', 1, NULL),
('Guitare électrique', 'Guitare Fender Stratocaster', 2, NULL),
('Batterie', 'Batterie acoustique 5 fûts', 2, NULL),
('Console de mixage', 'Console numérique 32 pistes', 3, NULL);

INSERT INTO formation (nom, duree_minutes, id_ressource_associe, id_formation_prerequis) VALUES
('Sécurité électrique', 60, NULL, NULL),
('Utilisation salle A', 45, 1, NULL),
('Utilisation salle B', 45, 2, NULL),
('Formation guitare électrique', 90, 3, NULL),
('Formation batterie', 120, 4, NULL),
('Utilisation console de mixage', 120, 5, 1);

UPDATE ressource SET id_formation_associee = 2 WHERE nom = 'Salle A';
UPDATE ressource SET id_formation_associee = 3 WHERE nom = 'Salle B';
UPDATE ressource SET id_formation_associee = 4 WHERE nom = 'Guitare électrique';
UPDATE ressource SET id_formation_associee = 5 WHERE nom = 'Batterie';
UPDATE ressource SET id_formation_associee = 6 WHERE nom = 'Console de mixage';

INSERT INTO utilisateur (prenom, nom, statut, mot_de_passe, email) VALUES
('Elsa', 'Borget', 'musicien', 'hash_mdp_elsa', 'elsa@example.com'),
('Luc', 'Martin', 'musicien', 'hash_mdp_luc', 'luc@example.com'),
('Julie', 'Durand', 'technicien', 'hash_mdp_julie', 'julie@example.com');

INSERT INTO utilisateur_formation (id_utilisateur, id_formation, date_validation) VALUES
(1, 2, '2025-05-10'),
(1, 4, '2025-05-15'),
(2, 3, '2025-05-12'),
(2, 5, '2025-05-20'),
(3, 1, '2025-05-08'),
(3, 6, '2025-05-18');

INSERT INTO reservation (id_utilisateur, id_ressource, date_jour) VALUES
(1, 1, '2025-06-01'),
(1, 3, '2025-06-01'),
(2, 2, '2025-06-02'),
(3, 5, '2025-06-03');

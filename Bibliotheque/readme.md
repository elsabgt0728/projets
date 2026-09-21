# 📚 Bibliothèque — Système de gestion de bibliothèque

Application web permettant de gérer le catalogue d'une bibliothèque : ajout, modification et suppression de livres, enregistrement des emprunts et des retours, suivi du statut de chaque ouvrage, avec connexion obligatoire pour toute action de modification.

Projet réalisé dans le cadre de ma formation **Développeur web et web mobile (RNCP niveau 5)** à l'ESIEA.

---

## ✨ Fonctionnalités

### Catalogue (public)
- **Liste de tous les livres** avec titre, auteur, catégories, statut et emprunteur actuel
- Consultation accessible **sans connexion**

### Gestion des livres (connexion requise)
- **Ajout d'un livre** : titre, auteur et une ou plusieurs catégories
- **Modification d'un livre** : formulaire prérempli (titre, auteur, catégories)
- **Suppression d'un livre**
- **Catégories multiples** : un livre peut appartenir à plusieurs catégories (relation N:N)

### Emprunts et retours (connexion requise)
- **Enregistrement d'un emprunt** : associe un livre disponible à un emprunteur (nom + prénom), avec vérification que le livre n'est pas déjà emprunté
- **Enregistrement d'un retour** : remet un livre emprunté en stock et le dissocie de l'emprunteur

### Authentification
- **Page de connexion** (identifiant + mot de passe)
- **Mots de passe hachés** avec `password_hash()` et vérifiés avec `password_verify()` (jamais en clair en base)
- **Session PHP** (`$_SESSION`) pour garder l'utilisateur connecté entre les pages
- **Protection des contrôleurs** : chaque contrôleur sensible (ajout, modification, suppression, emprunt, retour) vérifie la session et redirige vers `login.php` si l'utilisateur n'est pas connecté
- **Déconnexion** qui détruit la session

### Qualité et sécurité
- **Requêtes préparées PDO** sur toutes les requêtes SQL
- **Validation des formulaires** : messages d'erreur affichés dans le formulaire, avec conservation des valeurs saisies
- **Transactions SQL** sur les opérations sensibles (ajout, modification, emprunt, retour) : en cas d'erreur en cours d'opération, aucune modification partielle n'est appliquée à la base
- **Échappement des sorties** avec `htmlspecialchars()` à l'affichage

## 🛠️ Stack technique

| Côté | Technologies |
|---|---|
| Back-end | PHP (PDO, requêtes préparées, sessions) |
| Base de données | MySQL |
| Front-end | HTML5, CSS3 (pas de framework JS) |
| Typographie | Google Fonts — Playfair Display & Inter |
| Architecture | MVC simplifié (Vues / Contrôleurs / Modèles) |

## 📁 Structure du projet

```
Bibliotheque/
├── config/
│   └── db_connect.php              # Connexion PDO à la base (fonction getPDOConnection())
│
├── controller/
│   ├── addbook.php                 # Traite le formulaire d'ajout de livre
│   ├── editbook_controller.php     # Traite le formulaire de modification d'un livre
│   ├── delete_book_controller.php  # Traite la suppression d'un livre
│   ├── addBorrower.php             # Traite le formulaire d'emprunt
│   └── addReturn.php               # Traite le formulaire de retour
│
├── models/
│   ├── addbook_model.php           # Ajout d'un livre + liaisons catégories (transaction), liste des catégories
│   ├── editbook_model.php          # Lecture d'un livre et de ses catégories, modification (transaction)
│   ├── delete_model.php            # Suppression d'un livre
│   ├── addborrower_model.php       # Ajout d'un emprunteur + assignation du livre (transaction)
│   ├── returnbook_model.php        # Traitement d'un retour (transaction)
│   └── book_model.php              # Récupération du catalogue (avec jointures)
│
└── views/
    ├── menu.php                    # Page d'accueil : catalogue + navigation (publique)
    ├── login.php                   # Formulaire de connexion + vérification des identifiants
    ├── logout.php                  # Déconnexion (destruction de la session)
    ├── formulaireAjout.php         # Formulaire d'ajout de livre
    ├── formulaireModification.php  # Formulaire de modification de livre
    ├── formulaireEmprunt.php       # Formulaire d'emprunt
    └── formulaireRetour.php        # Formulaire de retour
```

## 🗄️ Modèle de données

| Table | Colonnes principales | Rôle |
|---|---|---|
| `Books` | `id_book`, `namebook`, `auteur`, `statut`, `borrower_id` | Catalogue des livres. `statut` vaut `stock` ou `emprunté`. |
| `borrower` | `borrower_id`, `First_name`, `Last_name` | Personnes ayant emprunté un livre |
| `Categorie` | `Categorie_id`, `nom` | Catégories de livres (nom unique) |
| `book_categorie` | `id_book`, `categorie_id` | Table de liaison livre ↔ catégorie (relation N:N, clé primaire composée) |
| `users` | `id`, `username`, `password_hash` | Comptes autorisés à gérer le catalogue |

Relations :

- Un livre peut avoir **plusieurs catégories**, et une catégorie peut regrouper **plusieurs livres** (N:N via `book_categorie`).
- Un livre est emprunté par **au plus un emprunteur** à la fois (`Books.borrower_id`).

Création de la table `users` :

```sql
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);
```

## 🚀 Installation

**Prérequis** : PHP 8+, MySQL, un serveur local (XAMPP, WAMP, ou `php -S`)

1. Cloner le dossier `Bibliotheque/` dans ton dossier serveur (ex : `htdocs/`)
2. Créer une base de données MySQL et y importer les 5 tables décrites ci-dessus
3. Ajouter quelques catégories (pour l'instant via phpMyAdmin) :
   ```sql
   INSERT INTO Categorie (nom) VALUES ('Roman'), ('Science-fiction'), ('Bande dessinée');
   ```
4. Configurer la connexion dans `config/db_connect.php` :
   ```php
   function getPDOConnection() {
       return new PDO("mysql:host=localhost;dbname=NOM_DE_TA_BASE;charset=utf8mb4", "utilisateur", "mot_de_passe");
   }
   ```
5. Créer un compte administrateur avec un script temporaire, à ouvrir une fois dans le navigateur puis à **supprimer** :
   ```php
   <?php
   require_once 'config/db_connect.php';
   $pdo = getPDOConnection();

   $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:u, :p)")
       ->execute([':u' => 'admin', ':p' => password_hash('VotreMotDePasse', PASSWORD_DEFAULT)]);
   ```
6. Lancer le serveur (ex : démarrer Apache/MySQL via XAMPP)
7. Ouvrir `views/menu.php` dans le navigateur

## 🧭 Utilisation

- **Sans connexion** : consultation du catalogue sur `menu.php`
- **Connexion** : via la page `login.php`. Une fois connecté, le menu (icône ☰ en haut à gauche) donne accès à **Ajouter un livre**, **Enregistrer un emprunt** et **Enregistrer un retour**
- Le tableau principal liste tous les livres avec leur statut en temps réel
- Le bouton **Modifier** ouvre le formulaire prérempli d'un livre
- Le bouton **Supprimer** retire définitivement un livre du catalogue
- **Déconnexion** via `logout.php`

## 🗺️ Pistes d'évolution

- [x] Modification d'un livre existant (CRUD complet)
- [x] Plusieurs catégories par livre (relation N:N)
- [x] Authentification (connexion requise pour gérer le catalogue)
- [ ] Interface de gestion des catégories (créer, renommer, supprimer depuis l'application, sans passer par phpMyAdmin)
- [ ] Recherche et filtres dans le catalogue
- [ ] Confirmation avant suppression
- [ ] Dates d'emprunt / retour prévu + détection des retards
- [ ] Historique des emprunts
- [ ] Tableau de bord avec statistiques
- [ ] Tests automatisés (PHPUnit) sur les fonctions de modèle

## 👤 Auteure

**Elsa Borget** — Étudiante en développement web & IA à l'ESIEA
[LinkedIn](https://www.linkedin.com/in/elsa-borget) · [GitHub](https://github.com/elsabgt0728)
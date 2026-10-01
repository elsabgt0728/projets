# HelpDesk IT — Outil de gestion de tickets support interne

Application de gestion de tickets pour le support informatique interne d'une entreprise : un employé signale un incident, un technicien le prend en charge puis le clôture une fois résolu.

> Projet migré depuis une application de gestion de bibliothèque (CRUD + authentification + statuts + relation many-to-many) vers un contexte helpdesk IT, plus pertinent pour une recherche d'alternance développeur web.

---

## 1. Fonctionnalités

### Déjà implémentées (dans la version bibliothèque, à renommer/adapter)

- [x] **Authentification technicien** — session PHP, mot de passe hashé (`password_hash` / `password_verify`), redirection si non connecté sur toutes les pages protégées.
- [x] **Tableau de bord** — liste de tous les tickets avec recherche texte (titre / description).
- [x] **Création de ticket** — formulaire avec titre, description et une ou plusieurs catégories (checkboxes), validation serveur, réaffichage des erreurs et conservation des champs saisis (flash session).
- [x] **Modification de ticket** — pré-remplissage du formulaire avec les valeurs actuelles, mêmes règles de validation.
- [x] **Suppression de ticket**.
- [x] **Prise en charge d'un ticket** — assignation à un technicien, avec verrou transactionnel (`FOR UPDATE`) pour éviter qu'un ticket soit pris en charge deux fois en même temps ; vérifie que le ticket est bien encore "ouvert" avant d'autoriser l'action.
- [x] **Clôture d'un ticket** — passage au statut "résolu", même logique transactionnelle de contrôle de statut.
- [x] **Gestion des catégories** multiples par ticket (table d'association).

### À ajouter (pour renforcer le portfolio)

- [ ] **Niveau de priorité** (Basse / Moyenne / Haute) par ticket, avec badge coloré dans le tableau de bord.
- [ ] **Historique du ticket** — table `ticket_historique` journalisant création / prise en charge / clôture avec horodatage, affichée comme une mini-timeline sur la fiche ticket.
- [ ] **Statistiques du tableau de bord** — compteurs "Ouverts / En cours / Résolus" en haut de la page d'accueil.
- [ ] **Filtres combinés** — par statut et par catégorie, en plus de la recherche texte déjà existante.
- [ ] **Protection CSRF** sur tous les formulaires (jeton caché vérifié côté serveur) — bon point à mettre en avant en entretien.
- [ ] **Pagination** de la liste de tickets (au-delà de ~20 lignes).
- [ ] **Tests unitaires** (PHPUnit) sur les fonctions des models (`create_ticket`, `assign_ticket_to_technicien`, etc.) — très valorisé pour une alternance.
- [ ] **Export CSV** de la liste des tickets (fonctionnalité simple à fort effet démo).

---

## 2. Stack technique

- PHP natif (sans framework), architecture **MVC artisanale** : `views/` (formulaires + affichage), `models/` (accès données via PDO), `controller/` (logique de traitement des formulaires).
- **MySQL** via PDO (requêtes préparées partout).
- **Sessions PHP** pour l'authentification et les messages flash (erreurs + anciennes valeurs de formulaire).
- **CSS natif**, sans framework, feuille de style unique et partagée (voir fichier `style.css` fourni séparément).

---

## 3. Modèle de données cible

```
utilisateur
 ├─ id_utilisateur  (PK)
 ├─ email
 └─ mot_de_passe        -- hashé

technicien
 ├─ technicien_id   (PK)
 ├─ Last_name
 └─ First_name

Categorie
 ├─ Categorie_id    (PK)
 └─ Nom                 -- ex: Matériel, Réseau, Logiciel, Compte, Sécurité

tickets
 ├─ id_ticket       (PK)
 ├─ titre
 ├─ description
 ├─ statut              -- 'ouvert' | 'en_cours' | 'resolu'
 ├─ priorite            -- 'basse' | 'moyenne' | 'haute'   (à ajouter)
 ├─ date_creation
 └─ technicien_id   (FK, nullable)  -- renseigné à la prise en charge

ticket_categorie            -- table d'association (many-to-many)
 ├─ id_ticket       (FK)
 └─ Categorie_id    (FK)

ticket_historique            -- à ajouter
 ├─ id_historique   (PK)
 ├─ id_ticket       (FK)
 ├─ action              -- 'creation' | 'prise_en_charge' | 'cloture'
 └─ date_action
```

---

## 4. Guide de migration — fichier par fichier

### Vues (`views/`)

| Fichier actuel | Nouveau fichier | Changements de contenu |
|---|---|---|
| `menu.php` | `dashboard.php` | Titre "Catalogue de la bibliothèque" → "Tableau de bord des tickets". Colonnes du tableau : `Ticket`, `Catégorie`, `Priorité`, `Statut`, `Technicien assigné`, `Action`. Lien nav "Ajouter un livre" → "Créer un ticket", etc. |
| `formulaireAjout.php` | `formulaireCreationTicket.php` | "Ajouter un livre" → "Signaler un incident". Champs `namebook`/`auteur` → `titre`/`description` (passer `auteur` en `<textarea>` description). Garder les checkboxes catégories. |
| `formulaireModification.php` | `formulaireModificationTicket.php` | Mêmes renommages de champs que ci-dessus. |
| `formulaireEmprunt.php` | `formulairePriseEnCharge.php` | "Ajouter un emprunteur" → "Prendre en charge un ticket". Champ `namebook` → sélection du ticket (idéalement un `<select>` des tickets au statut "ouvert" plutôt qu'un champ texte libre). Champs nom/prénom → nom/prénom du **technicien**. |
| `formulaireRetour.php` | `formulaireCloture.php` | "Enregistrer un retour" → "Clôturer un ticket". Champ titre libre → idéalement un `<select>` des tickets "en_cours". |
| `login.php` | `login.php` | Texte "Bibliothèque" → "HelpDesk IT". Icône 📖 → 🎫 ou icône SVG. Reste identique (formulaire + logique inchangés). |

### Models (`models/`)

| Fichier actuel | Nouveau fichier | Changements |
|---|---|---|
| `addbook_model.php` | `ticket_model.php` | `add_book()` → `create_ticket()`. Table `Books` → `tickets`, colonnes `namebook`/`auteur` → `titre`/`description`. `get_categories()` inchangé. |
| `book_model.php` | `ticket_list_model.php` | `list_book()` → `list_tickets()`. Adapter le `SELECT` : jointure sur `technicien` au lieu de `borrower`, colonnes renommées. |
| `editbook_model.php` | `edit_ticket_model.php` | `get_book()` → `get_ticket()`, `get_book_categories()` → `get_ticket_categories()`, `update_book()` → `update_ticket()`. |
| `addborrower_model.php` | `prise_en_charge_model.php` | `add_borrower()` → `add_technicien()` (ou réutiliser un technicien existant si tu ajoutes une liste déroulante). `get_book_by_name()` → `get_ticket_by_titre()`, vérifie `statut === 'ouvert'` au lieu de `'stock'`. `assign_book_to_borrower()` → `assign_ticket_to_technicien()`, passe le statut à `'en_cours'`. |
| `returnbook_model.php` | `cloture_ticket_model.php` | `get_borrowed_book_by_name()` → `get_assigned_ticket_by_titre()`, vérifie `statut === 'en_cours'`. `return_book()` → `resolve_ticket()`, passe le statut à `'resolu'`. |
| `delete_model.php` | `delete_ticket_model.php` | `delete_grade()` → `delete_ticket()`, table `books` → `tickets`. |
| `connexion_model.php` | `connexion_model.php` | Inchangé (authentification générique, déjà bien nommée). |

### Contrôleurs (`controller/`)

| Fichier actuel | Nouveau fichier | Changements |
|---|---|---|
| `addbook.php` | `creation_ticket_controller.php` | Variables `$namebook`/`$autor` → `$titre`/`$description`. Messages d'erreur adaptés ("Le titre du ticket est obligatoire.", etc.). |
| `editbook_controller.php` | `edit_ticket_controller.php` | Mêmes renommages de champs. |
| `addBorrower.php` | `prise_en_charge_controller.php` | Adapter aux nouveaux noms de fonctions du model renommé. |
| `addReturn.php` | `cloture_controller.php` | Idem. |
| `delete_book_controller.php` | `delete_ticket_controller.php` | Idem. |
| `connexion_controller.php` | `connexion_controller.php` | Inchangé. |

### Base de données

- Renommer la table `Books` → `tickets`, colonnes `namebook` → `titre`, `auteur` → `description`.
- Renommer `borrower` → `technicien`.
- Renommer `book_categorie` → `ticket_categorie`, colonne `id_book` → `id_ticket`.
- Ajouter la colonne `priorite ENUM('basse','moyenne','haute') DEFAULT 'moyenne'` sur `tickets`.
- Mettre à jour les valeurs de `statut` : `stock` → `ouvert`, `emprunté` → `en_cours`, ajouter `resolu`.
- Repeupler la table `Categorie` avec des valeurs IT : Matériel, Réseau, Logiciel, Compte, Sécurité, Autre.

### CSS

- Extraire les blocs `<style>` inline de chaque vue vers un fichier unique partagé : `assets/css/style.css` (fourni séparément).
- Chaque vue n'a plus qu'un seul `<link rel="stylesheet" href="../assets/css/style.css">` dans le `<head>`.
- Remplacer les emoji (📖 👤 🔒) par des icônes SVG inline ou une police d'icônes, plus cohérent avec un outil IT professionnel.

---

## 5. Points à mentionner en entretien

- Sécurité : requêtes préparées PDO partout, hashage des mots de passe, verrou transactionnel `FOR UPDATE` pour éviter les accès concurrents sur un même ticket.
- Pattern "flash session" pour conserver les erreurs et les valeurs saisies après une redirection (PRG — Post/Redirect/Get).
- Relation many-to-many proprement modélisée (ticket ↔ catégories) plutôt qu'une colonne texte.
- Architecture en couches (vues / contrôleurs / models) malgré l'absence de framework — montre une compréhension du MVC "from scratch".

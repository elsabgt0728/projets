# Cahier des charges : NovaCRM

Projet DWWM, application CRM pour NovaServices  
Version 1.0, octobre 2026  
Rédigé par Elsa BORGET

> NovaServices est une entreprise fictive, créée pour le projet de la formation.

## Sommaire

1. [Présentation du projet](#1-présentation-du-projet)
2. [Utilisateurs et rôles](#2-utilisateurs-et-rôles)
3. [Besoins fonctionnels](#3-besoins-fonctionnels)
4. [Règles de gestion principales](#4-règles-de-gestion-principales)
5. [Contraintes](#5-contraintes)
6. [Environnement humain et technique](#6-environnement-humain-et-technique)
7. [Livrables attendus](#7-livrables-attendus)
8. [Critères d'acceptation](#8-critères-dacceptation)
9. [Risques](#9-risques)
10. [Planning](#10-planning)
11. [Glossaire](#11-glossaire)

---

## 1. Présentation du projet

### 1.1 Contexte

NovaServices est une PME de 15 salariés qui vend des prestations informatiques à d'autres entreprises : développement sur mesure, infogérance et conseil. L'équipe commerciale compte trois commerciaux et un responsable commercial, sous la direction du dirigeant.

Aujourd'hui, le suivi des clients et des prospects repose sur des fichiers Excel personnels, des boîtes mail et des carnets de notes.

### 1.2 Problème constaté

- Des relances oubliées, donc des ventes perdues.
- Aucune vision globale du chiffre d'affaires prévisionnel pour le dirigeant.
- Un historique des échanges inaccessible aux collègues : quand un commercial est absent, personne ne peut reprendre ses dossiers.
- Des doublons et des informations obsolètes entre les fichiers de chacun.
- Des données personnelles de contacts stockées sans cadre précis (consentement, suppression), ce qui pose un risque vis-à-vis du RGPD.

### 1.3 Objectifs

NovaCRM est une application web, utilisable aussi sur mobile, qui centralise les contacts, les opportunités commerciales, les tâches de relance et l'historique des échanges.

| Objectif | Indicateur de réussite |
|---|---|
| Ne plus oublier de relance | Chaque opportunité active a une tâche à venir, et les tâches en retard sont signalées |
| Donner de la visibilité au dirigeant | Un tableau de bord affiche le chiffre d'affaires pondéré et la répartition par étape |
| Partager l'information | Tout l'historique d'un client est consultable depuis sa fiche (les commerciaux voient tout et ne modifient que leurs données) |
| Respecter le RGPD | Consentement enregistré, export et suppression des données d'un contact possibles |
| Rester simple à utiliser | Un commercial déplace une opportunité d'une étape à l'autre en un geste |

### 1.4 Périmètre

**Inclus :** gestion des entreprises et des contacts, des opportunités (pipeline), des tâches de relance, journal des interactions, tableau de bord, gestion des utilisateurs et des rôles, conformité RGPD de base.

**Exclu (hors périmètre) :** facturation, envoi automatique de mails, synchronisation avec une messagerie ou un agenda externe, application mobile native, intégration à un autre logiciel de l'entreprise.

## 2. Utilisateurs et rôles

| Rôle | Effectif | Besoins principaux | Droits |
|---|---|---|---|
| Commercial | 3 | Suivre ses prospects, ne rien oublier, saisir ses échanges | Voit et modifie uniquement ses propres contacts, opportunités et tâches |
| Manager (responsable commercial) | 1 | Piloter l'équipe, répartir les dossiers | Voit toute l'équipe, réassigne des opportunités, consulte les statistiques |
| Administrateur | 1 | Gérer les accès et les paramètres | Crée et désactive les comptes, modifie les étapes du pipeline et leurs probabilités |

Le dirigeant consulte le tableau de bord via un compte Manager.

## 3. Besoins fonctionnels

Le détail de chaque fonctionnalité, avec ses règles de gestion et ses cas d'utilisation, est dans la partie spécifications fonctionnelles. Les priorités suivent la méthode MoSCoW (Must : indispensable, Should : important, Could : si le temps le permet).

| N° | Fonctionnalité | Priorité |
|---|---|---|
| F1 | Connexion sécurisée et gestion des rôles | Must |
| F2 | Gestion des entreprises clientes et prospects (création, consultation, modification, suppression) | Must |
| F3 | Gestion des contacts rattachés à une entreprise, avec consentement RGPD | Must |
| F4 | Gestion des opportunités : titre, montant, étape, probabilité, date de clôture prévue | Must |
| F5 | Tableau kanban : déplacer une opportunité d'une étape à l'autre sans recharger la page | Must |
| F6 | Tâches de relance liées à une opportunité, avec échéance et signalement des retards | Must |
| F7 | Journal des interactions (appel, mail, rendez-vous, note) | Must |
| F8 | Tableau de bord : chiffre d'affaires pondéré, opportunités par étape, tâches en retard | Must |
| F9 | Administration des utilisateurs et paramétrage des étapes | Must |
| F10 | Export et suppression des données d'un contact (droits RGPD et MongoDB) | Must |
| F11 | Recherche et filtres sur les listes | Should |
| F12 | Page publique de présentation de NovaServices | Should |
| F13 | Export PDF ou CSV des opportunités | Could |
| F14 | Rappels de relance par mail | Could |

## 4. Règles de gestion principales

Elles sont détaillées dans les spécifications fonctionnelles. En voici le résumé.

- Une opportunité suit les étapes dans l'ordre : Nouveau, Rendez-vous, Proposition, Négociation, puis Gagné ou Perdu. Aucune étape ne peut être sautée.
- À partir de l'étape Proposition, le montant est obligatoire et supérieur à zéro.
- Le passage à Perdu exige un motif.
- Le chiffre d'affaires pondéré est la somme des montants multipliés par la probabilité de l'étape de chaque opportunité.
- Le passage à Gagné crée automatiquement une tâche de suivi client et enregistre un événement dans le journal.
- Un commercial ne peut modifier que ses propres opportunités.
- Une tâche dont l'échéance est dépassée est signalée visuellement.

## 5. Contraintes

### 5.1 Techniques

| Domaine | Choix |
|---|---|
| Langage back-end | C#, programmation orientée objet, architecture en couches (contrôleur, service, accès aux données) |
| Framework web | ASP.NET Core Web API : il expose des endpoints REST qui renvoient du JSON |
| Documentation de l'API | Swagger / OpenAPI, généré automatiquement |
| Base de données relationnelle | SQL server |
| Base de données NoSQL | MongoDB, pour le journal des interactions |
| Acces SQL | Entity Framework Core |
| Authentification | ASP.NET Identity, avec cookie HttpOnly et rôles |
| Front-end | React, créé avec Vite, en JavaScript |
| Environnement | Git, Docker et Docker Compose |
| Tests | Tests unitaires et tests de sécurité |
| Maquettes | Figma |
| Navigation | React Router |
| Style | CSS |
| Environnement et déploiement | Git, Docker Compose, serveur web (nginx) pour servir le front |

### 5.2 Sécurité

- Validation systématique des entrées côté client et côté serveur, requêtes paramétrées.
- Protection contre les principales failles web (injection SQL, XSS, CSRF), en suivant le guide de tests OWASP.
- Respect des recommandations de l'ANSSI pour les sites web.
- Compte applicatif de base de données avec droits limités.
- Sauvegarde et restauration de la base de données.

### 5.3 Réglementaires

- **RGPD :** mentions légales, politique de confidentialité, consentement des contacts, droit d'accès et d'effacement.
- **Accessibilité :** application du RGAA (contrastes, étiquettes de formulaire, navigation au clavier). Le glisser-déposer du kanban est doublé d'une alternative au clavier et au toucher.
- **Éco-conception :** peu d'images, polices légères, pas d'animations inutiles.

### 5.4 Organisationnelles

- Application utilisable sur ordinateur et sur mobile.
- Interface en français (possibilité de basculer en anglais via le traducteur automatique).
- Documentation technique et commentaires du code en anglais.
- Projet réalisé seul, pendant la formation, avec des outils gratuits ou open source.
- Livraison finale en juin 2027 (ou avant).

## 6. Environnement humain et technique

- **Client (fictif) :** NovaServices, représentée par son responsable commercial Milene.
- **Développeur :** Elsa Borget, seule sur la conception, le développement, les tests et la documentation.
- **Méthode de travail :** itérations courtes de deux semaines avec un objectif fonctionnel par itération, inspirées des méthodes agiles. Suivi des tâches dans un tableau de type kanban.
- **Outils :** Visual studio , Git et dépôt distant, Docker, outil de qualité de code, Figma, outil de modélisation de base de données.

### Objectifs de qualité

- Code lisible, commenté, respectant les conventions de nommage du langage.
- Chaque règle de gestion couverte par au moins un test unitaire.
- Aucune faille connue du Top 10 OWASP sur les fonctionnalités principales.
- Accessibilité vérifiée avec un outil d'audit.

## 7. Livrables attendus



| Fait | Livrable | Échéance prévue |
|:---:|---|---|
| ✅ | Cahier des charges | Octobre 2026 |
| ✅ | Spécifications fonctionnelles | Octobre 2026 |
| ✅ | Schéma de navigation | Octobre 2026 |
| ✅ | Maquettes Figma (mobile et bureau) et charte graphique | Novembre 2026 |
| ⬜ | Modèle de données (conceptuel, logique, physique), script de création, jeu d'essai de la base | Novembre 2026 |
| ⬜ | Interfaces React fidèles aux maquettes (responsive, RGAA) et page publique HTML/CSS | Novembre à décembre 2026 |
| ⬜ | API en couches, authentification, CRUD entreprises et contacts, Docker Compose | Décembre 2026 |
| ⬜ | Composants métier et d'accès aux données (opportunités, règles de gestion, transaction) | Janvier 2027 |
| ⬜ | Journal MongoDB et front branché à l'API | Janvier 2027 |
| ⬜ | Kanban dynamique, tableau de bord, RGPD (export et suppression) | Février 2027 |
| ⬜ | Tests unitaires et de sécurité, jeu d'essai de la fonctionnalité vedette (gel du code le 30 avril) | Février 2027 |
| ⬜ | Procédure de déploiement, scripts et conteneurs | Mars à Avril 2027 |
| ⬜ | Dossier de projet et diaporama | Rédaction en continu d'octobre 2026 à fin mai 2027 |

## 8. Critères d'acceptation

Le projet est considéré comme réussi si :

1. Toutes les fonctionnalités de priorité Must (F1 à F8 et F10) fonctionnent de bout en bout.
2. Les règles de gestion de la section 4 sont respectées, jeu d'essai à l'appui.
3. Les droits d'accès par rôle sont effectifs : un commercial ne peut pas modifier le dossier d'un autre.
4. Les écrans principaux sont utilisables sur mobile et sur ordinateur.
5. L'application se déploie à partir de la procédure écrite.

## 9. Risques

| Risque | Parade |
|---|---|
| Retard dû à l'apprentissage de C#, react et d'ASP.NET Core | Deux mois de formation et d'exercices avant le développement, marge de trois semaines en fin de projet |
| Projet trop ambitieux | Priorités MoSCoW, les fonctionnalités Could ne sont traitées qu'une fois le reste terminé et testé |
| Difficultés avec MongoDB ou Docker | Usage limité à un seul besoin clair chacun, tests dès février sur un exemple minimal, pas encore vu en cours |
| Perte de données ou de code | Commits Git hebdomadaires, sauvegarde du dépôt et de la base |
| Faille de sécurité découverte tard | Tests de sécurité et veille OWASP tout au long du projet |

## 10. Planning


| Fait | Période | Apprendre | Réaliser (projet CRM) | Dossier |
|:---:|---|---|---|---|
| ✅ | 15 au 31 oct. | C# : classes, héritage, interfaces, collections | Finaliser le cahier des charges, créer le dépôt Git, installer les outils, lancer la veille | Section contexte, début du journal de veille |
| ✅ | 15 au 31 oct. | C# : LINQ, exceptions, async, premiers tests xUnit | Spécifications fonctionnelles (règles métier, cas d'utilisation par rôle) | Résumé des spécifications |
| ⬜ | 1 au 15 nov. | ASP.NET Core Web API et EF Core (mini-API jetable), révision SQL | Schéma de navigation, découverte de Figma sur un écran d'exercice | Schéma de navigation |
| ⬜ | 1 au 15 nov. | JavaScript moderne (modules, async/await, fetch), HTML sémantique et RGAA | Mini-charte graphique, maquettes mobile | |
| ⬜ | 16 au 30 nov. | Rythme allégé : début de la doc officielle de React (react.dev) | Maquettes bureau, relecture de cohérence avec le schéma | Section maquettes |
| ⬜ | 1 au 15 déc. | React 1 : composants, JSX, props, état | MCD, MLD, MPD | |
| ⬜ | 16 au 31 déc. | React 2 : effets, formulaires, React Router, appels à l'API | Script de création, jeu d'essai, utilisateurs et droits, sauvegarde et restauration | Section base de données |
| ⬜ | 1 au 15 janv. | Mini-projet React jetable branché sur une API, bases de Docker | API en couches, EF Core, authentification (cookie HttpOnly, rôles), CRUD entreprises et contacts, Docker Compose | Environnement technique |
| ⬜ | 16 au 30 janv. | Mise en pratique | Interfaces React statiques fidèles aux maquettes (connexion, listes, fiches), responsive, RGAA, page publique HTML/CSS pour le SEO | Section interfaces statiques |
| ⬜ | 1 au 15 fév. | Tests xUnit en pratique | Opportunités et étapes, règles métier, transaction du passage à Gagné, tâches | Extraits de code métier |
| ⬜ | 16 au 28 fév. | MongoDB sur le journal des interactions | Journal MongoDB, front branché à l'API (formulaires, validation, gestion des erreurs) | Section accès aux données |
| ⬜ | 1 au 15 mars | Glisser-déposer accessible au clavier | Kanban dynamique avec bouton « Déplacer vers… », tableau de bord, RGPD (export et suppression) | Section partie dynamique |
| ⬜ | 16 au 31 mars | Guide OWASP, Vitest et React Testing Library | Tests unitaires back et front, tests de sécurité (injection SQL, XSS, CSRF), jeu d'essai, corrections. **Gel du code le 30 avril** | Jeu d'essai, sécurité, veille |
| ⬜ | 1 au 15 avr. | | Déploiement : publication sécurisée (SSH), scripts, procédure écrite, environnements test et production | Procédure de déploiement |
| ⬜ | 16 au 30 avr. | Anglais technique | Aucune nouvelle fonctionnalité, seulement des corrections | Dossier final (30 à 50 pages), annexes (30 pages maximum), diaporama |

### Jalons de contrôle

| Fait | Date | Ce qui doit être terminé |
|:---:|---|---|
| ⬜ | 30 nov. | Spécifications et schéma de navigation validés |
| ⬜ | 31 déc. | Toutes les maquettes terminées |
| ⬜ | 31 janv. | Base de données en place, bases de React acquises |
| ⬜ | 28 fév. | Authentification, CRUD et interfaces statiques |
| ⬜ | 31 mars | Règles métier, MongoDB, front branché à l'API |
| ⬜ | 30 avr. | Code gelé, tests passés |
| ⬜ | 31 mai | Dossier, diaporama et procédure de déploiement finalisés |

## 11.pages de l'application
## Pages de l'application

| # | Page | Rôles | Fonct. | Mène vers |
|---|---|---|---|---|
| 1 | Accueil (publique) | Non connecté | F12 | Connexion, Mentions légales |
| 2 | Connexion | Non connecté | F1 | Menu principal |
| 3 | Mentions légales et confidentialité | Tous | RGPD | Retour |
| 4 | Menu principal | Tous les connectés, boutons selon le rôle | F1 | Toutes les pages ci-dessous |
| 5 | Kanban des opportunités (filtres, indicateurs de retard) | Commercial (les siennes), Manager (toutes) | F5, F6, F11 | Fiche opportunité, formulaire de création |
| 6 | Fiche opportunité | Commercial (les siennes), Manager (toutes) | F4, F6, F7 | Formulaire de modification, Historique, Liste des tâches |
| 7 | Historique des interactions (d'une opportunité) | Commercial (les siennes), Manager (toutes) | F7 | Formulaire interaction |
| 8 | Liste des tâches | Commercial (les siennes), Manager (toutes) | F6 | Formulaire tâche |
| 9 | Liste des entreprises (avec recherche) | Commercial (les siennes), Manager (toutes) | F2, F11 | Formulaire entreprise, Fiche entreprise |
| 10 | Fiche entreprise (avec ses contacts) | Commercial (les siennes), Manager (toutes) | F2, F3 | Formulaire contact, Fiche contact |
| 11 | Fiche contact | Commercial (les siennes), Manager (toutes) | F3, F10 | Formulaire contact, export, confirmation de suppression |
| 12 | Statistiques (graphiques) | Manager | F8 | Retour |
| 13 | Liste des utilisateurs | Administrateur | F9 | Formulaire utilisateur |
| 14 | Paramétrage des étapes | Administrateur | F9 | Retour |

## Écrans complémentaires

| Type | Écrans |
|---|---|
| Formulaires | Opportunité (champ « commercial assigné » réservé au manager), interaction, tâche, entreprise, contact (avec consentement RGPD), utilisateur |
| Confirmation | Confirmation de suppression |
| Erreurs | Accès refusé, Page introuvable |

## 12. Glossaire

| Terme | Définition |
|---|---|
| CRM | Customer Relationship Management : gestion de la relation client |
| Opportunité | Vente potentielle en cours de suivi |
| Pipeline | Suite des étapes d'une opportunité, du premier contact à la vente ou à l'abandon |
| CA pondéré | Montant des opportunités multiplié par la probabilité de réussite de leur étape |
| Kanban | Tableau en colonnes où l'on déplace des cartes d'une étape à l'autre |
| RGPD | Règlement général sur la protection des données |
| RGAA | Référentiel général d'amélioration de l'accessibilité |
| OWASP | Organisation qui publie les principales failles de sécurité web et des guides de tests |

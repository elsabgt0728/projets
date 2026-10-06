<?php
session_start();
require_once '../models/ticket_list_model.php';
require_once 'helpers.php';

$recherche = $_GET["recherche"] ?? "";
$triStatut = $_GET["statut"];
$triCat = $_GET["categorie"];
$resultat = list_tickets($recherche);
$stats = count_tickets_by_statut();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk IT — Tableau de bord</title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
   
</head>
<body>

  <div class="menu">

    <input type="checkbox" id="burger">

    <label id="burger-logo" for="burger">
        <span class="burger-icon"><span></span><span></span><span></span></span>
    </label>

    <nav>
 <?php if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){ ?>

    <a href="login.php">se connecter</a>

 <?php } else {?>

      <a href="formulaireCreationTicket.php">Créer un ticket</a>
      <a href="formulairePriseEnCharge.php">Prendre en charge un ticket</a>
      <a href="formulaireCloture.php">Clôturer un ticket</a>

<?php } ?>

    </nav>
  </div>



  <div class="content">

    <form action="menu.php" method="GET">
        <input type="text" name="recherche" value="<?= htmlspecialchars($_GET["recherche"]?? "" )?>" placeholder="Rechercher un ticket..." >
        <button type="submit">Rechercher</button>
    </form>


    <div class="stat-row">
    <div class="stat-card ouvert">
        <div class="value"><?= $stats['ouvert'] ?></div>
        <div class="label">Tickets ouverts</div>
    </div>
    <div class="stat-card encours">
        <div class="value"><?= $stats['en_cours'] ?></div>
        <div class="label">En cours</div>
    </div>
    <div class="stat-card resolu">
        <div class="value"><?= $stats['resolu'] ?></div>
        <div class="label">Résolus</div>
    </div>
</div>


    <div class="table-wrap">
        <table>
            <caption>Tickets du support IT</caption>
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Catégorie</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Technicien assigné</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php
            foreach ($resultat as $ligne){
            ?>
                <tr>
                    <td><?= $ligne["titre"] ?? "" ?></td>
                    <td><?= $ligne["categorie_nom"] ?? "" ?></td>
                    <td><?= badge_priorite($ligne["priorite"] ?? "") ?></td>
                    <td><?= badge_statut($ligne["statut"] ?? "") ?></td>
                    <td><?= $ligne["First_name"] ?? "" ?> <?= $ligne["Last_name"] ?? "" ?></td>
                    <td>
                        <a href="../controller/delete_ticket_controller.php?id=<?= $ligne["id_ticket"] ?>" class="btn btn-delete">Supprimer</a>
                        <a href="../views/formulaireModificationTicket.php?id=<?= $ligne["id_ticket"] ?>" class="btn btn-modify">Modifier</a>
                        <a href="../views/ticketDetail.php?id=<?= $ligne["id_ticket"] ?>" class="btn btn-modify">Historique</a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
  </div>

</body>
</html>
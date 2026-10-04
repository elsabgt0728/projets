<?php
session_start();
require_once '../models/ticket_list_model.php';
$recherche = $_GET["recherche"] ?? "";
$resultat = list_tickets($recherche);

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
        <input type="text" name="recherche" value="<?= htmlspecialchars($_GET["recherche"]?? "" )?>" placeholder="Rechercher un titre..." >
        <button type="submit">Rechercher</button>
    </form>

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
                    <td><?= $ligne["priorite"] ?? "" ?></td>
                    <td><?= $ligne["statut"] ?? "" ?></td>
                    <td><?= $ligne["First_name"] ?? "" ?> <?= $ligne["Last_name"] ?? "" ?></td>
                    <td>
                        <a href="../controller/delete_ticket_controller.php?id=<?= $ligne["id_ticket"] ?>" class="btn btn-delete">Supprimer</a>
                        <a href="../views/formulaireModificationTicket.php?id=<?= $ligne["id_ticket"] ?>" class="btn btn-modify">Modifier</a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
  </div>

</body>
</html>
<?php
session_start();
require_once '../models/book_model.php';
$recherche = $_GET["recherche"] ?? "";
$resultat = list_book($recherche);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
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

      <a href="formulaireAjout.php">Ajouter un livre</a>
      <a href="formulaireEmprunt.php">Enregistrer un emprunt</a>
      <a href="formulaireRetour.php">Enregistrer un retour</a>

<?php } ?>

    </nav>
  </div>



  <div class="content">

    <form action="menu.php" method="GET">
        <input type="text" name="recherche" value="<?= htmlspecialchars($_GET["recherche"]?? "" )?>" placeholder="Rechercher un titre ou un auteur..." >
        <button type="submit">Rechercher</button>
    </form>

    <div class="table-wrap">
        <table>
            <caption>Catalogue de la bibliothèque</caption>
            <thead>
                <tr>
                    <th>Liste des livres</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Statut</th>
                    <th>Emprunteur</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php
            foreach ($resultat as $ligne){
            ?>
                <tr>
                    <td><?= $ligne["namebook"] ?? "" ?></td>
                    <td><?= $ligne["categorie_nom"] ?? "" ?></td>
                    <td><?= $ligne["auteur"] ?? "" ?></td>
                    <td><?= $ligne["statut"] ?? "" ?></td>
                    <td><?= $ligne["First_name"] ?? "" ?> <?= $ligne["Last_name"] ?? "" ?></td>
                    <td>
                        <a href="../controller/delete_book_controller.php?id=<?= $ligne["id_book"] ?>" class="btn btn-delete">Supprimer</a>
                        <a href="../views/formulaireModification.php?id=<?= $ligne["id_book"] ?>" class="btn btn-modify">Modifier</a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
  </div>

</body>
</html>
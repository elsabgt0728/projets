<?php

require_once '../models/book_model.php';
$resultat = list_book();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --cream: #f6efe3;
            --wood: #6b4226;
            --wood-dark: #4a2c1a;
            --maroon: #7c2a2a;
            --maroon-dark: #5e1f1f;
            --ink: #2b241b;
            --gold: #c9a227;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            /* Fond "rayonnage de livres" fait en SVG + dégradé, pas besoin d'image externe */
            background-image:
                linear-gradient(180deg, rgba(246,239,227,0.94), rgba(246,239,227,0.88)),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='240' viewBox='0 0 400 240'%3E%3Crect width='400' height='240' fill='%23f0e6d2'/%3E%3Cg%3E%3Crect x='0' y='40' width='400' height='14' fill='%236b4226'/%3E%3Crect x='0' y='130' width='400' height='14' fill='%236b4226'/%3E%3Crect x='0' y='220' width='400' height='14' fill='%236b4226'/%3E%3C/g%3E%3Cg%3E%3Crect x='10' y='10' width='16' height='30' fill='%237c2a2a'/%3E%3Crect x='28' y='6' width='14' height='34' fill='%23c9a227'/%3E%3Crect x='44' y='14' width='18' height='26' fill='%235e1f1f'/%3E%3Crect x='64' y='8' width='12' height='32' fill='%236b4226'/%3E%3Crect x='78' y='12' width='20' height='28' fill='%237c2a2a'/%3E%3Crect x='100' y='4' width='14' height='36' fill='%23c9a227'/%3E%3Crect x='116' y='10' width='16' height='30' fill='%234a2c1a'/%3E%3Crect x='134' y='6' width='18' height='34' fill='%237c2a2a'/%3E%3Crect x='154' y='14' width='12' height='26' fill='%236b4226'/%3E%3Crect x='168' y='8' width='16' height='32' fill='%23c9a227'/%3E%3Crect x='186' y='12' width='20' height='28' fill='%235e1f1f'/%3E%3Crect x='208' y='6' width='14' height='34' fill='%236b4226'/%3E%3Crect x='224' y='10' width='16' height='30' fill='%237c2a2a'/%3E%3Crect x='242' y='4' width='18' height='36' fill='%23c9a227'/%3E%3Crect x='262' y='12' width='12' height='28' fill='%234a2c1a'/%3E%3Crect x='276' y='8' width='20' height='32' fill='%236b4226'/%3E%3Crect x='298' y='14' width='14' height='26' fill='%237c2a2a'/%3E%3Crect x='314' y='6' width='16' height='34' fill='%23c9a227'/%3E%3Crect x='332' y='10' width='18' height='30' fill='%235e1f1f'/%3E%3Crect x='352' y='4' width='12' height='36' fill='%236b4226'/%3E%3Crect x='366' y='12' width='20' height='28' fill='%237c2a2a'/%3E%3Crect x='388' y='8' width='10' height='32' fill='%23c9a227'/%3E%3C/g%3E%3C/svg%3E");
            background-size: cover, 400px 240px;
            background-attachment: fixed, fixed;
        }

        h1{
            font-family: 'Playfair Display', serif;
            color: var(--wood-dark);
        }

        /* ---------- Burger / menu ---------- */
        #burger { display: none; }

        #burger-logo {
            cursor: pointer;
            position: fixed;
            top: 0; left: 0;
            z-index: 20;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            width: 220px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            color: var(--cream);
            padding: 14px 16px;
            transform: translateX(-176px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.25);
        }

        .burger-icon{
            display: inline-flex;
            flex-direction: column;
            gap: 5px;
            width: 22px;
        }
        .burger-icon span{
            display: block;
            height: 2px;
            background: var(--cream);
            border-radius: 2px;
            transition: 0.35s;
        }
        #burger:checked ~ #burger-logo .burger-icon span:nth-child(1){ transform: translateY(7px) rotate(45deg); }
        #burger:checked ~ #burger-logo .burger-icon span:nth-child(2){ opacity: 0; }
        #burger:checked ~ #burger-logo .burger-icon span:nth-child(3){ transform: translateY(-7px) rotate(-45deg); }

        nav {
            position: fixed;
            top: 0; left: 0; height: 100vh;
            z-index: 10;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, var(--wood-dark), var(--ink));
            overflow: hidden;
            width: 220px;
            padding-top: 64px;
            transform: translateX(-220px);
            box-shadow: 2px 0 16px rgba(0,0,0,0.35);
        }

        #burger-logo,
        nav {
            transition: transform 0.5s ease;
        }

        #burger:checked ~ #burger-logo,
        #burger:checked ~ nav {
            transform: translateX(0);
        }

        nav a {
            color: var(--cream);
            text-decoration: none;
            padding: 14px 20px;
            font-weight: 500;
            letter-spacing: 0.2px;
            border-left: 3px solid transparent;
            transition: background 0.2s, border-color 0.2s;
        }

        nav a:hover {
            background: rgba(255,255,255,0.08);
            border-left-color: var(--gold);
        }

        .page-hint{
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px;
            text-align: center;
        }

        /* ---------- Tableau : liste des livres ---------- */
        .content{
            padding: 56px 40px;
            display: flex;
            justify-content: center;
        }

        .table-wrap{
            width: 100%;
            max-width: 1100px;
            background: #fffdf8;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(74,44,26,0.18);
            border: 1px solid #e7dcc6;
            overflow: hidden;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 0.92rem;
        }

        caption{
            caption-side: bottom;
            padding: 14px;
            font-style: italic;
            font-size: 0.85rem;
            color: var(--wood);
            background: #fbf6ec;
        }

        thead tr{
            background: linear-gradient(90deg, var(--wood-dark), var(--maroon-dark));
        }

        th{
            color: var(--cream);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-size: 0.78rem;
            text-align: left;
            padding: 16px 18px;
            border: none;
        }

        td{
            padding: 14px 18px;
            border-bottom: 1px solid #ecdfc2;
            color: var(--ink);
            vertical-align: middle;
        }

        tbody tr{
            background: #fffdf8;
            transition: background 0.15s;
        }

        tbody tr:nth-child(even){
            background: #fbf3e3;
        }

        tbody tr:hover{
            background: #f3e4bd;
        }

        tbody tr:last-child td{
            border-bottom: none;
        }

        .btn{
            display: inline-block;
            color: var(--cream);
            text-decoration: none;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 7px 16px;
            border-radius: 20px;
            border: none;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn + .btn{ margin-left: 6px; }

        .btn:hover{
            transform: translateY(-1px);
            opacity: 0.92;
        }

        .btn-edit{
            color: var(--ink);
            background: linear-gradient(135deg, var(--gold), #a9821e);
            box-shadow: 0 4px 10px rgba(201,162,39,0.35);
        }

        .btn-delete{
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            box-shadow: 0 4px 10px rgba(124,42,42,0.35);
        }
    </style>
</head>
<body>

  <div class="menu">

    <input type="checkbox" id="burger">

    <label id="burger-logo" for="burger">
        <span class="burger-icon"><span></span><span></span><span></span></span>
    </label>

    <nav>

      <a href="formulaireAjout.php">Ajouter un livre</a>
      <a href="formulaireEmprunt.php">Enregistrer un emprunt</a>
      <a href="formulaireRetour.php">Enregistrer un retour</a>

    </nav>
  </div>

  <div class="content">
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
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
  </div>

</body>
</html>
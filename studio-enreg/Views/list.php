  <?php
   setcookie('username', 'Elsa', time() + 86400, "/"); // le slash signifie peu importe le dossier ou la page 
   setcookie('userprenom', 'BORGET', time() + 86400, "/");
   setcookie('id_utilisateur', '6', time() + 86400, "/");

     require_once '../models/list_model.php';
     require_once '../config/db_connect.php';
     $list = display_list()
     ?>

     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        margin: 0;
        padding: 40px 20px;
        background-color: #f4f5f7;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 900px;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        font-size: 0.95rem;
    }

    thead {
        background-color: #2c3e50;
    }

    th {
        color: #ffffff;
        text-align: left;
        padding: 14px 16px;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    td {
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
        color: #333;
    }

    tbody tr {
        transition: background-color 0.2s ease;
    }

    tbody tr:nth-child(even) {
        background-color: #fafbfc;
    }

    tbody tr:hover {
        background-color: #f0f4ff;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .btn {
        display: inline-block;
        color: #ffffff;
        text-decoration: none;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 8px 18px;
        border-radius: 20px;
        border: none;
        background: #2c3e50;
        transition: all 0.2s ease;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn:hover {
        background: #1a252f;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 600px) {
        table {
            font-size: 0.8rem;
        }

        th, td {
            padding: 10px 8px;
        }

        .btn {
            font-size: 0.65rem;
            padding: 6px 12px;
        }
    }
</style>


<body>

<table>
    <thead>
        <tr>
            <th>Nom de la ressource</th>
            <th>Categorie</th>
            <th>Formation obligatoire</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
  <?php
    foreach ($list as $ligne){
    ?>
        <tr>
         <td><?= $ligne["instrument"] ?> </td>
         <td><?= $ligne["categorie"] ?></td>
         <td><?= $ligne["formation"]  ?></td>
         <td><a href="../Views/reservation.php?id=<?= $ligne["id_ressource"] ?>" class="btn">Reserver</a></td>
        </tr>

    <?php } ?>

    </tbody>
</table>

</body>
</html>
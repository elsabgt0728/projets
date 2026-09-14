  <?php
   setcookie('user_id', '7', time() + 86400, "/");
   setcookie('username', 'Elsa', time() + 86400, "/"); // le slash signifie peu importe le dossier ou la page 
   setcookie('userprenom', 'BORGET', time() + 86400, "/");

     require_once '../models/display_list_models.php';
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
    
/* ----- Reset ----- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: #f5f7fb;
  font-family: "Inter", sans-serif;
  display: flex;
  justify-content: center;
  padding: 40px 0;
}

/* ----- Table container ----- */
table {
  width: 90%;
  max-width: 1100px;
  border-collapse: collapse;
  background: #ffffff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* ----- Header ----- */
thead {
  background: #1e3a8a;
  color: #ffffff;
}

thead th {
  padding: 14px;
  font-size: 0.9rem;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

/* ----- Rows ----- */
tbody tr {
  border-bottom: 1px solid #e5e7eb;
  transition: background 0.2s ease;
}

tbody tr:hover {
  background: #f0f4ff;
}

td {
  padding: 14px;
  font-size: 0.95rem;
  color: #1f2937;
}

/* ----- Button ----- */
.btn {
  display: inline-block;
  background: #2563eb;
  color: #ffffff;
  text-decoration: none;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  transition: background 0.2s ease, transform 0.15s ease;
}

.btn:hover {
  background: #1d4ed8;
  transform: translateY(-2px);
}

.btn:active {
  transform: scale(0.97);
}

/* ----- Responsive ----- */
@media (max-width: 600px) {
  table {
    width: 100%;
  }

  thead {
    display: none;
  }

  tbody tr {
    display: block;
    margin-bottom: 14px;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  }

  tbody td {
    display: flex;
    justify-content: space-between;
    padding: 12px 16px;
  }

  tbody td::before {
    content: attr(data-label);
    font-weight: 600;
    color: #374151;
  }
}

    </style>


<body>

<table>
    <thead>
        <tr>
            <th>Nom de la machine</th>
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
  <td data-label="Nom de la machine"><?= $ligne["nom"] ?></td>
  <td data-label="Categorie"><?= $ligne["nom"] ?></td>
  <td data-label="Formation obligatoire"><?= $ligne["nom"] ?></td>
  <td data-label="Actions">
    <a href="../Views/reservation.php?id=<?= $ligne["id_machine"] ?>" class="btn">Reserver</a>
</td>
        </tr>

    <?php } ?>

    </tbody>
</table>

</body>
</html>
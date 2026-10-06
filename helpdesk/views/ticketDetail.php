<?php
session_start();

require_once '../models/edit_ticket_model.php';
require_once '../models/ticket_model.php';
require_once 'helpers.php';


if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
    exit;
}


$id   = (int) ($_GET['id'] ?? 0);
$book = get_ticket($id);

if (!$book) {
    header("Location: dashboard.php");
    exit;
}

$historique = recup_historique($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  
</head>

<body>

   <h1>Historique « <?= htmlspecialchars($book['titre']) ?> »</h1>

        <ul> 
    <?php foreach ($historique as $h): ?>
        <li>
           <?= badge_action($h["action"]) ?>
           — <?= htmlspecialchars($h["date_action"]) ?>
       </li>
    <?php endforeach; ?>

      </ul>

</body>
</html>


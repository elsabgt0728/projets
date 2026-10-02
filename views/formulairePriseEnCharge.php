<?php
require_once '../models/prise_en_charge_model.php';
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
    <h1>Prendre en charge un ticket</h1>

    <form action="../controller/prise_en_charge_controller.php" method="POST">
        <label for="name">Ticket à prendre en charge (titre) :</label>
        <input type="text" id="titre" name="titre">

        <label for="nomtechnicien">Nom du technicien :</label>
        <input type="text" id="nomtechnicien" name="nomtechnicien">

        <label for="prenomtechnicien">Prénom du technicien :</label>
       <input type="text" id="prenomtechnicien" name="prenomtechnicien">
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html> 
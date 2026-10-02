<?php 
 require_once '../models/ticket_model.php';
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

    <h1>Signaler un incident</h1>

    <form action="../controller/creation_ticket_controller.php" method="POST">
        <label for="name">Titre de l'incident :</label>
        <input type="text" id="titre" name="titre" placeholder="Imprimante RH hors service" value="<?= htmlspecialchars($anciennes['titre'] ?? '') ?>">>
        
        <label for="description">Description :</label>
        <textarea id="description" name="description" placeholder="Détaillez le problème rencontré"><?= htmlspecialchars($anciennes['description'] ?? '') ?></textarea>
        
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>

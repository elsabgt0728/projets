<?php
session_start(); 
 require_once '../models/ticket_model.php';

 if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

$erreurs   = $_SESSION['erreurs'] ?? [];
$anciennes = $_SESSION['anciennes'] ?? [];
unset($_SESSION['erreurs'], $_SESSION['anciennes']); // affichées une seule fois

$categories = get_categories();

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

     <?php if (!empty($erreurs)): ?>
        <div class="alert alert-error" role="alert">
            <ul>
                <?php foreach ($erreurs as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?> 

    <form action="../controller/creation_ticket_controller.php" method="POST">
        <label for="name">Titre de l'incident :</label>
        <input type="text" id="titre" name="titre" placeholder="Imprimante RH hors service" value="<?= htmlspecialchars($anciennes['titre'] ?? '') ?>">
        
        <label for="description">Description :</label>
        <textarea id="description" name="description" placeholder="Détaillez le problème rencontré"><?= htmlspecialchars($anciennes['description'] ?? '') ?></textarea>
        
        <?php foreach ($categories as $c): ?>
        <label>
            <input type="checkbox" name="categories[]"
                   value="<?= (int) $c['Categorie_id'] ?>"
                   <?= in_array($c['Categorie_id'], $anciennes['categories'] ?? []) ? 'checked' : '' ?>>
            <?= htmlspecialchars($c['Nom']) ?>
        </label>
        <?php endforeach; ?>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>

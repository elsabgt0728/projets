<?php
session_start();
require_once '../models/addbook_model.php';

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

    <?php if (!empty($erreurs)): ?>
        <div class="erreurs" role="alert">
            <ul>
                <?php foreach ($erreurs as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <h1>Ajouter un livre</h1>

    <form action="../controller/addbook.php" method="POST">
        <label for="name">Nom du livre:</label>
        <input type="text" id="namebook" name="namebook" placeholder="Titre" value="<?= htmlspecialchars($anciennes['namebook'] ?? '') ?>">>
        <label for="name">Auteur:</label>
        <input type="text" id="auteur" name="auteur" placeholder="Auteur" value="<?= htmlspecialchars($anciennes['auteur'] ?? '') ?>">>
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

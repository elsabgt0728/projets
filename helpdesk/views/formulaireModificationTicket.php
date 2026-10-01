<?php
session_start();

require_once '../models/addbook_model.php';

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/editbook_model.php';

// 1. Quel livre modifier ? (id dans l'URL : editbook.php?id=3)
$id   = (int) ($_GET['id'] ?? 0);
$book = get_book($id);

if (!$book) {
    header("Location: menu.php");
    exit;
}

// 2. Erreurs et anciennes valeurs (si on revient après une erreur)
$erreurs   = $_SESSION['erreurs'] ?? [];
$anciennes = $_SESSION['anciennes'] ?? [];
unset($_SESSION['erreurs'], $_SESSION['anciennes']);

// 3. Valeurs à afficher : celles de l'erreur si elles existent, sinon celles de la base
$titre      = $anciennes['namebook']   ?? $book['namebook'];
$auteur     = $anciennes['auteur']     ?? $book['auteur'];
$cochees    = $anciennes['categories'] ?? get_book_categories($id);

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

   <h1>Modifier « <?= htmlspecialchars($book['namebook']) ?> »</h1>

<?php if (!empty($erreurs)): ?>
    <div class="erreurs" role="alert">
        <ul>
            <?php foreach ($erreurs as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="../controller/editbook_controller.php">
    <!-- L'id voyage dans un champ caché pour que le contrôleur sache quel livre modifier -->
    <input type="hidden" name="id" value="<?= (int) $book['id_book'] ?>">

    <input type="text" name="namebook" placeholder="Titre" value="<?= htmlspecialchars($titre) ?>">
    <input type="text" name="auteur" placeholder="Auteur" value="<?= htmlspecialchars($auteur) ?>">

    <?php foreach ($categories as $c): ?>
        <label>
            <input type="checkbox" name="categories[]"
                   value="<?= (int) $c['Categorie_id'] ?>"
                   <?= in_array((int) $c['Categorie_id'], $cochees) ? 'checked' : '' ?>>
            <?= htmlspecialchars($c['Nom']) ?>
        </label>
    <?php endforeach; ?>

    <button type="submit">Enregistrer</button>
    <a href="menu.php">Annuler</a>
</form>

</body>
</html>
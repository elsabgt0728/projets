<?php
session_start();

require_once '../models/edit_ticket_model.php';
if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
    exit;
}


$id   = (int) ($_GET['id'] ?? 0);
$book = $book = get_ticket($id);

if (!$book) {
    header("Location: dashboard.php");
    exit;
}

$erreurs   = $_SESSION['erreurs'] ?? [];
$anciennes = $_SESSION['anciennes'] ?? [];
unset($_SESSION['erreurs'], $_SESSION['anciennes']);

$titre      = $anciennes['titre']   ?? $book['titre'];
$description     = $anciennes['description']     ?? $book['description'];
$cochees    = $anciennes['categories'] ?? get_ticket_categories($id);

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

   <h1>Modifier « <?= htmlspecialchars($book['titre']) ?> »</h1>

<?php if (!empty($erreurs)): ?>
    <div class="erreurs" role="alert">
        <ul>
            <?php foreach ($erreurs as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="../controller/edit_ticket_controller.php">
    <!-- L'id voyage dans un champ caché pour que le contrôleur sache quel livre modifier -->
    <input type="hidden" name="id" value="<?= (int) $book['id_ticket'] ?>">

    <input type="text" name="titre" placeholder="Titre" value="<?= htmlspecialchars($titre) ?>">
<textarea name="description" placeholder="Description"><?= htmlspecialchars($description) ?></textarea>


    <?php foreach ($categories as $c): ?>
        <label>
            <input type="checkbox" name="categories[]"
                   value="<?= (int) $c['Categorie_id'] ?>"
                   <?= in_array((int) $c['Categorie_id'], $cochees) ? 'checked' : '' ?>>
            <?= htmlspecialchars($c['Nom']) ?>
        </label>
    <?php endforeach; ?>

    <button type="submit">Enregistrer</button>
    <a href="dashboard.php">Annuler</a>
</form>

</body>
</html>
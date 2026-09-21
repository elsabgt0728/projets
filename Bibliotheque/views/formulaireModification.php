<?php
session_start();
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
 
        body{
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            padding: 24px;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background: radial-gradient(circle at 20% 20%, #fbf6ec, var(--cream) 60%);
        }
 
        .card{
            width: 100%;
            max-width: 440px;
            background: #fffdf8;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(74,44,26,0.18);
            overflow: hidden;
            border: 1px solid #e7dcc6;
        }
 
        .card-accent{
            height: 8px;
            background: linear-gradient(90deg, var(--maroon), var(--gold));
        }
 
        .card-body{ padding: 34px 32px 32px; }
 
        h1{
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--wood-dark);
            margin: 0 0 26px;
            text-align: center;
        }
 
        form{
            display: flex;
            flex-direction: column;
        }
 
        label{
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--wood-dark);
            margin-bottom: 6px;
        }
 
        input[type="text"]{
            font-family: inherit;
            font-size: 1rem;
            padding: 12px 14px;
            border: 1.5px solid #ddcfae;
            border-radius: 8px;
            background: #fffef9;
            margin-bottom: 20px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
 
        input[type="text"]:focus{
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,162,39,0.25);
        }
 
        button{
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            color: var(--cream);
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            border: none;
            border-radius: 8px;
            padding: 13px;
            margin-top: 6px;
            transition: transform 0.15s, box-shadow 0.15s;
        }
 
        button:hover{
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(124,42,42,0.35);
        }
 
        .back-link{
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--wood);
            text-decoration: none;
        }
        .back-link:hover{ color: var(--maroon); text-decoration: underline; }

        .erreurs {
            background: #fdecea;
            border: 1px solid #f5c2c0;
            border-left: 5px solid #d93025;
            color: #b3261e;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        .erreurs ul {
            margin: 0;
            padding-left: 18px;
        }

    </style>
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
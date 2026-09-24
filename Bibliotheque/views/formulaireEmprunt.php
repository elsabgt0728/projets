<?php
session_start();

if( !isset ($_SESSION["isAuthenticated"]) || $_SESSION["isAuthenticated"] !== true){
    header("Location: ../views/login.php");
exit;
}

require_once '../models/addbook_model.php';
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
            flex-direction: column;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background: radial-gradient(circle at 80% 20%, #fbf6ec, var(--cream) 60%);
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
            background: linear-gradient(90deg, var(--gold), var(--maroon));
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
            /* correction : "align item : center" (invalide) -> align-items retiré, inutile en colonne pleine largeur */
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
    </style>
</head>
<body>
    <h1>Ajouter un emprunteur</h1>

    <form action="../controller/addBorrower.php" method="POST">
        <label for="name">Nom du livre :</label>
        <input type="text" id=namebook name="namebook">

        <label for="name">Nom de l'emprunteur :</label>
        <input type="text" id="nameborrower" name="nameborrower">

        <label for="surname">Prenom de l'emprunteur :</label>
        <input type="text" id="surnameborrower" name="surnameborrower">

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html> 
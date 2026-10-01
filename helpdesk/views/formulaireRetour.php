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
    <link rel="stylesheet" href="../public/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
   
</head>
<body>
    <h1>Enregistrer un retour</h1>

    <form action="../controller/addreturn.php" method="POST">
        <label for="name">Nom du livre :</label>
        <input type="text" id=namebook name="namebook">
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
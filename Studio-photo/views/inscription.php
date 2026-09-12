<?php
require_once '../config/db_connect.php';
require_once '../models/inscription_model.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        padding: 40px 20px;
        background-color: #f4f5f7;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
        max-width: 420px;
        margin: 0 auto;
        padding: 32px 32px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        color: #333;
    }

    label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #555;
        margin-bottom: -8px;
    }

    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #333;
        background-color: #fafafa;
        transition: border-color 0.2s ease, background-color 0.2s ease;
        font-family: inherit;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    select:focus {
        outline: none;
        border-color: #2c3e50;
        background-color: #ffffff;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        cursor: pointer;
    }

    button[type="submit"] {
        margin-top: 8px;
        padding: 10px 18px;
        border: none;
        border-radius: 20px;
        background: #2c3e50;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    button[type="submit"]:hover {
        background: #1a252f;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 500px) {
        form {
            padding: 22px 22px;
        }
    }
</style>
</head>
<body>
    <form action="../controllers/inscription_controller.php" method="POST">

        <label for="">Nom :</label>
        <input type="text" name="nom">

        <label for="">Prenom :</label>
        <input type="text" name="prenom">

        <label for="">statut :</label>
       <select name="statut" id="statut" required>
         <option value="" disabled selected>Choix du statut</option>
         <option value="membre">Membre</option>
    </select>

        <label for="">Mot de passe :</label>
        <input type="text" name="mdp">

         <label for="">email :</label>
        <input type="text" name="email">

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
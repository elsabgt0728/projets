<?php
session_start()
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Bibliothèque</title>
    <link rel="stylesheet" href="../public/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
</head>
<body>

    <div class="auth">

        <div class="auth-brand">
            <div class="brand-icon">📖</div>
            <h1>Bibliothèque</h1>
            <div class="brand-divider"></div>
            <p>Gérez le catalogue, les emprunts et les retours en toute simplicité.</p>
        </div>

        <div class="auth-form">
            <h2>Connexion</h2>
            <p class="subtitle">Entrez vos identifiants pour accéder à l'espace de gestion.</p>

            <!-- erreur de connexion -->
             <p class="error-msg">Identifiant ou mot de passe incorrect.</p> 

            <form action="../controller/connexion_controller.php" method="POST">
                <div class="field">
                    <label for="identifiant">Identifiant</label>
                    <div class="input-wrap">
                        <span class="icon">👤</span>
                        <input type="text" id="email" name="email" placeholder="votre identifiant" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrap">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="field-row">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                    <a class="forgot" href="#">Mot de passe oublié ?</a>
                </div>

                <button type="submit">Se connecter →</button>
            </form>

            <a class="back-link" href="menu.php">← Retour au catalogue</a>
        </div>

    </div>

</body>
</html>
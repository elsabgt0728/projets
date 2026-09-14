<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($erreur)) {
    $erreur = "";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* ----- Reset ----- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Inter", sans-serif;
  background: #f3f4f6;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 20px;
}

/* ----- Card ----- */
.login-card {
  background: #ffffff;
  width: 100%;
  max-width: 420px;
  padding: 32px;
  border-radius: 16px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 12px 40px rgba(0,0,0,0.08);
}

/* ----- Title ----- */
.login-card h1 {
  text-align: center;
  font-size: 26px;
  font-weight: 700;
  color: #d97706; /* orange foncé */
  margin-bottom: 24px;
}

/* ----- Error ----- */
.error {
  background: #fee2e2;
  color: #b91c1c;
  padding: 10px 12px;
  border-radius: 8px;
  font-size: 14px;
  margin-bottom: 18px;
  text-align: center;
}

/* ----- Form ----- */
form {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

/* ----- Labels ----- */
label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
}

/* ----- Inputs ----- */
input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 12px 14px;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  background: #f9fafb;
  font-size: 14px;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

input:focus {
  border-color: #d97706; /* orange */
  box-shadow: 0 0 0 3px rgba(217,119,6,0.25);
  outline: none;
}

/* ----- Button ----- */
button,
input[type="submit"] {
  background: #d97706; /* orange */
  color: #ffffff;
  border: none;
  padding: 12px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.15s ease;
}

button:hover,
input[type="submit"]:hover {
  background: #b45309; /* orange foncé */
  transform: translateY(-2px);
}

button:active,
input[type="submit"]:active {
  transform: scale(0.97);
}

    </style>
</head>

<body>

    <div class="login-card">
    <h1>Connecte toi</h1>

    <form action="../controllers/connexion_controller.php" method="POST">

          <?php if (!empty($erreur)): ?>
        <p style="color:red;"><?= $erreur ?></p>
          <?php endif; ?>

        <p>
             <label for="">Nom :</label>
             <input type="text" name="nom">
        </p>

        <p>
            <label for="">Prenom :</label>
            <input type="text" name="prenom">
        </p>

        <p>
            <label for="">email :</label>
            <input type="text" name="email">
        </p>

         <p>
            <label for="password"> Password:</label>
            <input type="password" name="password" id="password">
        </p>

        <input type="submit">
    </form>

   
    </div>
</body>

</html>

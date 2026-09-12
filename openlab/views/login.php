<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
    /* ----- Reset ----- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Inter", sans-serif;
  background: #f2f2f2;
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
  max-width: 380px;
  padding: 32px;
  border-radius: 14px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  border: 1px solid #e0e0e0;
}

/* ----- Title ----- */
.login-card h1 {
  font-size: 24px;
  font-weight: 700;
  color: #222;
  text-align: center;
  margin-bottom: 24px;
}

/* ----- Error ----- */
.error {
  background: #ffe5e5;
  color: #b30000;
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
  gap: 16px;
}

/* ----- Labels ----- */
label {
  font-size: 14px;
  font-weight: 600;
  color: #333;
}

/* ----- Inputs ----- */
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px 14px;
  border-radius: 8px;
  border: 1px solid #cfcfcf;
  background: #fafafa;
  font-size: 14px;
  transition: border-color 0.2s ease;
}

input:focus {
  border-color: #000;
  outline: none;
}

/* ----- Button ----- */
button {
  background: #000;
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 8px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.2s ease, transform 0.15s ease;
}

button:hover {
  opacity: 0.85;
  transform: translateY(-2px);
}

button:active {
  transform: scale(0.97);
}


    </style>
</head>

<body>


<div class="login-card">

    <h1>Connexion</h1>

    <?php if (!empty($erreur)): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form action="../controllers/login_controller.php" method="POST">

        <p>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
        </p>

        <p>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </p>

        <p>
            <button type="submit">Se connecter</button>
        </p>

    </form>

    </div>

</body>
</html>

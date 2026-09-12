<?php
 require_once '../config/db_connect.php';
 require_once '../models/list_model.php';



 $infosuser = elsa_info();
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

    h1 {
        width: 100%;
        text-align: center;
        color: #2c3e50;
        font-size: 1.4rem;
        margin-bottom: 24px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        width: 100%;
        max-width: 420px;
        margin: 0 auto 24px auto;
        padding: 28px 32px;
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
    input[type="date"] {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #333;
        background-color: #fafafa;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }

    input[type="text"]:focus,
    input[type="date"]:focus {
        outline: none;
        border-color: #2c3e50;
        background-color: #ffffff;
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
            padding: 20px 22px;
        }
    }
</style>
</head>
<body>
<h1>Bonjour <?= $_COOKIE["username"] . " " . $_COOKIE["userprenom"] . " " . $_COOKIE['id_utilisateur'] ?></h1>

<?php foreach ($infosuser as $info) { ?>

  <form action="../controllers/reservation_controller.php" method="POST">

  <input type="hidden" name="id_ressource" value = "<?php echo $_GET['id']?>">
  <input type="hidden" name= "id_utilisateur" value = "<?php echo $_COOKIE['id_utilisateur']?>">


  <label for="">Nom</label>
  <input type="text" name="nom" value="<?php echo $info["nom"]?>">

  <label for="">Prenom</label>
  <input type="text"  name="prenom" value="<?php echo $info["prenom"]?>">

  <label for="date">date de reservation :</label>
  <input type="date" name="date_jour" min="<?= date('Y-m-d') ?>">

  <button type="submit">enregistrer</button>

  </form>

  <?php } ?>

</body>
</html>
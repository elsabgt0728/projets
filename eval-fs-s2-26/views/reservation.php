<?php
 require_once '../config/db_connect.php';
 require_once '../models/display_list_models.php';

 $username = $_COOKIE["username"] ?? "";
$userprenom = $_COOKIE["userprenom"] ?? "";


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
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: #f5f7fb;
  font-family: "Inter", sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 40px 0;
  color: #1f2937;
}

/* ----- Title ----- */
h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1e3a8a;
  margin-bottom: 30px;
  letter-spacing: 0.5px;
}


form {
  background: #ffffff;
  width: 90%;
  max-width: 500px;
  padding: 28px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  gap: 18px;
  border: 1px solid #e5e7eb;
}


label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
}


input[type="text"],
input[type="date"] {
  width: 100%;
  padding: 10px 14px;
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  background: #f9fafb;
  font-size: 14px;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

input:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37,99,235,0.25);
  outline: none;
}


button {
  background: #2563eb;
  color: #ffffff;
  border: none;
  padding: 12px 18px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 600;
  letter-spacing: 0.04em;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.15s ease;
}

button:hover {
  background: #1d4ed8;
  transform: translateY(-2px);
}

button:active {
  transform: scale(0.97);
}

/* ----- Responsive ----- */
@media (max-width: 600px) {
  form {
    width: 95%;
    padding: 22px;
  }

  h1 {
    font-size: 22px;
  }
}

    </style>
</head>
<body>
<h1>Bonjour <?= $_COOKIE["username"] . " " . $_COOKIE["userprenom"] ?></h1>

    <?php
    foreach ($infosuser as $info){
    ?>
    <form action="../controllers/reservation_controller.php" method="POST">
        <input type="hidden" name="id_machine" value="<?php  echo $_GET['id']  ?>">
        <input type="hidden" name="id_utilisateur" value="<?php  echo $_COOKIE["user_id"]  ?>">

        <label for="name">Nom :</label>
        <input type="text" name="name" value="<?php echo $info["nom"]?>">

        <label for="name">Prenom :</label>
        <input type="text" name="surname" value="<?php echo $info["prenom"] ?>">

        <label for="date">date de reservation :</label>
        <input type="date" name="date_reservation" min="<?= date('Y-m-d') ?>">

        <button type="submit">enregistrer</button>
    </form>

     <?php } ?>
</body>
</html>
<?php
session_start();

if (!$_SESSION["isAuthenticated"]) {
    header("Location: ../views/connexion.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo $_COOKIE["dernier_adherent"] ?>
</body>
</html>
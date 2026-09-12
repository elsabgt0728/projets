<?php

  // Import PHPMailer classes into the global namespace, these must be at the top of your script, not inside a function.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './src/Exception.php';
require './src/PHPMailer.php';
require './src/SMTP.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../models/inscription_model.php';


    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $statut = $_POST['statut'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

       // Vérifier si email est dispo 
    if ( email_dispo($email)) {
        header("Location: ../views/inscription.php?error=exists");
        exit();
    }

    // Ajout 
    creer_user($nom, $prenom, $statut, $mdp, $email );

    // Instanciation and passing `true` enables exceptions
$mail = new PHPMailer(true);

//Server settings
$mail->SMTPDebug = 1; // Enable verbose debug output
$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'esieaexperts@gmail.com'; // SMTP username
$mail->Password = 'hkoi wwiq bdir zwrw'; // SMTP password
$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // TCP port to connect to

// Recipients
$mail ->setFrom('esieaexperts@gmail.com', 'ESIEA'); // Dans notre cas le Username est identique à l'adresse mail
$mail->addAddress('mariegraceelsa.borget@et.esiea.fr', 'Elsa'); // Add a recipient
$mail->addAddress('ellen@example.com'); // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('mariegraceelsa.borget@et.esiea.fr');
//$mail->addBCC('bcc@example.com');

// Attachments
//$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

try{
    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = "Borget Elsa - Token: M3GN-X254-39AU";
    $mail->Body = "Votre inscription a bien été prise en compte";
    $mail->AltBody = "ressource : $nom_ressource  ;Date de reservation : $date_jour";
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
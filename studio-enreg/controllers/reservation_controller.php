<?php
    // Import PHPMailer classes into the global namespace, these must be at the top of your script, not inside a function.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './src/Exception.php';
require './src/PHPMailer.php';
require './src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../models/reservation_models.php';

    $date_jour = $_POST['date_jour'];
    $id_ressource = $_POST['id_ressource'];
    $id_utilisateur = $_POST['id_utilisateur'];  



    // Vérifier si la reserv existe déjà
    if ( date_jour_exists($date_jour, $id_ressource, $id_utilisateur)) {
        header("Location: ../views/cadet_view.php?id=$id_ressource&error=exists");
        exit();
    }

    // Ajout de la reservation
    add_reservation($date_jour, $id_ressource, $id_utilisateur);
    $nom_ressource = ressource($id_ressource);

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
    $mail->Body = "RESERVATION TRANSMISE <b>ressource : $nom_ressource  ;Date de reservation : $date_jour</b>";
    $mail->AltBody = "ressource : $nom_ressource  ;Date de reservation : $date_jour";
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
     header("Location: ../views/cadet_view.php?id=$id_ressource&success=added");
    exit();
}
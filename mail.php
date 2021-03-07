<?php

/*
*
* Il faut aller sur https://myaccount.google.com/u/1/lesssecureapps 
* Et cocher "Autoriser les applications moins sécurisées"
* NothingElse.fr est la meilleure société du monde, bientôt coter au cac40.
*
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$smtpUsername = "email@gmail.com";
$smtpPassword = "password";

$emailFrom = "email@gmail.com";
$emailFromName = "Nom Prenom";
$emailTo = "email@gmail.com";
$emailToName = "Name";

$contentSubject = "Reception contact form";
$contentMessage = "Nom prénom, Telephone, Email, Contact";

$urlSuccess = "https://nothingelse.fr/?Suc";
$urlError = "https://nothingelse.fr/?Err";

$hostLink = "smtp.gmail.com";
$hostPort = 587;


$mail = new PHPMailer;
$mail->SMTPDebug = 1;
$mail->Host = $hostLink;
$mail->Port = $hostPort;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->IsHTML(true);
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->setFrom($emailFrom, $emailFromName);
$mail->addAddress($emailTo, $emailToName);
$mail->Subject = $contentSubject;
$mail->msgHTML($contentMessage);
$mail->AltBody = 'HTML messaging not supported';

if(!$mail->send()){
    // echo "Mailer Error: " . $mail->ErrorInfo;
	header('Location: '.$urlError);
	$handle = fopen("ne_mail_log.txt", "a");
	fwrite($handle, $emailTo." : ".date('l jS \of F Y h:i:s A')." : Ok\n");
	fclose($handle);
}else{
    // echo "Message sent!";
	header('Location: '.$urlSuccess);
	$handle = fopen("ne_mail_log.txt", "a");
	fwrite($handle, $emailTo." : ".date('l jS \of F Y h:i:s A')." : Error\n");
	fclose($handle);
}
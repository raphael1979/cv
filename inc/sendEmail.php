<?php

// Replace this with your own email address
$siteOwnersEmail = 'moudens.raphael@gmail.com';


if($_POST) {

	$name = trim(stripslashes($_POST['contactName']));
	$email = trim(stripslashes($_POST['contactEmail']));
	$subject = trim(stripslashes($_POST['contactSubject']));
	$contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "S'il vous plaît entrez votre nom.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "S'il vous plaît, mettez une adresse email valide.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Entrez votre message. Il devrait avoir au moins 15 caractères.";
	}
   // Subject
	if ($subject == '') { $subject = "Présentation du formulaire de contact"; }


   // Set Message
	$message .= "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
	$message .= "Message: <br />";
	$message .= $contact_message;
	$message .= "<br /> ----- <br /> Ce courriel a été envoyé à partir du formulaire de contact de votre site.. <br />";

   // Set From: header
	$from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

      if ($mail) { echo "OK"; }
      else { echo "Une erreur s'est produite. Veuillez réessayer."; }

	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>
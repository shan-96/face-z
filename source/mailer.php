<?php
require 'PHPMailer/PHPMailerAutoload.php';
date_default_timezone_set('asia/kolkata');

function trigger_alert_mail($email,$link){
	$mail = new PHPMailer;

	$mail->isSMTP();                            // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                     // Enable SMTP authentication
	$mail->Username = 'YOUR GMAIL ID HERE';   // SMTP username
	$mail->Password = 'YOUR GMAIL PASSWORD HERE'; 			// SMTP password
	$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                          // TCP port to connect to

	$mail->setFrom('noreply@face-z.com', 'face-z');
	$mail->addAddress($email);   // Add a recipient

	$mail->isHTML(true);  // Set email format to HTML

	$bodyContent = "<p>someone else is probably logged in to your account on ". date('l jS \of F Y h:i:s A') ."If it's not you log out through this link</p>
					<p>". $link ."</p>";

	$mail->Subject = 'How you doin\'?';
	$mail->Body    = $bodyContent;

	$mail->send();
}


?>
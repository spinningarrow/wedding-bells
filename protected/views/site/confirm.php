<?php
$this->pageTitle= 'Confirmation « ' . Yii::app()->name;
?>
<?php
	$subject = "Confirmation - Wedding Bells Account";

	$body = "Hi,\n\nThank you for signing up for wedding bells.\nPlease click on the link below to activate your account\n";
 
	$url = 'http://' . Yii::app()->request->getServerName();
	$url .= CController::createUrl('site/validate', array('passkey'=>$code));
 
	$body .= $url;
 
	$headers="From: verify\r\nReply-To: no-reply";
	
	// mail($email,$subject,$body,$headers);

	$message = $body;
	$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
	
	// Basic details - do not change
	$mailer->IsSMTP();
	$mailer->Port = 465;
	$mailer->Host = 'smtp.mail.yahoo.com';
	// $mail->IsHTML(true); // if you are going to send HTML formatted emails

	// Authorization details - do not change
	$mailer->Mailer = 'smtp';
	$mailer->SMTPSecure = 'ssl';
	$mailer->SMTPAuth = true;
	$mailer->Username = "swlab@yahoo.com";
	$mailer->Password = "s12345678";

	$mail->SingleTo = true; // if you want to send mail to the users individually so that no recipients can see that who has got the same email.
	
	$mailer->From = "swlab@yahoo.com"; // Apparently nothing else works
	$mailer->FromName = "verify";
	$mailer->AddReplyTo("no-reply@weddingbells.com"); // workaround so that reply-to is the user's email address

	$mailer->AddAddress($email);
	
	$mailer->Subject = $subject;
	$mailer->Body = $message;
	$mailer->Send();
?>

<p>A confirmation email has been sent to <strong><?php echo $email;?></strong> and should arrive in a few minutes.<br>Click on the link in the email, and your account will be activated automatically.</p>
<p>Still haven't received the email? Please check your spam to make sure the email hasn't ended up there.<br>If you still can't find it, <?php echo CHtml::link('click here',array('/site/confirmation&email='.$email.'&code='.$code));?> to retry.</p>
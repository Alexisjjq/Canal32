<?php
	if(!empty($_POST['email'])):
/*		DO SOMETHING*/
		$message = '<p>mot de pass envoyé sur votre email</p><p>redirection dans 1s</p>';
		echo $message;
	else: 
		$message = 'E-mail incorrect';
		echo $message;
	endif;
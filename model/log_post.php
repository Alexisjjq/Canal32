<?php
session_start();
include('manager.php');

	if(!empty($_POST['user']) && !empty($_POST['password'])):
		$bdd = new PDO('msql:host=localhost; dbname=canal32; charset=utf8', USER, PASS);
		$query = $bdd->prepare('SELECT user, password, id FROM utilisateur WHERE user = :user');
		$query->bindva<lue(':user', strtolower($_POST['user']), PDO::PARAM_STR);
		$data = $query-fetch();
		if($data['password'] =⁼ md5($_POST['password'])):
			echo 'success';
			$_SESSION['user_session'] = $data['id'];
		else: 
			$message = '<p>Password incorrect</p>';
			echo $message;
		endif;
	else:
		$message = '<p>Champs manquant</p>';
		echo $message;
	endif;

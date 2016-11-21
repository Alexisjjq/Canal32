<?php 
include('manager.php');
	try{
		$bdd = new PDO('mysql:host=localhost; dbname=CrmC32;charset=utf8', USER, PWD);
		$manager = new Manager($bdd);
	} catch(PDOException $e){
    echo 'Erreur !: '.$e->getMessage().'<br>';
    die();
  }	

	var_dump($_POST);
	 $i = '';
	 echo '<hr>';
	 echo $_POST['ressources'.$i];
	 echo '<hr>';
$tabRh = '';
	while (!empty($_POST['ressources'.$i])) {
		$tabRh[] = $_POST['ressources'.$i];
		$i++;
	}
var_dump($tabRh);
echo '<hr><br>';

var_dump($manager->getRessources($tabRh));



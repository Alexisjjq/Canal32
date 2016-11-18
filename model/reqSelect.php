<?php 
  include('manager.php');
  // CONNEXION BDD
  $bdd = new PDO('mysql:host=localhost; dbname=CrmC32;charset=utf8', USER, PWD);
  $manager = new Manager($bdd);

  echo $manager->assocMetierUser();

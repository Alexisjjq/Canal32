
<?php

include('manager.php');
// CONNEXION BDD
$bdd = new PDO('mysql:host=localhost; dbname=CrmC32;charset=utf8', USER, PWD);
$manager = new Manager($bdd);


// Rempli les selecteurs RH et metiers en fonction des actions de l'utilisateur sur la page devis (recup des dates et noms entrés dans les champs via ajax)
  if(isset($_GET['dataStart'], $_GET['dataEnd'])):
    echo $manager->RHselector($_GET['dataStart'], $_GET['dataEnd']);
  // else :
  //   message d'erreur, pas de dates envoyés
  endif;

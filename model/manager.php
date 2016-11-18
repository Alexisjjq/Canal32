<?php
include('conf.ini.php');

class Manager{
  private $bdd;

  public function __construct($bdd){
    $this->setBdd($bdd);
  }

  public function setBdd(PDO $bdd){
    $this->bdd = $bdd;
  }

  public function verifDate($date){
    if (!empty($date)):
      return preg_match('#^(?=\d)(?:(?!(?:1582(?:\.|-|\/)10(?:\.|-|\/) (?:0[5-9]|1[0-4]))|(?:1752(?:\.|-|\/)09(?:\.|-|\/)(?:0[3-9]|1[0-3])))(?=(?:(?!000[04]|(?:(?:1[^0-6]|[2468][^048]|[3579][^26])00))(?:(?:\d\d)(?:[02468][048]|[13579][26]))\D02\D29)|(?:\d{4}\D(?!(?:0?[2469]|11)\D31)(?!02(?:\.|-|\/)(?:29|30))))(\d{4})([-\/.])(0\d|1[012])\2((?!00)[012]\d|3[01])(?:$|(?=\x20\d)\x20))?((?:[01]\d|2[0-3])(?::[0-5]\d){1,2})?$#', $date);
    else :
      return 0;
    endif;
  }

  // A inclure dans un selecteur RH
  public function selectAllRH(){
    $message = '';
    $reqUtilisateur = $this->bdd->prepare('SELECT `nom_utilisateur`, `prenom_utilisateur`, `id_utilisateur` FROM Utilisateur');
    if($reqUtilisateur->execute()):
      $tabUtilisateur = $reqUtilisateur->fetchALL(PDO::FETCH_ASSOC);
      for ($i=0; $i < count($tabUtilisateur); $i++):
        $message .= '<option value='.$tabUtilisateur[$i]['id_utilisateur'].'>'.$tabUtilisateur[$i]['nom_utilisateur'].' '.$tabUtilisateur[$i]['prenom_utilisateur'].'</option>';
      endfor;
    else :
      $message .= 'Erreur requête tout Utilisateur (no dates)';
    endif;
    return $message;
  }

  // A inclure dans un selecteur Metier
  public function selectAllMetier(){
    $message = '';
    $reqMetier = $this->bdd->prepare('SELECT id_metier, nom_metier, taux_horaire_metier FROM Metier');
    if($reqMetier->execute()):
      $tabMetier = $reqMetier->fetchALL(PDO::FETCH_ASSOC);
      for ($i=0; $i < count($tabMetier); $i++):
        $message .= '<option value='.$tabMetier[$i]['id_metier'].'>'.$tabMetier[$i]['nom_metier'].'   '.$tabMetier[$i]['taux_horaire_metier'].'€ /h </option>';
      endfor;
    else :
      $message .= 'Erreur requête tout Utilisateur (no dates)';
    endif;
    return $message;
  }

  // A inclure dans un selecteur Materiel
  public function selectAllMateriel(){
    $message = '';
    $reqCategorieMat = $this->bdd->prepare('SELECT categorie_mat FROM Materiel');
    if($reqCategorieMat->execute()):
      $tabCategorieMat = $reqCategorieMat->fetchALL(PDO::FETCH_ASSOC);
      foreach ($tabCategorieMat as $CategorieMat):
      // Formation des groupes de catégories de matériel
        $message .= '<optgroup label="'.$CategorieMat['categorie_mat'].'">';
        // Insertion du materiel lié à sa catégorie
        $reqMateriel = $this->bdd->prepare('SELECT `id_mat`, `desc_mat` FROM Materiel WHERE categorie_mat="'.$CategorieMat['categorie_mat'].'"');
        if($reqMateriel->execute()):
          $tabMateriel = $reqMateriel->fetchALL(PDO::FETCH_ASSOC);
          for($i=0; $i < count($tabMateriel); $i++):
            $message .= '<option value='.$tabMateriel[$i]['id_mat'].'>'.$tabMateriel[$i]['desc_mat'].'</option>';
          endfor;
        else:
          $message .= 'Erreur dans la requête tout Materiel';
        endif;
        $message .= '</optgroup>';
      endforeach;
    else:
      $message .= 'Erreur dans la requête catégorie matériel';
    endif;
    return $message;
  }

  // Fonction de récupération des RH a integrer dans le selecteur du devis
  public function RHselector($dateStart, $dateEnd){
    $message = '';
  // On verifie que les dates soient valides (depuis le form de la page devis)
    $dateStartChecked = self::verifDate($dateStart); // booléen : retourne 1 (TRUE) ou 0 (FALSE)
    $dateEndChecked = self::verifDate($dateEnd); // booléen : retourne 1 (TRUE) ou 0 (FALSE)
    if($dateStartChecked && $dateEndChecked):
    // Requete des personnes NON disponibles
      $reqUserIndispo = $this->bdd->prepare('SELECT nom_utilisateur, prenom_utilisateur, id_utilisateur FROM Utilisateur INNER JOIN EventDevis ON Utilisateur.id_utilisateur=EventDevis.id_utilisateur_ WHERE ((EventDevis.date_debut BETWEEN :dateStart AND :dateEnd) OR (EventDevis.date_fin BETWEEN :dateStart AND :dateEnd) OR ((:dateStart BETWEEN EventDevis.date_debut AND EventDevis.date_fin) AND (:dateEnd BETWEEN EventDevis.date_debut AND EventDevis.date_fin))) GROUP BY Utilisateur.id_utilisateur');
      $reqUserIndispo->bindValue(':dateStart', $dateStart);
      $reqUserIndispo->bindValue(':dateEnd', $dateEnd);
      if ($reqUserIndispo->execute()):
        $tabUserIndispo = $reqUserIndispo->fetchALL(PDO::FETCH_ASSOC);
        // Insertion des personnes NON disponibles dans le selecteur (non selectionnables)
        for ($i=0; $i < count($tabUserIndispo); $i++):
          $message .= '<option disabled value='.$tabUserIndispo[$i]['id_utilisateur'].'>'.$tabUserIndispo[$i]['nom_utilisateur'].' '.$tabUserIndispo[$i]['prenom_utilisateur'].'</option>';
        endfor;
      else :
        $message .= 'Erreur dans la requete Utilisateurs non disponibles';
      endif;
    // On veux maintenant insérer les personnes disponibles dans le sélécteur : Requete de toutes les RH
      $reqUserDispo = $this->bdd->prepare('SELECT nom_utilisateur, prenom_utilisateur, id_utilisateur FROM Utilisateur');
      if ($reqUserDispo->execute()):
        $tabUserDispo = $reqUserDispo->fetchALL(PDO::FETCH_ASSOC);
      // Preparation d'un tableau contenant les id des utilisateurs indisponibles pendant la période choisie
        foreach ($tabUserIndispo as $infoUtilisateurIndispo):
          $tab_id_indispo[]=$infoUtilisateurIndispo['id_utilisateur'];
        endforeach;
      // Insertion des personnes disponibles dans le selecteur (en éliminant les indisponibles)
        for ($i=0; $i < count($tabUserDispo); $i++):
          if(!empty($tab_id_indispo)):
            if(!in_array($tabUserDispo[$i]['id_utilisateur'], $tab_id_indispo)):
              $message .= '<option value='.$tabUserDispo[$i]['id_utilisateur'].'>'.$tabUserDispo[$i]['nom_utilisateur'].' '.$tabUserDispo[$i]['prenom_utilisateur'].'</option>';
            endif;
          else:
            $message .= '<option value='.$tabUserDispo[$i]['id_utilisateur'].'>'.$tabUserDispo[$i]['nom_utilisateur'].' '.$tabUserDispo[$i]['prenom_utilisateur'].'</option>';
          endif;
        endfor;
      else :
        $message .= 'Erreur dans la requête Utilisateurs disponibles';
      endif;
    else: // Si pas de date, insertion de tout les employés dans le selecteur
      $message .= self::selectAllRH();
    endif;
    return $message;
  } // Fin RHselector()

  // Fonction de remplissage des selecteurs RH et métiers apparaissannt avec le bouton d'ajout de ligne sur la page devis
  public function assocMetierUser(){
    // Récupération de la liste des métiers
    $reqMetier = $this->bdd->prepare('SELECT id_metier, nom_metier, taux_horaire_metier FROM Metier');
      if($reqMetier->execute()):
        $tabMetier = $reqMetier->fetchALL(PDO::FETCH_ASSOC);
        foreach ($tabMetier as $key => $infoMetier):
          $prepJsonMetier[$infoMetier['id_metier']] = $infoMetier['nom_metier'].' '.$infoMetier['taux_horaire_metier'].'€ /h';
        endforeach;
        // tableau organisé de manière a être encodé en json $prepJsonMetier(id_metier => 'nom_metier THeuro /h')
        $tabMetierUser['metiers']=$prepJsonMetier;
      endif;
    // Récupération de la liste des RH
    $reqUtilisateur = $this->bdd->prepare('SELECT `nom_utilisateur`, `prenom_utilisateur`, `id_utilisateur` FROM Utilisateur');
    if($reqUtilisateur->execute()):
      $tabUtilisateur = $reqUtilisateur->fetchALL(PDO::FETCH_ASSOC);
      foreach ($tabUtilisateur as $key => $infoUtilisateur):
        $prepJsonUtilisateur[$infoUtilisateur['id_utilisateur']]= $infoUtilisateur['nom_utilisateur'].' '.$infoUtilisateur['prenom_utilisateur'];
      endforeach;
      $tabMetierUser['ressources']=$prepJsonUtilisateur;
    endif;

    $jsonMetierUser = json_encode($tabMetierUser, JSON_UNESCAPED_UNICODE);
    return $jsonMetierUser;
  }


  public function articleSelector(){
    $message ='';
    $reqArticles = $this->bdd->prepare('SELECT id_art, desc_art ,prix_unitaire FROM Articles');
    if($reqArticles->execute()):
      $tabArticles = $reqArticles->fetchAll(PDO::FETCH_ASSOC);
      var_dump($tabArticles);
      for ($i=0; $i < count($tabArticles); $i++){
        $message .= '<option value='.$tabArticles[$i]['id_art'].'>'.$tabArticles[$i]['desc_art'].' '.$tabArticles[$i]['prix_unitaire'].' &euro;</option>';
      }
    else :
      $message .= 'Erreur dans la requête Articles';
    endif;
    return $message;
  }

  // Fonction de récupération de la liste du matériel à integrer dans le selecteur du devis
  public function materielSelector($dateStart, $dateEnd){
    $message = '';
    $reqCategorieMat = $this->bdd->prepare('SELECT categorie_mat FROM Materiel');
    if($reqCategorieMat->execute()):
      $tabCategorieMat = $reqCategorieMat->fetchALL(PDO::FETCH_ASSOC);
      foreach ($tabCategorieMat as $id_mat => $CategorieMat):
      // Formation des groupes de catégories de matériel
        $message .= '<optgroup label="'.$CategorieMat['categorie_mat'].'">';
        // On verifie si on recupère bien une date de debut et de fin d'utilisation sur le formulaire devis et que les dates sont valides
        $dateStart = self::verifDate($dateStart); // booléen : retourne 1 (TRUE) ou 0 (FALSE)
        $dateEnd = self::verifDate($dateEnd); // booléen : retourne 1 (TRUE) ou 0 (FALSE)
        if($dateStart && $dateEnd):
        // Requête Materiel dispo
            $reqMatDispo = $this->bdd->prepare('SELECT id_mat, desc_mat FROM Materiel INNER JOIN groupMat ON Materiel.id_mat=groupMat.id_mat_ WHERE Materiel.categorie_mat=:categorie_mat AND NOT ((groupMat.date_debut BETWEEN :dateStart AND :dateEnd) OR (groupMat.date_fin BETWEEN :dateStart AND :dateEnd) OR ((:dateStart BETWEEN groupMat.date_debut AND groupMat.date_fin) AND (:dateEnd BETWEEN groupMat.date_debut AND groupMat.date_fin))) GROUP BY Materiel.id_mat');
          $reqMatDispo->bindValue(':categorie_mat', $CategorieMat['categorie_mat']);
          $reqMatDispo->bindValue(':dateStart', $dateStart);
          $reqMatDispo->bindValue(':dateEnd', $dateEnd);
          if($reqMatDispo->execute()):
            $tabMatDispo = $reqMatDispo->fetchALL(PDO::FETCH_ASSOC);
            // var_dump($tabMatDispo);
          // Insertion du materiel disponible dans le selecteur
            for($i=0; $i < count($tabMatDispo); $i++):
              $message .= '<option value='.$tabMatDispo[$i]['id_mat'].'>'.$tabMatDispo[$i]['desc_mat'].'</option>';
            endfor;
          else :
            $message .= 'Erreur dans la requete Materiel disponible';
          endif;
        else: // Si pas de date ou dates invalides, insertion de tout les équipements dans le selecteur
          $reqMat = $this->bdd->prepare('SELECT id_mat, desc_mat FROM Materiel WHERE Materiel.categorie_mat=:categorie_mat');
          $reqMat->bindValue(':categorie_mat', $CategorieMat['categorie_mat']);
          if($reqMat->execute()):
            $tabMat = $reqMat->fetchALL(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($tabMat); $i++):
              $message .= '<option value='.$tabMat[$i]['id_mat'].'>'.$tabMat[$i]['desc_mat'].'</option>';
            endfor;
          else :
            $message .= 'Erreur dans la requête matériel';
          endif;
        endif;
        $message .= '</optgroup>';
      endforeach;
    else:
      $message .= 'Erreur dans la requête Catégories de métier';
    endif;
    return $message;
  } // Fin materielSelector()

  // Fonction qui récupère les éléments du formulaire devis, vérifie si tout est complet et si c'est le cas, met à jour la bdd
  public function ValidationDevis(array $tab){

  }

}
?>

<?php
	include('model/manager.php');
	try{
		$bdd = new PDO('mysql:host=localhost; dbname=CrmC32;charset=utf8', USER, PWD);
		$manager = new Manager($bdd);
	} catch(PDOException $e){
    echo 'Erreur !: '.$e->getMessage().'<br>';
    die();
  }	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
  	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  	<link rel="stylesheet" href="dist/bootstrap/dist/css/bootstrap.min.css">
  	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  	<link rel="stylesheet" href="dist/bootstrap-select/dist/css/bootstrap-select.min.css">
  	<link rel="stylesheet" href="dist/datetimerpicker/css/bootstrap-datetimepicker.min.css">
  	<link rel="stylesheet" href="css/form_devis.css">
</head>
<body>
<header class="header">
  <nav class="nav navbar-default" role="navigation">
    <div class="navbar-header">
      <a href="#" class="navbar-brand header-logo"><img class="nav-img" src="dist/img/logo2.svg" width="35px" height="32px" alt="Canal 32"></a>
      <div class="btn-group nav-button">
        <button id="triggerRappel" type="button" class="btn popOverData nav-button" data-toggle="modal" data-target="#rappel" data-content="Créer un rappel" data-trigger="hover" data-placement="bottom"><i class="fa fa-bell-o fa-2x" aria-hidden="true"></i></button>

        <!-- START MODAL WINDOW -->

              <div class="modal fade" id="rappel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title" id="myModalLabel">Rappel</h4>
                    </div>
                    <div class="modal-body">
                     <form action="rappel.php">
                        <div class="group-form">
                          <label for="rappel">Date de rappel :</label>
                          <div class='input-group date datePicker'>
                           <input type='text' class="form-control" id="rappel"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                           </div>
                        </div>
                        <div class="group-form">
                          <label for="misc">Description :</label>
                          <input type="textfield" class="form-control" id="misc">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary login">Me rappeler</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END MODAL WINDOW -->
          <button type="button" class="btn dropdown-toggle popOverData nav-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-content="Afficher les notifs" data-trigger="hover" data-placement="bottom">
            <div class="circle">1</div>
           <i id="letter" class="fa fa-envelope-o fa-2x" aria-hidden="true"></i>
          </button>

            <!-- START DROPDOWN MENU -->

              <ul class="dropdown-menu">
                <li class="dropdown-item">
                  <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  <button type="button" class="btn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                  </button>
                </li>
                <li class="divider"></li>
                <li class="dropdown-item">
                  <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  <button type="button" class="btn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                  </button>
                </li>
                <li class="divider"></li>
                <li class="dropdown-item">
                  <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  <button type="button" class="btn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                  </button>
                </li>
                <li class="divider"></li>
                <li class="dropdown-item">
                  <p class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  <button type="button" class="btn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                  </button>
                </li>
              </ul>

          <!-- END DROPDOWN MENU -->

          <button type="button" class="btn popOverData nav-button" data-content="Paramètre" data-trigger="hover" data-placement="bottom"><i class="fa fa-cogs fa-2x" aria-hidden="true"></i></button>
          <button type="button" class="btn popOverData nav-button" data-content="Déconnexion" data-trigger="hover" data-placement="bottom"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></button>

      </div>
    </div>
  </nav>
</header>
<section class="form-devis">
	<div class="container-fluid">
		<h1 class="devis-title">Formulaire devis</h1>
		<form action="model/post_devis.php" method="post">
		<div class="row">
			<div class="col-lg-12">
				<div class="line">
					<label for="title">Titre :</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3">
				<input type="text" id="title" class="form-control" name="title" placeholder="Titre projet">
			</div>
			<div class="col-lg-9">
				<input type="text" class="form-control" name="desProjet" placeholder="Description projet">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="line">
					<label for="articles">Articles :</label>
				</div>
			</div>
		</div>
		<div id="targetArticle">
			<div class="row">
				<div class="col-lg-1">
					<button class="btn add" id="triggerArticles"><i class="fa fa-plus"></i></button>
				</div>
				<div class="col-lg-3">
					<select name="articles" id="articles" class="selectpicker" data-live-search="true" data-width="100%">
						<?= $manager->selectAllArticles();?>
					</select>
				</div>
				<div class="col-lg-3">
					<input type="text" name="nbDiff" class="form-control" id="nbDiffusion" placeholder="Nombre diffusion">
				</div>
				<div class="col-lg-2">
					<input type="text" class="form-control" id="prixArticles" placeholder="Prix">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="divers">
				<div class="col-lg-12">
					<input name="description" id="description" placeholder="Description" type="text" class="form-control">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="line">
					<label for="rh">Ressources humaines :</label>
				</div>
			</div>
		</div>
		<div id="targetRh">
			<div class="row">
				<div class="col-lg-1">
					<button class="btn add" id="triggerRh"><i class="fa fa-plus"></i></button>
				</div>
				<div class="col-lg-11">
					<div class="box row">
						<div class="col-lg-3">
							<div class='input-group date datePicker'>
		               			<input type='text' name="dateD" class="form-control" placeholder="Date debut" />
		               		 	<span class="input-group-addon">
		                  			<span class="glyphicon glyphicon-calendar"></span>
		                		</span>
		               		</div>
						</div>
						<div class="col-lg-3">
		               		<div class='input-group date datePicker'>
		               			<input type='text' class="form-control" name="dateF" placeholder="Date fin" />
		               		 	<span class="input-group-addon">
		                  			<span class="glyphicon glyphicon-calendar"></span>
		                		</span>
		               		</div>
						</div>
						<div class="col-lg-3">
						<select name="ressources" id="rh" class="selectpicker form-control" data-live-search="true" data-width="100%">
							<?=$manager->selectAllRH();?>
						</select>
						</div>
						<div class="col-lg-3">
							<select name="metier" id="metier" class="selectpicker" data-live-search="true" data-width="100%">
								<?=$manager->selectAllMetier();?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="line">
					<label for="fournisseur">Fournisseur :</label>
				</div>
			</div>
		</div>
		<div id="targetFour">
			<div class="row">
				<div class="col-lg-1">
					<button class="btn add" id="triggerFour"><i class="fa fa-plus"></i></button>
				</div>
				<div class="col-lg-3">
					<select name="fournisseur" id="fournisseur" class="selectpicker form-control" data-live-search="true" data-width="100%">
						<?=$manager->selectAllFournisseur();?>
					</select>
				</div>
				<div class="col-lg-3">
					<input type="text" class="form-control" name="prix-facture" placeholder="Prix facture">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="line">
					<label for="materiel">Materiel :</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-1">
				<button class="btn add"><i class="fa fa-plus"></i></button>
			</div>
			<div class="col-lg-3">
				<select name="materiel" id="" class="selectpicker" multiple="" data-live-search="true">
					<?=$manager->selectAllMateriel();?>
				</select>
			</div>
			<div class="col-lg-3">
				<div class='input-group date datePicker'>
           			<input type='text' class="form-control" name="dateMatos" placeholder="Date" />
           		 	<span class="input-group-addon">
              			<span class="glyphicon glyphicon-calendar"></span>
            		</span>
           		</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="line">
					<label for="divers">Divers :</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class='input-group date datePicker'>
           			<input type='text' class="form-control" name="dateTournage" placeholder="Date tournage" />
           		 	<span class="input-group-addon">
              			<span class="glyphicon glyphicon-calendar"></span>
            		</span>
           		</div>
			</div>
			<div class="col-lg-4">
				<div class='input-group date datePicker'>
           			<input type='text' class="form-control" name="datePeriodeDebut" placeholder="Début diffusion" />
           		 	<span class="input-group-addon">
              			<span class="glyphicon glyphicon-calendar"></span>
            		</span>
           		</div>
			</div>
			<div class="col-lg-4">
				<div class='input-group date datePicker'>
           			<input type='text' class="form-control" name="datePeriodeFin" placeholder="Fin diffusion" />
           		 	<span class="input-group-addon">
              			<span class="glyphicon glyphicon-calendar"></span>
            		</span>
           		</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="divers">
					<input type="text" class="form-control" id="misc" placeholder="Information complémentaire">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="devis-submit">
					<button type="submit" class="btn add">Valider</button>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>
<script src="dist/jquery/dist/jquery.js"></script>
<script src="dist/moment/moment.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/bootstrap/js/transition.js"></script>
<script src="dist/bootstrap/js/collapse.js"></script>
<script src="dist/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="dist/datetimerpicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="js/timepicker.js"></script>
<script src="js/getSelect.js"></script>
</body>
</html>

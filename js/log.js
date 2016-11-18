$(document).ready(function(){

	/*VERIFICATION SI JQUERY OK*/

  alert('JS OK');

/*  	AFFICHAGE DU FORM MDP OUBLIE	*/
  
	$('#triggerMdp').click(function(){
  	$('#connexion').hide();
  	$('#mdp').show();
  });

  $('#back').click(function(){
  	$('#mdp').hide();
  	$('#connexion').show();
  });
	
	$(document).on('submit', '#submit-login', function(){

	  	var data = $(this).serialize();
	  	$.ajax({
	  		type: 'POST',
	  		url: '../model/log_post.php',
	  		data: data,
	  		success: function(responses){
	  			if(responses == 'success'){
	  				window.location = 'profil.php';
	  			}
	  			else {
	  				$('#error').html(responses);
	  			}
	  		}
	  	});
	  	return false;
	});

	$(document).on('submit', '#submit-mdp', function(){

	 	var data = $(this).serialize();
	 	$.ajax({
	 		type: 'POST',
	 		url: '../model/mdp_post.php',
	 		data: data,
	 		success: function(responses){
	 			if(responses == 'success'){
	 				$('#error').html(responses).delay(1000);
	 				window.location = 'index.html';
	 			}
	 			else {
	 				$('#error').html(responses);
	 			}
	 		}
	 	})
	});

});

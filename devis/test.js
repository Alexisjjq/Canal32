$(document).ready(function(){

	function Personne(nom){
		this.nom = nom;
		console.log('Nouveau perso '+ this.nom +' crée'); 	
	}

	var personne1 = new Personne('bob');
	var personne2 = new Personne('toto');

	console.log('Perso 1 '+ personne1.nom +' !');

	Personne.prototype.direBonjour = function(){
		console.log('Bonjour, je suis '+this.nom+' !');
	};

	personne2.direBonjour();

});
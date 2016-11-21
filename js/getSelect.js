$(document).ready(function(){
	var i = 0;
	alert('JS OK')
// RESSOURCES HUMAINES PART

	$('#triggerRh').on('click', function(){
		console.log('ok');
		i++;
		// ON RECUPERE LES DONNEES DE LA REQUETES
		$.get('model/reqSelect.php', function(data){
			console.log(data);
			var data = JSON.parse(data);

			// FUNCTION PERMETTANT D AFFICHER LES METIERS DANS LE DOM(select)
			function affOptMetier(){

				req = '';
				for(var i in data.metiers){
					req = req + '<option value="'+ i +'">'+ data.metiers[i] +'</option>';
				};
				return req;
			};

			// FUNCTION PERMETTANT D AFFICHER LES RESSOURCES HUMAINES DANS LE DOM(select)
			function affOptRh(){

				req = '';
				for(var i in data.ressources){
					req = req + '<option value="'+ i +'">'+ data.ressources[i] +'</option>';
				}
				return req;
			};

			// ON AJOUTE LES LIGNES POUR LE FORMULAIRE

			$('#targetRh').append(

				'<div class="row">' +
					'<div class="col-lg-1">' +
						'<button class="btn add del-btn"><i class="fa fa-times" aria-hidden="true"></i></button>'+
					'</div>' +
					'<div class="col-lg-11">'+
						'<div class="row box">' +
						'<div class="col-lg-3">' +
							'<div class="input-group date datePicker">'+
								'<input type="text" name="dateD" class="form-control" placeholder="Date debut" />'+
								'<span class="input-group-addon">'+
									'<span class="glyphicon glyphicon-calendar"></span>'+
								'</span>'+
							'</div>'+
						'</div>' +
						'<div class="col-lg-3">'+
							'<div class="input-group date datePicker">'+
								'<input type="text" name="dateD" class="form-control" placeholder="Date fin" />'+
								'<span class="input-group-addon">'+
									'<span class="glyphicon glyphicon-calendar"></span>'+
								'</span>'+
							'</div>'+
						'</div>'+
						'<div class="col-lg-3">'+
							'<select class="selectpicker select-rh form-control" name="ressources'+ i +'">'+ affOptRh() +'</select>' +
						'</div>'+
						'<div class="col-lg-3">'+
							'<select class="selectpicker select-metier form-control" name="metiers'+ i +'">'+ affOptMetier() +'</select>' +
						'</div>'+
						'</div>' +
					'</div>'+
				'</div>'

			);
			$(".selectpicker").selectpicker('refresh');
		});
		return false;
	});

	$(document).on('keyup','.box', function(){
		var data = $('.dateD', this).val();
		var data2 = $('.dateF', this).val();
		var target = $('.select-rh', this);
		var req = Date.parse(data);
		var req2 = Date.parse(data2);

		console.log(req);
		if( data != '' & data2 != ''){
			if( !isNaN(req) & !isNaN(req2) ){
				console.log(data);
				console.log(data2);
				target.empty();

				$.ajax({
					type: 'get',
					url: 'reqSelect.php',
					data: 'dataStart='+data+'&dataEnd='+data2,
					success: function(data) {
						console.log(target);
						console.log(data);
						$(target).html(data);

					}
				});
			};
		}
	});

	$(document).on('change', '.box', function(){
		var selected = $('.select-rh', this).val();

		if( selected != ''){
			$.ajax({

				url:' reqSelect.php',
				data: 'value='+ selected,
				success: function(data){
					console.log(data);
				}
			});
		}
	});

	$(document).on('click', '.del-btn', function(){
		$(this).parents('.row').remove();
	});

// ARTICLES PARTS


	$('#triggerArticles').on('click', function(){
		i++;

		$.get('model/reqArticles.php', function(data){
			console.log(data);

			var data = JSON.parse(data);

			function affOptArt(){
				req = '';
				for(var i in data.articles){
					req = req + '<option value="'+ i +'">'+ data.articles[i] +'</option>';
				}
				return req;
			};
			
			$('#targetArticle').append(
				'<div class="row">'+
				'<div class="col-lg-1">'+
					'<button class="btn add del-btn"><i class="fa fa-times"></i></button>'+
				'</div>'+
				'<div class="col-lg-3">'+
					'<select name="articles'+i+'" class="selectpicker" data-live-search="true" data-width="100%">'+ affOptArt() +'</select>'+
				'</div>'+
				'<div class="col-lg-2">'+
					'<input type="text" class="form-control" name="prixArticles'+i+'" placeholder="Prix">'+
				'</div>'+
			'</div>'

			);

			$('.selectpicker').selectpicker('refresh');
		});
		return false;
	});
// FOURNISSEUR PARTS


	$('#triggerFour').on('click', function(){
		i++;
		console.log(i);
		$.get('model/reqFournisseur.php', function(data){
			console.log(data);

			function affOptFour(){
				req = '';
				for(var i in data.fournisseur){
					req = req + '<option value="'+ i +'">'+ data.fournisseur[i] +'</option>';
				}
				return req;
			};

			$('#targetFour').append(

				'<div class="row">'+
					'<div class="col-lg-1">'+
						'<button class="btn add del-btn"><i class="fa fa-times"></i></button>'+
				'</div>'+
				'<div class="col-lg-3">'+
					'<select name="fournisseur'+i+'" class="selectpicker form-control" data-live-search="true" data-width="100%">'+ affOptFour()+'</select>'+
				'</div>'+
				'<div class="col-lg-3">'+
					'<input type="text" class="form-control" name="prix-facture'+i+'" placeholder="Prix facture">'+							
				'</div>'+
			'</div>'

				);
			$('.selectpicker').selectpicker('refresh');
		});
		return false;
	});

});
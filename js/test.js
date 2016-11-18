$(document).ready(function(){
	var i = 0;
	console.log('ok');
	$('#triggerRh').on('click', function(){
		console.log('ok');
		i++;
		// ON RECUPERE LES DONNEES DE LA REQUETES
		// $.get('model/reqSelect.php', function(data){
		// 	console.log(data);
		// 	var data = JSON.parse(data);

			// FUNCTION PERMETTANT D AFFICHER LES METIERS DANS LE DOM(select)
			// function affOptMetier(){

			// 	req = '';
			// 	for(var i in data.metiers){
			// 		req = req + '<option value="'+ i +'">'+ data.metiers[i] +'</option>';
			// 	};
			// 	return req;
			// };

			// FUNCTION PERMETTANT D AFFICHER LES RESSOURCES HUMAINES DANS LE DOM(select)
			// function affOptRh(){

			// 	req = '';
			// 	for(var i in data.ressources){
			// 		req = req + '<option value="'+ i +'">'+ data.ressources[i] +'</option>';
			// 	}
			// 	return req;
			// };

			// ON AJOUTE LES LIGNES POUR LE FORMULAIRE

			$('#targetRh').append(

				'<div class="row">' +
					'<div class="col-lg-1">' +
						'<button class="btn del-btn"><i class="fa fa-times" aria-hidden="true"></i></button>'+
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
								'<input type="text" name="dateD" class="form-control" placeholder="Date debut" />'+
								'<span class="input-group-addon">'+
									'<span class="glyphicon glyphicon-calendar"></span>'+
								'</span>'+
							'</div>'+
						'</div>'+
						'<div class="col-lg-3">'+
							'<select class="selectpicker select-rh form-control" data-live-search="true" name="ressources'+ i +'"></select>' +
						'</div>'+
						'<div class="col-lg-3">'+
							'<select class="selectpicker select-metier form-control" data-live-search="true" name="metiers'+ i +'"></select>' +
						'</div>'+
						'</div>' +
					'</div>'+
				'</div>'

			);
			
			$(".selectpicker").selectpicker('refresh');
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
		var row = $(this).parents('.row');
		console.log(row);
		$(this).parents('.row').remove();
		return false;
	});


});
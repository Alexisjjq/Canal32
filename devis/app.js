$(document).ready(function(){
	$('.del-btn').on('click', function(){
		console.log('Js ok');
		console.log($(this).parent().parent('.row'));
		console.log($(this).parents('.row'));
		$(this).parents('.row').remove();
	});
});
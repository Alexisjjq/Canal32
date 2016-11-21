$(document).ready(function(){
	var data = '<div class="test"><select class="fuck"><option>lol</option></select><select class="chieur"><option>Hey!</option></div>';
	$('.trigger').on('click', function(){
		$('.box').append(data);
	});

	$(document).on('click','.test', function(){
			var target = $(this).find('.fuck');
			target.empty();
			$(target).html('<option>YEAH o//</option>');
	});
});

	
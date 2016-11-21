$(document).ready(function(){
		$(document).on('click', '.datePicker', function(){
		$(this).datetimepicker({
			icons: {
				time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
 	            down: "fa fa-arrow-down"
			}
		});
	});

});
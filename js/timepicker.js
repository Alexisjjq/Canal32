$(document).ready(function(){
		$(document).on('click', '.datePicker', function(){
		$(this).datetimepicker({
			date: null,
			format: 'YYYY/MM/DD HH:mm',
			icons: {
				time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
 	            down: "fa fa-arrow-down"
			}
		});
	});

});
$(document).ready(function(){
	$('#calendar').fullcalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month, agendaWeek, agendaDay, listWeek'
		}

		editable: true,
		navLinks: true,
		eventLimit: false,
		events: {
			url: 'php/get-events.php',
			error: function(){
				$('#script-warning').show();
			}
		},
		loading: function(){
			$('#loading').toogle(bool);
		}
	});
});
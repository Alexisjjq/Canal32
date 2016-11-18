$(document).ready(function(){

	$('#calendar').fullCalendar({
      height: 400, 
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      defaultDate: '2016-09-12',
      editable: true,
      navLinks: true, // can click day/week names to navigate views
      eventLimit: true, // allow "more" link when too many events
      events: {
        url: 'dist/fullcalendar/demos/php/get-events.php',
        error: function() {
          $('#script-warning').show();
        }
      },
      loading: function(bool) {
        $('#loading').toggle(bool);
      },
      // windowResize: function(view) {
      //   alert('The calendar has adjusted to a window resize');
      // }
    });

	$('.items-habillage').mouseover(function(){
    	$(this).find('.fa').removeClass('fa-folder').addClass('fa-folder-open');
  	}).mouseout(function(){
    	$(this).find('.fa').removeClass('fa-folder-open').addClass('fa-folder');
  	});

  	$('[data-toggle="tooltip"]').tooltip()
  	$('[data-toggle="popover"]').popover()
  	$('.popOverData').popover();
    $('.popOverData').popover({trigger : "hover"});
});

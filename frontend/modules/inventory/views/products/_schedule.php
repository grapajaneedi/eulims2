<?php 
use common\models\inventory\Equipmentservice;
use yii\helpers\Url;
?>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
<script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>

<?php
  $events = array();
  //Testing
  $Event = new Equipmentservice();
  $Event->equipmentservice_id = 1;
  // $Event->title = 'Testing';
  $Event->startdate = date('Y-m-d\TH:i:s\Z');
	  // $event->nonstandard = [
	  //   'field1' => 'Something I want to be included in object #1',
	  //   'field2' => 'Something I want to be included in object #2',
	  // ];
  $events[] = $Event;

  $Event = new Equipmentservice();
  $Event->equipmentservice_id = 2;
  // $Event->title = 'Testing';
  $Event->startdate = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
  $events[] = $Event;

  ?>

  <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
      // 'events'=> $events,
    	'events' => Url::to(['/inventory/products/jsoncalendar'])
      // 'id'=>'mycalendar'
  ));

?>


<script type="text/javascript">
	$('#w0').fullCalendar({"loading":function(isLoading, view ) {
                $('#w0').find('.fc-loading').toggle(isLoading);
        },"selectable":true,"selectHelper":true,"droppable":true,"editable":true,"drop":function(date) {
    alert("Dropped on " + date.format());
    if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
    }
},"select":function(start, end) {
    var title = prompt('Event Title:');
    var eventData;
    if (title) {
        eventData = {
            title: title,
            start: start,
            end: end
        };
        $('#w0').fullCalendar('renderEvent', eventData, true);
    }
    $('#w0').fullCalendar('unselect');
},"eventClick":function(calEvent, jsEvent, view) {

    alert('Event: ' + calEvent.title);
    alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    alert('View: ' + view.name);

    // change the border color just for fun
    $(this).css('border-color', 'red');

}
,"defaultDate":"2018-12-13","events":"/invenotry/products/jsoncalendar","header":{"center":"title","left":"prev,next today","right":"month,agendaWeek"}});

</script>
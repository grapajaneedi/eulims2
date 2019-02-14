<?php 
use common\models\inventory\Equipmentservice;
use yii\helpers\Url;
use yii\web\JsExpression;

$DragJS = <<<EOF
/* initialize the external events
-----------------------------------------------------------------*/
$('#external-events .fc-event').each(function() {
    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
    });
    // make the event draggable using jQuery UI
    $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
    });
});
EOF;
$this->registerJs($DragJS);

$JSDayClick = <<<EOF
function (date, allDay, jsEvent, view) { 
    alert('haha');
}
EOF;

$JSCode = <<<EOF
function(start, end) {
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
}
EOF;
$JSDropEvent = <<<EOF
function(date) {
    alert("Dropped on " + date.format());
    if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
    }
}
EOF;
$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {


    // $.ajax({
    //     url: Url::to(['/inventory/products/dayClickCalendarEvent']),
    //     dataType: 'json',
    //     data: { 
    //           title: calEvent.title,
             
    //     },
        
    // });

}
EOF;

?>
<div class="products-index">
    <div id="external-events">
    <h4>Draggable Events</h4>
    <div class="fc-event ui-draggable ui-draggable-handle">Calibration</div>
    <div class="fc-event ui-draggable ui-draggable-handle">Maintenace</div>
    <div class="fc-event ui-draggable ui-draggable-handle">Usage</div>
    <p>
        <input type="checkbox" id="drop-remove">
        <label for="drop-remove">remove after drop</label>
    </p>x
</div>
 <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
      'events'=> Url::to(['/inventory/products/jsoncalendar']),
      'clientOptions' => [
                    'selectable' => true,
                    'selectHelper' => true,
                    'droppable' => true,
                    'editable' => true,
                    'select' => new JsExpression($JSCode),
                    'drop' => new JsExpression($JSDropEvent),
                    'eventClick' => new JsExpression($JSEventClick),
                    // 'dayClick'=>new \yii\web\JsExpression($JSDayClick),
                    'defaultDate' => date('Y-m-d')
              ],
  ));
?>
</div>
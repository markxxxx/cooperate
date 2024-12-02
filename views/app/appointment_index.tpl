{include file="header.tpl"}

{head}
<link rel="stylesheet" href="/include/fullcalendar/fullcalendar.css" type="text/css" cache="false" />
<link rel="stylesheet" href="/include/fullcalendar/theme.css" type="text/css" cache="false" />

<script src="/include/fullcalendar/fullcalendar.min.js" cache="false"></script>


{literal}

<script>

  $(function(){
    $('#show_link').click(function(){
      $('#import').hide();
      $('#import_url').show('slow');
    });
  });

  !function ($) {

    $(function(){

      function padStr(i) {
          if(i == 0) {
            return "00";
          }
          return (i < 10) ? "0" + i : "" + i;
      }

      // fullcalendar
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();
      var addDragEvent = function($this){
        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($this.text()), // use the element's text as the event title
          className: $this.attr('class').replace('label','')
        };
        
        // store the Event Object in the DOM element so we can get to it later
        $this.data('eventObject', eventObject);
        
        // make the event draggable using jQuery UI
        $this.draggable({
          zIndex: 999,
          revert: true,      // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });
      };
      $('#calendar').each(function() {
        $(this).fullCalendar({
          header: {
            left: 'prev,next',
            center: 'title',
            right: 'today,month,agendaDay'
          },
          editable: false,
          dayClick: function(date, allDay, jsEvent, view) {
              if (view.name === "month") {
                  $('#calendar').fullCalendar('gotoDate', date);
                  $('#calendar').fullCalendar('changeView', 'agendaDay');
              } else if(view.name == 'agendaDay') {
            var dateStr = padStr(date.getFullYear()) +'-'+
                  padStr(1 + date.getMonth()) +'-'+
                  padStr(date.getDate()) +' '+
                  padStr(date.getHours()) +':'+
                  padStr(date.getMinutes());

                  $.colorbox({href:'/appointment/add?date='+encodeURIComponent(dateStr)});

              }
          },
          events:'/appointment/get_dates',


          droppable: false, // this allows things to be dropped onto the calendar !!!
          drop: function(date, allDay) { // this function is called when something is dropped
            
              // retrieve the dropped element's stored Event Object
              var originalEventObject = $(this).data('eventObject');
              
              // we need to copy it, so that multiple events don't have a reference to the same object
              var copiedEventObject = $.extend({}, originalEventObject);
              
              // assign it the date that was reported
              copiedEventObject.start = date;
              copiedEventObject.allDay = allDay;
              
              // render the event on the calendar
              // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
              $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
              
              // is the "remove after drop" checkbox checked?
              if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
              }
              
            }
          
          
        });
      });
      $('#myEvents').on('change', function(e, item){
        addDragEvent($(item));
      });

      $('#myEvents li').each(function() {
        addDragEvent($(this));
      });

    });
  }(window.jQuery);
</script>



{/literal}
{/head}

<div id="content">

    <h3 class="green" style="width:100%;font-size:200%">Calendar


    <div class="right" style="margin-top:12px;">
      <div class=" left fc-event fc-event-hori fc-event-start fc-event-end" style="margin-right:5px;"><span style="font-size:12px;padding:8px"class="fc-event-time">Calendar</span></div>

            <div class=" left fc-event fc-event-hori fc-event-start fc-event-end reminder_cal" style="margin-right:5px;"><span style="font-size:12px;padding:8px; "class="fc-event-time">Reminder</span></div>

                        <div style="margin-right:5px;" class=" left fc-event fc-event-hori fc-event-start fc-event-end event_date_cal"><span style="font-size:12px;padding:8px"class="fc-event-time">Event</span></div>

    </div>
	</h3>
        <div style="background-color:#EFEFEF;border:1px solid silver; padding:5px;font-size:12px;">

          <div id="import">
              <img style="padding-right:8px" src="/views/app/images/outlook.jpg" align="left">&nbsp;
              <img src="/views/app/images/goolge.gif" align="left"> &nbsp;

              <a href="#test" id="show_link">Click here</a> to import this calendar into your email client
          </div>
          <div class="hidden" id="import_url">
            <b>{$ics_link}.ics</b> - This is your unique calendar url for your email client. Import it using your mail client</b> 
          </div>
        </div>
        <br />
    <div  id="calendar"></div>


</div>
</div>

{include file="footer.tpl"}
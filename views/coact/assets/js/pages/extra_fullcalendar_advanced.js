/* ------------------------------------------------------------------------------
*
*  # Fullcalendar advanced options
*
*  Specific JS code additions for extra_fullcalendar_advanced.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Add events
    // ------------------------------

    // Default events
    var events = [
        {
            title: 'All Day Event',
            start: '2014-11-01'
        },
        {
            title: 'Long Event',
            start: '2014-11-07',
            end: '2014-11-10'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2014-11-09T16:00:00'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2014-11-16T16:00:00'
        },
        {
            title: 'Conference',
            start: '2014-11-11',
            end: '2014-11-13'
        },
        {
            title: 'Meeting',
            start: '2014-11-12T10:30:00',
            end: '2014-11-12T12:30:00'
        },
        {
            title: 'Lunch',
            start: '2014-11-12T12:00:00'
        },
        {
            title: 'Meeting',
            start: '2014-11-12T14:30:00'
        },
        {
            title: 'Happy Hour',
            start: '2014-11-12T17:30:00'
        },
        {
            title: 'Dinner',
            start: '2014-11-12T20:00:00'
        },
        {
            title: 'Birthday Party',
            start: '2014-11-13T07:00:00'
        },
        {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2014-11-28'
        }
    ];

    // Event colors
    var eventColors = [
        {
            title: 'All Day Event',
            start: '2014-11-01',
            color: '#EF5350'
        },
        {
            title: 'Long Event',
            start: '2014-11-07',
            end: '2014-11-10',
            color: '#26A69A'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2014-11-09T16:00:00',
            color: '#26A69A'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2014-11-16T16:00:00',
            color: '#5C6BC0'
        },
        {
            title: 'Conference',
            start: '2014-11-11',
            end: '2014-11-13',
            color: '#546E7A'
        },
        {
            title: 'Meeting',
            start: '2014-11-12T10:30:00',
            end: '2014-11-12T12:30:00',
            color: '#546E7A'
        },
        {
            title: 'Lunch',
            start: '2014-11-12T12:00:00',
            color: '#546E7A'
        },
        {
            title: 'Meeting',
            start: '2014-11-12T14:30:00',
            color: '#546E7A'
        },
        {
            title: 'Happy Hour',
            start: '2014-11-12T17:30:00',
            color: '#546E7A'
        },
        {
            title: 'Dinner',
            start: '2014-11-12T20:00:00',
            color: '#546E7A'
        },
        {
            title: 'Birthday Party',
            start: '2014-11-13T07:00:00',
            color: '#546E7A'
        },
        {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2014-11-28',
            color: '#FF7043'
        }
    ];

    // External events
    // ------------------------------

    // Add switcher for events removal
    var remove = document.querySelector('.switch');
    var removeInit = new Switchery(remove);

    // Initialize the calendar
    // ADP 2018/08/22 - Remove the Week and Day view //,agendaWeek,agendaDay
    $('.fullcalendar-external').fullCalendar({
        header: {
            left: 'title',
            center: 'month,agendaWeek,agendaDay',
            right: 'prev,next today' //'month,agendaWeek,agendaDay'
        },
        editable: true,
        navLinks: false, // can click day/week names to navigate views
        defaultDate: new Date(),
        defaultView: 'month',
        firstDay: 1,
        selectable: true,
        selectHelper: true,
        droppable: true, // this allows things to be dropped onto the calendar
        locale: 'en',
        businessHours: true,
        eventLimit: false, // allow "more" link when too many events
        //displayEventTime: false,
        // ADP 2019/06/19
        //eventRender: function(info) {
        //    var tooltip = new Tooltip(info.el, {
        //        title: info.event.extendedProps.title,
        //        placement: 'top',
        //        trigger: 'hover',
        //        container: 'body'
        //    });
        //},
        events: {
            url: '/appointment/get_dates',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching project events.');
            }
        },
        //eventDataTransform: function (eventData) {
        //
        //    var start = new Date(eventData.start);
        //    var end = new Date(eventData.end);
        //    var newdate = new Date(end);
        //
        //    var isSameDay = (start.getDate() === end.getDate()
        //    && start.getMonth() === end.getMonth()
        //    && start.getFullYear() === end.getFullYear());
        //
        //    eventData.allDay = true;
        //
        //    if (!isSameDay) {
        //        newdate.setDate(newdate.getDate() + 1);
        //    }
        //    //alert(end + ' / ' + newdate);
        //    //var dd = newdate.getDate();
        //    //var mm = newdate.getMonth() + 1;
        //    //var y = newdate.getFullYear();
        //
        //    //var FormattedDate = y + '-' + mm + '-' + dd + ' 00:00:00';
        //    //alert(end + ' / ' + FormattedDate);
        //    eventData.end = newdate; //FormattedDate;
        //
        //    return(eventData);
        //},
        drop: function(date, jsEvent, ui, resourceId) {
            if ($('#drop-remove').is(':checked')) { // is the "remove after drop" checkbox checked?
                $(this).remove(); // if so, remove the element from the "Draggable Events" list
            }
            
            var start = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
            var color = $(this).data('color');

            $.ajax({
                url: '/appointment/add/',
                data: 'title=' + $(this).html() + '&start=' + start + '&end=' + end + '&color=' + color,
                type: "POST",
                //dataType: 'json',
                success: function(response) {

                    // var view = $('.fullcalendar-external').fullCalendar('getView');
                    // alert("The view's title is " + view.name);
                    // alert($('.fc-state-active').text)
                    // if (view.name == "month"){ // only refresh for month view so i gets inserted id
//                                tasks = JSON.parse(response);
//                                $('#appointment_id').val(tasks[0]['appointment_id']);
//                                var select="<option value=''>Select Task:</option>";
//                                for (var i = 0; i < tasks.length; i++){
//                                    select=select+"<option value='"+tasks[i]['id']+"'>"+tasks[i]['task']+"</option>";
//                                }
//                                $('#field_task_id').html(select);
//                                $('#modal_appointment_info').modal();
//                                $('.fullcalendar-external').fullCalendar('refetchEvents');
                    // $('.fullcalendar-external').fullCalendar('refresh');
                    // }

                    //alert(response);

                    tasks = JSON.parse(response);

                    if (tasks && tasks.length > 0) {

                        // Capture the appointment ID
                        $('#field_appointment_id').val(tasks[0]['appointment_id']);

                        // Build the task list
                        var select="<option value=''>Select Task:</option>";
                        for (var i = 0; i < tasks.length; i++){
                            select=select+"<option value='"+tasks[i]['id']+"'>"+tasks[i]['task']+"</option>";
                        }
                        // Populate the dropdown list with the available tasks
                        $('#field_task_id').html(select);
                        // Show the modal popup
                        $('#modal_appointment_info').modal();

                    } else {
                        alert('Unable to create an event for the project: No tasks available.');
                    }

                    // Refresh the calendar events
                    $('.fullcalendar-external').fullCalendar('refetchEvents');

                }
            });
        },
        //select: function(start, end, allDay) {
        //    var title = prompt('Event Title:');
        //    if (title) {
        //        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
        //        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
        //        $.ajax({
        //            url: '/appointment/add/',
        //            data: 'title=' + title + '&start=' + start + '&end=' + end,
        //            type: "POST",
        //            success: function(json) {
        //                alert('Added Successfully');
        //            }
        //        });
        //
        //        $('.fullcalendar-external').fullCalendar('refetchEvents');
        //        // $('.fullcalendar-external').fullCalendar('renderEvent',
        //        //     {
        //        //         title: title,
        //        //         start: start,
        //        //         end: end,
        //        //         allDay: allDay
        //        //     },
        //        //     true
        //        // );
        //    }
        //    // $('.fullcalendar-external').fullCalendar('unselect');
        //},
        eventDrop: function(event, delta) {
            //alert('eventDrop');
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            $.ajax({
                url: '/appointment/add/'+event.id+'/',
                data: 'title=' + event.title + '&start=' + start + '&end=' + end,
                type: "POST",
                success: function(json) {
                    alert("Updated Successfully");
                    $('.fullcalendar-external').fullCalendar('refetchEvents');
                }
            });
        },
        eventClick: function(event) {
            var firstpart = $(this).html().split('SubRef:');
            var project_id = firstpart[1].split('(')[0];
            var task_id = 0;
            if (firstpart[1].indexOf('(') > -1){
                var secondpart = firstpart[1].split('(');
                task_id = secondpart[1].split(')')[0];
            }

            // alert(project_id);
            // alert(task_id);

            $.ajax({
                //url: '/appointment/event_view/'+project_id[0]+'/'+task_id[0],
                url: '/appointment/event_view/'+project_id+'/'+task_id,
                // data: 'title=' + $(this).html() + '&start=' + start + '&end=' + end + '&color=' + color,
                type: "POST",
                success: function(response) {
                    var info = JSON.parse(response);
                    var project_info='';
                    var project_plan='';
                    // console.log(info['thistask']);

                    project_info=project_info+'<span class="label bg-teal help-inline">Subjec</span><br>'+info['thisproject']['project_name']+'<br>';
                    project_info=project_info+'<span class="label bg-teal help-inline">Description</span><br>'+info['thisproject']['description']+'<br>';

                    // Show the project plans
                    // if (info['thisproject']['plan']) {
                    //     project_plan = project_plan + '<span class="label bg-teal help-inline">Plans</span><br><a href="/documents/plans/' + info['thisproject']['plan'] + '" target="_blank">' + info['thisproject']['plan'] + '</a><br>';
                    // } else {
                    //     project_plan = project_plan + '<span class="label bg-teal help-inline">Plans</span><br>No plan linked to this project<br>';
                    // }

                    // Show the appointment task
                    if (info['thistask']['task']) {
                        project_info=project_info+'<span class="label bg-teal help-inline">Lesson</span><br>'+info['thistask']['task']+'<br>';
                        if (info['thistask']['completed'] == 1) {
                            project_info=project_info+'<span class="label bg-teal help-inline">Completed</span><br>Yes<br>';
                        } else {
                            project_info=project_info+'<span class="label bg-teal help-inline">Completed</span><br>No<br>';
                        }
                    }

                    // Show the appointment id
                    if (info['thisappointment']) {

                        $('#appointment_id').val(info['thisappointment']['appointment_id']); //document.getElementById('hidden1').value=info['thisappointment']['appointment_id'];
                        $('#task_id').val(info['thistask']['id']);
                        $('#field_comments').val(info['thisappointment']['comments']);

                    }

                    $('#project_information').html(project_info);
                    $('#project_plan').html(project_plan);
                    $('#modal_project_info').modal();
                }
            });
            // var decision = confirm("Do you really want to remove this appointment?");
            // if (decision) {
            //     $.ajax({
            //         type: "POST",
            //         url: "/appointment/delete/"+event.id+"/",
            //         data: "&id=" + event.id,
            //         success: function(json) {
            //             $('.fullcalendar-external').fullCalendar('removeEvents', event.id);
            //             // alert("Removed Successfully");
            //             $('.fullcalendar-external').fullCalendar('refetchEvents');
            //         }
            //     });
            // }
        },
        eventResize: function(event, delta, revertFunc) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            $.ajax({
                url: '/appointment/add/'+event.id+'/',
                data: 'title=' + event.title + '&start=' + start + '&end=' + end,
                type: "POST",
                success: function(data) {
                    alert("Updated Successfully");
                    $('.fullcalendar-external').fullCalendar('refetchEvents');
                }
            });
        }
    });

    // Initialize the external events
    $('#external-events .fc-event').each(function() {

        // Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});

        // Store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).html()), // use the element's text as the event title
            color: $(this).data('color'),
            stick: false // maintain when user navigates (see docs on the renderEvent method) dont show after refresh
        });

        // Make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0 // original position after the drag
        });

    });

    // RTL direction
    // ------------------------------

    // $('.fullcalendar-rtl').fullCalendar({
    //     header: {
    //         left: 'prev,next today',
    //         center: 'title',
    //         right: 'month,agendaWeek,agendaDay'
    //     },
    //     defaultDate: '2014-11-12',
    //     editable: true,
    //     isRTL: true,
    //     locale: 'ar',
    //     events: events
    // });
    
});

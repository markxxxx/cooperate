/* ------------------------------------------------------------------------------
*
*  # Fullcalendar basic options
*
*  Specific JS code additions for extra_fullcalendar_views.html and 
*  extra_fullcalendar_styling.html pages
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

    // Event background colors
    var eventBackgroundColors = [
        {
            title: 'All Day Event',
            start: '2014-11-01'
        },
        {
            title: 'Long Event',
            start: '2014-11-07',
            end: '2014-11-10',
            color: '#DCEDC8',
            rendering: 'background'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2014-11-06T16:00:00'
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
            title: 'Happy Hour',
            start: '2014-11-12T17:30:00'
        },
        {
            title: 'Dinner',
            start: '2014-11-24T20:00:00'
        },
        {
            title: 'Meeting',
            start: '2014-11-03T10:00:00'
        },
        {
            title: 'Birthday Party',
            start: '2014-11-13T07:00:00'
        },
        {
            title: 'Vacation',
            start: '2014-11-27',
            end: '2014-11-30',
            color: '#FFCCBC',
            rendering: 'background'
        }
    ];

    // Initialization
    // ------------------------------

    //// Basic view
    //$('.fullcalendar-basic').fullCalendar({
    //    header: {
    //        left: 'prev,next today',
    //        center: 'title',
    //        right: 'month,basicWeek,basicDay'
    //    },
    //    defaultDate: '2014-11-12',
    //    editable: true,
    //    events: events
    //});
    //
    //// Agenda view
    //$('.fullcalendar-agenda').fullCalendar({
    //    locale: 'en',
    //    header: {
    //        left: 'prev,next today',
    //        center: 'title',
    //        right: 'month,agendaWeek,agendaDay'
    //    },
    //    defaultDate: '2014-11-12',
    //    defaultView: 'agendaWeek',
    //    editable: true,
    //    events: events
    //});
    //
    //// List view
    //$('.fullcalendar-list').fullCalendar({
    //    header: {
    //        left: 'prev,next today',
    //        center: 'title',
    //        right: 'listDay,listWeek,listMonth'
    //    },
    //    views: {
    //        listDay: { buttonText: 'Day' },
    //        listWeek: { buttonText: 'Week' },
    //        listMonth: { buttonText: 'Month' }
    //    },
    //    defaultView: 'listMonth',
    //    defaultDate: '2014-11-12',
    //    navLinks: true, // can click day/week names to navigate views
    //    editable: true,
    //    eventLimit: true, // allow "more" link when too many events
    //    events: events
    //});

    function addDays(dateObj, numDays) {
       dateObj.setDate(dateObj.getDate() + numDays);
       return dateObj;
    }

    var now = new Date();
    var nextWeek = addDays(new Date(), 7);

    // Event colors this week
    $('.fullcalendar-event-colors-1').fullCalendar({
        //header: {
        //    left: 'prev,next today',
        //    center: 'title'//,
        //    //right: 'month,agendaWeek,agendaDay'
        //},
        editable: false, //editable: true,
        navLinks: false, // can click day/week names to navigate views
        defaultDate: new Date(),
        defaultView: 'month',
        firstDay: 1,
        selectable: true,
        selectHelper: true,
        droppable: false, // this allows things to be dropped onto the calendar
        locale: 'en',
        //businessHours: true,
        businessHours: [ // specify an array instead
            {
                dow: [ 1, 2, 3, 4, 5 ], // Monday, Tuesday, Wednesday
                start: '08:00', // 8am
                end: '18:00' // 6pm
            }//,
            //{
            //    dow: [ 5 ], // Thursday, Friday
            //    start: '08:00', // 8am
            //    end: '12:00' // 12pm
            //}
        ],
        //displayEventTime: false,
        events: {
            url: '/appointment/get_dates_team',
            type: 'POST', // Send post data
            error: function() {
                alert('There was an error while fetching team events.');
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
        //
        //    var dd = newdate.getDate();
        //    var mm = newdate.getMonth() + 1;
        //    var y = newdate.getFullYear();
        //
        //    var FormattedDate = y + '-' + mm + '-' + dd + ' 00:00:00';
        //
        //    eventData.end = FormattedDate;
        //
        //    return(eventData);
        //},
        //drop: function(date, jsEvent, ui, resourceId) {
        //    if ($('#drop-remove').is(':checked')) { // is the "remove after drop" checkbox checked?
        //        $(this).remove(); // if so, remove the element from the "Draggable Events" list
        //    }
        //
        //    var start = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
        //    var end = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
        //    var color = $(this).data('color');
        //    $.removeCookie("project");
        //    $.ajax({
        //        url: '/appointment/add/',
        //        data: 'title=' + $(this).html() + '&start=' + start + '&end=' + end + '&color=' + color,
        //        type: "POST",
        //        success: function(response) {
        //            // var view = $('.fullcalendar-external').fullCalendar('getView');
        //            // alert("The view's title is " + view.name);
        //            // alert($('.fc-state-active').text)
        //            // if (view.name == "month"){ // only refresh for month view so i gets inserted id
        //                parts = response.split("-");
        //                $('#appointment_id').val(parts[0]);
        //                $('#project_id').val(parts[1]);
        //
        //                // $.cookie("project", parts[1], { path:'/'} );
        //                // $('#project_id').val(parts[1]);
        //                 // alert($.now()+5);
        //                 $('#modal_appointment_info').modal();
        //                $('.fullcalendar-external').fullCalendar('refetchEvents');
        //
        //                // $('.fullcalendar-external').fullCalendar('refresh');
        //            // }
        //        }
        //    });
        //
        //},
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
        //eventDrop: function(event, delta) {
        //    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        //    $.ajax({
        //        url: '/appointment/add/'+event.id+'/',
        //        data: 'title=' + event.title + '&start=' + start + '&end=' + end,
        //        type: "POST",
        //        success: function(json) {
        //            alert("Updated Successfully");
        //            $('.fullcalendar-external').fullCalendar('refetchEvents');
        //        }
        //    });
        //},
        eventClick: function(event) {
            var firstpart = $(this).html().split('SubRef:');
            var project_id = firstpart[1].split(' - ')[0];
            var task_id = 0;
            if (firstpart[1].indexOf('(') > -1){
                var secondpart = firstpart[1].split('(');
                task_id = secondpart[1].split(')')[0];
            }

            //alert(project_id);
            //alert(task_id);

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

                    project_info=project_info+'<span class="label bg-teal help-inline">Project Name</span><br>'+info['thisproject']['project_name']+'<br>';
                    project_info=project_info+'<span class="label bg-teal help-inline">Project Description</span><br>'+info['thisproject']['description']+'<br>';
                    project_info=project_info+'<span class="label bg-teal help-inline">Customer</span><br>'+info['thisproject']['customer_name']+' '+info['thisproject']['customer_surname']+'<br>';
                    project_info=project_info+'<span class="label bg-teal help-inline">Contact Details</span><br>'+info['thisproject']['contact_number']+'<br>'+info['thisproject']['email']+'<br>';
                    project_info=project_info+'<span class="label bg-teal help-inline">Project Status</span><br>'+info['thisproject']['status']+'<br>';

                    // Show the project plans
                    if (info['thisproject']['plan']) {
                        project_plan = project_plan + '<span class="label bg-teal help-inline">Plans</span><br><a href="/documents/plans/' + info['thisproject']['plan'] + '" target="_blank">' + info['thisproject']['plan'] + '</a><br>';
                    } else {
                        project_plan = project_plan + '<span class="label bg-teal help-inline">Plans</span><br>No plan linked to this project<br>';
                    }

                    // Show the appointment task
                    if (info['thistask']['task']){
                        project_info=project_info+'<span class="label bg-teal help-inline">Task</span><br>'+info['thistask']['task']+'<br>';
                        if (info['thistask']['completed'] == 1) {
                            project_info=project_info+'<span class="label bg-teal help-inline">Completed</span><br>Yes<br>';
                        } else {
                            project_info=project_info+'<span class="label bg-teal help-inline">Completed</span><br>No<br>';
                        }
                    }

                    // Show the appointment id
                    if (info['thisappointment']) {

                        $('#appointment_id').val(info['thisappointment']['appointment_id']);
                        $('#task_id').val(info['thistask']['id']);
                        $('#field_comments').val(info['thisappointment']['comments']);

                    }

                    $('#project_information').html(project_info);
                    $('#project_plan').html(project_plan);
                    $('#modal_project_info').modal();
                }
            });

            // alert(task_id[0] );
            //$.ajax({
            //    url: '/appointment/event_view/'+project_id[0]+'/'+task_id[0],
            //    // data: 'title=' + $(this).html() + '&start=' + start + '&end=' + end + '&color=' + color,
            //    type: "POST",
            //    success: function(response) {
            //        var info = JSON.parse(response);
            //        var project_info='';
            //        // console.log(info['thistask']);
            //
            //        project_info=project_info+'<span class="label bg-teal help-inline">Project Name</span><br>'+info['thisproject']['project_name']+'<br>';
            //        project_info=project_info+'<span class="label bg-teal help-inline">Project Description</span><br>'+info['thisproject']['description']+'<br>';
            //        project_info=project_info+'<span class="label bg-teal help-inline">Customer</span><br>'+info['thisproject']['customer_name']+' '+info['thisproject']['customer_surname']+'<br>';
            //        project_info=project_info+'<span class="label bg-teal help-inline">Contact Details</span><br>'+info['thisproject']['contact_number']+'<br>'+info['thisproject']['email']+'<br>';
            //        project_info=project_info+'<span class="label bg-teal help-inline">Project Status</span><br>'+info['thisproject']['status']+'<br>';
            //
            //        // Show the project plans
            //        if (info['thisproject']['plan']) {
            //            project_info=project_info+'<span class="label bg-teal help-inline">Plans</span><br><a href="/documents/plans/'+info['thisproject']['plan']+'" target="_blank">'+info['thisproject']['plan']+'</a><br>';
            //        } else {
            //            project_info=project_info+'<span class="label bg-teal help-inline">Plans</span><br>No plan linked to this project<br>';
            //        }
            //
            //        // Show the appointment task
            //        if (info['thistask']['task']){
            //            project_info=project_info+'<span class="label bg-teal help-inline">Task</span><br>'+info['thistask']['task']+'<br>';
            //            if (info['thistask']['completed'] == 1) {
            //                project_info=project_info+'<span class="label bg-teal help-inline">Completed</span><br>Yes<br>';
            //            } else {
            //                project_info=project_info+'<span class="label bg-teal help-inline">Completed</span><br>No<br>';
            //            }
            //        }
            //
            //        // Show the appointment id
            //        if (info['thisappointment']) {
            //            $('#appointment_id').val(info['thisappointment']['appointment_id']);
            //            $('#task_id').val(info['thistask']['id']);
            //            //document.getElementById('hidden1').value=info['thisappointment']['appointment_id'];
            //        }
            //
            //        $('#project_information').html(project_info);
            //        $('#modal_project_info').modal();
            //    }
            //});

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

    // Event colors next week
    // $('.fullcalendar-event-colors-2').fullCalendar({
    //     locale: 'en',
    //     header: {
    //         left: 'prev,next today',
    //         center: 'title',
    //         right: 'month,agendaWeek'
    //     },
    //     defaultDate: nextWeek,
    //     defaultView: 'month',
    //     events: {
    //         url: '/appointment/get_dates_team',
    //         type: 'POST', // Send post data
    //         error: function() {
    //             alert('There was an error while fetching events.');
    //         }
    //     },
    //     droppable: true, // this allows things to be dropped onto the calendar
    //     drop: function(date, jsEvent, ui, resourceId) {
    //         if ($('#drop-remove').is(':checked')) { // is the "remove after drop" checkbox checked?
    //             $(this).remove(); // if so, remove the element from the "Draggable Events" list
    //         }
            
    //         var start = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
    //         var end = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
    //         var color = $(this).data('color');
    //         $.removeCookie("project");
    //         $.ajax({
    //             url: '/appointment/add/',
    //             data: 'title=' + $(this).html() + '&start=' + start + '&end=' + end + '&color=' + color,
    //             type: "POST",
    //             success: function(response) {
    //                 // var view = $('.fullcalendar-external').fullCalendar('getView');
    //                 // alert("The view's title is " + view.name);
    //                 // alert($('.fc-state-active').text)
    //                 // if (view.name == "month"){ // only refresh for month view so i gets inserted id
    //                     parts = response.split("-");
    //                     $('#appointment_id').val(parts[0]);
    //                     $('#project_id').val(parts[1]);
                        
    //                     // $.cookie("project", parts[1], { path:'/'} );
    //                     // $('#project_id').val(parts[1]);
    //                      // alert($.now()+5);
    //                      $('#modal_appointment_info').modal();
    //                     $('.fullcalendar-external').fullCalendar('refetchEvents');

    //                     // $('.fullcalendar-external').fullCalendar('refresh');
    //                 // }
    //             }
    //         });
            
    //     },           
    //     selectable: true,
    //     selectHelper: true,
    //     select: function(start, end, allDay) {
    //         var title = prompt('Event Title:');
    //         if (title) {
    //             var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
    //             var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
    //             $.ajax({
    //                 url: '/appointment/add/',
    //                 data: 'title=' + title + '&start=' + start + '&end=' + end,
    //                 type: "POST",
    //                 success: function(json) {
    //                     alert('Added Successfully');
    //                 }
    //             });

    //             $('.fullcalendar-external').fullCalendar('refetchEvents');
    //             // $('.fullcalendar-external').fullCalendar('renderEvent',
    //             //     {
    //             //         title: title,
    //             //         start: start,
    //             //         end: end,
    //             //         allDay: allDay
    //             //     },
    //             //     true
    //             // );
    //         }
    //         // $('.fullcalendar-external').fullCalendar('unselect');
    //     },
    //     editable: true,
    //     eventDrop: function(event, delta) {
    //         var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
    //         var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
    //         $.ajax({
    //             url: '/appointment/add/'+event.id+'/',
    //             data: 'title=' + event.title + '&start=' + start + '&end=' + end,
    //             type: "POST",
    //             success: function(json) {
    //                 alert("Updated Successfully");
    //                 $('.fullcalendar-external').fullCalendar('refetchEvents');
    //             }
    //         });
    //     },
    //     eventClick: function(event) {
    //         var decision = confirm("Do you really want to remove this appointment?");
    //         if (decision) {
    //             $.ajax({
    //                 type: "POST",
    //                 url: "/appointment/delete/"+event.id+"/",
    //                 data: "&id=" + event.id,
    //                 success: function(json) {
    //                     $('.fullcalendar-external').fullCalendar('removeEvents', event.id);
    //                     // alert("Removed Successfully");
    //                     $('.fullcalendar-external').fullCalendar('refetchEvents');
    //                 }
    //             });
    //         }
    //     },
    //     eventResize: function(event, delta, revertFunc) {
    //         var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
    //         var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
    //         $.ajax({
    //             url: '/appointment/add/'+event.id+'/',
    //             data: 'title=' + event.title + '&start=' + start + '&end=' + end,
    //             type: "POST",
    //             success: function(data) {
    //                 alert("Updated Successfully");
    //                 $('.fullcalendar-external').fullCalendar('refetchEvents');
    //             }
    //         });
    //     }
    // });

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

    //// Event background colors
    //$('.fullcalendar-background-colors').fullCalendar({
    //    header: {
    //        left: 'prev,next today',
    //        center: 'title',
    //        right: 'month,agendaWeek,agendaDay'
    //    },
    //    defaultDate: '2014-11-12',
    //    editable: true,
    //    events: eventBackgroundColors
    //});

});

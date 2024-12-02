{include file="header.tpl"}
{head}

    <script type="text/javascript" src="{$template_dir}/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/fullcalendar/lang/ar.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/extra_fullcalendar.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    {literal}
    <script type="text/javascript">

        $( document ).ready(function() {

            $('#field_team').on("change",function(event) {

                //alert($('#field_team').val());
                UpdateCalView($('#field_team').val())

            });

        });

        function UpdateCalView(team_id) {

            //alert('Click: '+id);

            // Event colors this week
            $('.fullcalendar-event-colors-1').fullCalendar('destroy');
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
                    url: '/appointment/get_dates_team/'+team_id,
                    type: 'POST', // Send post data
                    error: function() {
                        alert('There was an error while fetching team events.');
                    }
                },
//                eventDataTransform: function (eventData) {
//
//                    var start = new Date(eventData.start);
//                    var end = new Date(eventData.end);
//                    var newdate = new Date(end);
//
//                    var isSameDay = (start.getDate() === end.getDate()
//                    && start.getMonth() === end.getMonth()
//                    && start.getFullYear() === end.getFullYear());
//
//                    eventData.allDay = true;
//
//                    if (!isSameDay) {
//                        newdate.setDate(newdate.getDate() + 1);
//                    }
//
//                    var dd = newdate.getDate();
//                    var mm = newdate.getMonth() + 1;
//                    var y = newdate.getFullYear();
//
//                    var FormattedDate = y + '-' + mm + '-' + dd + ' 00:00:00';
//
//                    eventData.end = FormattedDate;
//
//                    return(eventData);
//                },
//                eventDrop: function(event, delta) {
//                    //alert('eventDrop');
//                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//                    $.ajax({
//                        url: '/appointment/add/'+event.id+'/',
//                        data: 'title=' + event.title + '&start=' + start + '&end=' + end,
//                        type: "POST",
//                        success: function(json) {
//                            alert("Updated Successfully");
//                            $('.fullcalendar-external').fullCalendar('refetchEvents');
//                        }
//                    });
//                },
                eventClick: function(event) {
                    var firstpart = $(this).html().split('SubRef:');
                    var project_id = firstpart[1].split(' - ')[0];
                    var task_id = 0;
                    if (firstpart[1].indexOf('(') > -1){
                        var secondpart = firstpart[1].split('(');
                        task_id = secondpart[1].split(')')[0];
                    }

//                    alert(project_id);
//                    alert(task_id);

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

                    //                var decision = confirm("Do you really want to remove this appointment?");
                    //                if (decision) {
                    //                    $.ajax({
                    //                        type: "POST",
                    //                        url: "/appointment/delete/"+event.id+"/",
                    //                        data: "&id=" + event.id,
                    //                        success: function(json) {
                    //                            $('.fullcalendar-external').fullCalendar('removeEvents', event.id);
                    //                            // alert("Removed Successfully");
                    //                            $('.fullcalendar-external').fullCalendar('refetchEvents');
                    //                        }
                    //                    });
                    //                }
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

        }

        function CompleteTask() {

            var id = document.getElementById("task_id").value;
            //alert('Task ID: '+id);

            var result = confirm("Are you sure you want to Complete the task?");
            if (result) {

                $.ajax({
                    url: '/task/complete/'+id,
                    type: "POST",
                    success: function(response) {
                        $('#modal_project_info').modal('hide');
                        alert('Task successfully completed');
                        $('.fullcalendar-external').fullCalendar('refetchEvents');
                    }
                });

            }

        }

        function DeleteAppointment() {

            var id = document.getElementById("appointment_id").value;
            //alert('Appointment ID: '+id);

            var result = confirm("Are you sure you want to Remove the appointment?");
            if (result) {

                $.ajax({
                    url: '/appointment/delete/'+id,
                    type: "POST",
                    success: function(response) {
                        $('#modal_project_info').modal('hide');
                        alert('Appointment successfully removed');
                        $('.fullcalendar-external').fullCalendar('refetchEvents');
                    }
                });

            }

        }

        function UpdateAppointment() {

            var id = document.getElementById("appointment_id").value;
            var comments = document.getElementById("field_comments").value;

            //alert(comments);
            //alert('Appointment ID: ' + id);

            $.ajax({
                url: '/appointment/update_comments/'+id+'/'+comments,
                type: "POST",
                success: function (response) {
                    $('#modal_project_info').modal('hide');
                    alert('Appointment successfully updated');
                    $('.fullcalendar-external').fullCalendar('refetchEvents');
                }
            });

        }

    </script>
    {/literal}
{/head}

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Class Schedule</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    {if $user->can_access('quote', 'index')}
                        <a href="/quote" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Quotes</span></a>
                    {/if}
                    {if $user->can_access('invoice', 'index')}
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    {/if}
                    {if $user->can_access('appointment', 'index')}
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar text-primary"></i> <span>Appointments</span></a>
                    {/if}
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Class Schedule</li>
            </ul>
            <ul class="breadcrumb-elements">
                <!-- <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-gear position-left"></i>
                                    Settings
                                    <span class="caret"></span>
                                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
                        <li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
                        <li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>
    <!-- /Page header -->

    <!-- Content area -->
    <div class="content">
<!--         <div style="background-color:#EFEFEF;border:1px solid silver; padding:5px;font-size:12px;">
            <div id="import">
                <img style="padding-right:8px" src="/views/app/images/outlook.jpg" align="left">&nbsp;
                <img src="/views/app/images/goolge.gif" align="left"> &nbsp;
                <a href="#test" id="show_link">Click here</a> to import this calendar into your email client
            </div>
            <div class="hidden" id="import_url">
                <b>{$ics_link}.ics</b> - This is your unique calendar url for your email client. Import it using your mail client</b>
            </div>
        </div>
        <br /> -->
        <!-- <div id="calendar"></div> -->
        <!-- External events -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                {*<h5 class="panel-title">Team Schedule</h5>*}
                <div class="heading-elements">
                    <!-- <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a href="/appointment/get_dates_team" data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul> -->
                </div>
                <div style="display: none;">
                    <fieldset>
                    <ol style="list-style: none;">
                        <li>
                            <span class="label bg-teal help-inline">Filter By Class</span>                                               
                            <select name="data[team]" id="field_team" class="form-control">
                                <option value=''>Select Class:</option>
                                {section name=inst loop=$groups}
                                <option value="{$groups[inst].id}" {if $data.id eq $groups[inst].id}selected{/if}>{$groups[inst].name}, {$groups[inst].account}</option>
                                {/section}
                            </select>
                            <span class="clearFix">&nbsp;</span> {error field=team}
                        </li>
                    </ol>
                    </fieldset>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="content-group" id="external-events">
                            <h6 style="height: 38px; text-align: center; cursor: pointer;" onclick="UpdateCalView(0)">Class List</h6>
                            <div class="fc-events-container content-group">
                                <div class="fc-event" data-color="#323B44" onclick="UpdateCalView(0)" style="cursor: pointer; text-align: center;">All</div>
                                {section name=inst loop=$groups}
                                    <div class="fc-event" data-color="{$groups[inst].colour}" onclick="UpdateCalView({$groups[inst].id})" style="cursor: pointer;">{$groups[inst].name}</div> {*{$groups[inst].account}*}
                                {/section}
                            </div>
                            <div class="checkbox checkbox-right checkbox-switchery switchery-xs text-center">
                                <label>
                                    <input type="checkbox" class="switch" checked="checked" id="drop-remove" style="display:none;"> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="fullcalendar-event-colors-1"></div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="fullcalendar-event-colors-2"></div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- /external events -->

        <!-- Project info modal -->
        <div id="modal_project_info" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Project Information</h5>
                    </div>
                    <div class="modal-body">
                        {*<div class="alert alert-info alert-styled-left text-blue-800 content-group">*}
                            {*<span class="text-semibold">Project </span> info about the appointment.*}
                            {*<button type="button" class="close" data-dismiss="alert">×</button>*}
                        {*</div>*}
                        {*<h6 class="text-semibold"><i class="icon-law position-left"></i> Project Information</h6>*}
                        <hr>
                        <input type="hidden" id="task_id"><br>
                        <input type="hidden" id="appointment_id">
                        <div id="project_information"></div>
                        {if $user->can_access('quote', 'index')}
                            <div id="project_plan"></div>
                        {/if}
                        <span class="label bg-teal help-inline">Comments</span><br>
                        <input type="text" name="data[comments]" aria-multiline="true" class="form-control" id="field_comments" {if $user->can_access('appointment', 'update_comments')} placeholder="Enter comments here" {else}readonly{/if} />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                        {if $user->can_access('appointment', 'delete')}
                            <button class="btn btn-primary delete" onclick="DeleteAppointment();"><i class="icon-cross"></i> Delete</button>
                        {/if}
                        {if $user->can_access('task', 'complete')}
                            <button class="btn btn-primary submit" onclick="CompleteTask();"><i class="icon-check"></i> Complete</button>
                        {/if}
                        {if $user->can_access('appointment', 'update_comments')}
                            <button class="btn btn-primary submit" onclick="UpdateAppointment();"><i class="icon-pencil"></i> Update</button>
                        {/if}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->

</div>
<!-- /Main content -->
{include file="footer.tpl"}
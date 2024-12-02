<?php /* Smarty version 2.6.29, created on 2022-09-29 13:23:08
         compiled from /home/yourtctw/public_html/cooperate/views/coact/appointment_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/appointment_index.tpl', 2, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/appointment_index.tpl', 832, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/appointment_index.tpl', 884, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/fullcalendar/lang/ar.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/extra_fullcalendar_advanced.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <?php echo '
    <script type="text/javascript">

        $( document ).ready(function() {

            // Only display the appointments for the selected project filter
            $(\'#field_project\').on("change",function(event) {

                var project_id = $(\'#field_project\').val();
                //alert(\'change - ProjectID: \'+project_id);

                // Show the tasks for the selected project
                if (project_id > 0)
                {
                    document.getElementById("divTask").style.display = "block";
                    // Call function to load all the tasks for the selected project
                    LoadProjectTasks(project_id);
                } else {
                    $(\'#field_task\').empty();
                    document.getElementById("divTask").style.display = "none";
                }

                // Populate the calendar according to the selected project
//                $(\'.fullcalendar-external\').fullCalendar(\'destroy\');
//                $(\'.fullcalendar-external\').fullCalendar({
//                    locale: \'en\',
//                    header: {
//                        left: \'prev,next today\',
//                        center: \'title\'//,
//                        //right: month,agendaWeek,agendaDay
//                    },
//                    defaultDate: new Date(),
//                    //navLinks: false, // can click day/week names to navigate views
//                    //editable: true,
//                    //url: \'/appointment/get_dates/\'+$(\'#field_project\').val(),
//                    events: {
//                        url: \'/appointment/get_dates/\'+project_id,
//                        type: \'POST\', // Send post data
//                        error: function() {
//                            alert(\'There was an error while fetching project events 1.\');
//                        }
//                    },
//                    // eventRender: function(event, element, view) {
//                    //     if (event.allDay === \'true\') {
//                    //         event.allDay = true;
//                    //     } else {
//                    //         event.allDay = false;
//                    //     }
//                    // },
//                    droppable: true, // this allows things to be dropped onto the calendar
//                    drop: function(date, jsEvent, ui, resourceId) {
//                        if ($(\'#drop-remove\').is(\':checked\')) { // is the "remove after drop" checkbox checked?
//                            $(this).remove(); // if so, remove the element from the "Draggable Events" list
//                        }
//
//                        var start = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
//                        var end = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
//                        var color = $(this).data(\'color\');
//
//                        $.ajax({
//                            url: \'/appointment/add/\',
//                            data: \'title=\' + $(this).html() + \'&start=\' + start + \'&end=\' + end + \'&color=\' + color,
//                            type: "POST",
//                            success: function(response) {
//
//                                tasks = JSON.parse(response);
//
//                                if (tasks && tasks.length > 0) {
//
//                                    // Capture the appointment ID
//                                    $(\'#field_appointment_id\').val(tasks[0][\'appointment_id\']);
//
//                                    // Build the task list
//                                    var select="<option value=\'\'>Select Task:</option>";
//                                    for (var i = 0; i < tasks.length; i++){
//                                        select=select+"<option value=\'"+tasks[i][\'id\']+"\'>"+tasks[i][\'task\']+"</option>";
//                                    }
//                                    // Populate the dropdown list with the available tasks
//                                    $(\'#field_task_id\').html(select);
//                                    // Show the modal popup
//                                    $(\'#modal_appointment_info\').modal();
//
//                                } else {
//                                    alert(\'Unable to create an event for the project: No tasks available.\');
//                                }
//
//                                // Refresh the calendar events
//                                $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//
//                            }
//                        });
//
//                    },
//                    selectable: true,
//                    selectHelper: true,
////                    select: function(start, end, allDay) {
////                        var title = prompt(\'Event Title:\');
////                        if (title) {
////                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
////                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
////                            $.ajax({
////                                url: \'/appointment/add/\',
////                                data: \'title=\' + title + \'&start=\' + start + \'&end=\' + end,
////                                type: "POST",
////                                success: function(json) {
////                                    alert(\'Added Successfully\');
////                                }
////                            });
////
////                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
////                            // $(\'.fullcalendar-external\').fullCalendar(\'renderEvent\',
////                            //     {
////                            //         title: title,
////                            //         start: start,
////                            //         end: end,
////                            //         allDay: allDay
////                            //     },
////                            //     true
////                            // );
////                        }
////                        // $(\'.fullcalendar-external\').fullCalendar(\'unselect\');
////                    },
//                    editable: true,
//                    eventDrop: function(event, delta) {
//                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//                        $.ajax({
//                            url: \'/appointment/add/\'+event.id+\'/\',
//                            data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
//                            type: "POST",
//                            success: function(json) {
//                                alert("Updated Successfully");
//                                $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                            }
//                        });
//                    },
//                    eventClick: function(event) {
//                        var firstpart = $(this).html().split(\'ProjRef:\');
//                        var project_id = firstpart[1].split(\' - \')[0];
//                        var task_id = 0;
//                        if (firstpart[1].indexOf(\'(\') > -1){
//                            var secondpart = firstpart[1].split(\'(\');
//                            task_id = secondpart[1].split(\')\')[0];
//                        }
//
//                        //alert(task_id[0]);
//                        $.ajax({
//                            url: \'/appointment/event_view/\'+project_id+\'/\'+task_id,
//                            // data: \'title=\' + $(this).html() + \'&start=\' + start + \'&end=\' + end + \'&color=\' + color,
//                            type: "POST",
//                            success: function(response) {
//                                var info = JSON.parse(response);
//                                var project_info=\'\';
//                                // console.log(info[\'thistask\']);
//
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Project Name</span><br>\'+info[\'thisproject\'][\'project_name\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Project Description</span><br>\'+info[\'thisproject\'][\'description\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Customer</span><br>\'+info[\'thisproject\'][\'customer_name\']+\' \'+info[\'thisproject\'][\'customer_surname\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Contact</span><br>\'+info[\'thisproject\'][\'contact_number\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Status</span><br>\'+info[\'thisproject\'][\'status\']+\'<br>\';
//
//                                if (info[\'thistask\'][\'task\']){
//                                    project_info=project_info+\'<span class="label bg-teal help-inline">Task</span><br>\'+info[\'thistask\'][\'task\']+\'<br>\';
//                                }
//                                $(\'#project_information\').html(project_info);
//                                $(\'#modal_project_info\').modal();
//                            }
//                        });
//                        // var decision = confirm("Do you really want to remove this appointment?");
//                        // if (decision) {
//                        //     $.ajax({
//                        //         type: "POST",
//                        //         url: "/appointment/delete/"+event.id+"/",
//                        //         data: "&id=" + event.id,
//                        //         success: function(json) {
//                        //             $(\'.fullcalendar-external\').fullCalendar(\'removeEvents\', event.id);
//                        //             // alert("Removed Successfully");
//                        //             $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                        //         }
//                        //     });
//                        // }
//                    },
//                    eventResize: function(event, delta, revertFunc) {
//                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//                        $.ajax({
//                            url: \'/appointment/add/\'+event.id+\'/\',
//                            data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
//                            type: "POST",
//                            success: function(data) {
//                                alert("Updated Successfully");
//                                $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                            }
//                        });
//                    }
//                });

                UpdateCalView(project_id, null)

            });

            // Load the tasks for the selected project filter
            function LoadProjectTasks(pid) {

                //alert(\'LoadProjectTasks: \'+pid);

                $("#field_task").empty();
                $("#field_task").append("<option>Loading...</option>");

                $.ajax({
                    url: \'/appointment/get_project_tasks/\'+pid,
                    type: \'POST\',
                    dataType: \'json\',
                    success: function(response) {
                        $("#field_task").empty();
                        if (response.length > 0) {
                            $("#field_task").append("<option value=\'0\'>Select Task:</option>");
                            for (var i=0; i<response.length; i++) {
                                var id = response[i][\'task_id\'];
                                var task = response[i][\'task_description\'];
                                $("#field_task").append("<option value=\'"+id+"\'>"+task+"("+id+")</option>");
                            }
                        } else {
                            $("#field_task").append("<option value=\'0\'>No Tasks</option>");
                        }
                    }
                });

            }

            // Only display the appointments for the selected project/task filter
            $(\'#field_task\').on("change",function(event) {

                var project_id = $(\'#field_project\').val();
                var task_id = $(\'#field_task\').val();
                var task = $(\'#field_task :selected\').text();
                if (task_id == 0){
                    task = null;
                }

                //alert(\'project_id: \'+project_id+\' task_id: \'+task_id+\'task: \'+task);
                //alert(\'Task: \'+task);
                //alert(\'ProjectID: \'+project_id+\' change - TaskID: \'+task_id);
                // Populate the calendar according to the selected project
//                $(\'.fullcalendar-external\').fullCalendar(\'destroy\');
//                $(\'.fullcalendar-external\').fullCalendar({
//                    locale: \'en\',
//                    header: {
//                        left: \'prev,next today\',
//                        center: \'title\'//,
//                        //right: month,agendaWeek,agendaDay
//                    },
//                    defaultDate: new Date(),
//                    //navLinks: false, // can click day/week names to navigate views
//                    //editable: true,
//                    events: {
//                        url: \'/appointment/get_dates/\'+project_id+\'/\'+task,
//                        type: \'POST\', // Send post data
//                        error: function() {
//                            alert(\'There was an error while fetching project events 2.\');
//                        }
//                    },
//                    // eventRender: function(event, element, view) {
//                    //     if (event.allDay === \'true\') {
//                    //         event.allDay = true;
//                    //     } else {
//                    //         event.allDay = false;
//                    //     }
//                    // },
//                    droppable: true, // this allows things to be dropped onto the calendar
//                    drop: function(date, jsEvent, ui, resourceId) {
//                        if ($(\'#drop-remove\').is(\':checked\')) { // is the "remove after drop" checkbox checked?
//                            $(this).remove(); // if so, remove the element from the "Draggable Events" list
//                        }
//
//                        var start = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
//                        var end = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
//                        var color = $(this).data(\'color\');
//
//                        $.ajax({
//                            url: \'/appointment/add/\',
//                            data: \'title=\' + $(this).html() + \'&start=\' + start + \'&end=\' + end + \'&color=\' + color,
//                            type: "POST",
//                            success: function(response) {
//
//                                tasks = JSON.parse(response);
//
//                                if (tasks && tasks.length > 0) {
//
//                                    // Capture the appointment ID
//                                    $(\'#field_appointment_id\').val(tasks[0][\'appointment_id\']);
//
//                                    // Build the task list
//                                    var select="<option value=\'\'>Select Task:</option>";
//                                    for (var i = 0; i < tasks.length; i++){
//                                        select=select+"<option value=\'"+tasks[i][\'id\']+"\'>"+tasks[i][\'task\']+"</option>";
//                                    }
//                                    // Populate the dropdown list with the available tasks
//                                    $(\'#field_task_id\').html(select);
//                                    // Show the modal popup
//                                    $(\'#modal_appointment_info\').modal();
//
//                                } else {
//                                    alert(\'Unable to create an event for the project: No tasks available.\');
//                                }
//
//                                // Refresh the calendar events
//                                $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//
//                            }
//                        });
//
//                    },
//                    selectable: true,
//                    selectHelper: true,
////                    select: function(start, end, allDay) {
////                        var title = prompt(\'Event Title:\');
////                        if (title) {
////                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
////                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
////                            $.ajax({
////                                url: \'/appointment/add/\',
////                                data: \'title=\' + title + \'&start=\' + start + \'&end=\' + end,
////                                type: "POST",
////                                success: function(json) {
////                                    alert(\'Added Successfully\');
////                                }
////                            });
////
////                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
////                            // $(\'.fullcalendar-external\').fullCalendar(\'renderEvent\',
////                            //     {
////                            //         title: title,
////                            //         start: start,
////                            //         end: end,
////                            //         allDay: allDay
////                            //     },
////                            //     true
////                            // );
////                        }
////                        // $(\'.fullcalendar-external\').fullCalendar(\'unselect\');
////                    },
//                    editable: true,
//                    eventDrop: function(event, delta) {
//                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//                        $.ajax({
//                            url: \'/appointment/add/\'+event.id+\'/\',
//                            data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
//                            type: "POST",
//                            success: function(json) {
//                                alert("Updated Successfully");
//                                $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                            }
//                        });
//                    },
//                    eventClick: function(event) {
//                        var firstpart = $(this).html().split(\'ProjRef:\');
//                        var project_id = firstpart[1].split(\' - \')[0];
//                        var task_id = 0;
//                        if (firstpart[1].indexOf(\'(\') > -1){
//                            var secondpart = firstpart[1].split(\'(\');
//                            task_id = secondpart[1].split(\')\')[0];
//                        }
//
//                        //alert(task_id[0]);
//                        $.ajax({
//                            url: \'/appointment/event_view/\'+project_id+\'/\'+task_id,
//                            // data: \'title=\' + $(this).html() + \'&start=\' + start + \'&end=\' + end + \'&color=\' + color,
//                            type: "POST",
//                            success: function(response) {
//                                var info = JSON.parse(response);
//                                var project_info=\'\';
//                                // console.log(info[\'thistask\']);
//
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Project Name</span><br>\'+info[\'thisproject\'][\'project_name\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Project Description</span><br>\'+info[\'thisproject\'][\'description\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Customer</span><br>\'+info[\'thisproject\'][\'customer_name\']+\' \'+info[\'thisproject\'][\'customer_surname\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Contact</span><br>\'+info[\'thisproject\'][\'contact_number\']+\'<br>\';
//                                project_info=project_info+\'<span class="label bg-teal help-inline">Status</span><br>\'+info[\'thisproject\'][\'status\']+\'<br>\';
//
//                                if (info[\'thistask\'][\'task\']){
//                                    project_info=project_info+\'<span class="label bg-teal help-inline">Task</span><br>\'+info[\'thistask\'][\'task\']+\'<br>\';
//                                }
//                                $(\'#project_information\').html(project_info);
//                                $(\'#modal_project_info\').modal();
//                            }
//                        });
//                        // var decision = confirm("Do you really want to remove this appointment?");
//                        // if (decision) {
//                        //     $.ajax({
//                        //         type: "POST",
//                        //         url: "/appointment/delete/"+event.id+"/",
//                        //         data: "&id=" + event.id,
//                        //         success: function(json) {
//                        //             $(\'.fullcalendar-external\').fullCalendar(\'removeEvents\', event.id);
//                        //             // alert("Removed Successfully");
//                        //             $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                        //         }
//                        //     });
//                        // }
//                    },
//                    eventResize: function(event, delta, revertFunc) {
//                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//                        $.ajax({
//                            url: \'/appointment/add/\'+event.id+\'/\',
//                            data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
//                            type: "POST",
//                            success: function(data) {
//                                alert("Updated Successfully");
//                                $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                            }
//                        });
//                    }
//                });

                UpdateCalView(project_id, task)

            });

        });

        function UpdateCalView(project_id, task = null) {

            //alert(project_id);
            //alert(task);

            $(\'.fullcalendar-external\').fullCalendar(\'destroy\');
            $(\'.fullcalendar-external\').fullCalendar({
                header: {
                    left: \'title\',
                    center: \'\',
                    right: \'prev,next today\' //\'month,agendaWeek,agendaDay\'
                },
                editable: true,
                navLinks: false, // can click day/week names to navigate views
                defaultDate: new Date(),
                defaultView: \'month\',
                firstDay: 1,
                selectable: true,
                selectHelper: true,
                droppable: true, // this allows things to be dropped onto the calendar
                locale: \'en\',
                businessHours: true,
                //displayEventTime: false,
                // ADP 2019/06/19
//                eventRender: function(info) {
//                    var tooltip = new Tooltip(info.el, {
//                        title: info.event.extendedProps.title,
//                        placement: \'top\',
//                        trigger: \'hover\',
//                        container: \'body\'
//                    });
//                },
                events: {
                    url: \'/appointment/get_dates/\'+project_id+\'/\'+task,
                    type: \'POST\', // Send post data
                    error: function() {
                        alert(\'There was an error while fetching project events.\');
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
                //    //alert(end + \' / \' + newdate);
                //    //var dd = newdate.getDate();
                //    //var mm = newdate.getMonth() + 1;
                //    //var y = newdate.getFullYear();
                //
                //    //var FormattedDate = y + \'-\' + mm + \'-\' + dd + \' 00:00:00\';
                //    //alert(end + \' / \' + FormattedDate);
                //    eventData.end = newdate; //FormattedDate;
                //
                //    return(eventData);
                //},
                drop: function(date, jsEvent, ui, resourceId) {
                    if ($(\'#drop-remove\').is(\':checked\')) { // is the "remove after drop" checkbox checked?
                        $(this).remove(); // if so, remove the element from the "Draggable Events" list
                    }

                    var start = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(date, "Y-MM-DD HH:mm:ss");
                    var color = $(this).data(\'color\');

                    $.ajax({
                        url: \'/appointment/add/\',
                        data: \'title=\' + $(this).html() + \'&start=\' + start + \'&end=\' + end + \'&color=\' + color,
                        type: "POST",
                        success: function(response) {

                            tasks = JSON.parse(response);

                            if (tasks && tasks.length > 0) {

                                // Capture the appointment ID
                                $(\'#field_appointment_id\').val(tasks[0][\'appointment_id\']);

                                // Build the task list
                                var select="<option value=\'\'>Select Task:</option>";
                                for (var i = 0; i < tasks.length; i++){
                                    select=select+"<option value=\'"+tasks[i][\'id\']+"\'>"+tasks[i][\'task\']+"</option>";
                                }
                                // Populate the dropdown list with the available tasks
                                $(\'#field_task_id\').html(select);
                                // Show the modal popup
                                $(\'#modal_appointment_info\').modal();

                            } else {
                                alert(\'Unable to create an event for the project: No tasks available.\');
                            }

                            // Refresh the calendar events
                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');

                        }
                    });

                },
                //select: function(start, end, allDay) {
                //    var title = prompt(\'Event Title:\');
                //    if (title) {
                //        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                //        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                //        $.ajax({
                //            url: \'/appointment/add/\',
                //            data: \'title=\' + title + \'&start=\' + start + \'&end=\' + end,
                //            type: "POST",
                //            success: function(json) {
                //                alert(\'Added Successfully\');
                //            }
                //        });
                //
                //        $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                //        // $(\'.fullcalendar-external\').fullCalendar(\'renderEvent\',
                //        //     {
                //        //         title: title,
                //        //         start: start,
                //        //         end: end,
                //        //         allDay: allDay
                //        //     },
                //        //     true
                //        // );
                //    }
                //    // $(\'.fullcalendar-external\').fullCalendar(\'unselect\');
                //},
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: \'/appointment/add/\'+event.id+\'/\',
                        data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
                        type: "POST",
                        success: function(json) {
                            alert("Updated Successfully");
                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                        }
                    });
                },
                eventClick: function(event) {
                    var firstpart = $(this).html().split(\'ProjRef:\');
                    var project_id = firstpart[1].split(\' - \')[0];
                    var task_id = 0;
                    if (firstpart[1].indexOf(\'(\') > -1){
                        var secondpart = firstpart[1].split(\'(\');
                        task_id = secondpart[1].split(\')\')[0];
                    }

//                    alert(project_id);
//                    alert(task_id);

                    $.ajax({
                        //url: \'/appointment/event_view/\'+project_id[0]+\'/\'+task_id[0],
                        url: \'/appointment/event_view/\'+project_id+\'/\'+task_id,
                        // data: \'title=\' + $(this).html() + \'&start=\' + start + \'&end=\' + end + \'&color=\' + color,
                        type: "POST",
                        success: function(response) {
                            var info = JSON.parse(response);
                            var project_info=\'\';
                            var project_plan=\'\';
                            // console.log(info[\'thistask\']);

                            project_info=project_info+\'<span class="label bg-teal help-inline">Project Name</span><br>\'+info[\'thisproject\'][\'project_name\']+\'<br>\';
                            project_info=project_info+\'<span class="label bg-teal help-inline">Project Description</span><br>\'+info[\'thisproject\'][\'description\']+\'<br>\';
                            project_info=project_info+\'<span class="label bg-teal help-inline">Customer</span><br>\'+info[\'thisproject\'][\'customer_name\']+\' \'+info[\'thisproject\'][\'customer_surname\']+\'<br>\';
                            project_info=project_info+\'<span class="label bg-teal help-inline">Contact Details</span><br>\'+info[\'thisproject\'][\'contact_number\']+\'<br>\'+info[\'thisproject\'][\'email\']+\'<br>\';
                            project_info=project_info+\'<span class="label bg-teal help-inline">Project Status</span><br>\'+info[\'thisproject\'][\'status\']+\'<br>\';

                            // Show the project plans
                            if (info[\'thisproject\'][\'plan\']) {
                                project_plan = project_plan + \'<span class="label bg-teal help-inline">Plans</span><br><a href="/documents/plans/\' + info[\'thisproject\'][\'plan\'] + \'" target="_blank">\' + info[\'thisproject\'][\'plan\'] + \'</a><br>\';
                            } else {
                                project_plan = project_plan + \'<span class="label bg-teal help-inline">Plans</span><br>No plan linked to this project<br>\';
                            }

                            // Show the appointment task
                            if (info[\'thistask\'][\'task\']) {
                                project_info=project_info+\'<span class="label bg-teal help-inline">Task</span><br>\'+info[\'thistask\'][\'task\']+\'<br>\';
                                if (info[\'thistask\'][\'completed\'] == 1) {
                                    project_info=project_info+\'<span class="label bg-teal help-inline">Completed</span><br>Yes<br>\';
                                } else {
                                    project_info=project_info+\'<span class="label bg-teal help-inline">Completed</span><br>No<br>\';
                                }
                            }

                            // Show the appointment id
                            if (info[\'thisappointment\']) {

                                $(\'#appointment_id\').val(info[\'thisappointment\'][\'appointment_id\']); //document.getElementById(\'hidden1\').value=info[\'thisappointment\'][\'appointment_id\'];
                                $(\'#task_id\').val(info[\'thistask\'][\'id\']);
                                $(\'#field_comments\').val(info[\'thisappointment\'][\'comments\']);

                            }

                            $(\'#project_information\').html(project_info);
                            $(\'#project_plan\').html(project_plan);
                            $(\'#modal_project_info\').modal();
                        }
                    });
                    // var decision = confirm("Do you really want to remove this appointment?");
                    // if (decision) {
                    //     $.ajax({
                    //         type: "POST",
                    //         url: "/appointment/delete/"+event.id+"/",
                    //         data: "&id=" + event.id,
                    //         success: function(json) {
                    //             $(\'.fullcalendar-external\').fullCalendar(\'removeEvents\', event.id);
                    //             // alert("Removed Successfully");
                    //             $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                    //         }
                    //     });
                    // }
                },
                eventResize: function(event, delta, revertFunc) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: \'/appointment/add/\'+event.id+\'/\',
                        data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
                        type: "POST",
                        success: function(data) {
                            alert(\'Appointment successfully updated\');
                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                        }
                    });
                }
            });

        }

        function CompleteTask() {

            var id = document.getElementById("task_id").value;
            //alert(\'Task ID: \'+id);

            var result = confirm("Are you sure you want to Complete the task?");
            if (result) {

                $.ajax({
                    url: \'/task/complete/\'+id,
                    type: "POST",
                    success: function(response) {
                        $(\'#modal_project_info\').modal(\'hide\');
                        alert(\'Task successfully completed\');
                        $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                    }
                });

            }

        }

        function DeleteAppointment() {

            var id = document.getElementById("appointment_id").value;
            //alert(\'Appointment ID: \'+id);

            var result = confirm("Are you sure you want to Remove the appointment?");
            if (result) {

                $.ajax({
                    url: \'/appointment/delete/\'+id,
                    type: "POST",
                    success: function(response) {
                        $(\'#modal_project_info\').modal(\'hide\');
                        alert(\'Appointment successfully removed\');
                        $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                    }
                });

            }

        }

        function UpdateAppointment() {

            var id = document.getElementById("appointment_id").value;
            var comments = document.getElementById("field_comments").value;

            //alert(comments);
            //alert(\'Appointment ID: \' + id);

            $.ajax({
                url: \'/appointment/update_comments/\'+id+\'/\'+comments,
                type: "POST",
                success: function (response) {
                    $(\'#modal_project_info\').modal(\'hide\');
                    alert(\'Appointment successfully updated\');
                    $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                }
            });

        }

    </script>
    '; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Appointments</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <?php if ($this->_tpl_vars['user']->can_access('quote','index')): ?>
                        <a href="/quote" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Quotes</span></a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['user']->can_access('invoice','index')): ?>
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['user']->can_access('appointment','team_week_view')): ?>
                        <a href="/appointment/team_week_view" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar text-primary"></i> <span>Team Schedule</span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Appointments</li>
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
                <b><?php echo $this->_tpl_vars['ics_link']; ?>
.ics</b> - This is your unique calendar url for your email client. Import it using your mail client</b>
            </div>
        </div>
        <br /> -->
        <!-- <div id="calendar"></div> -->
        <!-- External events -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                                <div class="heading-elements">
<!--                     <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a href="/appointment/get_dates" data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul> -->
                </div>
                <div>
                    <fieldset>
                    <ol style="list-style: none;">
                        <li>
                            <span class="label bg-teal help-inline">Filter By Project</span>                                               
                            <select name="data[project]" id="field_project" class="form-control">
                                <?php if ($this->_tpl_vars['projects']): ?>
                                    <option value='0'>Select Project:</option>
                                    <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['projects']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['inst']['show'] = true;
$this->_sections['inst']['max'] = $this->_sections['inst']['loop'];
$this->_sections['inst']['step'] = 1;
$this->_sections['inst']['start'] = $this->_sections['inst']['step'] > 0 ? 0 : $this->_sections['inst']['loop']-1;
if ($this->_sections['inst']['show']) {
    $this->_sections['inst']['total'] = $this->_sections['inst']['loop'];
    if ($this->_sections['inst']['total'] == 0)
        $this->_sections['inst']['show'] = false;
} else
    $this->_sections['inst']['total'] = 0;
if ($this->_sections['inst']['show']):

            for ($this->_sections['inst']['index'] = $this->_sections['inst']['start'], $this->_sections['inst']['iteration'] = 1;
                 $this->_sections['inst']['iteration'] <= $this->_sections['inst']['total'];
                 $this->_sections['inst']['index'] += $this->_sections['inst']['step'], $this->_sections['inst']['iteration']++):
$this->_sections['inst']['rownum'] = $this->_sections['inst']['iteration'];
$this->_sections['inst']['index_prev'] = $this->_sections['inst']['index'] - $this->_sections['inst']['step'];
$this->_sections['inst']['index_next'] = $this->_sections['inst']['index'] + $this->_sections['inst']['step'];
$this->_sections['inst']['first']      = ($this->_sections['inst']['iteration'] == 1);
$this->_sections['inst']['last']       = ($this->_sections['inst']['iteration'] == $this->_sections['inst']['total']);
?>
                                        <option value="<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
" <?php if ($this->_tpl_vars['data']['id'] == $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_name']; ?>
 <?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_surname']; ?>
 - <b><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_name']; ?>
: <?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['description']; ?>
</b></option>
                                    <?php endfor; endif; ?>
                                <?php else: ?>
                                    <option value='0'>No projects found!</option>
                                <?php endif; ?>
                            </select>
                            <span class="clearFix">&nbsp;</span> <?php echo smarty_function_error(array('field' => 'team'), $this);?>

                        </li>
                    </ol>
                    </fieldset>
                </div>
                <div id="divTask" style="display: none;">
                    <fieldset>
                        <ol style="list-style: none;">
                            <li>
                                <span class="label bg-teal help-inline">Filter By Project Task</span>
                                <select name="data[task]" id="field_task" class="form-control"></select>
                                <span class="clearFix">&nbsp;</span> <?php echo smarty_function_error(array('field' => 'team'), $this);?>

                            </li>
                        </ol>
                    </fieldset>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="content-group" id="external-events">
                            <h6 style="height: 38px; text-align: center; cursor: pointer;" onclick="UpdateCalView(0)">Project List</h6>
                            <div class="fc-events-container content-group" style="height: 860px; overflow-y: auto; float:left;">
                                                                                                                                <div class="fc-event" data-color="#323B44" onclick="UpdateCalView(0)" style="cursor: pointer; text-align: center; float:top;">All</div>
                                <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['projects_desc']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['inst']['show'] = true;
$this->_sections['inst']['max'] = $this->_sections['inst']['loop'];
$this->_sections['inst']['step'] = 1;
$this->_sections['inst']['start'] = $this->_sections['inst']['step'] > 0 ? 0 : $this->_sections['inst']['loop']-1;
if ($this->_sections['inst']['show']) {
    $this->_sections['inst']['total'] = $this->_sections['inst']['loop'];
    if ($this->_sections['inst']['total'] == 0)
        $this->_sections['inst']['show'] = false;
} else
    $this->_sections['inst']['total'] = 0;
if ($this->_sections['inst']['show']):

            for ($this->_sections['inst']['index'] = $this->_sections['inst']['start'], $this->_sections['inst']['iteration'] = 1;
                 $this->_sections['inst']['iteration'] <= $this->_sections['inst']['total'];
                 $this->_sections['inst']['index'] += $this->_sections['inst']['step'], $this->_sections['inst']['iteration']++):
$this->_sections['inst']['rownum'] = $this->_sections['inst']['iteration'];
$this->_sections['inst']['index_prev'] = $this->_sections['inst']['index'] - $this->_sections['inst']['step'];
$this->_sections['inst']['index_next'] = $this->_sections['inst']['index'] + $this->_sections['inst']['step'];
$this->_sections['inst']['first']      = ($this->_sections['inst']['iteration'] == 1);
$this->_sections['inst']['last']       = ($this->_sections['inst']['iteration'] == $this->_sections['inst']['total']);
?>
                                    <div class="fc-event" data-color="<?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['color']; ?>
" onclick="UpdateCalView(<?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['project_id']; ?>
)" style="cursor: pointer;"><?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['name']; ?>
 <?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['surname']; ?>
 - <?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['project_name']; ?>
: <?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['description']; ?>
 ProjRef:<?php echo $this->_tpl_vars['projects_desc'][$this->_sections['inst']['index']]['project_id']; ?>
</div>
                                <?php endfor; endif; ?>
                            </div>
                            <div class="checkbox checkbox-right checkbox-switchery switchery-xs text-center" style="display: none;">
                                <label>
                                    <input type="checkbox" class="switch" value="" id="drop-remove"> Remove after drop
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="fullcalendar-external"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /External events -->

        <!-- Appointment modal -->
        <div id="modal_appointment_info" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> Appointment</h5>
                    </div>
                    <div class="modal-body">
                                                                                                                                <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                        <p>dont forget to click SAVE :)</p>
                        <hr>
                        <form action="/appointment/task/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_appoinment" enctype="multipart/form-data" class="middle-forms" id="form_appoinment">
                            <fieldset>
                                <ol style="list-style: none;">
                                    <input type="text" name="data[appointment_id]" id="field_appointment_id" style="display: none;">
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Domain Selection</span>  -->
                                        <select name="data[task_id]" id="field_task_id" class="form-control">
                                                                                                                                                                                                                            </select>
                                                                                <?php echo smarty_function_error(array('field' => 'task_id'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Group Selection</span> -->
                                        <select name="data[group_id]" id="field_group_id" class="form-control">
                                            <option value=''>Select Team:</option>
                                            <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['inst']['show'] = true;
$this->_sections['inst']['max'] = $this->_sections['inst']['loop'];
$this->_sections['inst']['step'] = 1;
$this->_sections['inst']['start'] = $this->_sections['inst']['step'] > 0 ? 0 : $this->_sections['inst']['loop']-1;
if ($this->_sections['inst']['show']) {
    $this->_sections['inst']['total'] = $this->_sections['inst']['loop'];
    if ($this->_sections['inst']['total'] == 0)
        $this->_sections['inst']['show'] = false;
} else
    $this->_sections['inst']['total'] = 0;
if ($this->_sections['inst']['show']):

            for ($this->_sections['inst']['index'] = $this->_sections['inst']['start'], $this->_sections['inst']['iteration'] = 1;
                 $this->_sections['inst']['iteration'] <= $this->_sections['inst']['total'];
                 $this->_sections['inst']['index'] += $this->_sections['inst']['step'], $this->_sections['inst']['iteration']++):
$this->_sections['inst']['rownum'] = $this->_sections['inst']['iteration'];
$this->_sections['inst']['index_prev'] = $this->_sections['inst']['index'] - $this->_sections['inst']['step'];
$this->_sections['inst']['index_next'] = $this->_sections['inst']['index'] + $this->_sections['inst']['step'];
$this->_sections['inst']['first']      = ($this->_sections['inst']['iteration'] == 1);
$this->_sections['inst']['last']       = ($this->_sections['inst']['iteration'] == $this->_sections['inst']['total']);
?>
                                                <?php if ($this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id'] != 0): ?>
                                                    <option value="<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['data']['group_id'] == $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</option>
                                                <?php endif; ?>
                                            <?php endfor; endif; ?>
                                        </select>
                                                                                <?php echo smarty_function_error(array('field' => 'group_id'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Notes</span> -->
                                        <textarea name="data[notes]" rows="5" cols="5" class="form-control" placeholder="Enter Notes here"></textarea>
                                                                                <?php echo smarty_function_error(array('field' => 'notes'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                </ol>
                            </fieldset>
                            <div class="modal-footer">
                                <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                                <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project info modal -->
        <div id="modal_project_info" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;Project Information</h5>
                    </div>
                    <div class="modal-body">
                                                                                                                                                        <hr>
                        <input type="hidden" id="task_id"><br>
                        <input type="hidden" id="appointment_id">
                        <div id="project_information"></div>
                        <?php if ($this->_tpl_vars['user']->can_access('quote','index')): ?>
                        <div id="project_plan"></div>
                        <?php endif; ?>
                        <span class="label bg-teal help-inline">Comments</span><br>
                        <input type="text" name="data[comments]" aria-multiline="true" class="form-control" id="field_comments" <?php if ($this->_tpl_vars['user']->can_access('appointment','update_comments')): ?> placeholder="Enter comments here" <?php else: ?>readonly<?php endif; ?> />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                        <?php if ($this->_tpl_vars['user']->can_access('appointment','delete')): ?>
                            <button class="btn btn-primary delete" onclick="DeleteAppointment();"><i class="icon-cross"></i> Delete</button>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['user']->can_access('task','complete')): ?>
                            <button class="btn btn-primary submit" onclick="CompleteTask();"><i class="icon-check"></i> Complete</button>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['user']->can_access('appointment','update_comments')): ?>
                            <button class="btn btn-primary submit" onclick="UpdateAppointment();"><i class="icon-pencil"></i> Update</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Content area -->

</div>
<!-- /Main content -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
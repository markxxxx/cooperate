<?php /* Smarty version 2.6.29, created on 2022-09-29 13:19:02
         compiled from /home/yourtctw/public_html/cooperate/views/coact/appointment_team_week_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/appointment_team_week_view.tpl', 2, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/appointment_team_week_view.tpl', 354, false),)), $this); ?>
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
/assets/js/pages/extra_fullcalendar.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <?php echo '
    <script type="text/javascript">

        $( document ).ready(function() {

            $(\'#field_team\').on("change",function(event) {

                //alert($(\'#field_team\').val());
                UpdateCalView($(\'#field_team\').val())

            });

        });

        function UpdateCalView(team_id) {

            //alert(\'Click: \'+id);

            // Event colors this week
            $(\'.fullcalendar-event-colors-1\').fullCalendar(\'destroy\');
            $(\'.fullcalendar-event-colors-1\').fullCalendar({
                //header: {
                //    left: \'prev,next today\',
                //    center: \'title\'//,
                //    //right: \'month,agendaWeek,agendaDay\'
                //},
                editable: false, //editable: true,
                navLinks: false, // can click day/week names to navigate views
                defaultDate: new Date(),
                defaultView: \'month\',
                firstDay: 1,
                selectable: true,
                selectHelper: true,
                droppable: false, // this allows things to be dropped onto the calendar
                locale: \'en\',
                //businessHours: true,
                businessHours: [ // specify an array instead
                    {
                        dow: [ 1, 2, 3, 4, 5 ], // Monday, Tuesday, Wednesday
                        start: \'08:00\', // 8am
                        end: \'18:00\' // 6pm
                    }//,
                    //{
                    //    dow: [ 5 ], // Thursday, Friday
                    //    start: \'08:00\', // 8am
                    //    end: \'12:00\' // 12pm
                    //}
                ],
                //displayEventTime: false,
                events: {
                    url: \'/appointment/get_dates_team/\'+team_id,
                    type: \'POST\', // Send post data
                    error: function() {
                        alert(\'There was an error while fetching team events.\');
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
//                    var FormattedDate = y + \'-\' + mm + \'-\' + dd + \' 00:00:00\';
//
//                    eventData.end = FormattedDate;
//
//                    return(eventData);
//                },
//                eventDrop: function(event, delta) {
//                    //alert(\'eventDrop\');
//                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
//                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
//                    $.ajax({
//                        url: \'/appointment/add/\'+event.id+\'/\',
//                        data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
//                        type: "POST",
//                        success: function(json) {
//                            alert("Updated Successfully");
//                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
//                        }
//                    });
//                },
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
                            if (info[\'thistask\'][\'task\']){
                                project_info=project_info+\'<span class="label bg-teal help-inline">Task</span><br>\'+info[\'thistask\'][\'task\']+\'<br>\';
                                if (info[\'thistask\'][\'completed\'] == 1) {
                                    project_info=project_info+\'<span class="label bg-teal help-inline">Completed</span><br>Yes<br>\';
                                } else {
                                    project_info=project_info+\'<span class="label bg-teal help-inline">Completed</span><br>No<br>\';
                                }
                            }

                            // Show the appointment id
                            if (info[\'thisappointment\']) {

                                $(\'#appointment_id\').val(info[\'thisappointment\'][\'appointment_id\']);
                                $(\'#task_id\').val(info[\'thistask\'][\'id\']);
                                $(\'#field_comments\').val(info[\'thisappointment\'][\'comments\']);

                            }

                            $(\'#project_information\').html(project_info);
                            $(\'#project_plan\').html(project_plan);
                            $(\'#modal_project_info\').modal();
                        }
                    });

                    //                var decision = confirm("Do you really want to remove this appointment?");
                    //                if (decision) {
                    //                    $.ajax({
                    //                        type: "POST",
                    //                        url: "/appointment/delete/"+event.id+"/",
                    //                        data: "&id=" + event.id,
                    //                        success: function(json) {
                    //                            $(\'.fullcalendar-external\').fullCalendar(\'removeEvents\', event.id);
                    //                            // alert("Removed Successfully");
                    //                            $(\'.fullcalendar-external\').fullCalendar(\'refetchEvents\');
                    //                        }
                    //                    });
                    //                }
                },
                eventResize: function(event, delta, revertFunc) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: \'/appointment/add/\'+event.id+\'/\',
                        data: \'title=\' + event.title + \'&start=\' + start + \'&end=\' + end,
                        type: "POST",
                        success: function(data) {
                            alert("Updated Successfully");
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
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Team Schedule</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <?php if ($this->_tpl_vars['user']->can_access('quote','index')): ?>
                        <a href="/quote" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Quotes</span></a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['user']->can_access('invoice','index')): ?>
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['user']->can_access('appointment','index')): ?>
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar text-primary"></i> <span>Appointments</span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Team Schedule</li>
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
                            <span class="label bg-teal help-inline">Filter By Team</span>                                               
                            <select name="data[team]" id="field_team" class="form-control">
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
                                <option value="<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['data']['id'] == $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
, <?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['account']; ?>
</option>
                                <?php endfor; endif; ?>
                            </select>
                            <span class="clearFix">&nbsp;</span> <?php echo smarty_function_error(array('field' => 'team'), $this);?>

                        </li>
                    </ol>
                    </fieldset>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="content-group" id="external-events">
                            <h6 style="height: 38px; text-align: center; cursor: pointer;" onclick="UpdateCalView(0)">Install Team List</h6>
                            <div class="fc-events-container content-group">
                                <div class="fc-event" data-color="#323B44" onclick="UpdateCalView(0)" style="cursor: pointer; text-align: center;">All</div>
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
                                    <div class="fc-event" data-color="<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['colour']; ?>
" onclick="UpdateCalView(<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
)" style="cursor: pointer;"><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</div>                                 <?php endfor; endif; ?>
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
    <!-- /content area -->

</div>
<!-- /Main content -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
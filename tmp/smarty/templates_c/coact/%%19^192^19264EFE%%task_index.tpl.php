<?php /* Smarty version 2.6.29, created on 2022-12-22 10:07:14
         compiled from /home/yourtctw/public_html/cooperate/views/coact/task_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/task_index.tpl', 2, false),array('modifier', 'ucfirst', '/home/yourtctw/public_html/cooperate/views/coact/task_index.tpl', 113, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/task_index.tpl', 160, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/task_index.tpl', 185, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/picker_date.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/form_select2.js"></script>
    <?php echo '
        <!--  -->
        <style type="text/css">
            .ui-widget-content{ z-index: 9999 !important; top: 0!important}
        </style>
    '; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - -->Task Manager</h4>
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
                <li class="active">Task Manager</li>
            </ul>

            <ul class="breadcrumb-elements">
                <!--  <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">

        <div class="panel panel-flat">
            <div class="panel-heading">
                <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                <ul class="icons-list">
                    <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">
                    <i class="icon-statistics position-left"></i> Add New Task</a> <?php if ($this->_tpl_vars['data']['project_id']): ?><h1>PROJECT: <?php echo $this->_tpl_vars['data']['project_name']; ?>
</h1><?php endif; ?>
                </ul>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <!--<li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>-->
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

						<?php if ($this->_tpl_vars['tasks']): ?>
                            <table class="table datatable-basic-10 table-hover">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Project</th>
                                        <th>Address</th>
                                        <th>Assigned to</th>
                                        <th>Created</th>
                                        <th>Scheduled</th>
                                        <th>Completed</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['tasks']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    <tr style="color:<?php if ($this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_completed'] == 1): ?>green<?php else: ?>black<?php endif; ?>">
                                        <td><?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_description']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['project_name']; ?>
 - <b><?php echo ((is_array($_tmp=$this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['customer_name'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['customer_surname'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</b></td>
                                        <td><?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['customer_address']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['group_name']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_created']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['appointment_start']; ?>
</td>
                                        <td><?php if ($this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_completed'] == 1): ?>Yes<?php else: ?>No<?php endif; ?></td>                                         <td class="text-center">
                                            <?php if ($this->_tpl_vars['user']->can_access('task','complete') || $this->_tpl_vars['user']->can_access('task','edit') || $this->_tpl_vars['user']->can_access('task','delete')): ?>
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($this->_tpl_vars['user']->can_access('task','complete') && $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_completed'] == 0): ?>
                                                            <li><a href="/task/complete/<?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_id']; ?>
"><i class="icon-database-check"></i> Complete</a></li>
                                                        <?php endif; ?>
                                                        <?php if ($this->_tpl_vars['user']->can_access('task','edit') && $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_completed'] == 0): ?>
                                                            <li><a href="/task/add/<?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_id']; ?>
"><i class="icon-database-edit2"></i> Edit</a></li>
                                                        <?php endif; ?>
                                                        <?php if ($this->_tpl_vars['user']->can_access('task','delete')): ?>
                                                            <li><a href="/task/delete/<?php echo $this->_tpl_vars['tasks'][$this->_sections['inst']['index']]['task_id']; ?>
" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endfor; endif; ?>
                                </tbody>
                            </table>
						<?php else: ?>
							No tasks found!
						<?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Iconified modal -->
        <div id="modal_iconified" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> task</h5>
                    </div>
                    <div class="modal-body">
                        <form action="/task/add/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_task" enctype="multipart/form-data" class="middle-forms" id="form_task">
                            <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                                <span class="text-semibold">Yay!</span> more tasks.
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div>

                            <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                            <p>dont forget to click SAVE :)</p>
                            <hr>

                            <fieldset>
                                <ol style="list-style: none;">

                                    <li >
                                        <!-- <span class="label bg-teal help-inline">Project Selection</span>-->
                                        <select name="data[project_id]" id="field_project_id" class="form-control" required="">
                                            <option value=''>Select Project:</option>
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
" <?php if ($this->_tpl_vars['data']['project_id'] == $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']): ?>selected<?php endif; ?>> <?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_name']; ?>
 - <?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_name']; ?>
 <?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_surname']; ?>
 </option>
                                            <?php endfor; endif; ?>
                                        </select>
                                        <span class="clearFix">&nbsp;</span>
                                        <?php echo smarty_function_error(array('field' => 'project_id'), $this);?>

                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Task</span> -->
                                        <input name="data[task]" type="text" class="form-control" id="field_task" value="<?php echo $this->_tpl_vars['data']['task']; ?>
" placeholder="Enter a detailed task description" required/>
                                        <?php echo smarty_function_error(array('field' => 'task'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Start Date</span>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-icon legitRipple" id="ButtonStartDate"><i class="icon-calendar3"></i></button>
                                            </span>
                                            <input class="form-control" id="ButtonStartDateInput" placeholder="Select a start date" readonly="" type="text" name="data[start_date]">
                                        </div>
                                        <?php echo smarty_function_error(array('field' => 'start_date'), $this);?>

                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">End Date</span>
                                        <p><b>For tasks that take longer than 1 day, please select the date after the task will end.</b></p>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default btn-icon legitRipple" id="ButtonEndDate"><i class="icon-calendar3"></i></button>
                                            </span>
                                            <input class="form-control" id="ButtonEndDateInput" placeholder="Select an end date" readonly="" type="text" name="data[end_date]">
                                        </div>
                                        <?php echo smarty_function_error(array('field' => 'end_date'), $this);?>

                                    </li>
                                    <li>&nbsp;</li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Project Selection</span>-->
                                        <select name="data[group_id]" id="field_group_id" class="form-control" required="">
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
" <?php if ($this->_tpl_vars['data']['group_id'] == $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</option>
                                            <?php endfor; endif; ?>
                                        </select>
                                        <span class="clearFix">&nbsp;</span>
                                        <?php echo smarty_function_error(array('field' => 'group_id'), $this);?>

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

    </div>
    <!-- /end content -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
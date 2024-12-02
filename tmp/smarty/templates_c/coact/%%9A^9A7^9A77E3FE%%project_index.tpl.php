<?php /* Smarty version 2.6.29, created on 2022-09-29 13:36:53
         compiled from /home/yourtctw/public_html/cooperate/views/coact/project_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/project_index.tpl', 2, false),array('modifier', 'ucfirst', '/home/yourtctw/public_html/cooperate/views/coact/project_index.tpl', 131, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/project_index.tpl', 189, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/project_index.tpl', 234, false),)), $this); ?>
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
<script type="text/javascript">

    $( document ).ready(function() {

        $(\'#quote_decline\').click(function(e) {
            var txt = $(e.target).attr(\'href\');
            var project_id = txt.split(\'#\');
            var action_url= \'/project/statusDeclined/\'+project_id;
            $(\'#form_project_declined\').get(0).setAttribute(\'action\', action_url); //this works
            $(\'#form_project_declined\').attr(\'action\',action_url );
            console.log(project_id);
        });

    });

</script>
'; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Project Manager</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
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
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Project Manager</li>
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
                    <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified"><i class="icon-statistics position-left"></i> Add New Project</a>
                                                                                                                    </ul>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <!-- <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li> -->
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($this->_tpl_vars['projects']): ?>
                        <table class="table datatable-basic-9 table-hover">
                            <thead>
                                <tr>
                                    <th>Ref</th>
                                    <th>Project Name</th>
                                    <th>Start</th>
                                    <th>Customer</th>
                                    <th>Invoiced</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Sales Rep</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                <tr style="color:<?php if ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Lead'): ?>grey<?php elseif ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Accepted'): ?>black<?php elseif ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Declined'): ?>red<?php elseif ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'New'): ?>#ffc000<?php elseif ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Installed'): ?>#4472c4<?php elseif ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Complete'): ?>#70ad47<?php else: ?> pink<?php endif; ?>">
                                    <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
</td>
                                    <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_name']; ?>
</td>
                                    <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['start_date']; ?>
 order desc</td>
                                    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_name'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_surname'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</td>
                                    <?php if ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['payment_type'] == 'CASH'): ?>
                                        <td>Cash</td>
                                    <?php else: ?>
                                        <?php if ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['acount'] > 0): ?>
                                            <td>Approved</td>
                                        <?php else: ?>
                                            <?php if ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['pcount'] > 0): ?>
                                                <td>Pending</td>
                                            <?php else: ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_contact']; ?>
</td>
                                    <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['customer_address']; ?>
</td>
                                    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['projects'][$this->_sections['inst']['index']]['sales_name'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['projects'][$this->_sections['inst']['index']]['sales_surname'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
</td>
                                    <?php if ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Declined'): ?>
                                        <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status']; ?>
<?php if ($this->_tpl_vars['projects'][$this->_sections['inst']['index']]['declined_reason'] != ""): ?> - <?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['declined_reason']; ?>
<?php endif; ?></td>
                                    <?php else: ?>
                                        <td><?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status']; ?>
</td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <?php if ($this->_tpl_vars['user']->can_access('project','complete') && $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Installed'): ?>
                                                        <li><a href="/project/complete/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-database-edit2"></i> Complete</a></li>
                                                    <?php endif; ?>

                                                    <?php if ($this->_tpl_vars['user']->can_access('project','statusInstalled') && $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'New'): ?>
                                                        <li><a href="/project/statusInstalled/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-database-edit2"></i> Installed</a></li>
                                                    <?php endif; ?>

                                                    <?php if ($this->_tpl_vars['user']->can_access('project','statusNew') && $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['status'] == 'Accepted'): ?>
                                                        <li><a href="/project/statusNew/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-database-edit2"></i> Register New</a></li>
                                                    <?php endif; ?>

                                                    <?php if ($this->_tpl_vars['user']->can_access('snag','index')): ?>
                                                        <li><a href="/snag/index/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-wrench"></i> View Snags</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($this->_tpl_vars['user']->can_access('task','index')): ?>
                                                        <li><a href="/task/index/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-clipboard3"></i> View Tasks</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($this->_tpl_vars['user']->can_access('project','spec_print') && $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['technical_id']): ?>
                                                        <li><a href="/project/spec_print/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['technical_id']; ?>
" target="_blank"><i class="icon-paste"></i> Print Spec Sheet</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($this->_tpl_vars['user']->can_access('quote','index')): ?>
                                                        <li><a href="/quote/index/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-bars-alt"></i> View Quotes</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($this->_tpl_vars['user']->can_access('invoice','index')): ?>
                                                        <li><a href="/invoice/index/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-calculator"></i> View Invoices</a></li>
                                                    <?php endif; ?>

                                                    <?php if ($this->_tpl_vars['user']->can_access('project','edit')): ?>
                                                        <li><a href="/project/spec/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
/<?php echo ((is_array($_tmp=@$this->_tpl_vars['projects'][$this->_sections['inst']['index']]['technical_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
"><i class="icon-cogs"></i> Technical Specifications</a></li>
                                                    <?php endif; ?>
                                                    <?php if ($this->_tpl_vars['user']->can_access('project','edit')): ?>
                                                        <li><a href="/project/add/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
"><i class="icon-database-edit2"></i> Edit</a></li>
                                                    <?php endif; ?>
                                                    <!-- <li><a href="#"><i class="icon-user-check"></i> Login As this user</a></li> -->
                                                    <?php if ($this->_tpl_vars['user']->can_access('project','delete')): ?>
                                                        <li><a href="/project/delete/<?php echo $this->_tpl_vars['projects'][$this->_sections['inst']['index']]['project_id']; ?>
" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php endfor; endif; ?>
                            </tbody>
                        </table>
                        </form>
						<?php else: ?> No projects found! <?php endif; ?>
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
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> project</h5>
                    </div>
                    <div class="modal-body">
                        <form action="/project/add/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_project" enctype="multipart/form-data" class="middle-forms" id="form_project">
                            <!-- <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                                <span class="text-semibold">Yay!</span> more projects.
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div> -->
                            <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                            <!-- <p>dont forget to click SAVE :)</p> -->
                            <hr>
                            <fieldset>
                                <ol style="list-style: none;">
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Project Name</span> -->
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" placeholder="Project Name" required/> <?php echo smarty_function_error(array('field' => 'name'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Project Description</span> -->
                                        <input name="data[description]" type="text" class="form-control" id="field_description" value="<?php echo $this->_tpl_vars['data']['description']; ?>
" placeholder="Description" required/> <?php echo smarty_function_error(array('field' => 'description'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Start Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[start_date]" class="form-control daterange-single" value="<?php echo $this->_tpl_vars['data']['start_date']; ?>
" type="text" id="field_start_date" value="<?php echo $this->_tpl_vars['data']['start_date']; ?>
" placeholder="Start date" required>
                                            </div>
                                        </div>
                                        <?php echo smarty_function_error(array('field' => 'start_date'), $this);?>

                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">End Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[end_date]" class="form-control daterange-single" value="<?php echo $this->_tpl_vars['data']['end_date']; ?>
" type="text" id="field_end_date" value="<?php echo $this->_tpl_vars['data']['end_date']; ?>
" placeholder="End date" required>
                                            </div>
                                        </div>
                                        <?php echo smarty_function_error(array('field' => 'end_date'), $this);?>

                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Customer</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[customer_id]">
                                                <option value=''>Select Customer:</option>
                                                <option value='0' >-CREATE NEW CUSTOMER-</option>
                                                <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['customers']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                                    <option value="<?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['data']['customer_id'] == $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['surname']; ?>
, <?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['name']; ?>
 </option>
                                                <?php endfor; endif; ?>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Sales Rep</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[user_id]">
                                                <option value=''>Select Sales Rep:</option>
                                                <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['sales_reps']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                                    <option value="<?php echo $this->_tpl_vars['sales_reps'][$this->_sections['inst']['index']]['user_id']; ?>
" <?php if ($this->_tpl_vars['data']['user_id'] == $this->_tpl_vars['sales_reps'][$this->_sections['inst']['index']]['user_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['sales_reps'][$this->_sections['inst']['index']]['surname']; ?>
, <?php echo $this->_tpl_vars['sales_reps'][$this->_sections['inst']['index']]['user_name']; ?>
 </option>
                                                <?php endfor; endif; ?>
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Payment type</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[payment_type]">
                                                <option value=''>Select Payment type:</option>
                                                <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['payment_type']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                                    <option value="<?php echo $this->_tpl_vars['payment_type'][$this->_sections['inst']['index']]; ?>
" <?php if ($this->_tpl_vars['data']['payment_type'] == $this->_tpl_vars['payment_type'][$this->_sections['inst']['index']]): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['payment_type'][$this->_sections['inst']['index']]; ?>
 </option>
                                                <?php endfor; endif; ?>
                                            </select>
                                        </div>
                                    </li>
                                </ol>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                            <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- close Iconified modal -->

    </div>
    <!-- /end content -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
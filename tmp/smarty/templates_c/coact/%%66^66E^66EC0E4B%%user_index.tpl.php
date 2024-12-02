<?php /* Smarty version 2.6.29, created on 2022-12-22 10:16:32
         compiled from /home/yourtctw/public_html/cooperate/views/coact/user_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/user_index.tpl', 2, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/user_index.tpl', 172, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/user_index.tpl', 188, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/datatables_basic.js"></script>
<?php echo ' 
'; ?>
 
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> User Manager</h4>
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
                <li class="active">User Manager</li>
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
                            			<i class="icon-statistics position-left"></i> Add New User</a>
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
                        <form action="/user/delete_selected" name="form_user" id="form_user" method="POST">
                            <?php if ($this->_tpl_vars['users']): ?>
                            <table class="table datatable-basic-6 table-hover">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Group</th>
                                        <!-- <th>Domain</th> -->
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['users']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    <tr>
                                        <td><?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['first_name']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['surname']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['email']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['mobile_number']; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['group_name']; ?>
</td>
                                        <!-- <td><?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['domain']; ?>
</td> -->
                                        <!-- <td>
                                            <?php if ($this->_tpl_vars['user']->can_access('user','update_group')): ?>
                                            <select id="group_id_<?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['user_id']; ?>
" data-placeholder="Select" class="form-control" tabindex="-1" aria-hidden="true">
                                                <?php unset($this->_sections['relation']);
$this->_sections['relation']['name'] = 'relation';
$this->_sections['relation']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['relation']['show'] = true;
$this->_sections['relation']['max'] = $this->_sections['relation']['loop'];
$this->_sections['relation']['step'] = 1;
$this->_sections['relation']['start'] = $this->_sections['relation']['step'] > 0 ? 0 : $this->_sections['relation']['loop']-1;
if ($this->_sections['relation']['show']) {
    $this->_sections['relation']['total'] = $this->_sections['relation']['loop'];
    if ($this->_sections['relation']['total'] == 0)
        $this->_sections['relation']['show'] = false;
} else
    $this->_sections['relation']['total'] = 0;
if ($this->_sections['relation']['show']):

            for ($this->_sections['relation']['index'] = $this->_sections['relation']['start'], $this->_sections['relation']['iteration'] = 1;
                 $this->_sections['relation']['iteration'] <= $this->_sections['relation']['total'];
                 $this->_sections['relation']['index'] += $this->_sections['relation']['step'], $this->_sections['relation']['iteration']++):
$this->_sections['relation']['rownum'] = $this->_sections['relation']['iteration'];
$this->_sections['relation']['index_prev'] = $this->_sections['relation']['index'] - $this->_sections['relation']['step'];
$this->_sections['relation']['index_next'] = $this->_sections['relation']['index'] + $this->_sections['relation']['step'];
$this->_sections['relation']['first']      = ($this->_sections['relation']['iteration'] == 1);
$this->_sections['relation']['last']       = ($this->_sections['relation']['iteration'] == $this->_sections['relation']['total']);
?> <?php if ($this->_tpl_vars['groups'][$this->_sections['relation']['index']]['id'] != 0): ?>
                                                <option <?php if ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['group_id'] == $this->_tpl_vars['groups'][$this->_sections['relation']['index']]['id']): ?> selected <?php endif; ?> value='<?php echo $this->_tpl_vars['groups'][$this->_sections['relation']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['groups'][$this->_sections['relation']['index']]['name']; ?>
</option>
                                                <?php endif; ?> <?php endfor; endif; ?>
                                            </select>
                                            <?php else: ?> <?php unset($this->_sections['relation']);
$this->_sections['relation']['name'] = 'relation';
$this->_sections['relation']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['relation']['show'] = true;
$this->_sections['relation']['max'] = $this->_sections['relation']['loop'];
$this->_sections['relation']['step'] = 1;
$this->_sections['relation']['start'] = $this->_sections['relation']['step'] > 0 ? 0 : $this->_sections['relation']['loop']-1;
if ($this->_sections['relation']['show']) {
    $this->_sections['relation']['total'] = $this->_sections['relation']['loop'];
    if ($this->_sections['relation']['total'] == 0)
        $this->_sections['relation']['show'] = false;
} else
    $this->_sections['relation']['total'] = 0;
if ($this->_sections['relation']['show']):

            for ($this->_sections['relation']['index'] = $this->_sections['relation']['start'], $this->_sections['relation']['iteration'] = 1;
                 $this->_sections['relation']['iteration'] <= $this->_sections['relation']['total'];
                 $this->_sections['relation']['index'] += $this->_sections['relation']['step'], $this->_sections['relation']['iteration']++):
$this->_sections['relation']['rownum'] = $this->_sections['relation']['iteration'];
$this->_sections['relation']['index_prev'] = $this->_sections['relation']['index'] - $this->_sections['relation']['step'];
$this->_sections['relation']['index_next'] = $this->_sections['relation']['index'] + $this->_sections['relation']['step'];
$this->_sections['relation']['first']      = ($this->_sections['relation']['iteration'] == 1);
$this->_sections['relation']['last']       = ($this->_sections['relation']['iteration'] == $this->_sections['relation']['total']);
?> <?php if ($this->_tpl_vars['groups'][$this->_sections['relation']['index']]['id'] != 0): ?> <?php if ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['group_id'] == $this->_tpl_vars['groups'][$this->_sections['relation']['index']]['id']): ?> <?php echo $this->_tpl_vars['groups'][$this->_sections['relation']['index']]['name']; ?>
 <?php endif; ?> <?php endif; ?> <?php endfor; endif; ?> <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($this->_tpl_vars['user']->can_access('user','update_domain')): ?>
                                            <select id="domain_id_<?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['user_id']; ?>
" class="form-control" tabindex="-1" aria-hidden="true">
                                                <?php unset($this->_sections['relation']);
$this->_sections['relation']['name'] = 'relation';
$this->_sections['relation']['loop'] = is_array($_loop=$this->_tpl_vars['domains']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['relation']['show'] = true;
$this->_sections['relation']['max'] = $this->_sections['relation']['loop'];
$this->_sections['relation']['step'] = 1;
$this->_sections['relation']['start'] = $this->_sections['relation']['step'] > 0 ? 0 : $this->_sections['relation']['loop']-1;
if ($this->_sections['relation']['show']) {
    $this->_sections['relation']['total'] = $this->_sections['relation']['loop'];
    if ($this->_sections['relation']['total'] == 0)
        $this->_sections['relation']['show'] = false;
} else
    $this->_sections['relation']['total'] = 0;
if ($this->_sections['relation']['show']):

            for ($this->_sections['relation']['index'] = $this->_sections['relation']['start'], $this->_sections['relation']['iteration'] = 1;
                 $this->_sections['relation']['iteration'] <= $this->_sections['relation']['total'];
                 $this->_sections['relation']['index'] += $this->_sections['relation']['step'], $this->_sections['relation']['iteration']++):
$this->_sections['relation']['rownum'] = $this->_sections['relation']['iteration'];
$this->_sections['relation']['index_prev'] = $this->_sections['relation']['index'] - $this->_sections['relation']['step'];
$this->_sections['relation']['index_next'] = $this->_sections['relation']['index'] + $this->_sections['relation']['step'];
$this->_sections['relation']['first']      = ($this->_sections['relation']['iteration'] == 1);
$this->_sections['relation']['last']       = ($this->_sections['relation']['iteration'] == $this->_sections['relation']['total']);
?>
                                                <option <?php if ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['domain_id'] == $this->_tpl_vars['domains'][$this->_sections['relation']['index']]['id']): ?> selected <?php endif; ?> value='<?php echo $this->_tpl_vars['domains'][$this->_sections['relation']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['domains'][$this->_sections['relation']['index']]['domain']; ?>
</option>
                                                <?php endfor; endif; ?>
                                            </select>
                                            <?php else: ?> <?php unset($this->_sections['relation']);
$this->_sections['relation']['name'] = 'relation';
$this->_sections['relation']['loop'] = is_array($_loop=$this->_tpl_vars['domains']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['relation']['show'] = true;
$this->_sections['relation']['max'] = $this->_sections['relation']['loop'];
$this->_sections['relation']['step'] = 1;
$this->_sections['relation']['start'] = $this->_sections['relation']['step'] > 0 ? 0 : $this->_sections['relation']['loop']-1;
if ($this->_sections['relation']['show']) {
    $this->_sections['relation']['total'] = $this->_sections['relation']['loop'];
    if ($this->_sections['relation']['total'] == 0)
        $this->_sections['relation']['show'] = false;
} else
    $this->_sections['relation']['total'] = 0;
if ($this->_sections['relation']['show']):

            for ($this->_sections['relation']['index'] = $this->_sections['relation']['start'], $this->_sections['relation']['iteration'] = 1;
                 $this->_sections['relation']['iteration'] <= $this->_sections['relation']['total'];
                 $this->_sections['relation']['index'] += $this->_sections['relation']['step'], $this->_sections['relation']['iteration']++):
$this->_sections['relation']['rownum'] = $this->_sections['relation']['iteration'];
$this->_sections['relation']['index_prev'] = $this->_sections['relation']['index'] - $this->_sections['relation']['step'];
$this->_sections['relation']['index_next'] = $this->_sections['relation']['index'] + $this->_sections['relation']['step'];
$this->_sections['relation']['first']      = ($this->_sections['relation']['iteration'] == 1);
$this->_sections['relation']['last']       = ($this->_sections['relation']['iteration'] == $this->_sections['relation']['total']);
?> <?php if ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['domain_id'] == $this->_tpl_vars['domains'][$this->_sections['relation']['index']]['id']): ?> <?php echo $this->_tpl_vars['domains'][$this->_sections['relation']['index']]['domain']; ?>
 <?php endif; ?> <?php endfor; endif; ?> <?php endif; ?>
                                        </td> -->

                                        <?php if ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['account_status'] == 'Active'): ?>
                                            <td><span class="label label-success">Active</span></td>
                                        <?php elseif ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['account_status'] == 'Inactive'): ?>
                                            <td><span class="label label-danger">Inactive</span></td>
                                        <?php elseif ($this->_tpl_vars['users'][$this->_sections['inst']['index']]['account_status'] == 'Archived'): ?>
                                            <td><span class="label bg-blue">Archived</span></td>
                                        <?php else: ?>
                                            <td><span class="label bg-grey-400">Unknown</span></td>
                                        <?php endif; ?>

                                        <td class="text-center">
                                            <?php if ($this->_tpl_vars['user']->can_access('user','edit') || $this->_tpl_vars['user']->can_access('user','delete')): ?>
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <!-- <?php if ($this->_tpl_vars['user']->can_access('user','login_as') && ! $this->_tpl_vars['users'][$this->_sections['inst']['index']]['admin']): ?>
                                                        <a href="/user/login_as/<?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['user_id']; ?>
" class="ajax-tip2" title="Login as <?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['name']; ?>
  <?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['surname']; ?>
"><img border=none src="<?php echo $this->_tpl_vars['template_dir']; ?>
/images/login.gif"></a>&nbsp; &nbsp; <?php endif; ?> --> 
                                                        <?php if ($this->_tpl_vars['user']->can_access('user','edit')): ?>
                                                            <li><a href="/user/add/<?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['user_id']; ?>
"><i class="icon-database-edit2"></i> Edit</a></li>
                                                        <?php endif; ?> 
                                                        <?php if ($this->_tpl_vars['user']->can_access('user','delete')): ?>
                                                            <li><a href="/user/delete/<?php echo $this->_tpl_vars['users'][$this->_sections['inst']['index']]['user_id']; ?>
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
                            <?php if ($this->_tpl_vars['user']->can_access('user','delete_selected')): ?>
                            <!-- <input type="submit" class="submit" Value="Delete Seleted"> -->
                            <?php endif; ?>
                        </form>
                                                <?php else: ?>
                            No users found!
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
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                            <span class="text-semibold">Yay!</span> more users.
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                        <p>dont forget to click SAVE :)</p>
                        <hr>
                        <form action="/user/add/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                            <input type="hidden" name="is_admin" value="<?php echo $this->_tpl_vars['is_admin']; ?>
" id="is_admin" />
                            <fieldset>
                                <ol style="list-style: none;">
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Email address</span> -->
                                        <input name="data[email]" type="text" class="form-control" id="field_email" value="<?php echo $this->_tpl_vars['data']['email']; ?>
" placeholder="Email" required/> <?php echo smarty_function_error(array('field' => 'email'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Email address</span> -->
                                        <input name="data[mobile_number]" type="text" class="form-control" id="field_mobile_number" value="<?php echo $this->_tpl_vars['data']['mobile_number']; ?>
" placeholder="Mobile Number" required/> <?php echo smarty_function_error(array('field' => 'mobile_number'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User First Name</span> -->
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" placeholder="Name" required/> <?php echo smarty_function_error(array('field' => 'name'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Last Name</span> -->
                                        <input name="data[surname]" type="text" class="form-control" id="field_surname" value="<?php echo $this->_tpl_vars['data']['surname']; ?>
" placeholder="Surname" required /> <?php echo smarty_function_error(array('field' => 'surname'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Group Selection</span> -->
                                        <select name="data[group_id]" id="field_group_id" class="form-control">
                                            <option value=''>Select group:</option>
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
?> <?php if ($this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id'] != 0): ?>
                                            <option value="<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['data']['group_id'] == $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</option>
                                            <?php endif; ?> <?php endfor; endif; ?>
                                        </select>
                                        </label>
                                        <?php echo smarty_function_error(array('field' => 'group_id'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Domain Selection</span>											 -->
                                        <select name="data[domain_id]" id="field_domain_id" class="form-control">
                                            <option value=''>Select domain:</option>
                                            <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['domains']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                            <option value="<?php echo $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['data']['domain_id'] == $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['domain']; ?>
</option>
                                            <?php endfor; endif; ?>
                                        </select>
                                        <?php echo smarty_function_error(array('field' => 'domain_id'), $this);?>

                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Status Selection</span>                                                 -->
                                        <select name="data[account_status]" id="field_account_status" class="form-control">
                                            <option value=''>Select status:</option>=
                                            <option value="Active" <?php if ($this->_tpl_vars['data']['account_status'] == 'Active'): ?>selected<?php endif; ?>>Active</option>
                                            <option value="Inactive" <?php if ($this->_tpl_vars['data']['account_status'] == 'Inactive'): ?>selected<?php endif; ?>>Inactive</option>
                                            <option value="Archived" <?php if ($this->_tpl_vars['data']['account_status'] == 'Archived'): ?>selected<?php endif; ?>>Archived</option>
                                        </select>
                                        
                                        <span class="clearFix">&nbsp;</span>
                                        <?php echo smarty_function_error(array('field' => 'account_status'), $this);?>

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

    </div>
    <!-- /end content -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
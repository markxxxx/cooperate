<?php /* Smarty version 2.6.29, created on 2022-12-22 10:26:03
         compiled from /home/yourtctw/public_html/cooperate/views/coact/user_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/user_add.tpl', 2, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/user_add.tpl', 34, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/user_add.tpl', 86, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
<?php echo '
	
'; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "filter_options.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - User Manager</h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
    <!--                                 <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a> -->

                    </div>
                </div>
            </div>

            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li><a href="/user">User Manager</a></li>
                    <li class="active"><?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Add<?php else: ?>Edit<?php endif; ?></li>
                </ul>

                <ul class="breadcrumb-elements">
                  <!--   <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> User</h5>
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
                            <form action="/user/add/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                                <input type="hidden" name="is_admin" value="<?php echo $this->_tpl_vars['is_admin']; ?>
" id ="is_admin"/>
                                <fieldset>
                                    <ol style="list-style: none;">
                                        <li>
                                            <span class="label bg-teal help-inline">Email address</span>
                                            <input name="data[email]" type="text" class="form-control" id="field_email" value="<?php echo $this->_tpl_vars['data']['email']; ?>
" placeholder="Email" required/>
                                            <span class="clearFix">&nbsp;</span>
                                            <?php echo smarty_function_error(array('field' => 'email'), $this);?>

                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Mobile Number</span>
                                            <input name="data[mobile_number]" type="text" class="form-control" id="field_mobile_number" value="<?php echo $this->_tpl_vars['data']['mobile_number']; ?>
" placeholder="Mobile Number" required/> <?php echo smarty_function_error(array('field' => 'mobile_number'), $this);?>

                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User First Name</span>
                                            <input name="data[name]" type="text" class="form-control" id="field_name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" placeholder="Name" required/>
                                            <span class="clearFix">&nbsp;</span>
                                            <?php echo smarty_function_error(array('field' => 'name'), $this);?>

                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">User Last Name</span>
                                            <input name="data[surname]" type="text" class="form-control" id="field_surname" value="<?php echo $this->_tpl_vars['data']['surname']; ?>
" placeholder="Surname" required />
                                            <span class="clearFix">&nbsp;</span>
                                            <?php echo smarty_function_error(array('field' => 'surname'), $this);?>

                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User Group Selection</span>
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
?>
                                                    <?php if ($this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id'] != 0): ?>
                                                        <option value="<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['data']['group_id'] == $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</option>
                                                    <?php endif; ?>
                                                <?php endfor; endif; ?>
                                            </select>
                                            </label>
                                            <span class="clearFix">&nbsp;</span>
                                            <?php echo smarty_function_error(array('field' => 'group_id'), $this);?>

                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User Domain Selection</span>
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
                                            <span class="clearFix">&nbsp;</span>
                                            <?php echo smarty_function_error(array('field' => 'domain_id'), $this);?>

                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User Status Selection</span>
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
                                <div class="modal-footer">
                                    <a class="btn btn-link" href="/user/"><i class="icon-cross"></i> Close</a>
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
<?php /* Smarty version 2.6.29, created on 2022-12-22 10:18:10
         compiled from /home/yourtctw/public_html/cooperate/views/coact/group_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/group_add.tpl', 2, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/group_add.tpl', 72, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/group_add.tpl', 94, false),)), $this); ?>
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
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Group Manager</h4>
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
                            <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> Group</h5>
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
									<form action="/group/<?php echo $this->_tpl_vars['method']; ?>
/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_group" enctype="multipart/form-data" class="middle-forms" id="form_group">
										<!-- <h3><?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> Group</h3> -->
										<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
										<fieldset>
											
											<ol style="list-style: none;">
    											<li>
                                                    <span class="label bg-teal help-inline">Name</span>
                                                    <input name="data[name]" type="text" class="form-control" id="field_name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" placeholder="Name" required/> 
                                                    <?php echo smarty_function_error(array('field' => 'name'), $this);?>

                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
                                                <li>
                                                    <span class="label bg-teal help-inline">Account</span>
                                                    <input name="data[account]" type="text" class="form-control" id="field_account" value="<?php echo $this->_tpl_vars['data']['account']; ?>
" placeholder="Account" required/> 
                                                    <?php echo smarty_function_error(array('field' => 'account'), $this);?>

                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
                                                <li>
                                                    <span class="label bg-teal help-inline">Approve Changes?</span>
                                                    <select name="data[approve_changes]" id="field_approve_changes" class="form-control">
                                                        <option value=''>Approve Changes:</option>                                            
                                                        <option value='1' <?php if ($this->_tpl_vars['data']['approve_changes'] == 1): ?>selected<?php endif; ?>>Yes</option>                                            
                                                        <option value='0' <?php if ($this->_tpl_vars['data']['approve_changes'] == 0): ?>selected<?php endif; ?>>No</option>  
                                                    </select>
                                                    </label>
                                                    <?php echo smarty_function_error(array('field' => 'approve_changes'), $this);?>

                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
                                                <li>
                                                    <span class="label bg-teal help-inline">Recieve Notifications?</span>                                          
                                                    <select name="data[message_notifications]" id="field_message_notifications" class="form-control">
                                                        <option value=''>Recieve notifications:</option>                                            
                                                        <option value='1' <?php if ($this->_tpl_vars['data']['message_notification'] == 1): ?>selected<?php endif; ?>>Yes</option>                                            
                                                        <option value='0' <?php if ($this->_tpl_vars['data']['message_notification'] == 0): ?>selected<?php endif; ?>>No</option>  
                                                    </select>
                                                    </label>
                                                    <?php echo smarty_function_error(array('field' => 'message_notifications'), $this);?>

                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
											</ol>
										</ol>
                                </fieldset>
                            </div>
                            

                            <div class="modal-footer">
                              <a class="btn btn-link" href="/"><i class="icon-cross"></i> Close</a>
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
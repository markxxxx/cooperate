<?php /* Smarty version 2.6.29, created on 2022-06-01 09:11:57
         compiled from /home/yourtctw/public_html/cooperate/views/coact/customer_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/customer_index.tpl', 2, false),array('modifier', 'default', '/home/yourtctw/public_html/cooperate/views/coact/customer_index.tpl', 159, false),array('function', 'error', '/home/yourtctw/public_html/cooperate/views/coact/customer_index.tpl', 180, false),)), $this); ?>
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
<!--  -->
'; ?>

	
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Guardian Manager</h4>
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
                            <li class="active">Guardian Manager</li>
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
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                     <div class="panel panel-flat">
                        <div class="panel-heading">
                            <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                            <ul class="icons-list">
                            		<a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">
                            			<i class="icon-statistics position-left"></i> Add New Guardian</a>                            		
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
                           
									<?php if ($this->_tpl_vars['customers']): ?>	
										<table class="table datatable-basic-11 table-hover">
											<thead>
												<tr>
													<th>ID</th>
													<th>Name</th>
													<th>Surname</th>
													<th>Company</th>
													<th>Contact Number</th>
													<th>Email</th>
													<th>Address</th>
													<th class="text-center">Actions</th>
												</tr>
											</thead>
											<tbody>
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
												<tr>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['id']; ?>
</td>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['name']; ?>
</td>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['surname']; ?>
</td>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['company']; ?>
</td>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['contact_number']; ?>
</td>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['email']; ?>
</td>
													<td><?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['address']; ?>
</td>

													<td class="text-center">
														<?php if ($this->_tpl_vars['user']->can_access('customer','edit') || $this->_tpl_vars['user']->can_access('customer','delete')): ?>
														<ul class="icons-list">
															<li class="dropdown">
																<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="icon-menu9"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-right">
																	<?php if ($this->_tpl_vars['user']->can_access('customer','edit')): ?>
																		<li><a href="customer/add/<?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['id']; ?>
"><i class="icon-database-edit2"></i> Edit</a></li>
																	<?php endif; ?>
																	<!-- <li><a href="#"><i class="icon-user-check"></i> Login As this user</a></li> -->
																	<?php if ($this->_tpl_vars['user']->can_access('customer','delete')): ?>
																		<li><a href="customer/delete/<?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['id']; ?>
" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
																	<?php endif; ?>
																	<?php if ($this->_tpl_vars['user']->can_access('customer','dependant')): ?>
																		<li><a href="customer/dependant/<?php echo $this->_tpl_vars['customers'][$this->_sections['inst']['index']]['id']; ?>
"><i class="icon-users4"></i> Dependants</a></li>
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
										
									</form>

									<?php else: ?>
										No customers found!
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
			                  <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;<?php if (((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)) == 0): ?>Create a new<?php else: ?>Update current<?php endif; ?> customer</h5>
			                </div>

			                <div class="modal-body">
			                  <div class="alert alert-info alert-styled-left text-blue-800 content-group">
			                            <span class="text-semibold">Yay!</span> more customers.
			                            <button type="button" class="close" data-dismiss="alert">×</button>
			                        </div>

			                  <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
			                  <p>dont forget to click SAVE :)</p>

			                  <hr>

			                 <form action="/customer/add/<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" method="post" name="form_customer" enctype="multipart/form-data" class="middle-forms" id="form_customer">
								<fieldset>
									<ol style="list-style: none;">
										
										<li>
											<!-- <span class="label bg-teal help-inline">Email address</span> -->
											<input name="data[name]" type="text" class="form-control" id="field_name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" placeholder="Name" required/>
											<?php echo smarty_function_error(array('field' => 'name'), $this);?>

											<span class="clearFix">&nbsp;</span>
										</li>

										<li>
											<!-- <span class="label bg-teal help-inline">customer First Name</span> -->
											<input name="data[surname]" type="text" class="form-control" id="field_surname" value="<?php echo $this->_tpl_vars['data']['surname']; ?>
" placeholder="Surname" required/>
											<?php echo smarty_function_error(array('field' => 'surname'), $this);?>

											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											<input name="data[company]" type="text" class="form-control" id="field_company" value="<?php echo $this->_tpl_vars['data']['company']; ?>
" placeholder="Company" />
											<?php echo smarty_function_error(array('field' => 'company'), $this);?>

											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											<input name="data[contact_number]" type="text" class="form-control" id="field_contact_number" value="<?php echo $this->_tpl_vars['data']['contact_number']; ?>
" placeholder="Contact Number" required />
											<?php echo smarty_function_error(array('field' => 'contact_number'), $this);?>

											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
																						<input name="data[email]" type="text" class="form-control" id="field_email" value="<?php echo $this->_tpl_vars['data']['email']; ?>
" placeholder="Email" />
											<?php echo smarty_function_error(array('field' => 'email'), $this);?>

											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											<input name="data[address]" type="text" class="form-control" id="field_address" value="<?php echo $this->_tpl_vars['data']['address']; ?>
" placeholder="Address" required />
											<?php echo smarty_function_error(array('field' => 'address'), $this);?>

											<span class="clearFix">&nbsp;</span>
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
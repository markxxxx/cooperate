{include file="header.tpl"}
{head}
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
{literal}
<!--  -->
{/literal}
	
{/head}

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
                           
									{if $customers}	
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
											{section name=inst loop=$customers}	
												<tr>
													<td>{$customers[inst].id}</td>
													<td>{$customers[inst].name}</td>
													<td>{$customers[inst].surname}</td>
													<td>{$customers[inst].company}</td>
													<td>{$customers[inst].contact_number}</td>
													<td>{$customers[inst].email}</td>
													<td>{$customers[inst].address}</td>

													<td class="text-center">
														{if $user->can_access('customer', 'edit') || $user->can_access('customer', 'delete')}
														<ul class="icons-list">
															<li class="dropdown">
																<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="icon-menu9"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-right">
																	{if $user->can_access('customer', 'edit')}
																		<li><a href="customer/add/{$customers[inst].id}"><i class="icon-database-edit2"></i> Edit</a></li>
																	{/if}
																	<!-- <li><a href="#"><i class="icon-user-check"></i> Login As this user</a></li> -->
																	{if $user->can_access('customer', 'delete')}
																		<li><a href="customer/delete/{$customers[inst].id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
																	{/if}
																	{if $user->can_access('customer', 'dependant')}
																		<li><a href="customer/dependant/{$customers[inst].id}"><i class="icon-users4"></i> Dependants</a></li>
																	{/if}
																</ul>
															</li>
														</ul>
														{/if}
													</td>
												</tr>
											{/section}	
											</tbody>
										</table>
										
									</form>

									{else}
										No customers found!
									{/if}
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
			                  <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} customer</h5>
			                </div>

			                <div class="modal-body">
			                  <div class="alert alert-info alert-styled-left text-blue-800 content-group">
			                            <span class="text-semibold">Yay!</span> more customers.
			                            <button type="button" class="close" data-dismiss="alert">×</button>
			                        </div>

			                  <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
			                  <p>dont forget to click SAVE :)</p>

			                  <hr>

			                 <form action="/customer/add/{$data.id|default:0}" method="post" name="form_customer" enctype="multipart/form-data" class="middle-forms" id="form_customer">
								<fieldset>
									<ol style="list-style: none;">
										
										<li>
											<!-- <span class="label bg-teal help-inline">Email address</span> -->
											<input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/>
											{error field=name}
											<span class="clearFix">&nbsp;</span>
										</li>

										<li>
											<!-- <span class="label bg-teal help-inline">customer First Name</span> -->
											<input name="data[surname]" type="text" class="form-control" id="field_surname" value="{$data.surname}" placeholder="Surname" required/>
											{error field=surname}
											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											<input name="data[company]" type="text" class="form-control" id="field_company" value="{$data.company}" placeholder="Company" />
											{error field=company}
											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											<input name="data[contact_number]" type="text" class="form-control" id="field_contact_number" value="{$data.contact_number}" placeholder="Contact Number" required />
											{error field=contact_number}
											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											{*ADP 2018/08/22 : Remove required from email field*}
											<input name="data[email]" type="text" class="form-control" id="field_email" value="{$data.email}" placeholder="Email" />
											{error field=email}
											<span class="clearFix">&nbsp;</span>
										</li>
										<li >
											<!-- <span class="label bg-teal help-inline">customer Last Name</span> -->
											<input name="data[address]" type="text" class="form-control" id="field_address" value="{$data.address}" placeholder="Address" required />
											{error field=address}
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
            

{include file="footer.tpl"}
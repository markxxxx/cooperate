{include file="header.tpl"}
{head}
{*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
<script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/daterangepicker.js"></script>
<script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
<script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
<script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
<script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
<script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
<script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
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
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Appointment Manager</h4>
                        </div>

                        <div class="heading-elements">
                            <div class="heading-btn-group">
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
                    </div>

                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                            <li class="active">Appointment Manager</li>
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
                            		<!-- <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">
                            			<i class="icon-statistics position-left"></i> Add New Appointment</a>    -->                         		
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
                           
									{if $appointments}	
									<table class="table datatable-basic dataTable">
										<thead>
											<tr>
												<th>ID</th>
												<th>Description</th>
												<th>Start</th>
												<th >End</th>
												<!-- <th>Completed?</th> -->
												<th>Notes</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
										{section name=inst loop=$appointments}	
											<tr>
												<td>{$appointments[inst].id}</td>
												<td>{$appointments[inst].title}</td>
												<td>{$appointments[inst].start}</td>
												<td>{$appointments[inst].end} </td>
												<!-- <td>{if $appointments[inst].completed eq 1}Yes{else}No{/if}</td> -->
												<td>{$appointments[inst].notes}</td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																<i class="icon-menu9"></i>
															</a>

															<ul class="dropdown-menu dropdown-menu-right">																	
																<li><a href="/appointment/add/{$appointments[inst].id}"><i class="icon-database-edit2"></i> Edit</a></li>
																<!-- <li><a href="#"><i class="icon-user-check"></i> Login As this user</a></li> -->
																{if $user->can_access('task', 'delete')}
																	<li><a href="/appointment/delete/{$appointments[inst].id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
																{/if}
															</ul>
														</li>
													</ul>
												</td>
											</tr>
										{/section}	
										</tbody>
									</table>
									{else}
										No appointments found!
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
			                  <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} appointment</h5>
			                </div>

			                <div class="modal-body">
			                  <div class="alert alert-info alert-styled-left text-blue-800 content-group">
			                            <span class="text-semibold">Yay!</span> more appointments.
			                            <button type="button" class="close" data-dismiss="alert">×</button>
			                        </div>

			                  <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
			                  <p>dont forget to click SAVE :)</p>

			                  <hr>

			                 <form action="/appointment/FormAdd/{$data.id|default:0}" method="post" name="form_appointment" enctype="multipart/form-data" class="middle-forms" id="form_appointment">
								<fieldset>
									<ol style="list-style: none;">										
									<li>
                                        <!-- <span class="label bg-teal help-inline">project First Name</span> -->
                                        <input name="data[title]" type="text" class="form-control" id="field_title" value="{$data.title}" placeholder="Description" required/> {error field=title}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">project Last Name</span> -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[start]" class="form-control daterange-single" value="{$data.start}" type="text" id="field_start" value="{$data.start}" placeholder="Start date" required>
                                            </div>

                                            <div class="input-group">
												<span class="input-group-btn">
													<button type="button" class="btn btn-default btn-icon" id="ButtonCreationDemoButton"><i class="icon-calendar3"></i></button>
												</span>
												<input type="text" class="form-control" id="ButtonCreationDemoInput" placeholder="Select a date">
											</div>
											<span class="help-block">Format must be YYYY-MM-DD HH:MM:SS</span>
                                        </div>
                                        {error field=start}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">project Last Name</span> -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[end]" class="form-control daterange-single" value="{$data.end}" type="text" id="field_end" value="{$data.end}" placeholder="End date" required>
                                            </div>
                                        </div>
                                        {error field=end}
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
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
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Top Type Manager</h4>
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
							<li><a href="/setup">Setup Manager</a></li>
                        </ul>

                        <ul class="breadcrumb-elements">
                         <!--    <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
                            			<i class="icon-statistics position-left"></i> Add New Top Type</a>                            		
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
                           
									{if $toptypes}	
										<table class="table datatable-basic table-hover">
											<thead>
												<tr>
													<th>Id</th>
													<th>Type Name</th>
													<th>Variant Name</th>
													<th style="display: none"></th>
													<th style="display: none"></th>
													<th class="text-center">Actions</th>
												</tr>
											</thead>
											<tbody>
											{section name=inst loop=$toptypes}	
												<tr>
													<td>{$toptypes[inst].id}</td>
													<td>{$toptypes[inst].toptype_name}</td>
													<td>{$toptypes[inst].variant_name}</td>
													<td style="display: none"></td>
													<td style="display: none"></td>
													<td class="text-center">
														{if $user->can_access('toptype', 'delete')}
														<ul class="icons-list">
															<li class="dropdown">
																<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="icon-menu9"></i>
																</a>
																<ul class="dropdown-menu dropdown-menu-right">
																	<!-- <li><a href="toptype/add/{$toptypes[inst].id}"><i class="icon-database-edit2"></i> Edit</a></li> -->
																	<!-- <li><a href="#"><i class="icon-user-check"></i> Login As this user</a></li> -->
																	<li><a href="/setup/toptype_delete/{$toptypes[inst].id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
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
										No toptypes found!
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
			                  <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} toptype</h5>
			                </div>

			                <div class="modal-body">
			                  <div class="alert alert-info alert-styled-left text-blue-800 content-group">
			                            <span class="text-semibold">Yay!</span> more toptypes.
			                            <button type="button" class="close" data-dismiss="alert">×</button>
			                        </div>

			                  <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
			                  <p>dont forget to click SAVE :)</p>

			                  <hr>

			                 <form action="/setup/toptype_add/{$data.id|default:0}" method="post" name="form_toptype" enctype="multipart/form-data" class="middle-forms" id="form_toptype">
								<fieldset>
									<ol style="list-style: none;">
										
										<li>
											<!-- <span class="label bg-teal help-inline">Email address</span> -->
											<input name="data[toptype_name]" type="text" class="form-control" id="field_toptype_name" value="{$data.toptype_name}" placeholder="Main Name" required/>
											{error field=toptype_name}
											<span class="clearFix">&nbsp;</span>
										</li>
										<li>
											<!-- <span class="label bg-teal help-inline">Email address</span> -->
											<input name="data[variant_name]" type="text" class="form-control" id="field_variant_name" value="{$data.variant_name}" placeholder="Variant Name" required/>
											{error field=variant_name}
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
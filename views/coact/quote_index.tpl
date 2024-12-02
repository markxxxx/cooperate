{include file="header.tpl"}
{head}
	<script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="{$template_dir}/assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>
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
				<h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Quote Manager</h4>
			</div>
			<div class="heading-elements">
				<div class="heading-btn-group">
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
				<li class="active">Quote Manager</li>
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
					<i class="icon-statistics position-left"></i> Add New Quote</a>
					{if $data.project_id}<h1>PROJECT: {$data.project_name}</h1>{/if}
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
						{if $quotes}
							<table class="table datatable-basic-7 table-hover">
								<thead>
									<tr>
										<th>Project</th>
										<th>Customer</th>
										<th>Contact Number</th>
										<th>Created</th>
										<th>Status</th>
										<th>Quote</th>
										<th>Plans</th>
										<th class="text-center">Actions</th>
									</tr>
								</thead>
								<tbody>
									{section name=inst loop=$quotes}
										<tr>
											<td>{$quotes[inst].project_name}</td>
											<td>{$quotes[inst].customer_name} {$quotes[inst].customer_surname}</td>
											<td>{$quotes[inst].contact_number}</td>
											<td>{$quotes[inst].created}</td>
											<td>{$quotes[inst].quote_status}</td>
											{if $user->can_access('quote', 'index')}
												<td><a href="/documents/quotes/{$quotes[inst].file}" target="_blank">{$quotes[inst].file}</a></td>
											{else}
												<td>...</td>
											{/if}
											{if $user->can_access('invoice', 'index')}
												<td><a href="/documents/plans/{$quotes[inst].project_plan}" target="_blank">{$quotes[inst].project_plan}</a></td>
											{else}
												<td>...</td>
											{/if}
											<td class="text-center">
												<ul class="icons-list">
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
															<i class="icon-menu9"></i>
														</a>
														<ul class="dropdown-menu dropdown-menu-right">

															{if $user->can_access('quote', 'decline') && $quotes[inst].quote_status neq 'Declined'}
																<li><a href="/quote/decline/{$quotes[inst].quote_id}"><i class="icon-cross2"></i> Decline</a></li>
															{/if}

															{if $user->can_access('quote', 'accept') && $quotes[inst].quote_status neq 'Accepted'}
																<li><a href="/quote/accept/{$quotes[inst].quote_id}"><i class="icon-checkmark"></i> Accept</a></li>
															{/if}

															{if $user->can_access('quote', 'edit') && $quotes[inst].quote_status neq 'Accepted'}
																<li><a href="/quote/add/{$quotes[inst].quote_id}"><i class="icon-pencil7"></i> Edit</a></li>
															{/if}

															{if $user->can_access('quote', 'delete') && $quotes[inst].quote_status neq 'Accepted'}
																<li><a href="/quote/delete/{$quotes[inst].quote_id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
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
							No quotes found!
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
						<h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Quote</h5>
					</div>
					<div class="modal-body">
						<form action="/quote/add/{$data.id|default:0}" method="post" name="form_quote" enctype="multipart/form-data" class="middle-forms" id="form_quote">
							<div class="alert alert-info alert-styled-left text-blue-800 content-group">
								<span class="text-semibold">Yay!</span> more quotes.
								<button type="button" class="close" data-dismiss="alert">×</button>
							</div>
							<h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
							<p>dont forget to click SAVE :)</p>
							<hr>
							<fieldset>
								<ol style="list-style: none;">
									<li>
										<!-- <span class="label bg-teal help-inline">User Domain Selection</span>												 -->
										<select name="data[project_id]" id="field_project_id" class="form-control">
											<option value=''>Select Project:</option>
											{section name=inst loop=$projects}
												<option value="{$projects[inst].project_id}" {if $data.project_id eq $projects[inst].project_id}selected{/if}>{$projects[inst].project_name}, {$projects[inst].customer_name} {$projects[inst].customer_surname} </option>
											{/section}
										</select>
										{error field=project_id}
										<span class="clearFix">&nbsp;</span>
									</li>
									<li>
										<span class="label bg-teal help-inline">Quote Document</span>
										<input class="file-input" data-browse-class="btn btn-primary btn-block" data-show-remove="false" data-show-caption="false" data-show-upload="false" type="file" name="quote" required>
										{error field=file}
										<span class="clearFix">&nbsp;</span>
									</li>
									<li>
										<span class="label bg-teal help-inline">Plan Document(s)</span>
										<input class="file-input" data-browse-class="btn btn-primary btn-block" data-show-remove="false" data-show-caption="false" data-show-upload="false" type="file" name="project_plan">
										{error field=file}
										<span class="clearFix">&nbsp;</span>
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

		<!-- Iconified modal -->
		<div id="modal_plans" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Quote</h5>
					</div>
					<div class="modal-body">
						<form action="/quote/add/{$data.id|default:0}" method="post" name="form_quote" enctype="multipart/form-data" class="middle-forms" id="form_quote">
							<div class="alert alert-info alert-styled-left text-blue-800 content-group">
								<span class="text-semibold">Yay!</span> more quotes.
								<button type="button" class="close" data-dismiss="alert">×</button>
							</div>
							<h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
							<p>dont forget to click SAVE :)</p>
							<hr>
							<fieldset>
								<ol style="list-style: none;">
									<li>
										<!-- <span class="label bg-teal help-inline">User Domain Selection</span>												 -->
										<select name="data[project_id]" id="field_project_id" class="form-control">
											<option value=''>Select Project:</option>
											{section name=inst loop=$projects}
												<option value="{$projects[inst].project_id}" {if $data.project_id eq $projects[inst].project_id}selected{/if}>{$projects[inst].project_name}, {$projects[inst].customer_name} {$projects[inst].customer_surname} </option>
											{/section}
										</select>
										{error field=project_id}
										<span class="clearFix">&nbsp;</span>
									</li>
									<li>
										<span class="label bg-teal help-inline">Quote Document</span>
										<input class="file-input" data-browse-class="btn btn-primary btn-block" data-show-remove="false" data-show-caption="false" data-show-upload="false" type="file" name="quote" required>
										{error field=file}
										<span class="clearFix">&nbsp;</span>
									</li>
									<li>
										<span class="label bg-teal help-inline">Plan Document(s)</span>
										<input class="file-input" data-browse-class="btn btn-primary btn-block" data-show-remove="false" data-show-caption="false" data-show-upload="false" type="file" name="project_plan" required>
										{error field=file}
										<span class="clearFix">&nbsp;</span>
									</li>
								</ol>
							</fieldset>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
						<button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- /end content -->

{include file="footer.tpl"}
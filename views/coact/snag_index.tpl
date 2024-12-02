{include file="header.tpl"}
{head}
    {*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_api.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>
    {literal}
        <!--  -->
        <style type="text/css">
            .ui-widget-content{ z-index: 9999 !important; top: 0!important}
        </style>

        <!--{*<script type="text/javascript">*}

            {*$( document ).ready(function() {*}

                {*// Only display the appointments for the selected project filter*}
                {*$('#field_project').on("change",function(event) {*}

                    {*var project_id = $('#field_project').val();*}
                    {*alert('change - ProjectID: '+project_id);*}

                    {*UpdateSnagView (project_id);*}

                {*});*}

            {*});*}

            {*function UpdateSnagView(project_id) {*}

                {*$.ajax({*}
                    {*url: '/snag/'+project_id,*}
                    {*type: 'POST',*}
                    {*dataType: 'json',*}
                    {*success: function(response) {*}
                        {*//$("#div1").html(result);*}
                    {*}*}
                {*});*}

            {*}*}

        {*</script>*}-->
    {/literal}
{/head}

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - -->Snag Manager</h4>
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
                <li class="active">Snag Manager</li>
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
                <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                <ul class="icons-list">
                    <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">
                    <i class="icon-statistics position-left"></i> Add New Snag</a> {if $data.project_id}<h1>PROJECT: {$data.project_name}</h1>{/if}
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
                    {*table-responsive*}
                    <div class="col-lg-12">
                        {if $snags}
                            <table class="table datatable-basic-10 table-hover">
                                <thead>
                                    <tr>
                                        <th>Snag</th>
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
                                {section name=inst loop=$snags}
                                    <tr style="color:{if $snags[inst].snag_completed eq 1}green{else}black{/if}">
                                        <td>{$snags[inst].snag_description}</td>
                                        <td>{$snags[inst].project_name} - <b>{$snags[inst].customer_name|ucfirst} {$snags[inst].customer_surname|ucfirst}</b></td>
                                        <td>{$snags[inst].customer_address}</td>
                                        <td>{$snags[inst].group_name}</td>
                                        <td>{$snags[inst].snag_created}</td>
                                        <td>{$snags[inst].appointment_start}</td>
                                        <td>{if $snags[inst].snag_completed eq 1}Yes{else}No{/if}</td> {*{if {$snags[inst].snag_age} neq ""}({$snags[inst].snag_age}){else}{/if}*}
                                        <td class="text-center">
                                            {if $user->can_access('snag', 'complete') || $user->can_access('snag', 'edit') || $user->can_access('snag', 'delete')}
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        {if $user->can_access('snag', 'complete') && $snags[inst].snag_completed eq 0}
                                                            <li><a href="/snag/complete/{$snags[inst].snag_id}"><i class="icon-database-check"></i> Complete</a></li>
                                                        {/if}
                                                        {if $user->can_access('snag', 'edit') && $snags[inst].snag_completed eq 0}
                                                            <li><a href="/snag/add/{$snags[inst].snag_id}"><i class="icon-database-edit2"></i> Edit</a></li>
                                                        {/if}
                                                        {if $user->can_access('snag', 'delete')}
                                                            <li><a href="/snag/delete/{$snags[inst].snag_id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
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
                        {else}
                            No snags found!
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
                  <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} snag</h5>
                </div>

                <div class="modal-body">
                  <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                            <span class="text-semibold">Yay!</span> more snags.
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>

                  <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                  <p>dont forget to click SAVE :)</p>

                  <hr>

                 <form action="/snag/add/{$data.id|default:0}" method="post" name="form_snag" enctype="multipart/form-data" class="middle-forms" id="form_snag">
					<fieldset>
						<ol style="list-style: none;">

                            <li >
                                <!-- <span class="label bg-teal help-inline">Project Selection</span>-->
                                <select name="data[project_id]" id="field_project_id" class="form-control" required="">
                                    <option value=''>Select Project:</option>
                                    {section name=inst loop=$projects}
                                        <option value="{$projects[inst].project_id}" {if $data.project_id eq $projects[inst].project_id}selected{/if}> {$projects[inst].project_name} - {$projects[inst].customer_name} {$projects[inst].customer_surname} </option>
                                    {/section}
                                </select>                                           
                                <span class="clearFix">&nbsp;</span>
                                {error field=project_id}
                            </li>
							
							<li>
								<!-- <span class="label bg-teal help-inline">Snag</span> -->
								<input name="data[snag]" type="text" class="form-control" id="field_snag" value="{$data.snag}" placeholder="Enter a detailed snag description" required/>
								{error field=snag}
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
                                {error field=start_date}
                            </li>
                            <li>
                                <span class="label bg-teal help-inline">End Date</span>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-icon legitRipple" id="ButtonEndDate"><i class="icon-calendar3"></i></button>
                                    </span>
                                    <input class="form-control" id="ButtonEndDateInput" placeholder="Select an end date" readonly="" type="text" name="data[end_date]">
                                </div>
                                {error field=end_date}
                            </li>
                            <li>&nbsp;</li>

							<li >
								<!-- <span class="label bg-teal help-inline">Project Selection</span>-->
								<select name="data[group_id]" id="field_group_id" class="form-control" required="">
                                    <option value=''>Select Team:</option>
                                    {section name=inst loop=$groups}
                                        <option value="{$groups[inst].id}" {if $data.group_id eq $groups[inst].id}selected{/if}>{$groups[inst].name}</option>
                                    {/section}
                                </select>                                           
                                <span class="clearFix">&nbsp;</span>
                                {error field=group_id}
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
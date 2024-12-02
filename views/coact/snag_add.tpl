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
    <!-- <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script> -->
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>
{literal}
	<style type="text/css">
    .ui-widget-content{ z-index: 9999 !important; top: 0!important}
</style>
{/literal}
	

{/head}



{include file="filter_options.tpl"}

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Snag Manager</h4>
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
                            <li><a href="/snag">Snag Manager</a></li>
                            <li class="active">{if $data.id|default:0 eq 0}Add{else}Edit{/if}</li>
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
                            <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Snag</h5>
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
                                	<form action="/snag/add/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
								<input type="hidden" name="is_admin" value="{$is_admin}" id ="is_admin"/>
								<fieldset>
									 <ol style="list-style: none;">                                        
                                         <li >
                                             <span class="label bg-teal help-inline">Project Selection</span>
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
                                            <span class="label bg-teal help-inline">Snag</span>
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
                                                <input class="form-control" id="ButtonStartDateInput" placeholder="Select a start date" readonly="" type="text" name="data[start_date]" value="{$data.start_date}">
                                            </div>
                                            {error field=start_date}
                                           
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">End Date</span>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-icon legitRipple" id="ButtonEndDate"><i class="icon-calendar3"></i></button>
                                                </span>
                                                <input class="form-control" id="ButtonEndDateInput" placeholder="Select an end date" readonly="" type="text" name="data[end_date]" value="{$data.end_date}" >
                                            </div>
                                            {error field=end_date}
                                            
                                        </li>
                                        <li>&nbsp;</li>

                                        <li >
                                             <span class="label bg-teal help-inline">Team Selection</span>
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
                                <a class="btn btn-link" href="/snag"><i class="icon-cross"></i> Close</a>
			                    <!-- <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button> -->
			                    <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
			                </div>
			                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /end content -->

       

{include file="footer.tpl"}
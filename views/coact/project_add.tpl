{include file="header.tpl"}
{head}
    {*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>

{/head}



{include file="filter_options.tpl"}

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Project Manager</h4>
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
                            <li><a href="/project">Project Manager</a></li>
                            <li class="active">{if $data.id|default:0 eq 0}Add{else}Edit{/if}</li>
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
                            <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Project</h5>
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
                                	<form action="/project/add/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
								<input type="hidden" name="is_admin" value="{$is_admin}" id ="is_admin"/>
								<fieldset>
									<ol style="list-style: none;">
                                    <li>
                                        <span class="label bg-teal help-inline">Project Name</span>
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/> {error field=name}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Description</span>
                                        <input name="data[description]" type="text" class="form-control" id="field_description" value="{$data.description}" placeholder="Description" required/> {error field=description}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select HOD</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[customer_id]">
                                                <option value=''>Select HOD:</option>
                                                {* <option value='0' >-CREATE NEW CUSTOMER-</option> *}
                                                {section name=inst loop=$teachers}
                                                    <option value="{$teachers[inst].id}" {if $data.teacher_id eq $teachers[inst].id}selected{/if}>{$teachers[inst].user_surname}, {$teachers[inst].user_name} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li>
                                   {*  <li>
                                        <span class="label bg-teal help-inline">Start Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[start_date]" class="form-control daterange-single" value="{$data.start_date}" type="text" id="field_start_date" value="{$data.start_date}" placeholder="Start date" required>
                                            </div>
                                        </div>
                                        {error field=start_date}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">End Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[end_date]" class="form-control daterange-single" value="{$data.end_date}" type="text" id="field_end_date" value="{$data.end_date}" placeholder="End date" required>
                                            </div>
                                        </div>
                                        {error field=end_date}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Customer</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[customer_id]">
                                                <option value=''>Select Customer:</option>
                                                <option value='0' >-CREATE NEW CUSTOMER-</option>
                                                {section name=inst loop=$customers}
                                                    <option value="{$customers[inst].id}" {if $data.customer_id eq $customers[inst].id}selected{/if}>{$customers[inst].surname}, {$customers[inst].name} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Sales Rep</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[user_id]">
                                                <option value=''>Select Sales Rep:</option>
                                                {section name=inst loop=$sales_reps}
                                                    <option value="{$sales_reps[inst].user_id}" {if $data.user_id eq $sales_reps[inst].user_id}selected{/if}>{$sales_reps[inst].surname}, {$sales_reps[inst].user_name} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Payment type</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[payment_type]">
                                                <option value=''>Select Payment type:</option>
                                                {section name=inst loop=$payment_type}
                                                    <option value="{$payment_type[inst]}" {if $data.payment_type eq $payment_type[inst]}selected{/if}>{$payment_type[inst]} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li> *}
                                    </ol>
								</fieldset>
							</div>
							

			                <div class="modal-footer">
			                  <a class="btn btn-link" href="/project"><i class="icon-cross"></i> Close</a>
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
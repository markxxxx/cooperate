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
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>

{literal} 
<script type="text/javascript">

    $( document ).ready(function() {

        $('#quote_decline').click(function(e) {
            var txt = $(e.target).attr('href');
            var project_id = txt.split('#');
            var action_url= '/project/statusDeclined/'+project_id;
            $('#form_project_declined').get(0).setAttribute('action', action_url); //this works
            $('#form_project_declined').attr('action',action_url );
            console.log(project_id);
        });

    });

</script>
{/literal}
{/head}

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Subject Manager</h4>
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
                <li class="active">Subject Manager</li>
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
                <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                <ul class="icons-list">
                    <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified"><i class="icon-statistics position-left"></i> Add New Subject</a>
                    {*<li><img src="assets/images/project_lead.jpg"><a>Lead</a></li>*}
                    {*<li><img src="assets/images/project_new.jpg"><a>New</a></li>*}
                    {*<li><img src="assets/images/project_installed.jpg"><a>Installed</a></li>*}
                    {*<li><img src="assets/images/project_complete.jpg"><a>Complete</a></li>*}
                    {*<li><img src="assets/images/project_declined.jpg"><a>Declined</a></li>*}
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
                        {if $projects}
                        <table class="table datatable-basic-9 table-hover">
                            <thead>
                                <tr>
                                    <th>Ref</th>
                                    <th>Subject Name</th>
                                    <th>Description</th>
                                    <th>HOD</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {section name=inst loop=$projects}
                                <tr style="color:{if $projects[inst].status eq 'Lead'}grey{elseif $projects[inst].status eq 'Accepted'}black{elseif $projects[inst].status eq 'Declined'}red{elseif $projects[inst].status eq 'New'}#ffc000{elseif $projects[inst].status eq 'Installed'}#4472c4{elseif $projects[inst].status eq 'Complete'}#70ad47{else} pink{/if}">
                                    <td>{$projects[inst].project_id}</td>
                                    <td>{$projects[inst].project_name}</td>
                                    <td>{$projects[inst].project_description}</td>
                                    <td>{$projects[inst].teacher_name|ucfirst} {$projects[inst].teacher_surname|ucfirst}</td>
                                   {*  {if $projects[inst].payment_type == "CASH"}
                                        <td>Cash</td>
                                    {else}
                                        {if $projects[inst].acount > 0}
                                            <td>Approved</td>
                                        {else}
                                            {if $projects[inst].pcount > 0}
                                                <td>Pending</td>
                                            {else}
                                                <td></td>
                                            {/if}
                                        {/if}
                                    {/if}
                                    <td>{$projects[inst].customer_contact}</td>
                                    <td>{$projects[inst].customer_address}</td>
                                    <td>{$projects[inst].sales_name|ucfirst} {$projects[inst].sales_surname|ucfirst}</td> *}
                                    {* {if $projects[inst].status eq 'Declined'}
                                        <td>{$projects[inst].status}{if $projects[inst].declined_reason neq ""} - {$projects[inst].declined_reason}{/if}</td>
                                    {else} *}
                                        <td>{$projects[inst].status}</td>
                                    {* {/if} *}
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    {if $user->can_access('project', 'complete') && $projects[inst].status eq 'Installed'}
                                                        <li><a href="/project/complete/{$projects[inst].project_id}"><i class="icon-database-edit2"></i> Complete</a></li>
                                                    {/if}

                                                    {if $user->can_access('project', 'statusInstalled') && $projects[inst].status eq 'New'}
                                                        <li><a href="/project/statusInstalled/{$projects[inst].project_id}"><i class="icon-database-edit2"></i> Installed</a></li>
                                                    {/if}

                                                    {if $user->can_access('project', 'statusNew') && $projects[inst].status eq 'Accepted' }
                                                        <li><a href="/project/statusNew/{$projects[inst].project_id}"><i class="icon-database-edit2"></i> Register New</a></li>
                                                    {/if}

                                                    {if $user->can_access('snag', 'index')}
                                                        <li><a href="/snag/index/{$projects[inst].project_id}"><i class="icon-wrench"></i> View Snags</a></li>
                                                    {/if}
                                                    {if $user->can_access('task', 'index')}
                                                        <li><a href="/task/index/{$projects[inst].project_id}"><i class="icon-clipboard3"></i> View Tasks</a></li>
                                                    {/if}
                                                    {if $user->can_access('project', 'spec_print') && $projects[inst].technical_id}
                                                        <li><a href="/project/spec_print/{$projects[inst].project_id}/{$projects[inst].technical_id}" target="_blank"><i class="icon-paste"></i> Print Spec Sheet</a></li>
                                                    {/if}
                                                    {if $user->can_access('quote', 'index')}
                                                        <li><a href="/quote/index/{$projects[inst].project_id}"><i class="icon-bars-alt"></i> View Quotes</a></li>
                                                    {/if}
                                                    {if $user->can_access('invoice', 'index')}
                                                        <li><a href="/invoice/index/{$projects[inst].project_id}"><i class="icon-calculator"></i> View Invoices</a></li>
                                                    {/if}

                                                    {if $user->can_access('project', 'edit')}
                                                        <li><a href="/project/spec/{$projects[inst].project_id}/{$projects[inst].technical_id|default:0}"><i class="icon-cogs"></i> Technical Specifications</a></li>
                                                    {/if}
                                                    {if $user->can_access('project', 'edit')}
                                                        <li><a href="/project/add/{$projects[inst].project_id}"><i class="icon-database-edit2"></i> Edit</a></li>
                                                    {/if}
                                                    <!-- <li><a href="#"><i class="icon-user-check"></i> Login As this user</a></li> -->
                                                    {if $user->can_access('project', 'delete')}
                                                        <li><a href="/project/delete/{$projects[inst].project_id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
                                                    {/if}
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                {/section}
                            </tbody>
                        </table>
                        </form>
						{else} No subjects found! {/if}
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
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} project</h5>
                    </div>
                    <div class="modal-body">
                        <form action="/project/add/{$data.id|default:0}" method="post" name="form_project" enctype="multipart/form-data" class="middle-forms" id="form_project">
                            <!-- <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                                <span class="text-semibold">Yay!</span> more projects.
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div> -->
                            <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                            <!-- <p>dont forget to click SAVE :)</p> -->
                            <hr>
                            <fieldset>
                                <ol style="list-style: none;">
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Subject Name</span> -->
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Subject Name" required/> {error field=name}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Subject Description</span> -->
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
                                    {* <li>
                                        <span class="label bg-teal help-inline">Start Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[start_date]" class="form-control daterange-single" value="{$data.start_date}" type="text" id="field_start_date" value="{$data.start_date}" placeholder="Start date" required>
                                            </div>
                                        </div>
                                        {error field=start_date}
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
                                    </li> *}
                                    {* <li>
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
                            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                            <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- close Iconified modal -->

    </div>
    <!-- /end content -->

{include file="footer.tpl"}
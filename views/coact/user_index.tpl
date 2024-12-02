{include file="header.tpl"} 
{head}
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
{literal} 
{/literal} 
{/head}
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> User Manager</h4>
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
                <li class="active">User Manager</li>
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
                    <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">
                            			<i class="icon-statistics position-left"></i> Add New User</a>
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
                        <form action="/user/delete_selected" name="form_user" id="form_user" method="POST">
                            {if $users}
                            <table class="table datatable-basic-6 table-hover">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Group</th>
                                        <!-- <th>Domain</th> -->
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {section name=inst loop=$users}
                                    <tr>
                                        <td>{$users[inst].first_name}</td>
                                        <td>{$users[inst].surname}</td>
                                        <td>{$users[inst].email}</td>
                                        <td>{$users[inst].mobile_number}</td>
                                        <td>{$users[inst].group_name}</td>
                                        <!-- <td>{$users[inst].domain}</td> -->
                                        <!-- <td>
                                            {if $user->can_access('user', 'update_group')}
                                            <select id="group_id_{$users[inst].user_id}" data-placeholder="Select" class="form-control" tabindex="-1" aria-hidden="true">
                                                {section name="relation" loop=$groups} {if $groups[relation].id neq 0}
                                                <option {if $users[inst].group_id eq $groups[relation].id} selected {/if} value='{$groups[relation].id}'>{$groups[relation].name}</option>
                                                {/if} {/section}
                                            </select>
                                            {else} {section name="relation" loop=$groups} {if $groups[relation].id neq 0} {if $users[inst].group_id eq $groups[relation].id} {$groups[relation].name} {/if} {/if} {/section} {/if}
                                        </td>
                                        <td>
                                            {if $user->can_access('user', 'update_domain')}
                                            <select id="domain_id_{$users[inst].user_id}" class="form-control" tabindex="-1" aria-hidden="true">
                                                {section name="relation" loop=$domains}
                                                <option {if $users[inst].domain_id eq $domains[relation].id} selected {/if} value='{$domains[relation].id}'>{$domains[relation].domain}</option>
                                                {/section}
                                            </select>
                                            {else} {section name="relation" loop=$domains} {if $users[inst].domain_id eq $domains[relation].id} {$domains[relation].domain} {/if} {/section} {/if}
                                        </td> -->

                                        {if $users[inst].account_status eq 'Active' }
                                            <td><span class="label label-success">Active</span></td>
                                        {elseif $users[inst].account_status eq 'Inactive'}
                                            <td><span class="label label-danger">Inactive</span></td>
                                        {elseif $users[inst].account_status eq 'Archived'}
                                            <td><span class="label bg-blue">Archived</span></td>
                                        {else}
                                            <td><span class="label bg-grey-400">Unknown</span></td>
                                        {/if}

                                        <td class="text-center">
                                            {if $user->can_access('user', 'edit') || $user->can_access('user', 'delete')}
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <!-- {if $user->can_access('user', 'login_as') && !$users[inst].admin}
                                                        <a href="/user/login_as/{$users[inst].user_id}" class="ajax-tip2" title="Login as {$users[inst].name}  {$users[inst].surname}"><img border=none src="{$template_dir}/images/login.gif"></a>&nbsp; &nbsp; {/if} --> 
                                                        {if $user->can_access('user', 'edit')}
                                                            <li><a href="/user/add/{$users[inst].user_id}"><i class="icon-database-edit2"></i> Edit</a></li>
                                                        {/if} 
                                                        {if $user->can_access('user', 'delete')}
                                                            <li><a href="/user/delete/{$users[inst].user_id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
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
                            {if $user->can_access('user', 'delete_selected')}
                            <!-- <input type="submit" class="submit" Value="Delete Seleted"> -->
                            {/if}
                        </form>
                        {*{pager url='user/index' current_page=$page total_rows=$total_users per_page=$per_page} *}
                        {else}
                            No users found!
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
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                            <span class="text-semibold">Yay!</span> more users.
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                        <p>dont forget to click SAVE :)</p>
                        <hr>
                        <form action="/user/add/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                            <input type="hidden" name="is_admin" value="{$is_admin}" id="is_admin" />
                            <fieldset>
                                <ol style="list-style: none;">
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Email address</span> -->
                                        <input name="data[email]" type="text" class="form-control" id="field_email" value="{$data.email}" placeholder="Email" required/> {error field=email}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Email address</span> -->
                                        <input name="data[mobile_number]" type="text" class="form-control" id="field_mobile_number" value="{$data.mobile_number}" placeholder="Mobile Number" required/> {error field=mobile_number}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User First Name</span> -->
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/> {error field=name}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Last Name</span> -->
                                        <input name="data[surname]" type="text" class="form-control" id="field_surname" value="{$data.surname}" placeholder="Surname" required /> {error field=surname}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Group Selection</span> -->
                                        <select name="data[group_id]" id="field_group_id" class="form-control">
                                            <option value=''>Select group:</option>
                                            {section name=inst loop=$groups} {if $groups[inst].id neq 0}
                                            <option value="{$groups[inst].id}" {if $data.group_id eq $groups[inst].id}selected{/if}>{$groups[inst].name}</option>
                                            {/if} {/section}
                                        </select>
                                        </label>
                                        {error field=group_id}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Domain Selection</span>											 -->
                                        <select name="data[domain_id]" id="field_domain_id" class="form-control">
                                            <option value=''>Select domain:</option>
                                            {section name=inst loop=$domains}
                                            <option value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
                                            {/section}
                                        </select>
                                        {error field=domain_id}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">User Status Selection</span>                                                 -->
                                        <select name="data[account_status]" id="field_account_status" class="form-control">
                                            <option value=''>Select status:</option>=
                                            <option value="Active" {if $data.account_status eq 'Active'}selected{/if}>Active</option>
                                            <option value="Inactive" {if $data.account_status eq 'Inactive'}selected{/if}>Inactive</option>
                                            <option value="Archived" {if $data.account_status eq 'Archived'}selected{/if}>Archived</option>
                                        </select>
                                        
                                        <span class="clearFix">&nbsp;</span>
                                        {error field=account_status}
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
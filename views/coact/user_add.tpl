{include file="header.tpl"}
{head}
{literal}
	
{/literal}
{/head}

{include file="filter_options.tpl"}

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - User Manager</h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
    <!--                                 <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a> -->

                    </div>
                </div>
            </div>

            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li><a href="/user">User Manager</a></li>
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
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} User</h5>
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
                            <form action="/user/add/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                                <input type="hidden" name="is_admin" value="{$is_admin}" id ="is_admin"/>
                                <fieldset>
                                    <ol style="list-style: none;">
                                        <li>
                                            <span class="label bg-teal help-inline">Email address</span>
                                            <input name="data[email]" type="text" class="form-control" id="field_email" value="{$data.email}" placeholder="Email" required/>
                                            <span class="clearFix">&nbsp;</span>
                                            {error field=email}
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Mobile Number</span>
                                            <input name="data[mobile_number]" type="text" class="form-control" id="field_mobile_number" value="{$data.mobile_number}" placeholder="Mobile Number" required/> {error field=mobile_number}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User First Name</span>
                                            <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/>
                                            <span class="clearFix">&nbsp;</span>
                                            {error field=name}
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">User Last Name</span>
                                            <input name="data[surname]" type="text" class="form-control" id="field_surname" value="{$data.surname}" placeholder="Surname" required />
                                            <span class="clearFix">&nbsp;</span>
                                            {error field=surname}
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User Group Selection</span>
                                            <select name="data[group_id]" id="field_group_id" class="form-control">
                                                <option value=''>Select group:</option>
                                                {section name=inst loop=$groups}
                                                    {if $groups[inst].id neq 0}
                                                        <option value="{$groups[inst].id}" {if $data.group_id eq $groups[inst].id}selected{/if}>{$groups[inst].name}</option>
                                                    {/if}
                                                {/section}
                                            </select>
                                            </label>
                                            <span class="clearFix">&nbsp;</span>
                                            {error field=group_id}
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User Domain Selection</span>
                                            <select name="data[domain_id]" id="field_domain_id" class="form-control">
                                                <option value=''>Select domain:</option>
                                                {section name=inst loop=$domains}
                                                    <option value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
                                                {/section}
                                            </select>
                                            <span class="clearFix">&nbsp;</span>
                                            {error field=domain_id}
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">User Status Selection</span>
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
                                <div class="modal-footer">
                                    <a class="btn btn-link" href="/user/"><i class="icon-cross"></i> Close</a>
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
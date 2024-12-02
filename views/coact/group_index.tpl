{include file="header.tpl"}
{head}
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/group/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
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
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Group Manager</h4>
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
                <li class="active">Group Manager</li>
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
                            			<i class="icon-statistics position-left"></i> Add New Group</a>
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
                            {if $groups}
                            <table class="table datatable-basic table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Account</th>
                                        <th>Approve Changes</th>
                                        <th>Recieve Notifications</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {section name=inst loop=$groups}
                                    <tr>
                                        <td>{$groups[inst].name}</td>
                                        <td>{$groups[inst].account|ucfirst}</td>
                                        <td>{if $groups[inst].approve_changes eq 1}Yes{else}No{/if}</td>
                                        <td>{if $groups[inst].message_notification eq 1}Yes{else}No{/if}</td>
                                        <td><span class="label label-success">Active</span></td>
                                        <td class="text-center">
                                            {if $user->can_access('group', 'Edit') || $user->can_access('group', 'delete')}
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="icon-menu9"></i>
																</a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        {if $user->can_access('group', 'edit')}
                                                            <li><a href="group/add/{$groups[inst].id}"><i class="icon-database-edit2"></i> Edit</a></li>
                                                        {/if}
                                                        {if $user->can_access('group', 'delete')}
                                                        	<li><a href="group/delete/{$groups[inst].id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a></li>
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
                            {if $user->can_access('group', 'delete_selected')}
                            <!-- <input type="submit" class="submit" Value="Delete Seleted"> -->
                            {/if}
                        </form>
                        {pager url='group/index' current_page=$page total_rows=$total_groups per_page=$per_page} {else} No groups found! {/if}
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
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Group</h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                            <span class="text-semibold">Yay!</span> more groups.
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                        <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                        <p>dont forget to click SAVE :)</p>
                        <hr>
                        <form action="/group/add/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                            <input type="hidden" name="is_admin" value="{$is_admin}" id="is_admin" />
                            <fieldset>
                                <ol style="list-style: none;">
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Email address</span> -->
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/> 
                                        {error field=name}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Group First Name</span> -->
                                        <input name="data[account]" type="text" class="form-control" id="field_account" value="{$data.account}" placeholder="Account" required/> 
                                        {error field=account}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Group Group Selection</span> -->
                                        <select name="data[approve_changes]" id="field_approve_changes" class="form-control">
                                            <option value=''>Approve Changes:</option>                                            
                                            <option value='1'>Yes</option>                                            
                                            <option value='0'>No</option>  
                                        </select>
                                        </label>
                                        {error field=approve_changes}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Group Domain Selection</span>											 -->
                                        <select name="data[message_notification]" id="field_message_notification" class="form-control">
                                            <option value=''>Recieve notifications:</option>                                            
                                            <option value='1'>Yes</option>                                            
                                            <option value='0'>No</option>  
                                        </select>
                                        </label>
                                        {error field=message_notifications}
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
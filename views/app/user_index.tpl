{include file="header.tpl"}
{head}
{literal}
	<link href="/include/js/tool/tipsy.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="/include/js/tool/tipsy.hovercard.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>
	<script src="/include/js/tool/jquery.tipsy.hovercard.js" type="text/javascript"></script>
	<script src="/views/app/js/user_index.js?id=1" type="text/javascript"></script>
{/literal}
	
    {if $smarty.get.success }
    	{literal}
    	<script>
    		$(function(){
        	_alert('confirmation', "Filters updated successfully ");
        	});
        </script>
        {/literal}
    {/if}
{/head}



<div id="content">
{include file='filter_options.tpl'}





	<div id="content-top">
	<h2 style="margin-right:10px; font-size: 20px;">User Manager</h2>
		{include file='filter_list.tpl'}



		{if $user->can_access('dashboard', 'set_filters')}
			<div type="submit"  class="minibutton bblue modal_dashboard right" style="text-shadow:none"> {$total_users} users: Change filters</div>
		{/if}
		<div class="clear"></div>


 

	  </div>

	  
	  <div id="mid-col" class="full-col" style="width:100% !important;"><!-- end of div.box -->
		
	  <div class="box">
		<h4 class="white">User Manager
			
				{if $user->can_access('user','export')}
						<div class="minibutton right" data-dropdown="#dropdown-export" style="position:relative;top:-5px;text-transform:none;margin-left:10px">Export</div>
				{/if}
				{if $user->can_access('user','batch_update')}
						<div class="minibutton right" data-dropdown="#dropdown-update" style="position:relative;top:-5px;text-transform:none;">Update</div>
				{/if}
			


		</h4>

		{if $user->can_access('user','batch_export')}
	        <div id="dropdown-export" class="dropdown dropdown-tip has-icons dropdown-relative">
	            <ul class="dropdown-menu">
	                <li><a id="export_selected">Selected Items</a></li>
	                <li><a id="export">All Users: ({$total_users})</a></li>
	            </ul>
	        </div>
        {/if}


		{if $user->can_access('user','batch_update')}
	        <div id="dropdown-update" class="dropdown dropdown-tip has-icons dropdown-relative">
	            <ul class="dropdown-menu">
	                <li><a id="batch_update_selected">Selected Items</a></li>
	                <li><a id="batch_update">All Users: ({$total_users})</a></li>
	            </ul>
	        </div>
        {/if}

		<div class="box-container">
		<form action="/user/delete_selected" name="form_user" id="form_user" method="POST">
			{if $users}	
				<table class="table-long"  style="width:100% !important;"> 
					<thead>
						<tr>
							<td></td>
							<td>Name</td>
							<td>Scholarship</td>
							<td>Group</td>
							<td>Domain</td>
							<td>Options</td>
						</tr>
					</thead>

					<tbody>
					{section name=inst loop=$users}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$users[inst].id}]" /></td>
							<td class="col-second">
								{if $user->can_access('user', 'profile') && $users[inst].account eq 'bursar'}
									<a href="/{$users[inst].id}" {if $user->can_access('user', 'preview')} class="ajax-tip" {/if} data-url="/user/preview/{$users[inst].id}">{$users[inst].name} {$users[inst].surname}</a>
								{else}
									{$users[inst].name}  {$users[inst].surname}
								{/if}
							</td>
							<td class="col-second">
								{if $users[inst].account neq 'bursar'}
									Not a bursar!

								{else}
									{if strlen($users[inst].university) eq 0}
										Scholarship information incomplete!
									{/if}
								{/if}


								{if !$user->can_access('scholarship', 'preview')}
									{$users[inst].university}
								{else}
									<a href="/{$users[inst].id}" class="ajax-tip" data-url="/scholarship/preview/{$users[inst].id}">{$users[inst].university}</a>

								{/if}
							</td>
							<td>
								{if $user->can_access('user', 'update_group')}
									<select class="relation" id="group_id_{$users[inst].id}">
										{section name="relation" loop=$groups}
											{if $groups[relation].id neq 0}
												<option {if $users[inst].group_id eq $groups[relation].id} selected {/if} value='{$groups[relation].id}'>{$groups[relation].name}</option>
											{/if}
										{/section}
									</select>
								{else}
									{section name="relation" loop=$groups}
										{if $groups[relation].id neq 0}
											{if $users[inst].group_id eq $groups[relation].id} 
												{$groups[relation].name}
											{/if} 
										{/if}
									{/section}
								{/if}
							</td>

							<td>
								{if $user->can_access('user', 'update_domain')}
									<select class="relation" id="domain_id_{$users[inst].id}">
										{section name="relation" loop=$domains}
											<option {if $users[inst].domain_id eq $domains[relation].id} selected {/if} value='{$domains[relation].id}'>{$domains[relation].domain}</option>
										{/section}
									</select>
								{else}
									{section name="relation" loop=$domains}
										{if $users[inst].domain_id eq $domains[relation].id} 
											{$domains[relation].domain}
										{/if}
									{/section}
								{/if}
							</td>
							<td> 
								{if $user->can_access('user', 'login_as') && !$users[inst].admin}
									<a href="/user/login_as/{$users[inst].id}" class="ajax-tip2" title="Login as {$users[inst].name}  {$users[inst].surname}"><img border=none src="{$template_dir}/images/login.gif"></a>&nbsp; &nbsp;
								{/if}

								{**
								{if $user->can_access('user', 'edit')}
									<a href="/user/edit/{$users[inst].id}" title="Edit {$users[inst].name}  {$users[inst].surname} " class="table-edit-link ajax-tip2"></a>
								{/if}
								**}
								{if $user->can_access('user', 'delete')}
									<a title="Delete {$users[inst].name}  {$users[inst].surname} "  class="table-delete-link ajax-tip2" href="/user/delete/{$users[inst].id}"></a>&nbsp;&nbsp;
								{/if}
							</td>
						</tr>
					{/section}
					</tbody>
				</table>
				{if $user->can_access('user', 'delete_selected')}
					<input type="submit" class="submit" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='user/index' current_page=$page total_rows=$total_users per_page=$per_page}
{else}
	No users found!
{/if}
		</div>
		</div> 
	  </div>   
	  <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
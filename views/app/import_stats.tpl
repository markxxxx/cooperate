{include file="header.tpl"}

<form action="" method="POST" id="stat-filter">

<div id="content">
	<div id="content-top">

    <a href="/import/resend_registration_letters" class="right minibutton">Resend invitations</a><h2>Import stats </h2>

      <span class="clearFix">&nbsp;</span>
      </div>


      
      <div id="mid-col" class="full-col" style="width:100% !important;">

      <div class="box" id="to-do">
              <ul class="tab-menu">
                <li><a href="#registered">{$users|@count} Have not registered</a></li>
              </ul>



              <div class="box-container" id="registered">
<form action="/user/delete_selected" name="form_user" id="form_user" method="POST">
				<table class="table-long"  style="width:100% !important;"> 
					<thead>
						<tr>
							<td></td>
							<td>Name</td>
							<td>Email</td>
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
								{$users[inst].email}
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

						</tr>
					{/section}
					</tbody>
				</table>

			</form>
</div>
{include file="footer.tpl"}

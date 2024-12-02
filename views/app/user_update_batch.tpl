<html>
<head>

<body>

{if !$all}

<div id="test" style="height:250px">
<div style="width:600px; " >
	<h3 class="green">Batch update of {$smarty.post.id|@count} users</h3>
</div>
<form action="/user/update_batch/{$all}" method="POST">
	<table>
		<tr>
			<td valign="top" >
				<ul class="checklist">
					{section name=inst loop=$users}
						<li><label for="ck_domain_"><input type="checkbox" name="users[]" checked value="{$users[inst].id}" />{$users[inst].name} {$users[inst].surname}</label></li>
					{/section}
				</ul>
			</td>

			<td valign="top">
				<div style="margin-left:10px">
				<b>Please select what you want to update</b><br /><br />
				<label for="update_domain"><input type="checkbox" class="toggle_update" id="update_domain" name="update_domain"/>Update domain</label>
				<label for="update_group"><input type="checkbox"  class="toggle_update" id="update_group" name="update_group"/>Update group</label>
				<label for="update_status"><input type="checkbox" class="toggle_update" id="update_status" name="update_status"/>Update status</label>
				<br /><br />
				<div id="update_group_select" style="display:none">
					<table>
					<tr><td width="120">
					Select group:
					</td>
					<td>
					<select class="relation" name="updates[group]">
						<option value="">SELECT</option>

						{section name="relation" loop=$groups}
							{if $groups[relation].id neq 0}
								<option value='{$groups[relation].id}'>{$groups[relation].name}</option>
							{/if}
						{/section}
					</select><br />
					</td>
					</tr>
					</table>
				</div>
				<div id="update_domain_select" style="display:none">
					<table>
					<tr><td width="120">
					Select domain:
					</td><td>
					<select class="relation" name="updates[domains]">
						<option value="">SELECT</option>

						{section name="relation" loop=$domains}
							<option {if $users[inst].domain_id eq $domains[relation].id} selected {/if} value='{$domains[relation].id}'>{$domains[relation].domain}</option>
						{/section}
					</select>
					</td>
					</tr>
					</table>
				</div>
				<div id="update_status_select" style="display:none">
					<table>
					<tr><td width="120">
					Select status:
					</td><td>

					<select class="relation" name="updates[status]">
						<option value="">SELECT</option>
						{section name="relation" loop=$account_status}
							<option value='{$account_status[relation]}'>{$account_status[relation]}</option>
						{/section}
					</select>
					</td>
					</tr>
					</table>
				</div>

				<br />
				<input type="submit" class="minibutton " style="display:none" id="update_all" value="Update">

				

			</td>


		</tr>
	</table>

</form>


{else}
<div style="width:600px;height:300px;padding:5px">
<h3 class="green">Updating: 
{if count($filters)}
	{foreach from=$filters key=k item=v}
		{if count($v) eq 1}
			{if $k == 'domains'}
				{section name=inst loop=$domains}
					{if $domains[inst].id eq $v[0]}
						<a class="minibutton ajax-tip2 " title="Remove filter"  >{$domains[inst].domain}</a>
					{/if}
				{/section}
			{else}
				<a class="minibutton ajax-tip2 " >{$v[0]}</a>
			{/if}

			{else}
				<a class="minibutton " data-dropdown="#dropdown2-{$k}">{$v|@count} {$k|ucfirst|replace:'_':' '} selected<img src="/views/app/images/down_2.png" align="right"></a>
			{/if}
	{/foreach}

	{foreach from=$filters key=k item=v}

		{if count($v) > 1}
			<div id="dropdown2-{$k}" class="dropdown dropdown-tip has-icons dropdown-relative">
				<ul class="dropdown-menu">
					{section name=inst loop=$v}
						{if $k == 'domains'}
							{section name=inst2 loop=$domains}
								{if $domains[inst2].id eq $v[inst]}
									<li class="{$v[inst]}"><a>{$domains[inst2].domain}</a></li>
								{/if}
							{/section}
						{else}
							<li class="{$v[inst]}"><a>{$v[inst]}</a></li>
						{/if}
					{/section}
				</ul>
			</div>
		{/if}

	{/foreach}
{else}
	<a class="minibutton">All users</a>
{/if}
<div class="right" style="font-size:smaller">Total users: {$user_count} </div>
</h3>

<form action="/user/update_batch/{$all}" method="POST">
	<table>
		<tr>


			<td valign="top">
				<div style="margin-left:10px">
				<b>Please select what you want to update</b><br /><br />
				<label for="update_domain"><input type="checkbox" class="toggle_update" id="update_domain" name="update_domain"/>Update domain</label>
				<label for="update_group"><input type="checkbox"  class="toggle_update" id="update_group" name="update_group"/>Update group</label>
				<label for="update_status"><input type="checkbox" class="toggle_update" id="update_status" name="update_status"/>Update status</label>
				<br /><br />
				<div id="update_group_select" style="display:none">
					<table>
					<tr><td width="120">
					Select group:
					</td>
					<td>
					<select class="relation" name="updates[group]">
						<option value="">SELECT</option>

						{section name="relation" loop=$groups}
							{if $groups[relation].id neq 0}
								<option value='{$groups[relation].id}'>{$groups[relation].name}</option>
							{/if}
						{/section}
					</select><br />
					</td>
					</tr>
					</table>
				</div>
				<div id="update_domain_select" style="display:none">
					<table>
					<tr><td width="120">
					Select domain:
					</td><td>
					<select class="relation" name="updates[domains]">
						<option value="">SELECT</option>

						{section name="relation" loop=$domains}
							<option {if $users[inst].domain_id eq $domains[relation].id} selected {/if} value='{$domains[relation].id}'>{$domains[relation].domain}</option>
						{/section}
					</select>
					</td>
					</tr>
					</table>
				</div>
				<div id="update_status_select" style="display:none">
					<table>
					<tr><td width="120">
					Select status:
					</td><td>

					<select class="relation" name="updates[status]">
						<option value="">SELECT</option>
						{section name="relation" loop=$account_status}
							<option value='{$account_status[relation]}'>{$account_status[relation]}</option>
						{/section}
					</select>
					</td>
					</tr>
					</table>
				</div>

				<br />
				<input type="submit" class="minibutton " style="display:none" id="update_all" value="Update">

				

			</td>


		</tr>
	</table>




{/if}

</div>
</body>
</html>
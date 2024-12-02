{if $user->can_access('dashboard','set_filters')}
	
<div class="hidden">
	<div id="change_dashboard" style=" margin:20px"><h3 class="green" style="border-bottom:1px solid silver;padding-bottom:5px;margin-bottom:5px">Dashboard options<div style="float:right" >Total users: <span id="user_count">{$total_users}</span></div></h3>
		<br />
		<form action="/dashboard/set_filters/" id="message_counter" method="POST" />
			<table width="100%" style="border-spacing:5px;">
				<tr>
					<td>
							{if $domains|count > 1 }
								<b>Domains:</b><Br />
								<ul class="checklist">
									{section name=inst loop=$domains}
										<li><label for="ck_domain_{$domains[inst].id}"><input type="checkbox"  name="domains[]"  
										{if isset($filter_domains) && in_array($domains[inst].id, $filter_domains )} checked {/if} value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}"/>{$domains[inst].domain}</label></li>
									{/section}
								</ul>
							{/if}
					</td>
					<td>
						<b>Universities:</b><Br />

						<ul class="checklist">
							{section name=inst loop=$universities}
								<li><label for="ck_universities_{$universities[inst]}"><input type="checkbox"  name="universities[]"
								 {if isset($filter_universities) && in_array($universities[inst], $filter_universities )} checked {/if}  value="{$universities[inst]}" id="ck_universities_{$universities[inst]}"/>{$universities[inst]}</label></li>
							{/section}

						</ul>

					</td>


					<td>
					 
						<b>Year of study:</b><Br />

						<ul class="checklist">
							{section name=inst loop=$study_years}
								<li><label for="ck_study_years_{$study_years[inst]}"><input type="checkbox"  name="study_years[]"  value="{$study_years[inst]}" id="ck_study_years_{$study_years[inst]}"
								{if isset($filter_study_years) && in_array($study_years[inst], $filter_study_years )} checked {/if}
								/>{$study_years[inst]}</label></li>
							{/section}


						</ul>

					</td>

			   </tr>


			   <tr>

			   </tr>
					<td>
					 
						<b>Group:</b><Br />
						<ul class="checklist">
							{section name=inst loop=$groups}
								<li><label for="ck_groups_{$groups[inst].id}"><input type="checkbox"  name="groups[]"  value="{$groups[inst].id}" id="ck_groups_{$groups[inst].id}"
								{if isset($filter_groups) && in_array($groups[inst].id, $filter_groups )} checked {/if}
								/>{$groups[inst].name}</label></li>
							{/section}


						</ul>

					</td>
					<td valign="top">
						<b>Account status:</b><Br />
						{cfield field="account_status" name="account_status" value=$filter_status}
					</td>

			   <tr>


			   </tr>
			</table>
			<input type="submit" class="minibutton" Value="Change filters">

			<input type="button" class="minibutton bblue" value="Clear all" id="clear-filters">

		<br /><br />

		
	</div>
		</form>
		
</div>
{/if}

{ldelim}include file="header.tpl"{rdelim}
{ldelim}head{rdelim}{ldelim}literal{rdelim}
	<script>{literal}
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/admin/{/literal}{$meta.lower}{literal}/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});{/literal}
	</script>
{ldelim}/literal{rdelim}{ldelim}/head{rdelim}


<h2>{$meta.class} Manager</h2>
<div id="search-form">
	<form action="/admin/{$meta.lower}/" name="form_search_{$meta.lower}" id="form_search_{$meta.lower}" method="GET">
		<input type="text" name="search" id="search" size="15" value="" onKeyUp="if(event.keyCode == 13) document.form_search_{$meta.lower}.submit();return false;" />
	</form>
</div>
{literal}{if $user->can_access({/literal}'{$meta.lower}'{literal}, 'add')}{/literal}
	<div class="buttons">
		<a href="/admin/{$meta.lower}/add/">
			<img src="/views/admin/images/icons/folder.gif" alt="New {$meta.class}">
			New {$meta.class}
		</a>
	</div>
{literal}{/if}{/literal}

{section name=inst loop=$relations}
{literal}{if $user->can_access({/literal}'{$relations[inst].lower}'{literal}, 'add')}{/literal}
	<div class="buttons">
		<a href="/admin/{$relations[inst].lower}/add/">
			<img src="/views/admin/images/icons/folder.gif" alt="New {$relations[inst].class}">
			New {$relations[inst].class}
		</a>
	</div>
{literal}{/if}{/literal}
{/section}
<div style="clear:both"></div>

{ldelim}if ${$meta.table}{rdelim}
	<form action="/admin/{$meta.lower}/delete_selected" name="form_{$meta.lower}" id="form_{$meta.lower}" method="POST">
		<table width="100%" class="sortable-onload-1 rowstyle-alt no-arrow" id="table">
			<caption>Total {$meta.table}: {ldelim}${$meta.table}|@count{rdelim}</caption>
			<thead>
				<tr>
{section name=inst loop=$tablestructure}
					{if $tablestructure[inst].Field eq 'id'}<th class="sortable-numeric" width="20">Id</th>
{else}<th class="sortable-text">{$tablestructure[inst].Field|ucfirst}</th>
{/if}
{/section}
					<th class="sortable-text">Options</th>
				</tr>
			</thead>
			<tbody>
				{literal}{section name=inst loop={/literal}${$meta.table}{literal}}{/literal}
					<tr>
{section name=inst loop=$tablestructure}
{if strpos($tablestructure[inst].Field,'_id')}
{section name=inst2 loop=$relations}
{assign var="field" value=" `$tablestructure[inst].Field`"}
{if strpos($field, $relations[inst2].lower)}
						<td class="lft">
							{ldelim}if $user->can_access('{$meta.lower}', 'update_{$relations[inst2].lower}'){rdelim}
								<select class="relation" id="{$tablestructure[inst].Field}_{ldelim}${$meta.table}[inst].id{rdelim}">
									{ldelim}section name="relation" loop=${$relations[inst2].table}{rdelim}
										<option {ldelim}if ${$meta.table}[inst].{$relations[inst2].lower}_id eq ${$relations[inst2].table}[relation].id{rdelim} selected {ldelim}/if{rdelim} value='{ldelim}${$relations[inst2].table}[relation].id{rdelim}'>{ldelim}${$relations[inst2].table}[relation].{$relations[inst2].display}{rdelim}</option>
									{ldelim}/section{rdelim}
								</select>
							{ldelim}else{rdelim}
								{ldelim}assign var="current_id" value="$data[inst].id"{rdelim}
								{ldelim}${$relations[inst2].table}[$current_id].{$relations[inst2].display}{rdelim}
							{ldelim}/if{rdelim}
						</td>
{/if}
{sectionelse}
						<td class="lft">{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}</td>
{/section}

{elseif $tablestructure[inst].Field eq 'id'}
						<td class="lft" width="20"><input type="checkbox" name="id[{ldelim}${$meta.table}[inst].id{rdelim}]" /></td>
{elseif $tablestructure[inst].Field eq 'image'}
						<td class="lft">{ldelim}if strlen(${$meta.table}[inst].{$tablestructure[inst].Field}){rdelim}{ldelim}image src="media/{$meta.table}/`${$meta.table}[inst].{$tablestructure[inst].Field}`" width="60"{rdelim}{ldelim}else{rdelim}No Image{ldelim}/if{rdelim}</td>
{elseif $tablestructure[inst].Field eq 'enabled'}
						<td class="lft">
							{ldelim}if $user->can_access('{$meta.lower}', 'enable'){rdelim}
								<a href="/admin/{$meta.lower}/enable/{ldelim}${$meta.table}[inst].id{rdelim}">{ldelim}if ${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}Yes{ldelim}else{rdelim}No{ldelim}/if{rdelim}</a>
							{ldelim}else{rdelim}
								{ldelim}if ${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}Yes{ldelim}else{rdelim}No{ldelim}/if{rdelim}
							{ldelim}/if{rdelim}
						</td>
{elseif $tablestructure[inst].Field eq $meta.display}
						<td class="lft">
							{ldelim}if $user->can_access('{$meta.lower}', 'edit'){rdelim}
								<a href="/admin/{$meta.lower}/edit/{ldelim}${$meta.table}[inst].id{rdelim}">{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}</a>
							{ldelim}else{rdelim}
								{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}
							{ldelim}/if{rdelim}
						</td>
{else}
						<td class="lft">{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}</td>
{/if}
{/section}
						<td class="lft"> 
							{ldelim}if $user->can_access('{$meta.lower}', 'delete'){rdelim}
								<a title="Delete Edit {$meta.class}" href="/admin/{$meta.lower}/delete/{ldelim}${$meta.table}[inst].id{rdelim}"><img src="/views/admin/images/icons/delete.png"></a>&nbsp;&nbsp;
							{ldelim}/if{rdelim}
							{ldelim}if $user->can_access('{$meta.lower}', 'edit'){rdelim}
								<a href="/admin/{$meta.lower}/edit/{ldelim}${$meta.table}[inst].id{rdelim}" title="Edit {$meta.class}"><img src="/views/admin/images/icons/code.gif"></a>
							{ldelim}/if{rdelim}
						</td>
					</tr>
				{literal}{/section}{/literal}
			</tbody>
		</table>
		<input type="submit" value="Delete Selected" />
	</form>
	{ldelim}pager url='admin/{$meta.lower}/index' current_page=$page total_rows=$total_{$meta.table} per_page=$per_page{rdelim}
{ldelim}else{rdelim}
	No {$meta.table} found!
{ldelim}/if{rdelim}

{ldelim}include file="footer.tpl"{rdelim}
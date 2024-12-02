{ldelim}include file="header.tpl"{rdelim}
{ldelim}head{rdelim}{ldelim}literal{rdelim}
	<script>{literal}
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/{/literal}{$meta.lower}{literal}/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});{/literal}
	</script>
{ldelim}/literal{rdelim}{ldelim}/head{rdelim}

<div id="content">
	<div id="content-top">
    <h2>{$meta.class} Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">{$meta.class} Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{literal}{if $user->can_access({/literal}'{$meta.lower}'{literal}, 'add')}{/literal}
					<li><a href="/{$meta.lower}/add/">New {$meta.class}</a></li>
				{literal}{/if}{/literal}
{section name=inst loop=$relations}
				{literal}{if $user->can_access({/literal}'{$relations[inst].lower}'{literal}, 'add')}{/literal}
					<li><a href="/{$relations[inst].lower}/add/">New {$relations[inst].class}</a></li>
				{literal}{/if}{/literal}
				{literal}{if $user->can_access({/literal}'{$relations[inst].lower}'{literal}, 'index')}{/literal}
					<li><a href="/{$relations[inst].lower}/add/">View {$relations[inst].table|ucfirst}</a></li>
				{literal}{/if}{/literal}
{/section}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">{$meta.class} Manager</h4>
        <div class="box-container">
		<form action="/{$meta.lower}/delete_selected" name="form_{$meta.lower}" id="form_{$meta.lower}" method="POST">
			{ldelim}if ${$meta.table}{rdelim}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
{section name=inst loop=$tablestructure}
{if $tablestructure[inst].Field eq 'id'}
							<td>Id</td>
{else}
							<td>{$tablestructure[inst].Field|ucfirst}</td>
{/if}
{/section}
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{literal}{section name=inst loop={/literal}${$meta.table}{literal}}{/literal}
						<tr {ldelim}cycle values="class='odd',"{rdelim}>
{section name=inst loop=$tablestructure}
{if strpos($tablestructure[inst].Field,'_id')}
{section name=inst2 loop=$relations}
{assign var="field" value=" `$tablestructure[inst].Field`"}
{if strpos($field, $relations[inst2].lower)}
							<td>
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
							<td>{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}</td>
{/section}

{elseif $tablestructure[inst].Field eq 'id'}
							<td class="col-chk"><input type="checkbox" name="id[{ldelim}${$meta.table}[inst].id{rdelim}]" /></td>
{elseif $tablestructure[inst].Field eq 'image'}
							<td>{ldelim}if strlen(${$meta.table}[inst].{$tablestructure[inst].Field}){rdelim}{ldelim}image src="media/{$meta.table}/`${$meta.table}[inst].{$tablestructure[inst].Field}`" width="60"{rdelim}{ldelim}else{rdelim}No Image{ldelim}/if{rdelim}</td>
{elseif $tablestructure[inst].Field eq 'enabled'}
							<td class="col-second">
								{ldelim}if $user->can_access('{$meta.lower}', 'enable'){rdelim}
									<a href="/{$meta.lower}/enable/{ldelim}${$meta.table}[inst].id{rdelim}">{ldelim}if ${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}Yes{ldelim}else{rdelim}No{ldelim}/if{rdelim}</a>
								{ldelim}else{rdelim}
									{ldelim}if ${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}Yes{ldelim}else{rdelim}No{ldelim}/if{rdelim}
								{ldelim}/if{rdelim}
							</td>
{elseif $tablestructure[inst].Field eq $meta.display}
							<td class="col-second">
								{ldelim}if $user->can_access('{$meta.lower}', 'edit'){rdelim}
									<a href="/{$meta.lower}/edit/{ldelim}${$meta.table}[inst].id{rdelim}">{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}</a>
								{ldelim}else{rdelim}
									{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}
								{ldelim}/if{rdelim}
							</td>
{else}
							<td>{ldelim}${$meta.table}[inst].{$tablestructure[inst].Field}{rdelim}</td>
{/if}
{/section}
							<td> 
								{ldelim}if $user->can_access('{$meta.lower}', 'delete'){rdelim}
									<a title="Delete Edit {$meta.class}"  class="table-delete-link" href="/{$meta.lower}/delete/{ldelim}${$meta.table}[inst].id{rdelim}"></a>&nbsp;&nbsp;
								{ldelim}/if{rdelim}
								{ldelim}if $user->can_access('{$meta.lower}', 'edit'){rdelim}
									<a href="/{$meta.lower}/edit/{ldelim}${$meta.table}[inst].id{rdelim}" title="Edit {$meta.class}" class="table-edit-link"></a>
								{ldelim}/if{rdelim}
							</td>
						</tr>
					{literal}{/section}{/literal}
	      			</tbody>
	      		</table>
				{ldelim}if $user->can_access('{$meta.lower}', 'delete_selected'){rdelim}
					<input type="submit" class="button" Value="Delete Seleted">
				{ldelim}/if{rdelim}
			</form>

			{ldelim}pager url='{$meta.lower}/index' current_page=$page total_rows=$total_{$meta.table} per_page=$per_page{rdelim}
{ldelim}else{rdelim}
	No {$meta.table} found!
{ldelim}/if{rdelim}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{ldelim}include file="footer.tpl"{rdelim}
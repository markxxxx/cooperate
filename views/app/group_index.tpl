{include file="header.tpl"}
{head}{literal}
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
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Group Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Group Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('group', 'add')}
					<li><a href="/group/add/">New Group</a></li>
				{/if}
				{if $user->can_access('group', 'manage')}
					<li><a href="/group/manage/">Group Permissions</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Group Manager</h4>
        <div class="box-container">
		<form action="/group/delete_selected" name="form_group" id="form_group" method="POST">
			{if $groups}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>Name</td>
							<td>Account</td>
							<td>Approve changes</td>
							<td>Approve payments</td>
							<td>Message notification</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$groups}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$groups[inst].id}]" /></td>
							<td class="col-second">
								{if $user->can_access('group', 'edit') && !($groups[inst].id eq 1 || $groups[inst].id eq 0)}
									<a href="/group/edit/{$groups[inst].id}">{$groups[inst].name}</a>
								{else}
									{$groups[inst].name}
								{/if}
							</td>
							<td>{$groups[inst].account}</td>
							<td>{if $groups[inst].approve_changes}Yes{else}No{/if}</td>
							<td>{if $groups[inst].approve_payments}Yes{else}No{/if}</td>
							<td>{if $groups[inst].message_notification}Yes{else}No{/if}</td>
							<td> 
								{if $user->can_access('group', 'delete') && !($groups[inst].id eq 1 || $groups[inst].id eq 0)}
									<a title="Delete Edit Group"  class="table-delete-link" href="/group/delete/{$groups[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('group', 'edit') && !($groups[inst].id eq 1 || $groups[inst].id eq 0)}
									<a href="/group/edit/{$groups[inst].id}" title="Edit Group" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				{if $user->can_access('group', 'delete_selected')}
					<input type="submit" class="submit" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='group/index' current_page=$page total_rows=$total_groups per_page=$per_page}
{else}
	No groups found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
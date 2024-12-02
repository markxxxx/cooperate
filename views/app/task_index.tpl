{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/task/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Task Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Task Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('task', 'add')}
					<li><a href="/">New Task</a></li>
				{/if}
				{if $user->can_access('user', 'add')}
					<li><a href="/user/add/">New User</a></li>
				{/if}
				{if $user->can_access('user', 'index')}
					<li><a href="/user/add/">View Users</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Task Manager
			{if $domains|@count > 1}
				<div style="float:right">
					<form id="select-domain" method="get" action="">
						<select name="domain_id" onchange="document.getElementById('select-domain').submit()">
							<option>Select domain:</option>
							{section name=inst loop=$domains}
								<option {if $smarty.get.domain_id eq $domains[inst].id} selected {/if} value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
							{/section}
						</select>
					</form>
				</div>
			{/if}
		</h4>
        <div class="box-container">
		<form action="/task/delete_selected" name="form_task" id="form_task" method="POST">
			{if $tasks}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>User</td>
							<td>Task</td>
							<td>Created on</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$tasks}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$tasks[inst].id}]" /></td>
							<td class="col-second">
								<a href="/{$tasks[inst].user_id}">{$tasks[inst].name} {$tasks[inst].surname}</a>
							</td>
							<td class="col-second">
								{$tasks[inst].task|strip_tags}
							</td>
							<td>{$tasks[inst].created_on}</td>

							<td> 
								{if $user->can_access('task', 'delete')}
									<a title="Delete Edit Task"  class="table-delete-link" href="/task/delete/{$tasks[inst].id}"></a>&nbsp;&nbsp;
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				<br />
				{if $user->can_access('task', 'delete_selected')}
					<input type="submit" class="submit" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='task/index' current_page=$page total_rows=$total_tasks per_page=$per_page}
{else}
	No tasks found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
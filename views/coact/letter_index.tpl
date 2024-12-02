{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/letter/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Letter Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Letter Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('letter', 'add')}
					<li><a href="/letter/add/">New Letter</a></li>
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
      	<h4 class="white">Letter Manager</h4>
        <div class="box-container">
		<form action="/letter/delete_selected" name="form_letter" id="form_letter" method="POST">
			{if $letters}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>User_id</td>
							<td>Letter</td>
							<td>Date</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$letters}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$letters[inst].id}]" /></td>
							<td>
								{if $user->can_access('letter', 'update_user')}
									<select class="relation" id="user_id_{$letters[inst].id}">
										{section name="relation" loop=$users}
											<option {if $letters[inst].user_id eq $users[relation].id} selected {/if} value='{$users[relation].id}'>{$users[relation].name}</option>
										{/section}
									</select>
								{else}
									{assign var="current_id" value="$data[inst].id"}
									{$users[$current_id].name}
								{/if}
							</td>

							<td class="col-second">
								{if $user->can_access('letter', 'edit')}
									<a href="/letter/edit/{$letters[inst].id}">{$letters[inst].letter}</a>
								{else}
									{$letters[inst].letter}
								{/if}
							</td>
							<td>{$letters[inst].date}</td>
							<td> 
								{if $user->can_access('letter', 'delete')}
									<a title="Delete Edit Letter"  class="table-delete-link" href="/letter/delete/{$letters[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('letter', 'edit')}
									<a href="/letter/edit/{$letters[inst].id}" title="Edit Letter" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				{if $user->can_access('letter', 'delete_selected')}
					<input type="submit" class="button" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='letter/index' current_page=$page total_rows=$total_letters per_page=$per_page}
{else}
	No letters found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/reminder/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Reminder Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Reminder Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('reminder', 'add')}
					<li><a href="/reminder/add/">New Reminder</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Reminder Manager</h4>
        <div class="box-container">
		<form action="/reminder/delete_selected" name="form_reminder" id="form_reminder" method="POST">
			{if $reminders}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>User_id</td>
							<td>Ident_id</td>
							<td>Ident</td>
							<td>Reminder</td>
							<td>Reminder_date</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$reminders}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$reminders[inst].id}]" /></td>
							<td>{$reminders[inst].user_id}</td>

							<td>{$reminders[inst].ident_id}</td>

							<td>{$reminders[inst].ident}</td>
							<td class="col-second">
								{if $user->can_access('reminder', 'edit')}
									<a href="/reminder/edit/{$reminders[inst].id}">{$reminders[inst].reminder}</a>
								{else}
									{$reminders[inst].reminder}
								{/if}
							</td>
							<td>{$reminders[inst].reminder_date}</td>
							<td> 
								{if $user->can_access('reminder', 'delete')}
									<a title="Delete Edit Reminder"  class="table-delete-link" href="/reminder/delete/{$reminders[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('reminder', 'edit')}
									<a href="/reminder/edit/{$reminders[inst].id}" title="Edit Reminder" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				{if $user->can_access('reminder', 'delete_selected')}
					<input type="submit" class="button" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='reminder/index' current_page=$page total_rows=$total_reminders per_page=$per_page}
{else}
	No reminders found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
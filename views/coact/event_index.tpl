{include file="header.tpl"}
{head}{literal}
<script>
		$(document).ready(function(){
			$('.relation').change(function(){
					var element = $(this);
					var field = element.attr('id').split('_').shift();
					var id = element.attr('id').split('_').pop();
					$.get('/event/update_'+field+'/'+id+'/'+element.val(), function(){
							element.css('color','red');
					});
			});

		});
</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
		<h2>Event Manager</h2>

		<span class="clearFix">&nbsp;</span>
	</div>


	<div class="full-col" style="width:100% !important">

		<div class="box" >
			<h4 class="white">Event Manager
			

			</h4>
			<div class="box-container" >
				<form action="/event/delete_selected" name="form_event" id="form_event" method="POST">
			{if $events}	
					<table class="table-long" style="width:100% !important">
						<thead>
							<tr>
								<td>Id</td>
								<td>Event</td>
								<td>Location</td>
								<td>Create by</td>
								<td>Date</td>
								<td>Options</td>
							</tr>
						</thead>

						<tbody>
						{section name=inst loop=$events}
							<tr {cycle values="class='odd',"}>
								<td class="col-chk"><input type="checkbox" name="id[{$events[inst].id}]" /></td>
								<td class="col-second">
									{if $user->can_access('event', 'edit')}
										<a href="/event/edit/{$events[inst].id}">{$events[inst].name|truncate:40}</a>
									{else}
										{$events[inst].name|truncate:40}
									{/if}
								</td>
								<td>
									{$events[inst].location}
								</td>
								<td>
								{$events[inst].creator}
								</td>
								<td>{$events[inst].event_date}</td>
								<td> 
									{if $user->can_access('event', 'delete')}
										<a title="Delete Edit Event"  class="table-delete-link" href="/event/delete/{$events[inst].id}"></a>&nbsp;&nbsp;
									{/if}
									{if $user->can_access('event', 'edit')}
										<a href="/event/edit/{$events[inst].id}" title="Edit Event" class="table-edit-link"></a>
									{/if}
								</td>
							</tr>
						{/section}
						</tbody>
					</table>
					{if $user->can_access('event', 'delete_selected')}
						<input type="submit" class="submit" Value="Delete Seleted">
					{/if}
				</form>
				{pager url='event/index' current_page=$page total_rows=$total_events per_page=$per_page}
				{else}
					No events found!
				{/if}
			</div>
		</div> 
	</div>   
	<span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
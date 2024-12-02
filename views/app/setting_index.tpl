{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/supplier/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">

    <h3 class="green" style="width:100%;font-size:200%">Email Sync Manager
		{if $user->can_access('setting', 'add')}
			<a class="minibutton bblue right"href="/setting/add/">New Email Sync</a>
		{/if}
	</h3>

      
      <div id="mid-col" class="full-col" style="width:100%  !important"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Email Sync Manager</h4>
        <div class="box-container">
		<form action="/supplier/delete_selected" name="form_supplier" id="form_supplier" method="POST">
			{if $settings}	
	      		<table class="table-long" style="width:100% !important">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>Email Adress</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$settings}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk">{$settings[inst].id}</td>
							<td class="col-second">
								{if $user->can_access('setting', 'add')}
									<a href="/setting/add/{$settings[inst].id}">{$settings[inst].email}</a>
								{else}
									{$settings[inst].email}
								{/if}
							</td>

							<td> 
								{if $user->can_access('setting', 'delete')}
									<a title="Delete Email Sync setting"  class="table-delete-link" href="/setting/delete/{$settings[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('setting', 'add')}
									<a href="/setting/add/{$settings[inst].id}" title="Edit Email Sync setting" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>				

			</form>

{else}
	No Email sync settings found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/message_template/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Templates Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Template Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('message_template', 'add')}
					<li><a href="/message_template/add/">New Template</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Template Manager</h4>
        <div class="box-container">
		<form action="/message_template/delete_selected" name="form_message_template" id="form_message_template" method="POST">
			{if $message_templates}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Name</td>
							<td>Title</td>
							<td>Message</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$message_templates}
						<tr {cycle values="class='odd',"}>
							<td class="col-second">
								{if $user->can_access('message_template', 'edit')}
									<a href="/message_template/edit/{$message_templates[inst].id}">{$message_templates[inst].name}</a>
								{else}
									{$message_templates[inst].name}
								{/if}
							</td>
							<td>{$message_templates[inst].title|truncate:15}</td>
							<td>{$message_templates[inst].message|truncate:15}</td>
							<td> 

								{if $message_templates[inst].message_type neq 'system'}
									{if $user->can_access('message_template', 'delete')}
										<a title="Delete Edit Message_template"  class="table-delete-link" href="/message_template/delete/{$message_templates[inst].id}"></a>&nbsp;&nbsp;
									{/if}
								{/if}
								{if $user->can_access('message_template', 'edit')}
									<a href="/message_template/edit/{$message_templates[inst].id}" title="Edit Message_template" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>

			</form>
			<br />

{else}
	No message_templates found!
{/if}


      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
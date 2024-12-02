{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/reference/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Reference Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Reference Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('reference', 'add')}
					<li><a href="/reference/add/">New Reference</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Reference Manager</h4>
        <div class="box-container">
		<form action="/reference/delete_selected" name="form_reference" id="form_reference" method="POST">
			{if $references}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>Reference</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$references}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$references[inst].id}]" /></td>
							<td class="col-second">
								{if $user->can_access('reference', 'edit')}
									<a href="/reference/edit/{$references[inst].id}">{$references[inst].reference}</a>
								{else}
									{$references[inst].reference}
								{/if}
							</td>
							<td> 
								{if $user->can_access('reference', 'delete')}
									<a title="Delete Edit Reference"  class="table-delete-link" href="/reference/delete/{$references[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('reference', 'edit')}
									<a href="/reference/edit/{$references[inst].id}" title="Edit Reference" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				{if $user->can_access('reference', 'delete_selected')}
					<input type="submit" class="submit" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='reference/index' current_page=$page total_rows=$total_references per_page=$per_page}
{else}
	No references found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
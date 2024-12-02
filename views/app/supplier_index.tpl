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

    <h3 class="green" style="width:100%;font-size:200%">Supplier Manager
		{if $user->can_access('supplier', 'add')}
			<a class="minibutton bblue right"href="/supplier/add/">New Supplier</a>
		{/if}
	</h3>

      
      <div id="mid-col" class="full-col" style="width:100%  !important"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Supplier Manager</h4>
        <div class="box-container">
		<form action="/supplier/delete_selected" name="form_supplier" id="form_supplier" method="POST">
			{if $suppliers}	
	      		<table class="table-long" style="width:100% !important">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>Supplier</td>
							<td>Description</td>
							<td>Bank</td>
							<td>Bank_acc</td>
							<td>Bank_branch</td>
							<td>Bank_branch_name</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$suppliers}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$suppliers[inst].id}]" /></td>
							<td class="col-second">
								{if $user->can_access('supplier', 'edit')}
									<a href="/supplier/edit/{$suppliers[inst].id}">{$suppliers[inst].supplier}</a>
								{else}
									{$suppliers[inst].supplier}
								{/if}
							</td>
							<td>{$suppliers[inst].description}</td>
							<td>{$suppliers[inst].bank}</td>
							<td>{$suppliers[inst].bank_acc}</td>
							<td>{$suppliers[inst].bank_branch}</td>
							<td>{$suppliers[inst].bank_branch_name}</td>
							<td> 
								{if $user->can_access('supplier', 'delete')}
									<a title="Delete Edit Supplier"  class="table-delete-link" href="/supplier/delete/{$suppliers[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('supplier', 'edit')}
									<a href="/supplier/edit/{$suppliers[inst].id}" title="Edit Supplier" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>				
				{if $user->can_access('supplier', 'delete_selected')}
                    <input type="submit" class="submit" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='supplier/index' current_page=$page total_rows=$total_suppliers per_page=$per_page}
{else}
	No suppliers found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
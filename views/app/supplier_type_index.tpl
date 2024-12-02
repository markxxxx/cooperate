{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/supplier_type/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Supplier type Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Supplier type Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('supplier_type', 'add')}
					<li><a href="/supplier_type/add/">New Supplier type</a></li>
				{/if}
              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Supplier type Manager</h4>
        <div class="box-container">
		<form action="/supplier_type/delete_selected" name="form_supplier_type" id="form_supplier_type" method="POST">
			{if $supplier_types}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Type</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$supplier_types}
						<tr {cycle values="class='odd',"}>
							<td>{$supplier_types[inst].type}</td>
							<td> 

								{if $user->can_access('supplier_type', 'edit')}
									<a href="/supplier_type/edit/{$supplier_types[inst].id}" title="Edit Supplier type" class="table-edit-link"></a>
								{/if}

								{if $user->can_access('supplier_type', 'delete')}
									<a href="/supplier_type/delete/{$supplier_types[inst].id}" title="Delete Supplier type" class="table-delete-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>

			</form>

			{pager url='supplier_type/index' current_page=$page total_rows=$total_supplier_types per_page=$per_page}
{else}
	No supplier types found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
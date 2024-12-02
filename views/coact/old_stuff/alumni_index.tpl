{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/alumni/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Alumni Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Alumni Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('alumni', 'add')}
					<li><a href="/alumni/add/">New Alumni</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Alumni Manager</h4>
        <div class="box-container">
		<form action="/alumni/delete_selected" name="form_alumni" id="form_alumni" method="POST">
			{if $alumni}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>User_id</td>
							<td>Work_for</td>
							<td>Hired_after</td>
							<td>Monthly_salary</td>
							<td>Have_contributed</td>
							<td>Contributed</td>
							<td>Have_contributed_moshal</td>
							<td>Contributed_moshal</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$alumni}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$alumni[inst].id}]" /></td>
							<td>{$alumni[inst].user_id}</td>

							<td>{$alumni[inst].work_for}</td>
							<td>{$alumni[inst].hired_after}</td>
							<td>{$alumni[inst].monthly_salary}</td>
							<td>{$alumni[inst].have_contributed}</td>
							<td>{$alumni[inst].contributed}</td>
							<td>{$alumni[inst].have_contributed_moshal}</td>
							<td>{$alumni[inst].contributed_moshal}</td>
							<td> 
								{if $user->can_access('alumni', 'delete')}
									<a title="Delete Edit Alumni"  class="table-delete-link" href="/alumni/delete/{$alumni[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('alumni', 'edit')}
									<a href="/alumni/edit/{$alumni[inst].id}" title="Edit Alumni" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				{if $user->can_access('alumni', 'delete_selected')}
					<input type="submit" class="button" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='alumni/index' current_page=$page total_rows=$total_alumni per_page=$per_page}
{else}
	No alumni found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
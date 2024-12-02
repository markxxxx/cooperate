{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/forum/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Forum Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Forum Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('forum', 'add')}
					<li><a href="/forum/add/">New Forum</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Forum Manager</h4>
        <div class="box-container">
		<form action="/forum/delete_selected" name="form_forum" id="form_forum" method="POST">
			{if $forums}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Id</td>
							<td>Forum</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$forums}
						<tr {cycle values="class='odd',"}>
							<td class="col-chk"><input type="checkbox" name="id[{$forums[inst].id}]" /></td>
							<td class="col-second">
								{if $user->can_access('forum', 'edit')}
									<a href="/forum/edit/{$forums[inst].id}">{$forums[inst].forum}</a>
								{else}
									{$forums[inst].forum}
								{/if}
							</td>
							<td> 
								{if $user->can_access('forum', 'delete')}
									<a title="Delete Edit Forum"  class="table-delete-link" href="/forum/delete/{$forums[inst].id}"></a>&nbsp;&nbsp;
								{/if}
								{if $user->can_access('forum', 'edit')}
									<a href="/forum/edit/{$forums[inst].id}" title="Edit Forum" class="table-edit-link"></a>
								{/if}
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>
				{if $user->can_access('forum', 'delete_selected')}
					<input type="submit" class="button" Value="Delete Seleted">
				{/if}
			</form>

			{pager url='forum/index' current_page=$page total_rows=$total_forums per_page=$per_page}
{else}
	No forums found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
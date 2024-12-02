{include file="header.tpl"}
{head}{literal}
	<script>
		$(document).ready(function(){
			$('.relation').change(function(){
				var element = $(this);
				var field = element.attr('id').split('_').shift();
				var id = element.attr('id').split('_').pop();
				$.get('/cron_job/update_'+field+'/'+id+'/'+element.val(), function(){
					element.css('color','red');
				});
			});
		});
	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>Cron job Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Cron_job Options</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->
              <ul class="list-links">
				{if $user->can_access('cron_job', 'add')}
					<li><a href="/cron_job/add/">New Cron_job</a></li>
				{/if}

              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Cron job Manager</h4>
        <div class="box-container">
		<form action="/cron_job/delete_selected" name="form_cron_job" id="form_cron_job" method="POST">
			{if $cron_jobs}	
	      		<table class="table-long">
	      			<thead>
	      				<tr>
							<td>Job</td>
							<td>Last run</td>
							<td>Description</td>
							<td>Frequency</td>
							<td>Options</td>
	      				</tr>
	      			</thead>

	      			<tbody>
					{section name=inst loop=$cron_jobs}
						<tr {cycle values="class='odd',"}>
							<td>{$cron_jobs[inst].job}</td>
							<td>{$cron_jobs[inst].last_run|time_since}</td>
							<td>{$cron_jobs[inst].description}</td>
							<td>{$cron_jobs[inst].duration|seconds_to_time}</td>
							<td> 
								{if $user->can_access('cron_job', 'edit')}
									<a href="/cron_job/edit/{$cron_jobs[inst].id}" title="Edit Cron_job" class="table-edit-link"></a>
								{/if}

								<a href="/cron/run/{$cron_jobs[inst].job}" title="Run Cron job" >
									<img src="/views/app/images/paly.png"/>

								</a>
								
							</td>
						</tr>
					{/section}
	      			</tbody>
	      		</table>

			</form>

			{pager url='cron_job/index' current_page=$page total_rows=$total_cron_jobs per_page=$per_page}
{else}
	No cron_jobs found!
{/if}
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
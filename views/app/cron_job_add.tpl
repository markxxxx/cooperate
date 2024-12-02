{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Cron_job Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Cron_job Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('cron_job', 'index')}
					<li><a href="/cron_job/index/">View Cron_jobs</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Cron_job Manager</h4>
        <div class="box-container">
		<form action="/cron_job/add/{$data.id|default:0}" method="post" name="form_cron_job" enctype="multipart/form-data" class="middle-forms" id="form_cron_job">
			<h3>{if $cron_job.id|default:0 eq 0}Create a new{else}Update current{/if} Cron_job</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $cron_job.id|default:0 eq 0}Create a new{else}Update current{/if} Cron_job</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_job">Job:</label>
						<label><input name="data[job]" type="text" class="element text small" id="field_job" value="{$data.job}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=job}
					</li>

					<li class='even'>
						<label class="field-title" for="field_description">Description:</label>
						<label><textarea id="wysiwyg" rows="7" cols="25" name="data[description]" rows="5">{$data.description}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=description}
					</li>
					<li >
						<label class="field-title" for="field_duration">Duration:</label>
						<label><input name="data[duration]" type="text" class="element text small" id="field_duration" value="{$data.duration}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=duration}
					</li>

				</ol>
			</fieldset>
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
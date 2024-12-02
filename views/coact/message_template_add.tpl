{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Template Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Template Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('message_template', 'index')}
					<li><a href="/message_template/index/">View Templates</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Template Manager</h4>
        <div class="box-container">
		<form action="/message_template/add/{$data.id|default:0}" method="post" name="form_message_template" enctype="multipart/form-data" class="middle-forms" id="form_message_template">
			<h3>{if $message_template.id|default:0 eq 0}Create a new{else}Update current{/if} template</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $message_template.id|default:0 eq 0}Create a new{else}Update current{/if} template</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_name">Name:</label>
						<label><input name="data[name]" type="text" class="element text large" id="field_name" value="{$data.name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=name}
					</li>
					<li >
						<label class="field-title" for="field_title">Title:</label>
						<label><input name="data[title]" type="text" class="element text large" id="field_title" value="{$data.title}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=title}
					</li>
					<li class='even'>
						<label class="field-title" for="field_message">Message:</label>
						<label><textarea id="wysiwyg" rows="7" cols="25" name="data[message]" rows="5">{$data.message}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=message}
					</li>

				</ol>
			</fieldset>
			<br /><br />
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
			<br />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
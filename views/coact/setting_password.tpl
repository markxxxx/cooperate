{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Email settings</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Setting Options</h4>
          <div class="box-container">
              <ul class="list-links">
				
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Setting Manager</h4>
        <div class="box-container">
		<form action="/setting/add/{$data.id|default:0}" method="post" name="form_setting" enctype="multipart/form-data" class="middle-forms" id="form_setting">
			<h3>{if $setting.id|default:0 eq 0}Create a new{else}Update current{/if} Setting</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $setting.id|default:0 eq 0}Create a new{else}Update current{/if} Setting</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_imap_server">Imap_server:</label>
						<label><input name="data[imap_server]" type="text" class="element text small" id="field_imap_server" value="{$data.imap_server}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=imap_server}
					</li>
					<li >
						<label class="field-title" for="field_email">Email:</label>
						<label><input name="data[email]" type="text" class="element text small" id="field_email" value="{$data.email}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=email}
					</li>
					<li class='even'>
						<label class="field-title" for="field_password">Password:</label>
						<label><input name="data[password]" type="text" class="element text small" id="field_password" value="{$data.password}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=password}
					</li>


					<b>To save these settings, please enter your password.</b>
					<li class='even'>
						<label class="field-title" for="field_password">Password:</label>
						<label><input name="data[password]" type="text" class="element text small" id="field_password" value="{$data.password}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=password}
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
{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Reference Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Reference Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('reference', 'index')}
					<li><a href="/reference/index/">View References</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Reference Manager</h4>
        <div class="box-container">
		<form action="/reference/add/{$data.id|default:0}" method="post" name="form_reference" enctype="multipart/form-data" class="middle-forms" id="form_reference">
			<h3>{if $reference.id|default:0 eq 0}Create a new{else}Update current{/if} Reference</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $reference.id|default:0 eq 0}Create a new{else}Update current{/if} Reference</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_reference">Reference:</label>
						<label><input name="data[reference]" type="text" class="element text large" id="field_reference" value="{$data.reference}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=reference}
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
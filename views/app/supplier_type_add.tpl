{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Supplier type Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Supplier type Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('supplier_type', 'index')}
					<li><a href="/supplier_type/index/">View Supplier types</a></li>
				{/if}
              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Supplier type Manager</h4>
        <div class="box-container">
		<form action="/supplier_type/add/{$data.id|default:0}" method="post" name="form_supplier_type" enctype="multipart/form-data" class="middle-forms" id="form_supplier_type">
			<h3>{if $supplier_type.id|default:0 eq 0}Create a new{else}Update current{/if} Supplier type</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $supplier_type.id|default:0 eq 0}Create a new{else}Update current{/if} Supplier type</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_type">Type:</label>
						<label><input name="data[type]" type="text" class="element text large" id="field_type" value="{$data.type}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=type}
					</li>

				</ol>
			</fieldset>

			<br /><br />
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
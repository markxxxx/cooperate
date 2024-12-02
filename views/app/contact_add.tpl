{include file="header.tpl"}
{head}
<style type="text/css">
	{literal}
	#contact li {
		float:left;
		width:320px;
		height: 40px;
	}
	{/literal}

</style>
{/head}

<div id="content">
	<div id="content-top">
    <h2>Contact Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Contact Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('contact', 'index')}
					<li><a href="/contact/index/">View Contacts</a></li>
				{/if}
				{if $user->can_access('supplier', 'add')}
					<li><a href="/supplier/add/">New Supplier</a></li>
				{/if}
				{if $user->can_access('supplier', 'index')}
					<li><a href="/supplier/add/">View Suppliers</a></li>
				{/if}
				{if $user->can_access('domain', 'add')}
					<li><a href="/domain/add/">New Domain</a></li>
				{/if}
				{if $user->can_access('domain', 'index')}
					<li><a href="/domain/add/">View Domains</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Contact Manager</h4>
        <div class="box-container">
		<form action="/contact/add/{$data.id|default:0}" method="post" name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">
			<h3>{if $contact.id|default:0 eq 0}Create a new{else}Update current{/if} Contact</h3>


						<label class="field-title" for="field_contact_type">Contact type:</label>

						<ul class="checklist" style="width:98%;margin-top:5px;padding:8px;height:40px">

							{section name=inst loop=$contact_type}

								<li style="float:left; margin-right:15px;width:150px">
									<label for="ck_domain2_{$contact_type[inst]}"><input
									{if in_array($contact_type[inst], $smarty.post.contact_types)} checked {/if}
									 type="checkbox"  name="contact_types[]" value="{$contact_type[inst]}" id="ck_domain2_{$contact_type[inst]}"/>{$contact_type[inst]}</label>
									
									
								</li>
							{/section}
						</ul>
						{error field=contact_type}



			<fieldset>
				<legend>{if $contact.id|default:0 eq 0}Create a new{else}Update current{/if} Contact</legend>


				<ol id="contact">

					<li class='even left'>
						<label class="field-title" for="field_name">Full name:</label>
						<label><input name="data[name]" type="text" class="element text large" id="field_name" value="{$data.name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=name}
					</li>
					<li class='even'>
						<label class="field-title" for="field_email">Email:</label>
						<label><input name="data[email]" type="text" class="element text large" id="field_email" value="{$data.email}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=email}
					</li>

					<li >
						<label class="field-title" for="field_mobile">Mobile number:</label>
						<label><input name="data[mobile]" type="text" class="element text large" id="field_mobile" value="{$data.mobile}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=mobile}
					</li>

					<li >
						<label class="field-title" for="field_mobile">Work number:</label>
						<label><input name="data[office]" type="text" class="element text large" id="field_mobile" value="{$data.office}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=office}
					</li>
					<li class='even'>
						<label class="field-title" for="field_website">Website:</label>
						<label><input name="data[website]" type="text" class="element text large" id="field_website" value="{$data.website}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=website}
					</li>

					<li class='even'>
						<label class="field-title" for="field_supplier_id">Supplier:</label>
						<label>
						<select name=data[supplier_id] id="field_supplier_id" style="width:100px;">
							<option value=''>Select supplier:</option>
							{section name=inst loop=$suppliers}
								<option value="{$suppliers[inst].id}" {if $data.supplier_id eq $suppliers[inst].id}selected{/if}>{$suppliers[inst].supplier}</option>
							{/section}
						</select>
						</label>
						{error field=supplier_id}
					</li>
					<li >
						<label class="field-title" for="field_domain_id">Domain:</label>
						<label>
						<select name=data[domain_id] id="field_domain_id">
							<option value=''>Select domain:</option>
							{section name=inst loop=$domains}
								<option value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
							{/section}
						</select>
						</label>
						{error field=domain_id}
					</li>

				</ol>
			</fieldset>
				<br />
				<b>Description:</b><br /><Br />
				<label><textarea id="wysiwyg" rows="7" cols="25" name="data[description]" rows="5" style="width:680px">{$data.description}</textarea></label>
				<span class="clearFix">&nbsp;</span>
				{error field=description}
				<Br />
				<input type="submit" name="save" class="minibutton  bblue" value="Update details"  />
				<div class="clear"></div>
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
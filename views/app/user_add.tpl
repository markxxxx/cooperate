{include file="header.tpl"}

{head}{literal}
<script>
    $(document).ready(function(){
    
        $('#field_group_id').change(function(){
 			$.getJSON('/group/is_admin/'+$(this).val(), function(data){
 				if(data.is_admin) {
 					$('#admin_domains').show();
 					$('#is_admin').val('1');
 				} else { 
 					$('#admin_domains').hide();
 					$('#is_admin').val('0');
 				}
 			});
        });
        
    });
</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">
    <h2>User Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">User Options</h4>
          <div class="box-container">
              <ul class="list-links">
                {if $method eq 'edit'}
                    {if $user->can_access('user', 'add')}
                        <li><a href="/user/add/">New User</a></li>
                    {/if}
                {/if}
				{if $user->can_access('user', 'index')}
					<li><a href="/user/index/">View Users</a></li>
				{/if}
				{if $user->can_access('domain', 'add')}
					<li><a href="/domain/add/">New Domain</a></li>
				{/if}
				{if $user->can_access('domain', 'index')}
					<li><a href="/domain/index/">View Domains</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">User Manager</h4>
        <div class="box-container">
		<form action="/user/{$method}/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
			<input type="hidden" name="is_admin" value="{$is_admin}" id ="is_admin"/>
			<h3>{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} User</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} User</legend>
				<ol>
					<li  class='even' >
						<label class="field-title" for="field_group_id">Group:</label>
						<label>
						<select name="data[group_id]" id="field_group_id">
							<option value=''>Select group:</option>
							{section name=inst loop=$groups}
                                {if $groups[inst].id neq 0}
								    <option value="{$groups[inst].id}" {if $data.group_id eq $groups[inst].id}selected{/if}>{$groups[inst].name}</option>
                                {/if}
							{/section}
						</select>
						</label>
						<span class="clearFix">&nbsp;</span>

						{error field=group_id}
					</li>
					<li>
						<label class="field-title" for="field_email">Email:</label>
						<label><input name="data[email]" type="text" class="element text large" id="field_email" value="{$data.email}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=email}
					</li>

					<li class='even'>
						<label class="field-title" for="field_name">Name:</label>
						<label><input name="data[name]" type="text" class="element text large" id="field_name" value="{$data.name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=name}
					</li>
					<li >
						<label class="field-title" for="field_surname">Surname:</label>
						<label><input name="data[surname]" type="text" class="element text large" id="field_surname" value="{$data.surname}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=surname}
					</li>
					{**
					<li  class='even'>
						<label class="field-title" for="field_admin">Admin:</label>
						<label><input name="data[admin]" type="checkbox" {if $data.admin|default:0 eq 1}checked{/if} id="field_admin" value="{$data.admin}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=admin}
					</li>
					**}
					<li class='even'>
						<label class="field-title" for="field_domain_id">Primary domain:</label>
						<label>
						<select name="data[domain_id]" id="field_domain_id">
							<option value=''>Select domain:</option>
							{section name=inst loop=$domains}
								<option value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
							{/section}
						</select>
						</label>
                        <span class="clearFix">&nbsp;</span>
						{error field=domain_id}
					</li>
                        <li  {if $is_admin neq 1} style="display:none" {/if} id="admin_domains">
                            <label class="field-title" for="field_domain_id">Administrator domains:</label>
                            <label>
                                <ul class="checklist">
                                {section name=inst loop=$domains}
                                    <li><label for="ck_domain_{$domains[inst].id}"><input type="checkbox" {if in_array($domains[inst].id, $current_domains)} checked {/if} name="domains[]" value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}"/>{$domains[inst].domain}</label></li>
                                {/section}
                                </ul>
                            </label>
                            <span class="clearFix">&nbsp;</span>
                        </li>


				</ol>
			</fieldset>
			<br /><Br />
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
{include file="header.tpl"}
{head}
	{literal}
	<style>
		.field-title {width:250px !important;}
	</style>
	{/literal}
{/head}
<div id="content">
	<div id="content-top">
    <h2>Group Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Group Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('group', 'index')}
					<li><a href="/group/index/">View Groups</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Group Manager</h4>
        <div class="box-container">
		<form action="/group/{$method}/{$data.id|default:0}" method="post" name="form_group" enctype="multipart/form-data" class="middle-forms" id="form_group">
			<h3>{if $group.id|default:0 eq 0}Create a new{else}Update current{/if} Group</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $group.id|default:0 eq 0}Create a new{else}Update current{/if} Group</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_name">Name:</label>
						<label><input name="data[name]" type="text" class="element text large" id="field_name" value="{$data.name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=name}
					</li>
					<li >
						<label class="field-title" for="field_description">Description:</label>
						<label><textarea id="wysiwyg" rows="7" cols="25" name="data[description]" rows="5">{$data.description}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=description}
					</li>
					<li class='even'>
						<label class="field-title" for="field_account">Account:</label>
						<label>{cfield field=account value=$data.account|default:''}</label>
						<span class="clearFix">&nbsp;</span>

						{error field=account}
					</li>
					<li>
						<li>
                            <label class="field-title" for="field_domain_id">This group's users will beable to create/manage user who are grouped in:</label>
                            <label>
                                <ul class="checklist">
                                {section name=inst loop=$group_priority}
                                    <li><label for="ck_domain_{$group_priority[inst].id}"><input type="checkbox" {if in_array($group_priority[inst].id, $current_priorities)} checked {/if} name="priorities[]" value="{$group_priority[inst].id}" id="ck_domain_{$group_priority[inst].id}"/>{$group_priority[inst].name}</label></li>
                                {/section}
                                </ul>
                            </label>
                            <span class="clearFix">&nbsp;</span>
                        </li>
					</li>
					<li >
						<label class="field-title" for="field_approve_changes">Is alumni:</label>
						<label><input name="data[is_alumni]" type="checkbox" {if $data.is_alumni|default:0 eq 1}checked{/if} id="field_admin" value="{$data.is_alumni}" /></label>
						<span class="clearFix">&nbsp;</span>
					</li>
					<li >
						<label class="field-title" for="field_approve_changes">Approve bursar account/supplier changes:</label>
						<label><input name="data[approve_changes]" type="checkbox" {if $data.approve_changes|default:0 eq 1}checked{/if} id="field_admin" value="{$data.approve_changes}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=approve_changes}
					</li>
					<li class='even'>
						<label class="field-title" for="field_approve_payments">Approve payments:</label>
							<label><input name="data[approve_payments]" type="checkbox" {if $data.approve_payments|default:0 eq 1}checked{/if} id="field_admin" value="{$data.approve_payments}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=approve_payments}
					</li>
					<li >
						<label class="field-title" for="field_message_notification">Email message notification:</label>
						<label><input name="data[message_notification]" type="checkbox" {if $data.message_notification|default:0 eq 1}checked{/if} id="field_admin" value="{$data.message_notification}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=message_notification}
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
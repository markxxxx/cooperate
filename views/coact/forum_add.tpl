{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Forum Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Forum Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('forum', 'index')}
					<li><a href="/forum/index/">View Forums</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Forum Manager</h4>
        <div class="box-container">
        	{if !count($domains)}
				<b> All domains have been assigned a forum! </b>
		 </div>
				      
      </div> 
			{else}
		<form action="/forum/add/{$data.id|default:0}" method="post" name="form_forum" enctype="multipart/form-data" class="middle-forms" id="form_forum">
			
			

			
			<h3>{if $forum.id|default:0 eq 0}Create a new{else}Update current{/if} Forum</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			

			
			<fieldset>
				<legend>{if $forum.id|default:0 eq 0}Create a new{else}Update current{/if} Forum</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_forum">Forum:</label>
						<label><input name="data[forum]" type="text" class="element text large" id="field_forum" value="{$data.forum}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=forum}
					</li>
					<li class='even' >
                            <label class="field-title" for="field_domain_id">Administrator domains:</label>
                            <label>
                                <ul class="checklist">
                                {section name=inst loop=$domains}
                                    <li><label for="ck_domain_{$domains[inst].id}"><input type="checkbox" {if in_array($domains[inst].id, $current_domains)} checked {/if} name="domains[]" value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}">{$domains[inst].domain}</label></li>
                                {/section}
                                </ul>
                            </label>
                            <span class="clearFix">&nbsp;</span>
                            {error field=domain}
                        </li>
                      
				</ol>
			</fieldset>
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
		
      {/if}
		
      	</div>
      		
      	</div> 
      
      </div> 
 
      <span class="clearFix">&nbsp;</span>
      
{include file="footer.tpl"}
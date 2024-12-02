{ldelim}include file="header.tpl"{rdelim}

<div id="content">
	<div id="content-top">
    <h2>{$meta.class} Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">{$meta.class} Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{literal}{if $user->can_access({/literal}'{$meta.lower}'{literal}, 'index')}{/literal}
					<li><a href="/{$meta.lower}/index/">View {$meta.table|ucfirst}</a></li>
				{literal}{/if}{/literal}
{section name=inst loop=$relations}
				{literal}{if $user->can_access({/literal}'{$relations[inst].lower}'{literal}, 'add')}{/literal}
					<li><a href="/{$relations[inst].lower}/add/">New {$relations[inst].class}</a></li>
				{literal}{/if}{/literal}
				{literal}{if $user->can_access({/literal}'{$relations[inst].lower}'{literal}, 'index')}{/literal}
					<li><a href="/{$relations[inst].lower}/add/">View {$relations[inst].table|ucfirst}</a></li>
				{literal}{/if}{/literal}
{/section}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">{$meta.class} Manager</h4>
        <div class="box-container">
		<form action="/{$meta.lower}/add/{ldelim}$data.id|default:0{rdelim}" method="post" name="form_{$meta.lower}" enctype="multipart/form-data" class="middle-forms" id="form_{$meta.lower}">
			<h3>{ldelim}if ${$meta.lower}.id|default:0 eq 0{rdelim}Create a new{ldelim}else{rdelim}Update current{ldelim}/if{rdelim} {$meta.class}</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{ldelim}if ${$meta.lower}.id|default:0 eq 0{rdelim}Create a new{ldelim}else{rdelim}Update current{ldelim}/if{rdelim} {$meta.class}</legend>
				<ol>
{section name=inst loop=$tablestructure}
{if $tablestructure[inst].Field neq 'id' AND $tablestructure[inst].Field neq 'created_on' AND $tablestructure[inst].Field neq 'modified_on' AND !strpos($tablestructure[inst].Field,'_id')}
					<li {cycle name="tr" values="class='even',"}>
						<label class="field-title" for="field_{$tablestructure[inst].Field}">{$tablestructure[inst].Field|ucfirst}:</label>
{if $tablestructure[inst].Field eq 'image'}
						<label><input type='file' name="uploadedfile" value='Browse'></label>
						{ldelim}if $data.image|@strlen{rdelim}
							{ldelim}image src="media/{$meta.table}/`$data.image`" width="60"{rdelim}
						{ldelim}/if{rdelim}
{elseif $tablestructure[inst].Type eq 'varchar'}
						<label><input name="data[{$tablestructure[inst].Field}]" type="text" class="element text large" id="field_{$tablestructure[inst].Field}" value="{ldelim}$data.{$tablestructure[inst].Field}{rdelim}" /></label>
{elseif $tablestructure[inst].Type eq 'int'}
						<label><input name="data[{$tablestructure[inst].Field}]" type="text" class="element text small" id="field_{$tablestructure[inst].Field}" value="{ldelim}$data.{$tablestructure[inst].Field}{rdelim}" /></label>
{elseif $tablestructure[inst].Type eq 'text'}
						<label><textarea id="wysiwyg" rows="7" cols="25" name="data[{$tablestructure[inst].Field}]" rows="5">{ldelim}$data.{$tablestructure[inst].Field}{rdelim}</textarea></label>
{/if}
						<span class="clearFix">&nbsp;</span>
						{ldelim}error field={$tablestructure[inst].Field}{rdelim}
					</li>
{/if}
{/section}
{section name=inst2 loop=$relations}
					<li {cycle name="tr" values="class='even',"}>
						<label class="field-title" for="field_{$relations[inst2].lower}_id">{$relations[inst2].class}:</label>
						<label>
						<select name=data[{$relations[inst2].lower}_id] id="field_{$relations[inst2].lower}_id">
							<option value=''>Select {$relations[inst2].lower}:</option>
							{ldelim}section name=inst loop=${$relations[inst2].table}{rdelim}
								<option value="{ldelim}${$relations[inst2].table}[inst].id{rdelim}" {ldelim}if $data.{$relations[inst2].lower}_id eq ${$relations[inst2].table}[inst].id{rdelim}selected{ldelim}/if{rdelim}>{ldelim}${$relations[inst2].table}[inst].{$relations[inst2].display}{rdelim}</option>
							{ldelim}/section{rdelim}
						</select>
						</label>
						{ldelim}error field={$relations[inst2].lower}{rdelim}
					</li>
{/section}

				</ol>
			</fieldset>
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{ldelim}include file="footer.tpl"{rdelim}
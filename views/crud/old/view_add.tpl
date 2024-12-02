{ldelim}include file="header.tpl"{rdelim}
<h2>{ldelim}if ${$meta.lower}.id|default:0 eq 0{rdelim}Create a new{ldelim}else{rdelim}Update current{ldelim}/if{rdelim} {$meta.class}</h2>

<form action="/admin/{$meta.lower}/add/{ldelim}$data.id|default:0{rdelim}" method="post" name="form_{$meta.lower}" enctype="multipart/form-data" class="appnitro" id="form_{$meta.lower}">
	<fieldset>
	<legend>{$meta.class} Infomation</legend>
		<ul>
{section name=inst loop=$tablestructure}
{if $tablestructure[inst].Field neq 'id' AND $tablestructure[inst].Field neq 'created_on' AND $tablestructure[inst].Field neq 'modified_on' AND !strpos($tablestructure[inst].Field,'_id')}
			<li {ldelim}cycle name="tr" values="class='even',"{rdelim}>
				<label for="field_{$tablestructure[inst].Field}">{$tablestructure[inst].Field|ucfirst}:</label>
{if $tablestructure[inst].Field eq 'image'}
				<input type='file' name="uploadedfile" value='Browse'>
				{ldelim}if $data.image|@strlen{rdelim}
					{ldelim}image src="media/{$meta.table}/`$data.image`" width="60"{rdelim}
				{ldelim}/if{rdelim}
{elseif $tablestructure[inst].Type eq 'varchar'}
				<input name="data[{$tablestructure[inst].Field}]" type="text" class="element text large" id="field_{$tablestructure[inst].Field}" value="{ldelim}$data.{$tablestructure[inst].Field}{rdelim}" />
{elseif $tablestructure[inst].Type eq 'int'}
				<input name="data[{$tablestructure[inst].Field}]" type="text" class="element text small" id="field_{$tablestructure[inst].Field}" value="{ldelim}$data.{$tablestructure[inst].Field}{rdelim}" />
{elseif $tablestructure[inst].Type eq 'text'}
				<textarea cols="35" id="field_{$tablestructure[inst].Field}" name="data[{$tablestructure[inst].Field}]" rows="5">{ldelim}$data.{$tablestructure[inst].Field}{rdelim}</textarea>
{/if}
				{ldelim}error field={$tablestructure[inst].Field}{rdelim}
			</li>
{/if}
{/section}
{section name=inst2 loop=$relations}
			<li {ldelim}cycle name="tr" values="class='even',"{rdelim}>
				<label for="field_{$relations[inst2].lower}_id">{$relations[inst2].class}:</label>
				<select name=data[{$relations[inst2].lower}_id] id="field_{$relations[inst2].lower}_id">
					<option value=''>Select {$relations[inst2].lower}:</option>
					{ldelim}section name=inst loop=${$relations[inst2].table}{rdelim}
						<option value="{ldelim}${$relations[inst2].table}[inst].id{rdelim}" {ldelim}if $data.{$relations[inst2].lower}_id eq ${$relations[inst2].table}[inst].id{rdelim}selected{ldelim}/if{rdelim}>{ldelim}${$relations[inst2].table}[inst].{$relations[inst2].display}{rdelim}</option>
					{ldelim}/section{rdelim}
				</select>
				<p class="error_small">{ldelim}error field={$relations[inst2].lower}{rdelim}</p>
			</li>
{/section}
			<li class="buttons">
				<div class="buttons">
					<button type="submit" name="save" class="positive">
					<img src="/views/admin/images/icons/user.gif" alt="Save" />
						{ldelim}if ${$meta.lower}.id|default:0 eq 0{rdelim}Create{ldelim}else{rdelim}Update{ldelim}/if{rdelim} {$meta.class}
					</button>
				</div>
			</li>
		</ul>
	</fieldset>
</div>
</form>

          </div><!-- end of div.box-container -->            
          </div><!-- end of div.box -->            
      </div><!-- end of div#right-col -->     
      
      <span class="clearFix">&nbsp;</span>     
</div><!-- end of div#content -->

{ldelim}include file="footer.tpl"{rdelim}
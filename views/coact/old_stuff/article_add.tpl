{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Article Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
			{include file="profile_menu.tpl"}
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Articles Manager</h4>
        <div class="box-container">
		<form action="/article/add/{$data.id|default:0}" method="post" name="form_article" enctype="multipart/form-data" class="middle-forms" id="form_article">
			<h3>{if $article.id|default:0 eq 0}Create a new{else}Update current{/if} Article Record</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $article.id|default:0 eq 0}Create a new{else}Update current{/if} Article</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_company">Name of company signed with:</label>
						<label><input name="data[company]" type="text" class="element text large" id="field_company" value="{$data.company}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=company}
					</li>
					<li >
						<label class="field-title" for="field_agreement">Have you signed a final agreement:</label>
						<label>{cfield field=agreement value=$data.agreement}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=agreement}
					</li>

					<li >
						<label class="field-title" for="field_agreement">Brief job description:</label>
						<label><textarea name="data[description]">{$data.description}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=description}
					</li>

					

					<li class='even'>
						<label class="field-title" for="field_contact_name">Contant name:</label>
						<label><input name="data[contact_name]" type="text" class="element text large" id="field_contact_name" value="{$data.contact_name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=contact_name}
					</li>
					<li >
						<label class="field-title" for="field_contact_number">Contact number:</label>
						<label><input name="data[contact_number]" type="text" class="element text large" id="field_contact_number" value="{$data.contact_number}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=contact_number}
					</li>
					<li class='even'>
						<label class="field-title" for="field_year_to_start">Year to start:</label>
						<label>{html_select_date start_year=2012 end_year=2020 field_array=dob time=$data.year_to_start display_days=false  
    display_months=false}
						{error field=year_to_start}
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
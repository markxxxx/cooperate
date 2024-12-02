{include file="header.tpl"}

{head}
<style>
{literal}
.wysiwygIFrame {
	width:100% !important;
}
{/literal}
</style>

{/head}

<div id="content">
	<div id="content-top">
    <h2>Letter Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
              <ul class="list-links">
				{include file="profile_menu.tpl"}

              </ul>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Letter to Martin</h4>
        <div class="box-container">
		<form action="/letter/add/{$data.id|default:0}" method="post" name="form_letter" enctype="multipart/form-data" class="middle-forms" id="form_letter">
			<h3>Please submit your annual letter to Martin: {$smarty.now|date_format:"%Y"}</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend></legend>
				<ol>
					<li class='even'>
						<label style="width:95%"><textarea id="wysiwyg" rows="10" cols="25" style="width:100%" name="data[letter]" rows="5">{$data.letter}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=letter}
					</li>



				</ol>
			</fieldset>
			<br />
			<input type="submit" class="minibutton" value="Save"/>
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
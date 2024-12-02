{include file="header.tpl"}

{head}
{literal}
	<style>
		form.middle-forms fieldset ol li label.field-title {width:200px;}
	</style>

	<script>
		$(function(){
			$('#field-have_contributed').change(function(){
				if($(this).val() == 'Yes') {
					$('#contribution').show();
				} else {
					$('#contribution').hide();
				}

			});

			$('#field-have_contributed_moshal').change(function(){
				if($(this).val() == 'Yes') {
					$('#contribution2').show();
				} else {
					$('#contribution2').hide();
				}
			});

			$('#field-are_you_working').change(function(){
				if($(this).val() == 'Yes') {
					$('.workings').show('slow');
				} else {
					$('.workings').hide();
				}
			});


		});
	</script>

{/literal}
{/head}

<div id="content">
	<div id="content-top">
    <h2>Alumni Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
        {include file="profile_menu.tpl"}
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Alumni Manager</h4>
        <div class="box-container">
		<form action="/alumni/add/{$data.id|default:0}" method="post" name="form_alumni" enctype="multipart/form-data" class="middle-forms" id="form_alumni">
			<h3>Alumni</h3>

			<fieldset>
				<legend>Alumni details</legend>
				<ol>

					<li class="even">
						<label class="field-title " for="field_work_for">When did you graduate:</label>
						<label>{html_select_date start_year=2000 display_days=false field_array=graduation_date time=$data.graduation_date}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=graduation_date}
					</li>


					<li>
						<label class="field-title" for="field_work_for">Are you working:</label>
						<label>{cfield field="are_you_working" value=$data.are_you_working}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=are_you_working}
					</li>


					<li class='even {if $data.are_you_working neq 'Yes'} workings hidden {/if}' >
						<label class="field-title" for="field_work_for">What organisation do you work for:</label>
						<label><input name="data[work_for]" type="text" class="element text large" id="field_work_for" value="{$data.work_for}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=work_for}
					</li>
					<li class="{if $data.are_you_working neq 'Yes'} workings hidden {/if}">
						<label class="field-title" for="field_hired_after">How long did it take you to get the job after graduating:</label>
						<label>{cfield field="hired_after" value=$data.hired_after}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=hired_after}
					</li>
					<li class='even {if $data.are_you_working neq 'Yes'} workings hidden {/if}'>
						<label class="field-title" for="field_monthly_salary">Monthly salary:</label>
						{cfield field="monthly_salary" value=$data.monthly_salary}
						<span class="clearFix">&nbsp;</span>
						{error field=monthly_salary}
					</li>
					<li class="{if $data.are_you_working neq 'Yes'} workings hidden {/if}">
						<label class="field-title" for="field_have_contributed">Have you contributed to the Moshal Scholarship Program or to a charity:</label>
						<label>{cfield field="have_contributed" value=$data.have_contributed}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=have_contributed}
					</li>
					<li class='even {if $data.have_contributed neq 'Yes'}  hidden {/if}'  id='contribution'>
						<label class="field-title" for="field_contributed">Contribution details?</label>
						<label><textarea id="wysiwyg" rows="7" cols="25" name="data[contributed]" rows="5">{$data.contributed}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=contributed}
					</li>

					<li class='even {if $data.have_contributed_moshal neq 'Yes'} hidden {/if} ' id='contribution2'>
						<label class="field-title" for="field_contributed_moshal">What have you contributed to moshal?</label>
						<label><textarea  id="wysiwyg" rows="7" cols="25" name="data[contributed_moshal]" rows="5">{$data.contributed_moshal}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=contributed_moshal}
					</li>

				</ol>
			</fieldset>
			<br /><br />
			<input type="submit" class="minibutton" value="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
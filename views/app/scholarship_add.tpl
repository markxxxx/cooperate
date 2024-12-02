{include file="header.tpl"}

{head}
{literal}
	<script type="text/javascript">
		$(function(){
			
			$('#field-postgrad').change(function(){
				if($(this).val() == 'Yes') {
					$('.grad_fields').show();
				} else {
					$('.grad_fields').hide();
				}
			});

			$('#field-residence').change(function(){
				if($(this).val() == 'Other') {
					$('#residence_other').show();
				} else {
					$('#residence_other').hide();
				}			
			});


		});
	</script>
{/literal}
{/head}


<div id="content">
	<div id="content-top">
    <h2>Scholarship Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
			{include file="profile_menu.tpl"}
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Scholarship Manager</h4>
        <div class="box-container">
		<form action="/scholarship/add/{$data.id|default:0}" method="post" name="form_scholarship" enctype="multipart/form-data" class="middle-forms" id="form_scholarship">
			<h3>Scholarship Details</h3>
            {if $invalid|default:0 eq '1'}
                <div class="error">Could not save your Scholarship infomation. Please make sure all fields are filled out correctly</div>
            {/if}
			<fieldset>
				<legend>{if $scholarship.id|default:0 eq 0}Create a new{else}Update current{/if} Scholarship</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_student_number">Student number:</label>
						<label><input name="data[student_number]" type="text" class="element text large" id="field_student_number" value="{$data.student_number}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=student_number}
					</li>
					<li >
						<label class="field-title" for="field_award_date">First year of scholarship:</label>
						<label>{html_select_date start_year=2000 display_days=false field_array=award_date time=$data.award_date}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=award_date}
					</li>
					<li class='even'>
						<label class="field-title" for="field_year_of_study">Study Year:</label>
						<label>{cfield field=year_of_study display_days=false value=$data.year_of_study}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=year_of_study}
					</li>
					
					<!-- <li>
						<label class="field-title" for="field_grad_date">Expected Graduation date:</label>
						<label>{html_select_date start_year=2000 end_year=2030 display_days=false field_array=grad_date time=$data.grad_date}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=grad_date}
					</li> -->

					<li class='even'>
						<label class="field-title " for="field_grad_date">Are you currently studying a postgraduate degree:</label>
						<label>
							{cfield field=postgrad value=$data.postgrad}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=postgrad}
					</li>

					<!-- <li class="grad_fields {if $data.postgrad neq 'Yes'} hidden {/if}">
						<label class="field-title " for="field_grad_date">Expected Post Graduation date:</label>
						<label>
							{html_select_date start_year=2000 end_year=2020 field_array=postgrad_date time=$data.postgrad_date}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=postgrad_date}
					</li> -->

					<li class="grad_fields {if $data.postgrad neq 'Yes'} hidden {/if}">
						<label class="field-title" for="field_grad_date"> Are you studying part-time/full-time:</label>
						<label>
							{cfield field=postgrad_type value=$data.postgrad_type}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=postgrad_type}
					</li>

					{**
					<li class='even '>
						<label class="field-title" for="field_years_to_complete">Years to complete:</label>
						<label>{cfield field=years_to_complete value=$data.years_to_complete}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=years_to_complete}
					</li>
					**}
					<li >
						<label class="field-title" for="field_residence">Accommodation:</label>
						<label>{cfield field=residence value=$data.residence}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=residence}
					</li>

					<li id="residence_other" {if $data.residence neq 'Other'} style="display:none;" {/if}>
						<label class="field-title" for="field_residence">Accommodation other:</label>
						<label><input name="data[residence_other]" type="text" class="element text large" id="field_degree" value="{$data.residence_other}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=residence_other}
					</li>

					<li >
						<label class="field-title" for="field_discipline">Your Faculty:</label>
						<label>{cfield field=discipline value=$data.discipline}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=discipline}
					</li>

					<li class='even'>
						<label class="field-title" for="field_discipline">Your profession:</label>
						<label>{cfield field=profession value=$data.profession}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=profession}
					</li>
					<li >
						<label class="field-title" for="field_degree">Your Degree:</label>
						<label><input name="data[degree]" type="text" class="element text large" id="field_degree" value="{$data.degree}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=degree}
					</li>
					<li class='even'>
						<label class="field-title" for="field_university">Your University:</label>
						<label>{cfield field=university value=$data.university}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=university}
					</li>
					<li >
						<label class="field-title" for="field_campus">Your Campus:</label>
						<label><input name="data[campus]" type="text" class="element text large" id="field_campus" value="{$data.campus}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=campus}
					</li>


				</ol>
			</fieldset>
			<br />
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
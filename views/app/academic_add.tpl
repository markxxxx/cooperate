{include file="header.tpl"}
{head}

  <link href="/include/js/tool/tipsy.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="/include/js/tool/tipsy.hovercard.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>

  {literal}

<style>
  .field-title {width:150px !important;}
</style>

<script>





$(function() {

  $('.ajax-tip2').tipsy();


    function IsNumeric(input)
{
   return (input - 0) == input && input.length > 0;
}
  $(".addbutton").live('click',function(){
     posi = $(".removebutton").length;
     if($(".addedfields").length < 10){

       $(".addedfields tr:last").after(
         '<tr><td><input type="text" name="data[subjects]['+posi+'][subject]"  /></td>'+
         '<td><input type="text" name="data[subjects]['+posi+'][code]"  /></td>' +
         '<td><input type="text" name="data[subjects]['+posi+'][mark]" id="mark_'+posi+'" class="marks" size="2" /></td><td><input type="text"  id="symbol_'+posi+'" name="data[subjects]['+posi+'][credits]" size="2" /></td>' + 
         '<td><img src="/views/app/images/cross.png" class="removebutton" alt="not completed"></td></tr>'
       );
     }
  });

  $('#field-university_year').change(function() {
    if($(this).val() == 'Grade 12') {
        $('#school_info').css('display', 'block');
        $('#record_type').css('display', 'none');
    } else {
        $('#school_info').css('display', 'none');
        $('#record_type').css('display', 'block');
    }
  });

  $(".removebutton").live("click",function(){
     $(this).parent().parent().remove();
  });
  /*
  $(".marks").live('keyup',function(){
     var el = $(this) ;
    if(el.val() > 100) {
        el.val(0);
    } else {
        if(!IsNumeric(el.val())){
            el.val('');
        } else {
            mark = el.val();
            symbol = $("#symbol_"+el.attr('id').split('_').pop());

            if(mark < 50) {
                symbol.val('F');
            } else if(mark >= 50 && mark <=60) {
                symbol.val('D');
            } else if(mark >= 60 && mark <70) {
                symbol.val('C');
            } else if (mark >= 70 && mark <80) {
                symbol.val('B');
            } else {
                symbol.val('A');
            }
        }
    }
  });
  */

      $('#field-acadmic_record_type').change(function(){
        if($(this).val() == 'Other') {
          $('.acadmic_record_type_other').show();
          $('#acadmic_record_type_other').prop( "disabled", false );
          $('#acadmic_record_type_other').prop( "value", "" );

        } else {
          $('.acadmic_record_type_other').hide();
          $('#acadmic_record_type_other').prop( "disabled", true );
        }
      });

});
{/literal}
</script>
{/head}

<div id="content">
	<div id="content-top">
    <h2>Academic Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
			{include file="profile_menu.tpl"}
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Academic Manager</h4>
        <div class="box-container">
		<form action="/academic/add/{$data.id|default:0}" method="post" name="form_academic" enctype="multipart/form-data" class="middle-forms" id="form_academic">
			<h3>{if $academic.id|default:0 eq 0}Create a new{else}Update current{/if} Academic Record</h3>
            {if $invalid|default:0 eq '1'}
                <div class="error">Could not save your Academic infomation. Please make sure all fields are filled out correctly</div>
            {/if}
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $academic.id|default:0 eq 0}Create a new{else}Update current{/if} Academic Record</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_calendar_year">Academic year:</label>
						<label>{html_select_date start_year=2000 field_array=calendar_year time=$data.calendar_year display_days=false display_months=false}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=calendar_year}
					</li>
					<li >
						<label class="field-title" for="field_university_year">Year of study:</label>
						<label>{cfield field=university_year value=$data.university_year title='year'}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=university_year}
					</li>
                    
                    <div id="record_type"  {if $data.university_year eq 'Matric'} style="display:none"  {/if}>
                        <li class='even'>
                            <label class="field-title" for="field_acadmic_record_type" style="width:200px">What result are you filling in:</label>
                             <!-- <label><input type="text" value="{$data.acadmic_record_type}" name="data[acadmic_record_type]"/> eg. Semester test, Exams results, Semester mark, Project mark</label>  -->


                            <label>
                                {cfield field=acadmic_record_type value=$data.acadmic_record_type}
                            </label>

                            <span class="clearFix">&nbsp;</span>
                            {error field=acadmic_record_type}
                        </li>
                      

                      <!-- {*if field-acadmic_record_type eq 'Other' and $data.acadmic_record_type neq 'First semester' and $data.acadmic_record_type neq 'Second semester' and $data.acadmic_record_type neq 'Test results' and $data.acadmic_record_type neq 'Repeat results' and $data.acadmic_record_type neq 'Final results'*} -->
                      
                      {if field-acadmic_record_type eq 'Other'}
                        <li class='acadmic_record_type_other even'>
                          <label class="field-title" for="field_acadmic_record_type_other">Result Type</label>
                          <label><input type="text" value="{$data.acadmic_record_type}" name="data[acadmic_record_type]" id="acadmic_record_type_other" /></label>
                          <span class="clearFix">&nbsp;</span>
                        <li>
                      {/if}
                      
                    </div>
                   
                    <div id="school_info"  {if $data.university_year neq 'Matric'} style="display:none"  {/if}>
                        <li >
                            <label class="field-title" for="field_school_name">School name:</label>
                            <label><input name="data[school_name]" value="{$data.school_name}"/></label>
                            <span class="clearFix">&nbsp;</span>
                            {error field=school_name}
                        </li>
                        <li class='even'>
                            <label class="field-title" for="field_school_name">School Address:<br /><small>(Town, Province)</small></label>
                            <label><textarea name="data[school_address]">{$data.school_address}</textarea></label>
                            <span class="clearFix">&nbsp;</span>
                            {error field=school_address}
                        </li>

                    </div>

                    <li >
                      <label class="field-title" for="field_image">Upload results:</label>
                      <label><input type='file' name="uploadedfile" value='Browse'>

                        {if strlen($data.file)}<a href="/media/academics/{$data.file}">Download Attached document</a>{/if}
                      </label>
                      <span class="clearFix">&nbsp;</span>
                       {error field=file}
                        {if isset($upload_error)}
                          <br />
                          <span style='color:red'>{$upload_error}</span>
                      {/if}

                  </li>
           </li>

                    
					<li class='even'>
						<label class="field-title" for="">Results:</label>
			
                            <ul >
                                <table class="addedfields">
                                    <tr>
                                        <td>Subject</td>
                                        <td>Subject code</td>
                                        <td>Result</td>
                                        <td>&nbsp;Credits<img align="left" src="/views/app/images/help.png" class="ajax-tip2" title="If your course has credits please indicate below"/> </td>
                                        <td></td>
                                    </tr>
                                {section name=inst loop=$data.subjects}
                                    {if $data.subjects[inst] neq ''}
                                        <tr>
                                            <td><input type="text" name="data[subjects][{$smarty.section.inst.index}][subject]" value="{$data.subjects[inst].subject}" class="textbox" /></td>
                                            <td><input type="text" name="data[subjects][{$smarty.section.inst.index}][code]" value="{$data.subjects[inst].code}" class="textbox" /></td>
                                            <td><input type="text" name="data[subjects][{$smarty.section.inst.index}][mark]" class="marks" id="mark_{$smarty.section.inst.index}" value="{$data.subjects[inst].mark}" size="2"></td>
                                            <td><input type="text" name="data[subjects][{$smarty.section.inst.index}][credits]" class="marks" id="mark_{$smarty.section.inst.index}" value="{$data.subjects[inst].credits}" size="2"></td>
                                            <td><img src="/views/app/images/cross.png" class="removebutton" alt="not completed"></td>
                                        </tr>
                                    {/if}
                                {/section}
                                </table>
                            </ul>
							<br />
                            <input type="button" class="addbutton" value="Add another subject"/>
                        
                        </label>
						<span class="clearFix">&nbsp;</span>
						{error field=subjects}
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
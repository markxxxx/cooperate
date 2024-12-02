{include file="header.tpl"}

<div id="content">
    <div id="content-top">
        <h2>Internship Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
	{include file="profile_menu.tpl"}
    </div>
    <div id="mid-col" class="full-col">
        <div class="box">
            <h4 class="white">Internship Manager</h4>
            <div class="box-container">
                <form action="/internship/add/{$data.id|default:0}" method="post" name="form_internship" enctype="multipart/form-data" class="middle-forms" id="form_internship">
                    <h3>{if $internship.id|default:0 eq 0}Create a new{else}Update current{/if} work record</h3>
                    {if $invalid|default:0 eq '1'}
                    <div class="error">Could not save your work infomation. Please make sure all fields are filled out correctly</div>
                    {/if}
                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                    <fieldset>
                        <legend>{if $internship.id|default:0 eq 0}Create a new{else}Update current{/if} work record</legend>
                        <ol>
                            <li class='even'>
                                <label class="field-title" for="field_work_type">Work type:</label>
                                <label>{cfield field=work_type value=$data.work_type} </label>
                                <span class="clearFix">&nbsp;</span>
				{error field=work_type}
                            </li>
                            <li >
                                <label class="field-title" for="field_name">Company name:</label>
                                <label><input name="data[name]" type="text" class="element text large" id="field_name" value="{$data.name}" /></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=name}
                            </li>
                            <li class='even'>
                                <label class="field-title" for="field_location">Company location:</label>
                                <label><input name="data[location]" type="text" class="element text large" id="field_location" value="{$data.location}" /></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=location}
                            </li>
                            <li >
                                <label class="field-title" for="field_location">Position held:</label>
                                <label><input name="data[position_held]" type="text" class="element text large" id="field_location" value="{$data.position_held}" /></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=position_held}
                            </li>
                            <li class='even'>
                                <label class="field-title" for="field_location">Brief job description:</label>
                                <label><textarea name="data[description]">{$data.description}</textarea></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=description}
                            </li>

                            <li >
                                <label class="field-title" for="field_date_started">Date started:</label>
                                <label>{html_select_date start_year=2000 field_array=date_started time=$data.date_started}</label>
                                <span class="clearFix">&nbsp;</span>
				{error field=date_started}
                            </li>
                            <li  class='even'>
                                <label class="field-title" for="field_date_ended">Date ended:</label>
                                <label>{html_select_date start_year=2000 field_array=date_ended time=$data.date_ended}</label>
                                <span class="clearFix">&nbsp;</span>
				{error field=date_ended}
                            </li>
                            <li>
                                <label class="field-title" for="field_reported_to">Person reported to:</label>
                                <label><input name="data[reported_to]" type="text" class="element text large" id="field_reported_to" value="{$data.reported_to}" /></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=reported_to}
                            </li>
                            <li  class='even' >
                                <label class="field-title" for="field_reported_to_num">Email or Number for work contact person:</label>
                                <label><input name="data[reported_to_num]" type="text" class="element text large" id="field_reported_to_num" value="{$data.reported_to_num}" /></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=reported_to_num}
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
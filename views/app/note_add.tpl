{include file="header.tpl"}




<div id="content">
    <div id="content-top">
        <h2>Note Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">Note Options</h4>
            <div class="box-container">
                <ul class="list-links">
                    <li><a href="/{$profile.id}/">Back to {$profile.name|ucfirst} {$profile.surname|ucfirst} Profile</a></li>
                </ul>
            </div>
        </div>
    </div> 

    <div id="mid-col" class="full-col">
        <div class="box">
            <h4 class="white">Note Manager</h4>
            <div class="box-container">
                <form action="/note/add/{$data.id|default:0}/{$profile.id}" method="post" name="form_note" enctype="multipart/form-data" class="middle-forms" id="form_note">
                    <h3>Update Note for:  {$profile.name|ucfirst} {$profile.surname|ucfirst} </h3>
                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                    <fieldset>
                        <legend>{if $note.id|default:0 eq 0}Create a new{else}Update current{/if} Note</legend>
                        <ol>
                            <li >
                                <label class="field-title" for="field_note">Note:</label>
                                <label><textarea id="wysiwyg" rows="7" cols="25" name="data[note]" rows="5">{$data.note}</textarea></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=note}
                            </li>
                            {if $data.parent_id eq 0}
                                <li class='even'>
                                    <label class="field-title" for="field_note_type">Note type:</label>
                                    <label>{cfield field=note_type value=$data.note_type}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=note_type}
                                </li>
                            {/if}

                        </ol>
                    </fieldset><br />
                    <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
            </div>
            </form>
        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
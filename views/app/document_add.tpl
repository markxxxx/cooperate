{include file="header.tpl"}

<div id="content">
    <div id="content-top">
        <h2>Document Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
	{include file="profile_menu.tpl"}
    </div> 

    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Document Manager</h4>
            <div class="box-container">
                <form action="/document/add/{$data.id|default:0}" method="post" name="form_document" enctype="multipart/form-data" class="middle-forms" id="form_document">
                    <h3>{if $document.id|default:0 eq 0}Create a new{else}Update current{/if} Document</h3>
                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                    <fieldset>
                        <legend>{if $document.id|default:0 eq 0}Create a new{else}Update current{/if} Document</legend>
                        <ol>
                            <li class='even'>
                                <label class="field-title" for="field_title">Name of document:</label>
                                <label><input name="data[title]" type="text" class="element text large" id="field_title" value="{$data.title}" /></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=title}
                            </li>
                            <li >
                                <label class="field-title" for="field_description"><em>*</em>Description:</label>
                                <label><textarea id="wysiwyg" rows="7" cols="25" name="data[description]" rows="5">{$data.description}</textarea></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=description}
                            </li>
                            <li class='even'>
                                <label class="field-title" for="field_image">Document:</label>
                                <label><input type='file' name="uploadedfile" value='Browse'></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=file}
				{if isset($upload_error)}
                                    <br />
                                    <span style='color:red'>{$upload_error}</span>
				{/if}
                            </li>

                        </ol>
                    </fieldset>
                    <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
            </div>
            </form>
        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
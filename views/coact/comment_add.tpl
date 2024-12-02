{include file="header.tpl"}

<div id="content">
    <div id="content-top">
        <h2>Comment Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">Comment Options</h4>
            <div class="box-container">
                <ul class="list-links">
                    <li><a href="/{$profile.id}/">Back to {$profile.name|ucfirst} {$profile.surname|ucfirst} Profile</a></li>
                </ul>
            </div>
        </div>
    </div> 
    
    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Comment Manager</h4>
            <div class="box-container">
                <form action="/comment/add/{$data.id|default:0}/{$profile.id}" method="post" name="form_comment" enctype="multipart/form-data" class="middle-forms" id="form_comment">
                    <h3>{if $comment.id|default:0 eq 0}Create a new{else}Update current{/if} Comment</h3>
                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                    <fieldset>
                        <legend>{if $comment.id|default:0 eq 0}Create a new{else}Update current{/if} Comment</legend>
                        <ol>

                            <li class='even'>
                                <label class="field-title" for="field_comment">Comment:</label>
                                <label><textarea id="wysiwyg" rows="7" cols="25" name="data[comment]" rows="5">{$data.comment}</textarea></label>
                                <span class="clearFix">&nbsp;</span>
				{error field=comment}
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
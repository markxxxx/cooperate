{include file="header.tpl"}

<div id="content">
    <div id="content-top">
        <h2>Domain Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">Domain Options</h4>
            <div class="box-container">
                <ul class="list-links">
                    {if $user->can_access('domain', 'index')}
                        <li><a href="/domain/index/">View Domains</a></li>
                    {/if}
                </ul>
            </div>
        </div>
    </div> 

    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Domain Manager</h4>
            <div class="box-container">
                <form action="/domain/{$method}/{$data.id|default:0}" method="post" name="form_domain" enctype="multipart/form-data" class="middle-forms" id="form_domain">
                    <h3>{if $domain.id|default:0 eq 0}Create a new{else}Update current{/if} Domain</h3>
                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                    <fieldset>
                        <legend>{if $domain.id|default:0 eq 0}Create a new{else}Update current{/if} Domain</legend>
                        <ol>
                            <li class='even'>
                                <label class="field-title" for="field_domain">Domain:</label>
                                <label><input name="data[domain]" type="text" class="element text large" id="field_domain" value="{$data.domain}" /></label>
                                <span class="clearFix">&nbsp;</span>
                                {error field=domain}
                            </li>
                            <li >
                                <label class="field-title" for="field_reference">Payment Reference:</label>
                                <label><input name="data[reference]" type="text" class="element text large" id="field_reference" value="{$data.reference}" /></label>
                                <span class="clearFix">&nbsp;</span>
                                {error field=reference}
                            </li>
                            <li class="even">
                                <label class="field-title" for="field_admin">Administrators:</label>
                                <label>
                                    <ul class="checklist">
                                    {section name=inst loop=$admins}
                                        <li><label for="ck_admin_{$admins[inst].id}"><input type="checkbox" {if in_array($admins[inst].id, $current_admins)} checked {/if} name="admins[]" value="{$admins[inst].id}" id="ck_admin_{$admins[inst].id}">{$admins[inst].name} {$admins[inst].surname}</label></li>
                                    {/section}
                                    </ul>
                                    <br />
                                </label>
                                <span class="clearFix">&nbsp;</span>
                                {if !count($current_admins) and count($smarty.post)}
                                    <font color="red">Domain needs atleast 1 administrator</font>
                                {/if}
                            </li>
                            <li class='even'>
                                <label class="field-title" for="field_approve_payments">Show payment summary on bursars profile:</label>
                                <label><input name="data[payment_summary]" type="checkbox" {if $data.payment_summary|default:0 eq 1}checked{/if} id="field_admin" value="1" /></label>
                                <span class="clearFix">&nbsp;</span>
                            </li>
                            <li >
                                <label class="field-title" for="field_approve_payments">Country:</label>
                                <label>{cfield field='country' value=$data.country}</label>
                                <span class="clearFix">&nbsp;</span>
                                {error field=country}

                            </li>
                            <li>
                                <label class="field-title" for="field_image">Image:</label>
                                <label><input type='file' name="uploadedfile" value='Browse'></label>
                                {if $data.image|@strlen}
                                    {image src="media/domains/`$data.image`" width="60"}
                                {/if}
                                <span class="clearFix">&nbsp;</span>
                                {error field=image}
                            </li>
                        </ol>
                    </fieldset>
                    <br /><br />
                    <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
            </div>
            </form>
        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
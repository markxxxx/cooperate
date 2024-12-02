{include file="header.tpl"}

<div id="content">
    <div id="content-top">
        <h2>Event Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">Event Options</h4>
            <div class="box-container">
                <ul class="list-links">
		{if $user->can_access('event', 'index')}
                    <li><a href="/event/index/">View Events</a></li>
		{/if}
                </ul>
            </div>
        </div>
    </div> 

    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Event Manager
            {if $domains|@count > 1 && !$data.id}
                <div style="float:right">
                    <form id="select-domain" method="get" action="">
                        <select name="domain_id" onchange="parent.location.href='/domain/select/'+this.value+'?redirect=event/add'">
                            <option>Select domain:</option>
                            {section name=inst loop=$domains}
                                <option {if $domains[inst].id eq $user->current_domain()} selected {/if} value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
                            {/section}
                        </select>
                    </form>
                </div>
            {/if}


            </h4>
            <div class="box-container">
                <form action="/event/{$method}/{$data.id|default:0}" method="post" name="form_event" enctype="multipart/form-data" class="middle-forms" id="form_event">
                    <h3>{if $event.id|default:0 eq 0}Create a new{else}Update current{/if} Event</h3>
                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                    <fieldset>
                        <legend>{if $event.id|default:0 eq 0}Create a new{else}Update current{/if} Event</legend>
                        <ol>
                            <li class='even'>
                                <label class="field-title" for="field_event">Event:</label>
                                <label><textarea id="wysiwyg" rows="7" cols="25" name="data[event]" rows="5">{$data.event}</textarea></label>
                                <span class="clearFix">&nbsp;</span>
                                {error field=event}
                            </li>

                            <li >
                                <label class="field-title" for="field_event_date">Event date:</label>
                                <label>{html_select_date start_year=1980 field_array=event_date time=$data.event_date}</label>
                                <span class="clearFix">&nbsp;</span>
				{error field=event_date}
                            </li>

                            <li class="even">
                                <label class="field-title" for="field_admin">For users:</label>
                                <label>
                                    <ul class="checklist">
                                    {section name=inst loop=$users}
                                        <li><label for="ck_users_{$users[inst].id}"><input type="checkbox" {if in_array($users[inst].id, $current_users)} checked {/if} name="users[]" value="{$users[inst].id}" id="ck_admin_{$users[inst].id}">{$users[inst].full_name}</label></li>
                                    {/section}
                                    </ul>
                                </label>
                                <span class="clearFix">&nbsp;</span>
				{if !count($current_users) and count($smarty.post)}
                                <font color="red">Please add users for this event/font>
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
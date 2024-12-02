{include file="header.tpl"}

{head}
<script src="/include/uploader/jquery.ui.widget.js"></script>
<script src="/include/uploader/jquery.iframe-transport.js"></script>
<script src="/include/uploader/jquery.fileupload.js"></script>
<script type='text/javascript' src='/views/app/js/attachment.js?new=7'></script>

<link href="/views/app/css/attachment.css" media="screen" rel="stylesheet" type="text/css" />

{/head}

<div id="content">
    <div id="content-top">
        <h2>Message - {$thread.message.title}</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">Inbox</h4>
            <div class="box-container">
                <div id="sys-messages-container">
                    <h5>Latest Messages <span></span></h5>
                    <ul>
                    {section name=inst loop=$messages}
                        <li class="{cycle values="odd,even"}-messages">{if $messages[inst].opened eq 1}<sup syle='color:green;'>R</sup>{else}<sup syle='color:red;'>U</sup>{/if}&nbsp;<a href="/message/view/{$messages[inst].id}">{$messages[inst].reference} - {$messages[inst].title}</a></li>
                    {/section}
                    </ul>
                    <center>R = read &nbsp;&nbsp;U = unread</center>
                </div>
            </div>
        </div>
    </div> 

    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Message thread - newest on top</h4>
            <div class="box-container">
                <form action="/message/reply/{$thread.message.id}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                    <h3>{$thread.message.title} - {$thread.message.created_on|date_format}</h3>
                    {section name=inst loop=$thread.replies}
                    <div id='message-{$thread.replies[inst].id}'>
                        <div class='note-header'>
                            <div class='note-by'><b>
                                {if $user->is_bursar()}  
                                    {if $thread.replies[inst].sender_id eq $user->id}
                                        You
                                    {else}
                                        Bursary Administrator
                                    {/if} 
                                {else}
                                    {if $thread.replies[inst].sender_id eq $user->id}
                                        You
                                    {else}
                                       
                                            <a style="color:#1D8895;font-weight:bold;" href="/{$thread.replies[inst].user_id}">{$thread.replies[inst].name} {$thread.replies[inst].surname} {$thread.replies[inst].user_id}</a>



                                    {/if}

                                {/if}</b>

                            </div>
                            <div class='note-date'>{$thread.replies[inst].created_on|date_format}</div>
                            <div style="clear:both"></div>



                        </div>
                            {attachments message_id=$thread.replies[inst].id}
                            <div style="clear:both"></div>
                        <p class="note">{$thread.replies[inst].message|php_strip|nl2br}</p>

                    </div>
                    {/section}
                    <div id='message-{$thread.replies[inst].id}'>
                        <div class='note-header'>
                            <div class='note-by'><b>
                            {if $user->is_bursar()}  
                                {if $thread.message.sender_id eq $user->id}
                                    You
                                {else}
                                    Bursary Administrator
                                {/if} 
                            {else}
                                {if $thread.message.sender_id eq $user->id}
                                        You
                                {else}
                                   
                                        <a style="color:#1D8895;font-weight:bold;" href="/{$thread.replies[inst].user_id}">{$thread.message.name} {$thread.message.surname}</a>
    

                                {/if}

                            {/if}</b>

                            </div>
                            <div class='note-date'>{$thread.message.created_on|date_format}</div>
                            <div style="clear:both"></div>

                        </div>
                            {attachments message_id=$thread.message.id}
                            <div style="clear:both"></div>


                        <p class="note">{$thread.message.message|php_strip|nl2br}</p>

                    </div>


                    {if $user->can_access('message', 'reply')}
                        <textarea id='wysiwyg' cols="80" row="40" name="message"></textarea><br />
                        <input type="submit" value="Send reply" class="minibutton bblue" style="float:right; margin-right:38px;" />

                    	<div class="uploader">
							{uploader}
							<ol id="filelist">
							</ol>	
						</div>
						<div style="clear:both"></div>
				
                    {/if}

            </div>
            </form>
        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
{include file="header.tpl"}
{head}
<link rel="stylesheet" type="text/css" href="/views/app/js/jquery.tooltip.css" /> 
<script type='text/javascript' src='/views/app/js/jquery.tooltip.min.js'></script> 
	{literal}
<script>
        $(document).ready(function(){
                $('.selected').tooltip( {delay: 0} );
        });
</script>
	{/literal}
{/head}

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
                <h3 class="green">Document Manager</h3>
                <p>You can manage your uploaded documents here</p><br />
                <form action="/document/delete_selected" name="form_document" id="form_document" method="POST">
		{if $documents}	
                    {section name=inst loop=$documents}
                        <div class="doc_files">
                            <a class='selected' title='{$documents[inst].created_on|date_format} - <b>{$documents[inst].description}<b/>' href='/media/documents/{$documents[inst].file}'>
                            {$documents[inst].title|truncate:25}<br /><br />
                            {mime_type filename=$documents[inst].file}</a>
                            {if $user->can_access('document', 'delete')}
                                <br />
                                <input type="checkbox" name="id[{$documents[inst].id}]" />&nbsp;&nbsp;<a title="Delete Edit Document"  class="table-delete-link" href="/document/delete/{$documents[inst].id}"></a>&nbsp;&nbsp;
                            {/if}
                        </div>
                    {/section}
                    <div style="clear:both"></div>
                    {if $user->can_access('document', 'delete_selected')}
                        <br /><Br />
                        <input type="submit" class="submit" Value="Delete Seleted">
                    {/if}
                </form>
                {pager url='document/index' current_page=$page total_rows=$total_documents per_page=$per_page}
                {else}
                        No documents found!
                {/if}
            </div>
        </div> 
    </div>   
    <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
{include file="header.tpl"}
{head}{literal}
<script>
        $(document).ready(function(){
                $('.relation').change(function(){
                        var element = $(this);
                        var field = element.attr('id').split('_').shift();
                        var id = element.attr('id').split('_').pop();
                        $.get('/note/update_'+field+'/'+id+'/'+element.val(), function(){
                                element.css('color','red');
                        });
                });
        });
</script>
{/literal}{/head}

<div id="content">
    <div id="content-top">
        <h2>Note Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        <div class="box">
            <h4 class="yellow">Note Options</h4>
            <div class="box-container"><
                <ul class="list-links">
                    {if $user->can_access('note', 'add')}
                        <li><a href="/note/add/">New Note</a></li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    <div id="mid-col" class="full-col">
        <div class="box">
            <h4 class="white">Note Manager</h4>
            <div class="box-container">
                <form action="/note/delete_selected" name="form_note" id="form_note" method="POST">
                {if $notes}	
                    <table class="table-long">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>User_id</td>
                                <td>Created_by</td>
                                <td>Note</td>
                                <td>Note_type</td>
                                <td>Created_on</td>
                                <td>Modified_on</td>
                                <td>Options</td>
                            </tr>
                        </thead>
                        <tbody>
                        {section name=inst loop=$notes}
                            <tr {cycle values="class='odd',"}>
                                <td class="col-chk"><input type="checkbox" name="id[{$notes[inst].id}]" /></td>
                                <td>{$notes[inst].user_id}</td>
                                <td>{$notes[inst].created_by}</td>
                                <td class="col-second">
				{if $user->can_access('note', 'edit')}
                                    <a href="/note/edit/{$notes[inst].id}">{$notes[inst].note}</a>
				{else}
                                    {$notes[inst].note}
                                {/if}
                                </td>
                                <td>{$notes[inst].note_type}</td>
                                <td>{$notes[inst].created_on}</td>
                                <td>{$notes[inst].modified_on}</td>
                                <td> 
                                    {if $user->can_access('note', 'delete')}
                                        <a title="Delete Edit Note"  class="table-delete-link" href="/note/delete/{$notes[inst].id}"></a>&nbsp;&nbsp;
                                    {/if}
                                    {if $user->can_access('note', 'edit')}
                                        <a href="/note/edit/{$notes[inst].id}" title="Edit Note" class="table-edit-link"></a>
                                    {/if}
                                </td>
                            </tr>
                        {/section}
                        </tbody>
                    </table>
                    {if $user->can_access('note', 'delete_selected')}
                        <input type="submit" class="button" Value="Delete Seleted">
                    {/if}
                </form>
                {pager url='note/index' current_page=$page total_rows=$total_notes per_page=$per_page}
                {else}
                        No notes found!
                {/if}
            </div>
        </div> 
    </div>   
    <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
{include file="header.tpl"}
{head}{literal}
<script>
        $(document).ready(function(){
                $('.relation').change(function(){
                        var element = $(this);
                        var field = element.attr('id').split('_').shift();
                        var id = element.attr('id').split('_').pop();
                        $.get('/domain/update_'+field+'/'+id+'/'+element.val(), function(){
                                element.css('color','red');
                        });
                });
        });
</script>
{/literal}{/head}

<div id="content">
    <h3 class="green left" style="width:100%;font-size:200%">Domain Manager
        {if $user->can_access('domain', 'add')}
            <a class="right minibutton bblue" href="/domain/add/">New Domain</a>
        {/if}
    </h3>

    <div id="mid-col" class="full-col" style="width:100% !important; ">
        <div class="box">
            <h4 class="white">
                Domain Manager

            </h4>
            <div class="box-container">
                <form action="/domain/delete_selected" name="form_domain" id="form_domain" method="POST">
                {if $domains}	
                    <table class="table-long" style="width:100% !important; ">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Domain</td>
                                <td>Users</td>
                                <td>Reference</td>
                                <td>Show payment summary to bursars</td>
                                <td>Country</td>
                                <td>Created on</td>
                                <td>Options</td>
                            </tr>
                        </thead>

                        <tbody>
                        {section name=inst loop=$domains}
                            <tr {cycle values="class='odd',"}>
                                <td class="col-chk"><input type="checkbox" name="id[{$domains[inst].id}]" /></td>
                                <td class="col-second">
                                {if $user->can_access('domain', 'edit')}
                                    <a href="/domain/edit/{$domains[inst].id}">{$domains[inst].domain}</a>
                                {else}
                                    {$domains[inst].domain}
                                {/if}
                                </td>
                                <td class="col-second">
                                    {if $user->can_access('user','index') && in_array($domains[inst].id, $managed_domains)}
                                        <a href="/user?domain_id={$domains[inst].id}">{$domains[inst].total_users}</a>
                                    {else}
                                        {$domains[inst].total_users}
                                    {/if}
                                </td>

                                <td>{$domains[inst].reference}</td>
                                <td align="center">{if $domains[inst].payment_summary eq 1}Yes{else}No{/if}</td>
                                <td>{$domains[inst].country}</td>
                                <td>{$domains[inst].created_on}</td>
                                <td> 
                                    {if $user->can_access('domain', 'delete')}
                                        <a title="Delete Edit Domain"  class="table-delete-link" href="/domain/delete/{$domains[inst].id}"></a>&nbsp;&nbsp;
                                    {/if}
                                    {if $user->can_access('domain', 'edit')}
                                        <a href="/domain/edit/{$domains[inst].id}" title="Edit Domain" class="table-edit-link"></a>
                                    {/if}
                                </td>
                            </tr>
                        {/section}
                        </tbody>
                    </table>
                    <br />
                    {if $user->can_access('domain', 'delete_selected')}
                        <input type="submit" class="submit" Value="Delete Seleted">
                    {/if}
                </form>
                {pager url='domain/index' current_page=$page total_rows=$total_domains per_page=$per_page}
                {else}
                    No domains found!
                {/if}
            </div>
        </div> 
    </div>   
    <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
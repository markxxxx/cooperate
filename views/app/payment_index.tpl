{include file="header.tpl"}
{head}{literal}
<script>
    $(document).ready(function(){
        
        $("#new_payment").colorbox({onClosed:function(){location.reload();}});
        $(".edit_payment").colorbox();



        $('.relation').change(function(){
            var element = $(this);
            var field = element.attr('id').split('_').shift();
            var id = element.attr('id').split('_').pop();
                $.get('/payment/update_'+field+'/'+id+'/'+element.val(), function(){
                element.css('color','red');
            });
        });
    });
</script>
{/literal}{/head}

<div class="hidden">
    <div ><h2 style="font-size:160%; font-weight:bold; margin:10px 0;">Create a new Payment file</h2>
        <p>
        <form method="POST" action="/payment/add/" >
            <input class="txtbox-middle" id="new_payment_title" name="data[name]" type="input"><br />
            <input id="new_payment_save" type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
        </form>
        </p>
    </div>
</div>

<div id="content">
    <div id="content-top">
        <h2>Payment Manager</h2>
        <a href="/payment/add" id="new_payment" class="minibutton bblue" style="float:right">Create payment</a>
        <span class="clearFix">&nbsp;</span>
    </div>

    <div id="mid-col" class="full-col" style="width:100% !important">
        <div class="box">
            <h4 class="white">Payment Manager</h4>
            <div class="box-container">
                <form action="/payment/delete_selected" name="form_payment"  id="form_payment" method="POST">
			{if $payments}	
                    <table class="table-long" style="width:100% !important">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Name</td>
                                <td>Created by</td>
                                <td>Enabled</td>
                                <td>Created on</td>
                                <td>Options</td>
                            </tr>
                        </thead>

                        <tbody>
			{section name=inst loop=$payments}
                            <tr {cycle values="class='odd',"}>
                                <td class="col-chk"><input type="checkbox" name="id[{$payments[inst].id}]" /></td>
                                <td class="col-second">
				{if $user->can_access('payment', 'batch_edit')}
                                    <a href="/payment/batch_edit/{$payments[inst].id}">{$payments[inst].name}</a>
                                {else}
                                    {$payments[inst].name}
                                {/if}
                                </td>
                                <td>{$payments[inst].created}</td>
                                <td class="col-second">
                                {if $user->can_access('payment', 'enable')}
                                    <a href="/payment/enable/{$payments[inst].id}">{if $payments[inst].enabled}Yes{else}Closed By {$payments[inst].closed}{/if}</a>
                                {else}
                                    {if $payments[inst].enabled}Yes{else}Closed By {$payments[inst].closed}{/if}
                                {/if}
                                </td>
                                <td>{$payments[inst].created_on}</td>
                                <td>
                                
                                {if $user->can_access('payment', 'export')}
                                    {if !$payments[inst].enabled}
                                            <a title="Export to payment file" style="position:relative;padding-right:10px;" href="/payment/export/{$payments[inst].id}">
                                                <img border="none" src="{$template_dir}/images/export.png" alt="Export to payment file">
                                            </a>
                                    {/if}
                                {/if}
                                {**
                                {if $user->can_access('payment', 'add_users') and $payments[inst].enabled}
                                    <a title="Add users to payment" href="/payment/batch_edit/{$payments[inst].id}"><img style="border:none" src="{$template_dir}/images/user_add.gif"></a>&nbsp;&nbsp;&nbsp;
                                {/if}
                                **}

                                {if $user->can_access('payment', 'edit')}
                                    <a  href="/payment/edit/{$payments[inst].id}" title="Edit Payment" class="table-edit-link edit_payment"></a>
                                {/if}
                                
                                
  
                                

                                {if $user->can_access('payment', 'delete')}
                                    <a title="Delete Edit Payment"  class="table-delete-link" href="/payment/delete/{$payments[inst].id}"></a>&nbsp;&nbsp;
                                {/if}
                                </td>
                            </tr>
                        {/section}
                        </tbody>
                    </table>
                    <br />
                    {if $user->can_access('payment', 'delete_selected')}
                        <input type="submit" class="submit" Value="Delete Seleted">
                    {/if}
                </form>

                {pager url='payment/index' current_page=$page total_rows=$total_payments per_page=$per_page}
                {else}
                    No payments found!
                {/if}
            </div>
        </div> 
    </div>   
    <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
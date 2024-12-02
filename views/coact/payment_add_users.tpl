{include file="header.tpl"}
{head}{literal}
<script>
        $(document).ready(function(){

        
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

<div id="content">
    <div id="content-top">
        <h2>Add users to payment - {$payment.name}</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>

    {if $domains|@count >0 }
        <div id="left-col">
            <div class="box">
                <h4 class="yellow">Change Programmes</h4>
                <div class="box-container">
                    <ul class="list-links">
                        {section name=inst loop=$domains}
                            {if $domains[inst].id neq $user->current_domain()}
                            <li><a href="/domain/select/{$domains[inst].id}?redirect=payment/add_users/{$payment.id}" >{$domains[inst].domain}</a></li>
                            {/if}
                        {/section}
                    </ul>
                </div>
            </div>
        </div>
      {/if}

    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Add users to payment - {$payment.name}
            {if $domains|@count > 1}
                    <div style="float:right">
                        <form id="select-domain" method="get" action="">
                            <select name="domain_id" onchange="parent.location.href='/domain/select/'+this.value+'?redirect=payment/add_users/{$payment.id}'">
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
                <form action="/payment/add_users/{$payment.id}" name="form_payment" id="form_payment"  method="POST">
                    <h3 class="green">Showing users belonging to: {$domain.domain}</h3>
                    <p>Please select users and click next</p><br />
                    {if $domain_users}
                        <table class="table-long">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Cell</td>
                                </tr>
                            </thead>
                            <tbody>
                            {section name=inst loop=$domain_users}
                                <tr {cycle values="class='odd',"}>
                                    <td >
                                        <select name="id[{$domain_users[inst].id}]">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>

                                    </td>
                                    <td class="col-second">
                                        <a href="/{$domain_users[inst].id}" target="_blank">{$domain_users[inst].name} {$domain_users[inst].surname}</a>
                                    </td>
                                    <td>{$domain_users[inst].email}</td>
                                    <td>{$domain_users[inst].cell_number}</td>
                                </tr>
                            {/section}
                            </tbody>
                        </table>
                        <br />
                        <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
                    </form>
                    {else}
                        No payments found!
                    {/if}
            </div>
        </div> 
    </div>   
    <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
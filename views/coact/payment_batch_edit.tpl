{include file="header.tpl"}


{head}
    <link rel="stylesheet" type="text/css" href="/include/js/jquery/jquery.autocompletefb.css" />
    <script type='text/javascript' src='/include/js/jquery/jquery.autocomplete.js'></script> 
    <script type='text/javascript' src='/include/js/jquery/jquery.autocompletefb.js'></script> 
    <script type='text/javascript' src='/include/js/jquery/jquery.bgiframe.min.js'></script> 
    {literal}
    <script>
        function change_references(ref,ident_id) {
            to_clear = true;
            
            if(ref == 'Vaction Work') {
                to_clear = false;
                element="<select name='user["+ident_id+"][reference_2]'><option value='Bus cost'>Bus cost</option><option value='Commuting'>Commuting</option><option value='Access Card'>Access Card</option><option value='Meal Allowance'>Meal Allowance</option></select>";
                $('#reference_2_'+ident_id).html(element);
            }
            
            if(to_clear) {
                $('#reference_2_'+ident_id).html('');
            }
        }

        $(function(){

                $("#message_counter ul").click(function(){
                    form = $('#message_counter');
                    $.ajax({
                        type: "POST",
                        url: '/dashboard/user_count',
                        data: $('#message_counter').serialize(),
                        dataType: 'json',
                        success: function(data){
                            $('#user_count').html(data.total_users);
                        }
                    });
                });

            $(".modal_dashboard").colorbox({fixedWidth:"900px", transitionSpeed:"100", inline:true, href:"#change_dashboard"});

            var add_suppliers = $("#invitesupplier.acfb-holder").autoCompletefb({urlLookup:{/literal}{$supplier_json}{literal}});

            var add_users = $("#invite.acfb-holder").autoCompletefb({urlLookup:{/literal}{$users}{literal}});
            $(".edit_payment").colorbox();

            $('#add_users').click(function(e){
                e.preventDefault();
                $(this).css('disabled',true);
                
                if( add_users.getData().length == 0 ) {
                    _alert("warning",'Add requires recipients');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: $('#add_user_form').attr('action'),
                    data: {
                        to : add_users.getData(),
                        entries : $('#payment_entries').val()
                    },
                    success: function() {
                        parent.location.href = '/payment/batch_edit/'+$('#payment_id').val()+'?message=added';
                    }
                });

            });

            $('#add_suppliers').click(function(e){
                e.preventDefault();
                $(this).css('disabled',true);
                
                if( add_suppliers.getData().length == 0 ) {
                    _alert("warning",'Add requires recipients');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: $('#add_supplier_form').attr('action'),
                    data: {
                        to : add_suppliers.getData(),
                        entries : $('#payment_entries').val()
                    },
                    success: function() {
                        parent.location.href = '/payment/batch_edit/'+$('#payment_id').val()+'?message=added';
                    }
                });

            });

        });
    </script>
    {/literal}

{/head}

<input type="hidden" id="payment_id" value="{$payment.id}" />



<div class="hidden">
    <div id="change_dashboard" style=" margin:20px"><h3 class="green" style="border-bottom:1px solid silver;padding-bottom:5px;margin-bottom:5px">Add users to payment<div style="float:right" >Total users: <span id="user_count">{$user_count}</span></div></h3>
        <br />
        <form action="/payment/add_advanced/{$payment.id}" id="message_counter" method="POST" />
           <table width="100%" style="border-spacing:5px;">
                <tr>
                    <td>
                        {if $domains|count > 1 }
                            <b>Domains:</b><Br />
                            <ul class="checklist">
                                {section name=inst loop=$domains}
                                    <li><label for="ck_domain_{$domains[inst].id}"><input type="checkbox"  name="domains[]"  value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}"/>{$domains[inst].domain}</label></li>
                                {/section}
                            </ul>
                        {/if}
                    </td>
                    <td>
                        <b>Universities:</b><Br />

                        <ul class="checklist">
                            {section name=inst loop=$universities}
                                <li><label for="ck_universities_{$universities[inst]}"><input type="checkbox"  name="universities[]"
                                  value="{$universities[inst]}" id="ck_universities_{$universities[inst]}"/>{$universities[inst]}</label></li>
                            {/section}

                        </ul>

                    </td>

                    <td>

                    </td>
                    <td>
                     
                        <b>Year of study:</b><Br />

                        <ul class="checklist">
                            {section name=inst loop=$study_years}
                                <li><label for="ck_study_years_{$study_years[inst]}"><input type="checkbox"  name="study_years[]"  value="{$study_years[inst]}" id="ck_study_years_{$study_years[inst]}"
                               
                                />{$study_years[inst]}</label></li>
                            {/section}


                        </ul>

                    </td>
               </tr>
                    <td>
                     
                        <b>Groups:</b><Br />
                        <ul class="checklist">
                            {section name=inst loop=$groups}
                                <li><label for="ck_groups_{$groups[inst].id}"><input type="checkbox"  name="groups[]"  value="{$groups[inst].id}" id="ck_groups_{$groups[inst].id}"
                                
                                />{$groups[inst].name}</label></li>
                            {/section}


                        </ul>

                    </td>
                    <td valign="top">


                    </td>

               <tr>
            </table>
            <br />
                <table width="400">
                    <tr>
                        <td><b>References:</b></td>
                        <td>
                            <select name="reference">
                                <option value=''>None</option>
                                {section name=inst_ref loop=$references}
                                    <option value='{$references[inst_ref]}'>{$references[inst_ref]}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Supplier:</b>
                        </td>
                        <td>
                            <select name="supplier" style="width:100px">
                                <option value='0'>User</option>
                                {section name=inst_ref loop=$suppliers}
                                        <option value='{$suppliers[inst_ref].id}'>{$suppliers[inst_ref].supplier}</option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Amount:</b>
                        </td>
                        <td>
                            <input type="text" value="0" name="amount">
                        </td>
                    </tr>
                </table>



        <br /><br />
            <input type="submit" class="submit minibutton bblue" Value="Add users to payment">

        
    </div>
        </form>
        
</div>



<div id="content">
    <div id="content-top">
        <h2>{$payment.name}</h2>
        {if $user->can_access('reminder','add')}
        <a class="right minibutton colorbox" href="/reminder/add/0/payment/{$payment.id}" style="margin-left:10px;">Add reminder
        </a>
        {/if}
        {if $user->can_access('payment', 'edit')}
            <a href="/payment/edit/{$payment.id}"  class="minibutton edit_payment" style="float:right">Edit payment details</a>
        {/if}
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">

            {if $payment.enabled && $user->can_access('payment', 'add_users')}
            <div class="box">
                <h4 class="yellow">Add users <div class="right minibutton modal_dashboard" style="text-transform:none;position:relative;top:-3px;">Advanced</div></h4>
                <div class="box-container">
                    <form action="/payment/add_users/{$payment.id}" method="POST" id="add_user_form">

                        Users:<br>
                        <ul id="invite" class="first acfb-holder">
                            <input type="text" id="id_message_text" name="to" class="city acfb-input"/>
                        </ul>
                        <br />
                        Payment file entries per user:<br />
                            <select style="width:100%" id='payment_entries'>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <br />
                            <br />
                        <input type="button" id="add_users" class="minibutton bblue right" style="float:right" name="save" value="Add users">

                        <div style="clear:both"></div>
                    
                    </form>
                </div>
            </div>
        {/if}

       <!--  for suppliers -->
         {if $payment.enabled && $user->can_access('payment', 'add_suppliers')}
            <div class="box">
                <h4 class="yellow">Add supplier<!-- <div class="right minibutton modal_dashboard" style="text-transform:none;position:relative;top:-3px;">Advanced</div> --></h4>
                <div class="box-container">
                    <form action="/payment/add_suppliers/{$payment.id}" method="POST" id="add_supplier_form">

                        Suppliers:<br>
                        <ul id="invitesupplier" class="first acfb-holder">
                            <input type="text" id="id_message_text" name="to" class="city acfb-input"/>
                        </ul>
                        <br />
                     <!--    Payment file entries per user:<br />
                            <select style="width:100%" id='payment_entries'>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <br />
                            <br /> -->
                        <input type="button" id="add_suppliers" class="minibutton bblue right" style="float:right" name="save" value="Add supplier">

                        <div style="clear:both"></div>
                    
                    </form>
                </div>
            </div>
        {/if}


        <div class="box">
            <h4 class="white">Payment file options</h4>
            <div class="box-container">
                <ul class="list-links">
                    <li><a href="/payment/batch_edit/{$payment.id}/0" class="modal_box">View Incomplete entries</a></li>
                    <li><a href="/payment/batch_edit/{$payment.id}/" class="modal_box">View all entries</a></li>
                </ul>
                <br />
 
            </div>
        </div>

    </div>


    <div id="mid-col" class="full-col">

        <div class="box">
            <h4 class="white">Manage payment</h4>
            <div class="box-container">
                <form action="/payment/batch_edit/{$payment.id}" name="form_payment"  id="form_payment" class="" method="POST">
			{if !$payment.enabled}
                    <h3 class="green">Payment disabled</h3>
			{/if}
			{if $payments}	
                    <table class="table-long">
                        <thead>
                            <tr>
                                <td>Pay</td>
                                <td>Amount</td>
                                <td>Reference</td>
                                <td>Added By</td>
                                <td>Source</td>
                                <td>Supplier</td>
                                <td>Options</td>
                            </tr>
                        </thead>
                        <tbody>
			{section name=inst loop=$payments}
                            <tr {cycle values="class='odd',"}>
                                <td class="col-second">
                                    {if $payments[inst].user_id eq 0}
                                        <a href="/supplier/edit/{$payments[inst].supplier_id}" target="_blank">{$payments[inst].supplier}</a>
                                    {/if}
                                    <a href="/{$payments[inst].user_id}" target="_blank">{$payments[inst].user}</a>
                                </td>
                                <td>
				{if $payment.enabled}
                                    <input name="user[{$payments[inst].id}][amount]" value="{$payments[inst].amount}" style="width:50px"/></td>
				{else}
                                    {$payments[inst].amount}
				{/if}
                                <td>
				{if $payment.enabled}
                                    <select name="user[{$payments[inst].id}][reference]" id="reference_{$payments[inst].id}" onchange="change_references(this.value, {$payments[inst].id})" style="width:100px">
                                        <option value=''>select reference:</option>
                                        {section name=inst_ref loop=$references}
                                                <option {if $references[inst_ref] eq $payments[inst].reference} selected {/if} value='{$references[inst_ref]}'>{$references[inst_ref]}</option>
                                        {/section}
                                    </select>
                                    <div id="reference_2_{$payments[inst].id}">
                                        {if $payments[inst].reference_2|@strlen}
                                            <a style="color:#508DB8;" onclick="change_references($('#reference_{$payments[inst].id}').val(), {$payments[inst].id});">{$payments[inst].reference_2}</a>
                                            <input type="hidden" name="user[{$payments[inst].id}][reference_2]" value="{$payments[inst].reference_2}" />
                                        {/if}
                                    </div>
                                    
                                    
                                    
                                {else}
                                        {$payments[inst].reference}
                                {/if}
                                </td>
                                <td class="col-second">{$payments[inst].added}</td>
                                <td>
                                    {$payments[inst].domain_ref}
                                </td>
                                <td>
                                {if $payment.enabled}

				
                                    <select name="user[{$payments[inst].id}][supplier_id]" style="width:100px">
                                        <option value='0'>User</option>
                                        {section name=inst_ref loop=$suppliers}
                                                <option {if $suppliers[inst_ref].id eq $payments[inst].supplier_id} selected {/if} value='{$suppliers[inst_ref].id}'>{$suppliers[inst_ref].supplier}</option>
                                        {/section}
                                    </select>
                                {else}
                                        {section name=inst_ref loop=$suppliers}
                                            {if $suppliers[inst_ref].id eq $payments[inst].supplier_id}
                                                {$suppliers[inst_ref].supplier}
                                            {/if}
                                        {/section}
                                {/if}
                                
                                <td>
                                {if $payment.enabled}
                                    {if $user->can_access('payment', 'delete_user')}
                                        <a title="Delete Payment entrie"  class="table-delete-link" href="/payment/delete_user/{$payment.id}/{$payments[inst].id}"></a>&nbsp;&nbsp;
                                    {/if}
                                {/if}
                                </td>

                            </tr>
			{/section}
                        </tbody>
                    </table>

                    <br />
                    {if $payment.enabled}
                        <input type="submit" value="Update payment" class="minibutton bblue">
                    {/if}
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
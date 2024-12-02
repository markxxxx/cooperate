{include file="header.tpl"}
{head}
    {*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>

   {*  <script type='text/javascript' src='/include/js/jquery/jquery.bgiframe.min.js'></script> 
    <script type='text/javascript' src='/include/js/jquery/jquery.dimensions.js'></script> 
    <script type='text/javascript' src='/include/js/jquery/jquery.autocomplete.js'></script> 
    <script type='text/javascript' src='/include/js/jquery/jquery.autocompletefb.js'></script> 
    <script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="/include/js/jquery/jquery.autocompletefb.css" /> 
    <link href="/include/js/tool/tipsy.css" media="screen" rel="stylesheet" type="text/css" />
    <script type='text/javascript' src='/views/app/js/attachment.js?new=5'></script>
    <script type='text/javascript' src='/views/app/js/messages.js?new=5'></script>

    <link href="/views/app/css/attachment.css?v=1" media="screen" rel="stylesheet" type="text/css" />


    <script src="/include/uploader/jquery.ui.widget.js"></script>
    <script src="/include/uploader/jquery.iframe-transport.js"></script>
    <script src="/include/uploader/jquery.fileupload.js"></script>

    <script type='text/javascript' src='/views/app/js/attachment.js?new=7'></script> *}

{literal} 
<script type="text/javascript">

    $( document ).ready(function() {

        $('#quote_decline').click(function(e) {
            var txt = $(e.target).attr('href');
            var project_id = txt.split('#');
            var action_url= '/project/statusDeclined/'+project_id;
            $('#form_project_declined').get(0).setAttribute('action', action_url); //this works
            $('#form_project_declined').attr('action',action_url );
            console.log(project_id);
        });

    });

</script>
{/literal}
{/head}

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Message Manager</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    <div class="heading-btn-group">
                        {if $user->can_access('quote', 'index')}
                            <a href="/quote" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Quotes</span></a>
                        {/if}
                        {if $user->can_access('invoice', 'index')}
                            <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        {/if}
                        {if $user->can_access('appointment', 'index')}
                            <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar text-primary"></i> <span>Appointments</span></a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Message Manager</li>
            </ul>
            <ul class="breadcrumb-elements">
               <!--  <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-gear position-left"></i>
                                    Settings
                                    <span class="caret"></span>
                                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
                        <li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
                        <li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                <ul class="icons-list">
                    <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified"><i class="icon-statistics position-left"></i> Send New Message</a>
                    {*<li><img src="assets/images/project_lead.jpg"><a>Lead</a></li>*}
                    {*<li><img src="assets/images/project_new.jpg"><a>New</a></li>*}
                    {*<li><img src="assets/images/project_installed.jpg"><a>Installed</a></li>*}
                    {*<li><img src="assets/images/project_complete.jpg"><a>Complete</a></li>*}
                    {*<li><img src="assets/images/project_declined.jpg"><a>Declined</a></li>*}
                </ul>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <!-- <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li> -->
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="hidden">
                            <div id="send_message" style="margin:20px;width:600px"><h3 class="green" style="border-bottom:1px solid silver">Send a message</h2>
                                <div id="quick-send-message-container">
                                            <h5>
                                                {if $attachment_count neq 0}
                                                    {$attachment_count} files attached
                                                    <a href="/message/remove_attachments" class="selected" title="Remove attachments"><img src="/views/app/images/icon-delete.gif"></a>
                                                {else}
                                                    {if $user->can_access('sms', 'send')}
                                                        <legend><a id="message-type" href="#" style="float:left;text-decoration:none;margin-left:18px;">Click here to send SMS's</a> </legend>
                                                        <div class="clear"></div>
                                                     {else} 
                                                        <legend>Quick Send Message</legend> 
                                                     {/if}
                                                    

                                                    
                                                {/if}
                                            </h5> 

                                                <fieldset id="message-form">
                                                    <form id="form2" name="send-message-form" method="get" action="" autocomplete="off">

                                        
                                                    <legend>Quick Send Message</legend>
                                                        {if $user->is_admin()}
                                                        <a class="right add_cc" style="text-decoration:none;padding-top:4px;font-weight:bold">Add CC</a>
                                                            <p><label><input name="send-everyone" id='send-everyone' type="checkbox" value="" />To Everyone

                                        {* {if count($filters)}



                                            {foreach from=$filters key=k item=v}
                                                {if count($v) eq 1}
                                                    {if $k == 'domains'}
                                                        {section name=inst loop=$domains}
                                                            {if $domains[inst].id eq $v[0]}
                                                                <a class="minibutton ajax-tip2 " title="Remove filter"  >{$domains[inst].domain}</a>
                                                            {/if}
                                                        {/section}
                                                    {else}
                                                        <a class="minibutton ajax-tip2 " >{$v[0]}</a>
                                                    {/if}

                                                    {else}
                                                        <a class="minibutton " data-dropdown="#dropdown2-{$k}">{$v|@count} {$k|ucfirst|replace:'_':' '} selected<img src="/views/app/images/down_2.png" align="right"></a>
                                                    {/if}
                                            {/foreach}

                                                                {foreach from=$filters key=k item=v}

                                                {if count($v) > 1}
                                                    <div id="dropdown2-{$k}" class="dropdown dropdown-tip has-icons dropdown-relative">
                                                        <ul class="dropdown-menu">
                                                            {section name=inst loop=$v}
                                                                {if $k == 'domains'}
                                                                    {section name=inst2 loop=$domains}
                                                                        {if $domains[inst2].id eq $v[inst]}
                                                                            <li class="{$v[inst]}"><a>{$domains[inst2].domain}</a></li>
                                                                        {/if}
                                                                    {/section}
                                                                {else}
                                                                    <li class="{$v[inst]}"><a>{$v[inst]}</a></li>
                                                                {/if}
                                                            {/section}
                                                        </ul>
                                                    </div>
                                                {/if}

                                            {/foreach}
                                        {else}
                                            <a class="minibutton">All users</a>
                                        {/if} *}

                                                            </label>

                                                            </label> </p>
                                                            <ul id="message" class="first acfb-holder" style="width:95%;">
                                                                <input type="text" id="id_message_text" class="city acfb-input" />
                                                            </ul>

                                                            <div id="add_cc" style="display:none">
                                                                <p><br/><label>CC</label></p>
                                                                <ul id="cc" class="first acfb-holder" style="width:95%;">
                                                                    <input type="text" id="id_cc_text" class="city acfb-input" style="width:100%;"/>
                                                                </ul>
                                                            </div>




                                                        {/if}<br />
                                                        <div id="message_templates" class="hidden"> 
                                                        <p><label>Message Template: </label>
                                                            <select id="message_template" style="width:100%;">
                                                                <option value="">Select</option>
                                                            {section name=inst loop=$message_templates}
                                                                <option value="{$message_templates[inst].id}">{$message_templates[inst].name}</option>
                                                            {/section}
                                                            </select></p><br />
                                                        </div>


                                                        <p><label>Message Title: {if $user->is_admin()}<a class="right message_template_show" style="text-decoration:none;">Select Template</a>{/if}</label>
                                                            <input name="title" id="message-title" type="text" style="width:98%;"/></p>
                                                        <p><label>Content:</label>
                                                            <textarea name="message" id='message-body' style="width:98%;" cols="10" rows="5"></textarea></p>
                                                    </form>


                                                    <div class="uploader">
                                                        {uploader}
                                                        <ol id="filelist">
                                                        </ol>   
                                                    </div>


                                                    <div class="inner-nav">
                                                        <div class="align-right"><input class="minibutton bblue" id="send" name="button" type="button" value="Send Message" /></div>
                                                        <span class="clearFix">&nbsp;</span>
                                                    </div>      
                                                    
                                                </fieldset>

                                                {if $user->can_access('sms', 'send')}
                                                        <fieldset id="sms-form" class="hidden">
                                                            <form id="form2" name="send-message-form" method="get" action="" autocomplete="off">

                                                            <legend>Quick Send Message</legend>
                                                                <div id="sms_credits" class="right" style="position:relative;top:3px;color:red;"></div>
                                                                {if $user->is_admin()}
                                                                    <p><label><input name="send-everyone" id='sms-everyone' type="checkbox" value="" />To Everyone</label> </p>
                                                                    <ul id="sms" class="first acfb-holder">
                                                                        <input type="text" id="id_sms_text" class="city acfb-input"/>
                                                                    </ul>
                                                                {/if}<br />

                                                                <p><label> SMS Content:</label>
                                                                    <textarea name="message" id='sms-body' cols="10" rows="5"></textarea></p>
                                                                    <div id="remaining"></div>

                                                            </form>
                                                            <div class="align-right"><input class="minibutton bblue" id="send-sms" name="button" type="button" value="Send SMS" /></div>

                                                        </fieldset>
                                                {/if}

                                </div>
                            </div>
                        </div>

                        <div class="box-container">
                            <form action="" method="post" class="middle-forms">
                                <h3 class="green">My {if $box eq 'inbox'}Inbox{else}Outbox{/if}</h3>
                                    {if $messages}
                                <table class="table datatable-basic-9 table-hover">
                                    <thead>
                                        <tr>
                                            <td>Date</td>
                                            <td>Title</td>
                                            <td>Message</td>
                                            {if $user->is_admin()}
                                                {if $box eq 'inbox'}
                                                    <td>From</td>
                                                {else}
                                                    <td>Send by</td>
                                                    <td>To</td>
                                                {/if}
                                            {/if}
                                        </tr>
                                    </thead>

                                    <tbody>
                                        {section name=inst loop=$messages}
                                            <tr {cycle values="class='odd',"}>
                                                <td >
                                                    {if $messages[inst].opened eq 0 and $box neq 'outbox'}
                                                        <img src="/views/app/images/unread.png" style="position:relative;top:8px;">&nbsp;
                                                    {/if}
                                                    <small style="font-size:10px;">{$messages[inst].created_on|date_format}</small>
                                                </td>
                                                <td class="col-second"><a href="/message/view/{$messages[inst].id}">{$messages[inst].title|truncate:30}</a></td>
                                                <td >{$messages[inst].message|strip_tags|truncate:28}</td>
                                                {if $user->is_admin()}

                                                    <td class="col-second">
                                                        {if $box eq 'inbox'}
                                                            <a href="/{$messages[inst].sender_id}">{$messages[inst].name} {$messages[inst].surname}</a>
                                                        {else}
                                                            {$messages[inst].sender}
                                                        {/if}
                                                    </td>
                                                    {if $box eq 'outbox'}
                                                    <td class="col-second"><a href="/{$messages[inst].recipient_id}">{$messages[inst].name} {$messages[inst].surname}</a></td
                                                    >
                                                    {/if}

                                                {/if}
                                            </tr>
                                        {/section}
                                    </tbody>
                                </table>
                                <br />
                                    {pager url="dashboard/home/`$box`" current_page=$page total_rows=$total_messages per_page=30}
                                {else}
                                You have not recieved any messages yet.
                                {/if}
                            </form>
                        </div>








                    </div> <!--end col-lg-12 -->
                </div>
            </div>
        </div>
        
        <!-- Iconified modal -->
        <div id="modal_iconified" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Message</h5>
                    </div>
                    <div class="modal-body">
                        <form action="/message/add/{$data.id|default:0}" method="post" name="form_project" enctype="multipart/form-data" class="middle-forms" id="form_project">
                            <!-- <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                                <span class="text-semibold">Yay!</span> more projects.
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div> -->
                            <h6 class="text-semibold"><i class="icon-law position-left"></i> Please fill in the form below</h6>
                            <!-- <p>dont forget to click SAVE :)</p> -->
                            <hr>
                            <fieldset>
                                <ol style="list-style: none;">
                                    <li>
                                        <span class="label bg-teal help-inline">Select Recipient</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[customer_id]">
                                                <option value=''>Select Recipient:</option>
                                                {* <option value='0' >-CREATE NEW CUSTOMER-</option> *}
                                                {section name=inst loop=$recipients}
                                                    <option value="{$recipients[inst].id}" {if $data.teacher_id eq $recipients[inst].id}selected{/if}>{$recipients[inst].user_surname}, {$recipients[inst].user_name} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Subject Name</span> -->
                                        <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Subject Of Message" required/> {error field=name}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    <li>
                                        <!-- <span class="label bg-teal help-inline">Subject Description</span> -->
                                        <input name="data[message]" type="text" class="form-control" id="field_message" value="{$data.message}" placeholder="message" required/> {error field=message}
                                        <span class="clearFix">&nbsp;</span>
                                    </li>
                                    
                                    {* <li>
                                        <span class="label bg-teal help-inline">Start Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[start_date]" class="form-control daterange-single" value="{$data.start_date}" type="text" id="field_start_date" value="{$data.start_date}" placeholder="Start date" required>
                                            </div>
                                        </div>
                                        {error field=start_date}
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">End Date</span>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input name="data[end_date]" class="form-control daterange-single" value="{$data.end_date}" type="text" id="field_end_date" value="{$data.end_date}" placeholder="End date" required>
                                            </div>
                                        </div>
                                        {error field=end_date}
                                    </li> *}
                                    {* <li>
                                        <span class="label bg-teal help-inline">Select Customer</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[customer_id]">
                                                <option value=''>Select Customer:</option>
                                                <option value='0' >-CREATE NEW CUSTOMER-</option>
                                                {section name=inst loop=$customers}
                                                    <option value="{$customers[inst].id}" {if $data.customer_id eq $customers[inst].id}selected{/if}>{$customers[inst].surname}, {$customers[inst].name} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Sales Rep</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[user_id]">
                                                <option value=''>Select Sales Rep:</option>
                                                {section name=inst loop=$sales_reps}
                                                    <option value="{$sales_reps[inst].user_id}" {if $data.user_id eq $sales_reps[inst].user_id}selected{/if}>{$sales_reps[inst].surname}, {$sales_reps[inst].user_name} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="label bg-teal help-inline">Select Payment type</span>
                                        <div class="form-group">                                            
                                            <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[payment_type]">
                                                <option value=''>Select Payment type:</option>
                                                {section name=inst loop=$payment_type}
                                                    <option value="{$payment_type[inst]}" {if $data.payment_type eq $payment_type[inst]}selected{/if}>{$payment_type[inst]} </option>
                                                {/section}
                                            </select>
                                        </div>
                                    </li> *}
                                </ol>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button>
                            <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- close Iconified modal -->

    </div>
    <!-- /end content -->

{include file="footer.tpl"}
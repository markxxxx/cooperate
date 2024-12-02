<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{if $site_title|default:false}{$site_title}{else}{$controller|ucfirst} {if $method eq 'index'}Manager{else}{$method|ucfirst}{/if}{/if} - Bursary Manager</title>
        <link href="{$template_dir}/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="{$template_dir}/css/style.css?v=11" rel="stylesheet" type="text/css" />
        <link href="{$template_dir}/js/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
        <link type="text/css" media="screen" rel="stylesheet" href="{$template_dir}/js/colorbox.css?v=1" />
        <link type="text/css" media="screen" rel="stylesheet" href="{$template_dir}/js/colorbox-custom.css?v=1" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

        <script type="text/javascript" src="{$template_dir}/js/jquery.colorbox-min.js?v=2"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.ui.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.corners.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/bg.pos.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.wysiwyg.js"></script>
        <script src="{$template_dir}/js/tabs.pack.js?id=1" type="text/javascript"></script>
        <script type="text/javascript" src="{$template_dir}/js/cleanity.js"></script>
        <script type='text/javascript' src='/include/js/jquery/jquery.dropdown.js'></script> 

    {literal}
        <style type="text/css">
            div.wysiwyg ul.panel li {padding:0px !important;}
        </style>
        <!--[if IE 6]>
        <link rel="stylesheet" href="ie.css" type="text/css" />
        <![endif]-->
        <!--[if IE]>
        <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox-custom-ie.css" title="Cleanity" />
        <![endif]-->
        <script>

            function _alert(type,message) {
                clearInterval(hide_alertbox);
                $el = $('#messages div');
                $el.removeClass('confirmation').removeClass('warning');
                $('#messages div').addClass(type).html(message);
                $('#messages').show();
                var hide_alertbox = function() {$('#messages').fadeOut();}
                var sd=setTimeout(hide_alertbox , 6000);
            }

            $(document).ready(function($) {
                if(($.browser.msie && $.browser.version=="6.0") ||
                    ($.browser.msie && $.browser.version=="7.0")) {
                     window.onerror = function(){return true;}  
                }
                var hider_handle = function() {$('.success').animate({'height':0,opacity:0},'slow')};
                var reconnect_handel = function() { $.get('/user/re_connet');  setTimeout(reconnect_handel , 1000*60*2);};
                
                var r=setTimeout(reconnect_handel , 1000*60*2);
                var t=setTimeout(hider_handle , 3500);
                $('.search_module').click(function(){
                    $('#ui_element').attr('action', $(this).val());
                });
            });
            
            $(function() {
                var $search = $('#ui_element');

                if($search.length) {
                    $search.find('.sb_input').bind('focus click',function(){
                        $search.find('.sb_dropdown').show();
                    });
                    $search.bind('mouseleave', function(){
                        $search.find('.sb_dropdown').hide();
                    });
                }

                {/literal}

                    {if $smarty.get.success eq 1 && $controller neq 'user'}
                        _alert('confirmation', "{$controller|ucfirst} details saved/updated successfully! ");
                    {/if}

                    {if $smarty.get.deleted eq 1}
                        _alert('confirmation', "{$controller|ucfirst} deleted successfully! ");
                    {/if}

                    {if $validation_errors}
                        _alert('warning', "Error saving form. Please make sure all required fields are filled out ");
                    {/if}
                    {if isset($smarty.get.confirmation)}
                        _alert('confirmation', "{$smarty.get.confirmation}");
                    {/if}
                {literal}
            });
        
        </script> 
    {/literal}
    {** Nasty css hack **}
</head>
    <body {if isset($smarty.session.admin)} style="background-position:0px 34px;"  {/if} >
    <div id="messages" style="display: none;"><div class="warning" ></div></div>

        {if isset($smarty.session.admin)}
            <div style="height:30px;border-bottom:4px solid #CEAC0F; font-size:14px;background-color:#FFF;text-align:center;">
                <div style="padding-top:7px;">
                    You are currently logged in as {$user->name} {$user->surname}, Return as: <a style="color:#508DB8;" href='/user/login_as/0/{$user->id}'>{$smarty.session.admin.full_name}</a>
                </div>
            </div>
        {/if}
    


        <div id="dropdown-usermenu" class="dropdown dropdown-tip has-icons ">
            <ul class="dropdown-menu">
                {if $user->is_admin() && $user->can_access('setting','index')}
                    <li><a href="/setting/">Email settings</a></li>
                {/if}
                <li><a href="/user/password/">Change Password</a></li>
                <li><a href="/user/logout/">Logout</a></li>
                
            </ul>
        </div>


    
        <div id="container">

            <div id="header">
                <div id="top">
                    
                    
                        <a href="/"><img style="position:absolute; top:3px" src="/views/app/images/front_logo.png"></a>

                    
                    {if $user->id}
                        <p id="userbox">

                            
                        <a class="minibutton" data-dropdown="#dropdown-usermenu"><img src="/views/app/images/down_2.png" align="right">{$user->name} {$user->surname}</a>


                        <br />
                    {/if}
                    {if isset($smarty.session.admin)}
                        <small>Return as: <a href='/user/login_as/0'>{$smarty.session.admin.full_name}</a></small>
                    {else}
                        <small>Last Login: {$user->last_seen|date_format}</small>
                    {/if}
                    </p>
                    <span class="clearFix">&nbsp;</span>
                </div>
                <ul id="menu">
                {if $user->id}
                    <li class="selected" ><a class="top-level"  href="/">Dashboard<span>&nbsp;</span></a>
                        {if $user->is_admin()}
                            <ul>
                                <li><a style="color: #5c6467;" href="/message/inbox/">Messages Inbox</a></li>
                                <li><a style="color: #5c6467;" href="/message/outbox/">Messages Outbox</a></li>
                                <li><a style="color: #5c6467;" href="/message_template">Message Templates</a></li>


                            </ul>
                        {/if}
                    </li>
                {else}
                    <li class="selected"><a href="/">Login</a></li>
                {/if}
                    {if $user->can_access('user', 'index') or $user->can_access('group', 'manage')}
                        <li><a class="top-level" href="/user">Users <span>&nbsp;</span></a>
                            <ul>
                                <li><a href="/user/">View Users</a></li>
                                <li><a href="/user/?group_id=6">View Alumni</a></li>
                                {if $user->can_access('user', 'add')}
                                    <li><a href="/user/add">Add User</a></li>
                                {/if}
                                {if $user->can_access('group', 'index')}
                                    <li><a href="/group/">View Groups</a></li>
                                {/if}
                                {if $user->can_access('group', 'manage')}
                                    <li><a href="/group/manage">Group Permissions</a></li>
                                {/if}
                                {if $user->can_access('import', 'stats')}
                                    <li><a href="/import/stats">Import stats</a></li>
                                {/if}

                        </ul>
                    </li>
		{/if}
        



		{if $user->is_bursar()}
            <li><a class="top-level" href="/profile">My Profile<span>&nbsp;</span></a></li>
		{/if}


		{if $user->can_access('domain', 'add') or $user->can_access('domain', 'index')}
                    <li><a class="top-level" href="/domain">Domains <span>&nbsp;</span></a>
                        <ul>
                            <li><a href="/domain/">View Domains</a></li>
	                {if $user->can_access('domain', 'add')}
                            <li><a href="/domain/add">Add Domain</a></li>
                    {/if}
                    {if $user->can_access('domain', 'select')}
                            <li><a href="/domain/select">Change Domain</a></li>
                    {/if}
                        </ul>
                    </li>
		{/if}

		{if $user->can_access('payment', 'index')}<li><a class="top-level" href="/payment/">Payments<span>&nbsp;</span></a>

                <ul>
                    <li><a href="/payment/">View Payments</a></li>
                    {if $user->can_access('reference', 'index')}
                        <li><a class="colorbox" href="/payment/add">Add Payment</a></li>
                    {/if}
                    {if $user->can_access('reference', 'index')}
                        <li><a href="/reference/index">Payment References</a></li>
                    {/if}

                </ul>
        </li>{/if}
        {if $user->can_access('supplier', 'index')}
            <li><a class="top-level" href="/supplier">Suppliers <span>&nbsp;</span></a>
                <ul>
                    <li><a href="/supplier/">View Suppliers</a></li>
                    {if $user->can_access('supplier', 'add')}
                        <li><a href="/supplier/add">Add Supplier</a></li>
                    {/if}

                    {if $user->can_access('supplier_type', 'index')}
                        <li><a href="/supplier_type/">Supplier Types</a></li>
                    {/if}
                </ul>
            </li>
		{/if}
        
		{if $user->can_access('contact', 'index')}
            <li><a class="top-level" href="/contact">Contacts <span>&nbsp;</span></a>
            <ul>
                <li><a href="/contact/">View Contacts</a></li>
                    {if $user->can_access('supplier', 'add')}
                        <li><a href="/contact/add">Add Contact</a></li>
                    {/if}
                </ul>
            </li>
        {/if}


        {if $user->can_access('appointment', 'index')}
            <li><a class="top-level" href="/appointment">Calendar <span>&nbsp;</span></a>
                <ul>
                    <li><a href="/appointment/">Full Calendar</a></li>
                    {if $user->can_access('event', 'index')}
                        <li><a  href="/event">Events <span>&nbsp;</span></a></li>
                    {/if}
                </ul>
            </li>
        {/if}







                </ul>
                {if $user->id}
                <form {if $method eq 'home'}action="/user/"{else}action="/{$controller}"{/if} method="get" name="form1" id="ui_element" autocomplete="off">
                    <fieldset>
                        <legend>Search</legend>
                        <label id="searchbox">
                            <input type="text" class="sb_input" name="search" id="s"/>
                        </label>
                        <input class="hidden" type="submit" name="Submit" value="Search" />
                    </fieldset>
                    {if !$user->is_bursar()}
                        <div class="sb_spacer">
                            <ul class="sb_dropdown" style="display:none;">
                                <li class="sb_filter">Filter your search</li>
                                {if $user->can_access('user', 'index')}
                                    <li><input type="radio" class="search_module" name="group1" value="/user" {if $controller eq 'user' || $method eq 'home'} checked {/if} /><label for="Users">Users</label></li>
                                {/if}

                                {if $user->can_access('user', 'home') && !$user->is_mentor()}
                                    <li><input type="radio" class="search_module" name="group1" value="/user/home"  /><label for="Messages">Messages</label></li>
                                {/if}
                                {if $user->can_access('task', 'index')}
                                    <li><input type="radio" class="search_module" name="group1" value="/task" {if $controller eq 'task'} checked {/if}/><label for="Tasks">Tasks</label></li>
                                {/if}
                                {if $user->can_access('payment', 'index')}
                                    <li><input type="radio" class="search_module" name="group1" value="/payment" {if $controller eq 'payment'} checked {/if}/><label for="Payments">Payments</label></li>
                                {/if}
                                {if $user->can_access('domain', 'index')}
                                    <li><input type="radio" class="search_module" name="group1" value="/domain" {if $controller eq 'domain'} checked {/if}/><label for="Domains">Domains</label></li>
                                {/if}
                                {if $user->can_access('event', 'index')}
                                    <li><input type="radio" class="search_module" name="group1" value="/event" {if $controller eq 'event'} checked {/if}/><label for="Events">Events</label></li>
                                {/if}
                                {if $user->can_access('supplier', 'index')}
                                    <li><input type="radio" class="search_module" name="group1" value="/event" {if $controller eq 'supplier'} checked {/if}/><label for="Events">Suppliers</label></li>
                                {/if}
                                {if $user->can_access('contact', 'index')}
                                <li><input type="radio" class="search_module" name="group1" value="/contact" {if $controller eq 'contact'} checked {/if}/><label for="Contacts">Contacts</label></li>
                                {/if}
                                {if $user->can_access('reference', 'index')}
                                <li><input type="radio" class="search_module" name="group1" value="/reference" {if $controller eq 'reference'} checked {/if}/><label for="Reference">References</label></li>
                                {/if}
                                {if $user->can_access('reminder', 'index')}
                                <li><input type="radio" class="search_module" name="group1" value="/reference" {if $controller eq 'reminder'} checked {/if}/><label for="Reminder">Reminder</label></li>
                                {/if}
                            </ul>
                        </div>
                    {/if}
                </form>
            {/if}

            <span class="clearFix">&nbsp;</span>
      </div>
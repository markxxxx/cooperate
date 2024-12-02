<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{if $site_title|default:false}{$site_title}{else}{$controller|ucfirst} {if $method eq 'index'}Manager{else}{$method|ucfirst}{/if}{/if} - Bursary Manager</title>
        <link href="{$template_dir}/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="{$template_dir}/css/style.css?v=10" rel="stylesheet" type="text/css" />
        <link href="{$template_dir}/js/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
        <link type="text/css" media="screen" rel="stylesheet" href="{$template_dir}/js/colorbox.css?v=1" />
        <link type="text/css" media="screen" rel="stylesheet" href="{$template_dir}/js/colorbox-custom.css?v=1" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.colorbox-min.js?v=2"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.ui.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.corners.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/bg.pos.js"></script>
        <script type="text/javascript" src="{$template_dir}/js/jquery.wysiwyg.js"></script>
        <script src="{$template_dir}/js/tabs.pack.js?id=1" type="text/javascript"></script>
        <script type="text/javascript" src="{$template_dir}/js/cleanity.js"></script>
        <script type='text/javascript' src='/include/js/jquery/jquery.dropdown.js'></script> 
{literal}
        <style>
        .pac-container {z-index:40000 !important;}
    </style>
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

        function loadScript(src,callback){
            var script = document.createElement("script");
            script.type = "text/javascript";
            if(callback)script.onload=callback;
            document.getElementsByTagName("head")[0].appendChild(script);
            script.src = src;
        }

        if(typeof google == 'undefined') {
            loadScript('http://maps.googleapis.com/maps/api/js?key={/literal}{$config.maps.api_key}{literal}&sensor=false&callback=initialize',function(){});
        } else {
            initialize();
        }

        function initialize() {
            var geocoder = new google.maps.Geocoder();
                
                geocoder.geocode( { 'address': '{/literal}{$event.location}{literal}'}, function(results, status) {
            
                    if(status == google.maps.GeocoderStatus.OK) {
                        
                        var options = {
                            zoom: 16,
                            position: results[0].geometry.location,
                            center: results[0].geometry.location,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("map_canvas"), options);

                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });

                    } 

                });
            }

        $(function(){
            $('#rsvp').change(function(){
                if($(this).val() == 'Yes') {
                    if($('#food_option').val() == 1) {
                        $('#food-tr').show();
                    }
                    $('#no-tr').hide();

                } else if($(this).val() == 'No') {
                    //$('#no-tr').show();
                    if($('#food_option').val() == 1) {
                        $('#food-tr').hide();
                    }
                }
            });
        });

        function submit_rsvp() {

            var post_data = {};

            rsvp = $('#rsvp').val();
            feedback = $('#feedback').val();

            if(rsvp == 'Pending') {
                _alert("warning",'Please select an RSVP option: Yes or No');
                return false;
            }




            if(rsvp == 'Yes' && $('#food_option').val() == 1) {

                if($('#field-food_option').val() == '') {
                    _alert("warning",'Please specify a food option');
                    return false;
                } else {
                    post_data.food_option = $('#field-food_option').val();
                }
            } 

            post_data.rsvp = rsvp;
            post_data.save = true;


            $.post($('#rsvp_action').val(), post_data ,  function(){ 
                _alert("confirmation",'Your RSVP has been saved!');
                $('.rsvp-box').hide();
                $('#complete').show('slow');
            });
        }
            

    {/literal}
    </script>
     
    {** Nasty css hack **}
    <body {if isset($smarty.session.admin)} style="background-position:0px 34px;"  {/if} >
    <div id="messages" style="display: none;"><div class="warning" ></div></div>

  

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
                {if $user->is_admin() && $user->can_access('setting','edit')}
                    <li><a href="/setting/add/">Email settings</a></li>
                {/if}
                <li><a href="/user/password/">Change Password</a></li>
                <li><a href="/user/logout/">Logout</a></li>
                
            </ul>
        </div>


    
        <div id="container">

            <div id="header">
                <div id="top">
                    
                    
                        <a href="/"><img style="position:absolute; top:3px" src="/views/app/images/front_logo.png"></a>






                    </div></div>


            <span class="clearFix">&nbsp;</span>

  {if $rsvp_success eq 0}
<div id="content">
    <br /><br /><br /><br /><br /><br />
    <h3 class="green left" style="width:100%;font-size:200%">Hi {$contact.name}, Please provide us with your RSVP.

    </h3>





<div id="complete" style="display:none;">
        <br /> <br />
        <center>
        Your RSVP has been saved.<br /><br />
        <a href="/" class="bblue minibutton">Close</a>
        </center>
    </div>

    <div id="quick-send-message-container" class="rsvp-box">
            <div class='form' id='form-calendar' style="width:100%;">
                
            <br /><br />

                <input type="hidden" id="food_option" value="{$event.food_option}"/>
                <input type="hidden" value="/contact/rsvp/{$event_id_hash}/{$contact_id_hash}" id="rsvp_action">
                <form action="/contact/rsvp/{$event_id_hash}/{$contact_id_hash}" id="rsvp_form" method="POST">

    

                    <table width="100%">
                        <tr>
                            <td valign="top"><b>Event name</b></td>
                            <td valign="top">{$event.name}<Br /><br /></td>
                        </tr>
                        <tr>
                            <td valign="top"><b>Event date</b></td>
                            <td valign="top">{$event.event_date}<br /><br /></td>
                        </tr>
                        <tr>
                            <td width="230px" valign="top">
                                <b>Will you be attending this event: </b> 
                            </td>
                            <td valign="top">
                                <select name="data[rsvp]" id='rsvp'>
                                    {if $event_user.rsvp eq 'Pending'}
                                        <option  selected value="Pending">Pending</option>
                                    {/if}
                                    <option {if $event_user.rsvp eq "Yes" } selected {/if} value="Yes">Yes</option>
                                    <option {if $event_user.rsvp eq "No"} selected {/if} value="No">No</option> 
                                </select>
                            </td>
                        </tr>
                        {if $event.food_option}
                            <tr id="food-tr">
                                <td valign="top">
                                    <b>What are your dietary requirements:</b>
                                </td>
                                <td valign="top">
                                    {cfield field=food_option value=$event_user.food_option}
                                </td>
                            </tr>
                        {/if}

                        <tr id="no-tr" style="display:none">
                            <td valign="top">
                                <b>Why can you not attend this event:</b>
                            </td>
                            <td valign="top">
                                <textarea name="data[feedback]" id='feedback' cols="10" rows="5" style="width:90%"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>

                            </td>
                            <td>
                                <br />
                                <input type="button" onclick='submit_rsvp()' class="minibutton ajax-tip2 bblue " name="save" value="Submit my RSVP" />
                                    
                                </a>
                            </td>
                        </tr>
                    </table>

                 


                <br /><br />

                <b>Event details:</b><br />
                {$event.event}<Br /><br />


                <b>Location:</b><br /> {$event.location}
                <br /><br />

                <div id="map_canvas" style="width:100%; height:175px; "></div>
            </div>
        </form>
    </body>
    

    {else}
<div id="content">
    <br /><br /><br /><br /><br /><br />
       <h3 class="green left" style="width:100%;font-size:200%">Hi {$contact.name} - Thank you for your RSVP</h3>

                        <b>Event details:</b><br />
                {$event.event}<Br /><br />


                <b>Location:</b><br /> {$event.location}

                                <div id="map_canvas" style="width:100%; height:175px; "></div>
            <br /><br /><br /><br /><br /><br />
    <br /><br /><br /><br /><br /><br />



    {/if}

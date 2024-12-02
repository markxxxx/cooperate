<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bursary manager</title>
<link type="text/css" media="screen" rel="stylesheet" href="{$template_dir}/js/colorbox.css" />
<link type="text/css" media="screen" rel="stylesheet" href="{$template_dir}/js/colorbox-custom.css" />
<script type="text/javascript" src="{$template_dir}/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$template_dir}/js/jquery.colorbox-min.js"></script>

<style type="text/css">
{literal}
html, body {height: 100%; }
div#distance { margin-bottom: -10em; width: 1px;height: 39%; float: left;}
div#container {	position: relative;   text-align: left; height: 150px;	width: 575px; margin: 0 auto; padding-top: 75px; clear: left;}

body {background: url(/views/app/images/bg-login.jpg) repeat-x center; margin: 0; padding: 0;
font-family: Helvetica, Arial, Tahoma, serif; font-size: 9pt;}
h1 {font-size:250%; text-transform:uppercase; letter-spacing:-1px; font-weight:bold; width:450px; 
	margin: 0 0 45px 85px; padding: 0;}
h1 a {color:#fff; text-decoration:none;}
h1 a:hover {color:#ccc;}

fieldset, form {margin: 0; padding: 0; border: 0; outline: 0;}
fieldset legend {display: none;}

ol {margin: 0; padding: 0; list-style: none;}
ol li {float: left; margin-right: 15px;}
label {display: block;}
label.field-title {width:75px; color:#fff; font-weight: bold; float: left; padding-top: 3px;}
label.txt-field {width: 185px; height: 21px;   float: left; margin-right: 10px}
label.txt-field input { padding: 2px 0 0 8px;}
a.remember {color:#ccc; float:left; width: 200px; margin-top: 20px; margin-left:75px; margin-right: 215px;}
div.align-right {float: left; width: 56px;  margin-top: 20px;}
.hidden {display:none;}
#message{padding:5px;color:red;}

.minibutton {
    text-decoration: none;
  background-color:#EAEAEA;
  background-image:linear-gradient(#FAFAFA, #EAEAEA);
  background-repeat:repeat no-repeat;
  border-bottom-left-radius:3px;
  border-bottom-right-radius:3px;
  border-color:#DDDDDD #DDDDDD #C5C5C5;
  border-image-source:none;
  border-style:solid;
  border-top-left-radius:3px;
  border-top-right-radius:3px;
  border-width:1px;
  box-shadow:rgba(0, 0, 0, 0.0470588) 0 1px 3px;
  color:#333333;
  cursor:pointer;
  display:inline-block;
  font-size:12px;
  font-weight:normal;
  padding:4px 8px;
  text-shadow:rgba(255, 255, 255, 0.901961) 0 1px 0;
  vertical-align:middle;
  white-space:nowrap;
  position: relative;
  right:19px;
}


#messages {
    opacity: 0.95;
    left: 50%;
    margin-left: -225px;
    opacity: 0.95;
    position: fixed;
    top: -1px;
    z-index: 100000;
}
#messages div.error, #messages div.warning {
    background: url("/views/app/images/icons.png") no-repeat scroll 6px -97px #EF9398;
    border: 1px solid #DC5757;
    color:#000;
}
#messages div {
    margin: 0;
    min-height: 22px;
    padding: 8px 10px 8px 46px;
    width: 400px;
}

#messages div.confirmation {
    background: url("/views/app/icons.png") no-repeat scroll 6px -47px #A6EF7B;
    border: 1px solid #76C83F;
}

#ie6 { color:#FFFFFF; background-color:red;padding:15px;font-weight:bold}
</style>

        <!--[if IE 6]>
        <style type="text/css">
        label.remember {width: 200px; margin-left:40px;}
        label.txt-field {margin-right: 5px}
        </style>
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
    $(document).ready(function(){
        $(".modal_box").colorbox({fixedWidth:"50%", transitionSpeed:"100", inline:true, href:"#forgot_password"});
        $("#remider_btn").click(function(){
            el = $(this);
            el.css('disabled','true');
            $('#message').html('Loading');
            $.getJSON('/user/reset_password/'+$('#email_reminder').val(),function(data){
                el.css('disabled','false');
                if(data.error == 1) {
                    $('#message').html('Email address not found');
                } else {
                    $('#message').html('An email with instructions has been send on how to reset your password');
                }
            });
        });





    });

</script>

{/literal}
 

<body>
    <div id="messages" style="display: none;"><div class="warning" ></div></div>

    {if $login_error}
        <script>
             _alert('warning', "The login details that you have provided is incorrect");   
        </script>
    {/if}

    {if $is_ie_6}

<div id="distance"></div>
    <div id="container">
    <div id="ie6">
    <h3>You are using an insecure browser!</h3>
    <p>
    It looks like you're using an insecure version of Internet Explorer. Using an outdated browser makes your computer and personal infomation unsafe.
    Please update your brower to gain access to this site.
    
    You can download the lastest <a href="http://windows.microsoft.com/en-ZA/internet-explorer/products/ie/home">version here</a>
    </p>
    </div>
</div>
{else}

<div class="hidden">
    <div id="forgot_password" style="margin:20px">
        <h3 class="green">Please provide us with your email address.</h2>
        <div id="message"></div>
        <input type="text" id="email_reminder" name="email_reminder" value="{$smarty.post.data.email}"/><br /><br />
        <input id="remider_btn" type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
    </div>
</div>


<div id="distance"></div>
    <div id="container">
    <div id="top"><h1>
            <img src="/views/app/images/moshal.png" />
    </h1></div>
    <div id="form-container">
        <form action="/user/login" method="POST" name="login-form">
        <fieldset>
            <legend>Login</legend>
            <ol>
                <li><label class="field-title">Email:</label><label class="txt-field"><input type="text" name="data[email]" /></label></li>
                <li><label class="field-title">Password:</label><label class="txt-field"><input type="password" name="data[password]" /></label></li>
                <li><a  class="modal_box remember" href="#">Forgot password?</a></label><div class="align-right">
                <input type="submit" name="login" class="minibutton" value="Login" />
                </div></li>
            </ol>
        </fieldset>
        <span class="clearFix">&nbsp;</span>
        </form>
    </div>
</div>

{/if}


</body>



</html>

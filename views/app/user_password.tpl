{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Change Password</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Password tips</h4>
          <div class="box-container">
              <ul class="list-links">
              
                <p style="padding:8px;">
                    There are different password policies which could define a secure password. The rules we recommend for creating a secure password is as follows:<br /><br />

                    1) 6 - 8 alpha-numeric (Numbers, letters, symbols) characters in length<br />
                    2) Varying case (Upper and lower case)<br />
                    3) No dictionary words in the password forwards or backwards.<br />
                    4) Change passwords every month or so.<br />
                    5) Never reuse passwords.<br />
                
                </p>

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Security checkpoint</h4>
        <div class="box-container">
		<form action="" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
			<h3>Create a new password</h3>
			<p>To ensure that your information is protected, please create a new password to access this system.<br />
			Please create a password between 6 and 10 characters containing both Case-Sensitive letters and numbers.</p>
            {if $error|default:0 eq 1}
                <span class="form-error-inline">Please make sure your password is at least 6 or more characters.<b>or</b> make sure your passwords are a match</span></label><span class="clearFix">&nbsp;</span>
            {/if}
			<fieldset>
				<legend></legend>
				<ol>

          {if $user->registered}
            <li >
              <label class="field-title" for="field_email">Your current password:</label>
              <label><input name="old_password" type="password" class="element text large" id="field_email" value="" /></label>
              <span class="clearFix">&nbsp;</span>
            </li>
          {/if}


					<li class='even'>
						<label class="field-title" for="field_email">New password:</label>
						<label><input name="new_password" type="password" class="element text large" id="field_email" value="" /></label>
						<span class="clearFix">&nbsp;</span>
                        

					</li>

					<li>
						<label class="field-title" for="field_name">Retype new password:</label>
						<label><input name="retyped_password" type="password" class="element text large" id="field_name" value="" /></label>
						<span class="clearFix">&nbsp;</span>
					</li>


				</ol>
			</fieldset>
      <br /><br />
			<input type="submit" class="minibutton bblue" value="Change password"/>
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
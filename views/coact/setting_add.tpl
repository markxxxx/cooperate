{include file="header.tpl"}
{head}
{literal}
	<script>
		$(function() {
			$('#test-settings').click(function(){
				$(this).css('enabled', false);
				$(this).html("<img src='/views/app/images/preloader.gif' /> Testing...");
				$.post('/setting/test/', $('#form_setting').serialize(), function(data){

					if(data =='false') {
						_alert('confirmation', 'Email settings correct');
					} else {
						_alert('warning', 'Cannot connect to email server');
					}

					$('#test-settings').css('enabled', true);
					$('#test-settings').html('Test email settings');

				});

			});
		});
	</script>
{/literal}
{/head}

{if isset($smarty.get.error)}
    <script>_alert('warning', "Website password invalid");</script>
{/if}

<div id="content">
	<div id="content-top">
    <h2>Email Sync Settings</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Email message sync</h4>
          <div class="box-container">
              <ul class="list-links">
              	<div style="padding:10px;">
					In order to automatically log email communication we need you to provide us with your email login information.<br />
				</div>
              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Email sync setting</h4>
        <div class="box-container">
		<form action="/setting/add/{$data.id|default:0}" method="post" name="form_setting" enctype="multipart/form-data" class="middle-forms" id="form_setting">
			<h3>IMAP settings</h3>
			<fieldset>
				<legend>{if $setting.id|default:0 eq 0}Create a new{else}Update current{/if} Setting</legend>
				<ol>
					<li class='even'>
						<label class="field-title" for="field_imap_server">Imap server url:</label>


						<label>
						<select name="data[imap_server]" tabindex="0">
							<option {if $data.imap_server eq 'imap.gmail.com:993/imap/ssl/novalidate-cert'} selected {/if} value="imap.gmail.com:993/imap/ssl/novalidate-cert">Select</option>
							<option {if $data.imap_server eq 'mail.moshalscholarship.org/novalidate-cert'} selected {/if} value="mail.moshalscholarship.org/novalidate-cert">Moshal</option>
							<option {if $data.imap_server eq 'imap.gmail.com:993/imap/ssl/novalidate-cert'}  selected {/if}value="imap.gmail.com:993/imap/ssl/novalidate-cert">Gmail</option> 
							<option {if $data.imap_server eq 'imap.mail.yahoo.com:993/imap/ssl'}  selected {/if}value="imap.mail.yahoo.com:993/imap/ssl">Yahoo</option> 
							<option {if $data.imap_server eq 'imap.aol.com:993/imap/ssl'} selected {/if} value="imap.aol.com:993/imap/ssl">AOL</option> 
						</select>
						</label>
						<span class="clearFix">&nbsp;</span>
						{error field=imap_server}
					</li>
					<li >
						<label class="field-title" for="field_email">Email address:</label>
						<label><input tabindex="1" name="data[email]" type="text" class="element text small" id="field_email" value="{$data.email}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=email}
					</li>
					<li class='even'>
					<a  class="minibutton right" href="#" id="test-settings" />Test email settings</a>
						<label class="field-title" for="field_password">Email Password:</label>
						<label><input tabindex="2" name="data[password]" type="password" class="element text small" id="field_password" value="" /></label>
						<span class="clearFix">&nbsp;</span>

						{error field=password}
					</li>

					<div style="padding:20px;">
						<b>To save these settings, please enter your login password.</b>
					</div>

					<li >
						<label class="field-title" for="field_email">Your password:</label>
						<label><input tabindex="3" name="data[site_password]" type="password" class="element text small" id="field_email" value="{$data.site_password}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=site_password}
					</li>


				</ol>
			</fieldset>
			<br />
			<input type="submit" class="minibutton bblue" value="Save" /> 
			

		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
{include file="header.tpl"}

{literal}
<link rel="stylesheet" type="text/css" href="/views/app/js/jquery.tooltip.css" />
<script type='text/javascript' src='/views/app/js/jquery.tooltip.min.js'></script> 

<link href="/views/app/css/attachment.css?v=1" media="screen" rel="stylesheet" type="text/css" />


<script src="/include/uploader/jquery.ui.widget.js"></script>
<script src="/include/uploader/jquery.iframe-transport.js"></script>
<script src="/include/uploader/jquery.fileupload.js"></script>
<script type='text/javascript' src='/views/app/js/attachment.js?new=7'></script>

<script type='text/javascript' src='/views/app/js/user_profile.js?v=1'></script>



<script>
$('#field-acadmic_progress_result').change(function(){
        if($(this).val() == 'Other') {
          $('#field-acadmic_progress_result_other').show();
          $('#field-acadmic_progress_result_other').prop( "disabled", false );
          $('#field-acadmic_progress_result_other').prop( "value", "" );

        } else {
          $('#field-acadmic_progress_result_other').hide();
          $('#field-acadmic_progress_result_other').prop( "disabled", true );
        }
      });
</script>
<style>
.fieldset-profile li {
	float:left;
	width:300px;
	height:20px;
}
#profile_files a{
	color:#508DB8;
}
#profile_files li{
	border-bottom:1px solid #EFEFEF;
	padding:4px;
}
</style>
{/literal}

<input type='hidden' id="profile-id" value="{$u_profile.id}" />



        <div id="dropdown-profile" class="dropdown dropdown-tip has-icons dropdown-relative">
            <ul class="dropdown-menu">



				<li><a class="toggle_view">View Messages</a></li>

				{if $user->can_access('sms','send')}
					<li><a href="#" class="send_message">Send Message</a></li>
				{/if}

				{if $user->can_access('sms','send')}
					<li><a href="/user/logout/" class="send_sms">Send SMS</a></li>
				{/if}

				{if $user->can_access('user','export')}
					<li><a href="/user/logout/" class="new_export">Export</a></li>
				{/if}

				{if $user->can_access('user','edit')}
					<li><a href="/user/edit/{$u_profile.id}">Edit user details</a></li>
				{/if}

				{if $user->can_access('user', 'login_as') }
					<li><a href="/user/login_as/{$u_profile.id}">Login as User</a></li>
				{/if}
				                
            </ul>
        </div>

<div class="hidden">
	<div id="new_export" style=" margin:20px"><h3 class="green" style="border-bottom:1px solid silver">Export Profile</h2>


		<img src="/views/app/mimes/16/wordprocessing.png">&nbsp;&nbsp;<a style="color:#508db8" href="/user/export/{$u_profile.id}/word">Export to word</a><br />
		
		<img src="/views/app/mimes/16/pdf.png">&nbsp;&nbsp;<a style="color:#508db8" href="/user/export/{$u_profile.id}">Export to pdf</a><br />

		<img src="/views/app/mimes/16/source_y.png">&nbsp;&nbsp;<a style="color:#508db8" href="/misc/download_application/{$u_profile.id}">Export to a zip folder</a>
	</div>
</div>

<div class="hidden">
	<div id="send_message" style="margin:20px;width:600px"><h3 class="green" style="border-bottom:1px solid silver">Send {$u_profile.name|ucfirst} {$u_profile.surname|ucfirst} a message</h2>

			<div id="message_templates" > 
		<p><label>Message Template: </label>
			<select id="message_template" style="width:100%;">
				<option value="">Select</option>
			{section name=inst loop=$message_templates}
				<option value="{$message_templates[inst].id}">{$message_templates[inst].name}</option>
			{/section}
			</select></p><br />
		</div>
		<input type="hidden" value="jopoes__{$u_profile.id}" id="to" name="to" />
		Message Title:<br />
		<input name="title" id="message-title" type="text" /><br />
		Content: <br />
		<textarea name="message" id='message-body' cols="10" rows="5" style="width:100%"></textarea></p>
		<div class="inner-nav">
			<span class="clearFix">&nbsp;</span>
		</div>    
				<input class="minibutton bblue" id="send" style="float:right" name="button" type="button" value="Send Message" />

						<div class="uploader">
							{uploader}
							<ol id="filelist">
							</ol>	
						</div>
						<div style="clear:both"></div>
	</div>
</div>


<div class="hidden">
	<div id="send_sms" style="margin:20px;width:600px"><h3 class="green" style="border-bottom:1px solid silver">Send {$u_profile.name|ucfirst} {$u_profile.surname|ucfirst} a SMS</h2>
		<input type="hidden" value="jopoes__{$u_profile.id}" id="to" name="to" />

		SMS Body: <br />
		<textarea name="message" id='sms-body' cols="10" rows="5" style="width:100%"></textarea></p>
													<div id="remaining">Remaining characters : 160</div>

		<div class="inner-nav">
			<span class="clearFix">&nbsp;</span>
		</div>    
				<input class="minibutton bblue" id="send" style="float:right" name="button" type="button" value="Send Message" />


						<div style="clear:both"></div>
	</div>
</div>



<div id="content">
	<div id="content-top">

		<h2>            
			{if $user->can_access('user', 'export')}
			{** <a href="/user/export/{$u_profile.id}" target="_blank"
			class="tips" title="Download a PDF version on {$u_profile.name|ucfirst} {$u_profile.surname|ucfirst}'s Profile"
			><img src="{$template_dir}/images/arrow_red_up_icon.png"></a> **}
			{/if}

			{$u_profile.name|ucfirst} {$u_profile.surname|ucfirst}


		</h2>
			<a class="minibutton right" data-dropdown="#dropdown-profile"><img src="/views/app/images/down_2.png" align="right">Options</a>
			{if $user->can_access('reminder','add')}
				<a class="right minibutton colorbox" href="/reminder/add/0/user/{$u_profile.id}" style="margin-right:10px;">Add reminder
			</a>
			{/if}

				{**

							{if $user->can_access('user','export')}
				<div class="minibutton new_export right" >Export</div>
			{/if}
		<div style="float:right;margin-top:4px;padding-right:20px ">
				{if $user->can_access('sms','send')}
					&nbsp;&nbsp;<a href="#" class="tips send_sms" title="Send {$u_profile.name} {$u_profile.surname} a SMS"><img border=none src="{$template_dir}/images/phone-16.png"></a>
				{/if}
				&nbsp;&nbsp;<a href="#" class="tips send_message" title="Send {$u_profile.name} {$u_profile.surname} a message"><img border=none src="{$template_dir}/images/feed/mail.png"></a>
				{if $user->can_access('user', 'login_as') }
					&nbsp;&nbsp;<a href="/user/login_as/{$u_profile.id}" class="tips" title="Login as {$u_profile.name} {$u_profile.surname}"><img border=none src="{$template_dir}/images/login.gif"></a>&nbsp; &nbsp;
				{/if}

			
			

		
			&nbsp;&nbsp;<a href="/user/login_as/{$u_profile.id}/academic.add" class="tips" title="Add a new academic record for {$u_profile.name} {$u_profile.surname}"><img border=none src="{$template_dir}/images/feed/a_academic.gif"></a>&nbsp; &nbsp;
			&nbsp;&nbsp;<a href="/user/login_as/{$u_profile.id}/document.add" class="tips" title="Upload a new document for {$u_profile.name} {$u_profile.surname}"><img border=none src="{$template_dir}/images/feed/a_upload.gif"></a>&nbsp; &nbsp;
			&nbsp;&nbsp;<a  href="/user/login_as/{$u_profile.id}/internship.add" class="tips" title="Add a new employment record for  {$u_profile.name} {$u_profile.surname}"><img border=none src="{$template_dir}/images/feed/login.gif"></a> 
			

		


		</div>
		**}


		<span class="clearFix">&nbsp;</span>
	</div>
	<div id="left-col">
		<div class="box">
			<h4 class="yellow">
				{$u_profile.name} {$u_profile.surname} 


			</h4>
			<div class="box-container">
				
				{image src="media/profiles/`$profile.image`" width=200 height=200}<br />
				<br />


				<table width="100%">
				<tr>
					<td><b>Status:</b></td>
					<td>{cfield field=account_status value=$u_profile.account_status title='record type' style="width:100%"}</td>
				</tr>
				{if $user->can_access('user','update_group')}
					<tr>
						<td><b>Group:</b> </td>
						<td>
							<select name="group" id="group" style="width:100%">
								{section name=inst loop=$groups}
									<option value="{$groups[inst].id}" {if $u_profile.group_id eq $groups[inst].id} selected {/if}>{$groups[inst].name}</option>
								{/section}
							</select>
						</td>
					</tr>
				{/if}
				{if $user->can_access('user','update_domain')}

				<tr>
					<td><b>Domain:</b></td>
					<td>
						<select name="group" id="domain"  style="width:100%">
							{section name=inst loop=$domains}
								<option value="{$domains[inst].id}" {if $u_profile.domain_id eq $domains[inst].id} selected {/if}>{$domains[inst].domain}</option>
							{/section}
						</select>
					</td>
				</tr>

				{/if}

				{if $user->can_access('user','update_domain')}

				<tr>
					<td><b>Risk:</b></td>
					<td>
						{cfield field=risk value=$u_profile.risk title='record type' style="width:100%"}
					</td>
				</tr>

				{/if}
				</table>
				{if $profile.twitter_url} <a target="_blank" href="{$profile.twitter_url}"><img src="/views/app/social/twitter.png"></a>{/if}
				{if $profile.facebook_url}<a target="_blank" href="{$profile.facebook_url}"><img src="/views/app/social/facebook.png"></a>{/if}
				{if $profile.linkedin_url}<a target="_blank" href="{$profile.linkedin_url}"><img src="/views/app/social/linkedin.png"></a>{/if}


	

				<br />

			</div>
		</div>

		{if $annual_user_summary }
		<div class="box">
			<h4 class="white">Financial Summary</h4>
			<div class="box-container">
				{foreach from=$annual_user_summary key=year item=details}
					<div class="finantial_header" data-year={$year}>

						<img style="position:relative; top: -1px;left:-2px" src="/views/app/images/bg-toplevel.gif"/>&nbsp;<b>{$year} Overview:</b>&nbsp;&nbsp; R {$details.summary|money} <br />
					</div>
				
				<table  width="100%" id="report_{$year}" class="hidden report_break_down">
					{section name=inst loop=$details.rows}
					<tr>
						<td><b>{$details.rows[inst].reference}: </b></td>
						<td>R {$details.rows[inst].total_expenditure|money}</td>
					</tr>
					{/section}
					<tr>
						<td colspan=2>
							<hr size="1" color="#CCC">

							<td>
							</tr>
						</table>
						{/foreach}
						<form action="/report/generate" id="report_gen" method="post">
							<input type="hidden" name="users[]" value="{$u_profile.id}">
							<input type="hidden" name="year" value="-1">

							<center><a onclick="$('#report_gen').submit()"  href="#">Download Full report</a></center>
						</form>
					</div>
				</div>
				{/if}
				

					<div class="box">
						<h4 class="white">User Stats</h4>
						<div class="box-container">
							<table width="100%">
								<tr>
									<td><b>Last seen</b></td>
									<td>
										:{$u_profile.last_seen|date_format}
									</td>
								</tr>
								<tr>
									<td><b>Unread messages</b></td>
									<td>:{$total_unread_messages}</td>
								</tr>
								<tr>
									<td><b>Incomplete tasks</b></td>
									<td>:{$total_incomplete_tasks}</td>
								</tr>
							</table>
						</div>
					</div>


				{if $documents}
				<div class="box">
					<h4 class="light-blue">Documents</h4>
					<div class="box-container">
						<ul id='profile_files'>
							{section name=inst loop=$documents}
							<li>
								{mime_type filename=$documents[inst].file size=16} &nbsp;<a class='selected'  title='{$documents[inst].created_on|date_format} - <b>{$documents[inst].description|escape}<b/>' href='{$config.site.domain}/media/documents/{$documents[inst].file}'>{$documents[inst].title}</a>
							</li>
							{/section}
						</div>
					</div>
					{/if}


					<div class="box">
						<h4 class="white">Calendar </h4>
						<div class="box-container">
							{if count($user_event_attendance) }
								<a onclick="$('#attendance').show();$(this).hide();return false;" href="#">Has attended {$user_event_attendance|@count} Events</a>
								<div class="clear"></div><br />
							{/if}
							<div id="attendance" class="hidden">
								{section name=inst loop=$user_event_attendance}
								<div class="finantial_header" >
									<b>{$user_event_attendance[inst].event_date}</b>: {$user_event_attendance[inst].name} 
								</div>
								{/section}
								<br />
							</div>

							<div id="calendar">
								{$calendar}
							</div>



						</div>
						

					</div>


				</div> 

				<div id="mid-col" class="full-col">
				<div  id="message-info" class="hidden">
					<div class="box" id="to-do">
							<ul class="tab-menu">
								<li><a href="#inbox">Inbox</a></li>
								<li><a href="#outbox">Outbox</a></li>
								<li><a href="#sms">SMS's</a></li>
								<li><a href="#attach_in">Attachments Sent</a></li>
								<li><a href="#attach_out">Attachments Received</a></li>  
							</ul>

							<div class="box-container" id="inbox">
								<h3 class="green">Inbox <div class="right">	<input type="input" name="search" id="inbox_search" class="right" value="Search..." onclick="if(this.value=='Search...') this.value =''; " /></div></h3>
								<div id="inbox_items">
									<table class="table-short" style="width:100%">
									<thead>
										<tr>
											<td>Date</td>
											<td>Title</td>
											<td>Message</td>
											<td>Send by</td>
										</tr>
									</thead>

									<tbody>
										{section name=inst loop=$inbox.messages}
											<tr {cycle values="class='odd',"}>
												<td >
													{if $inbox.messages[inst].opened eq 0 and $box neq 'outbox'}
														<img src="/views/app/images/unread.png" style="position:relative;top:8px;">&nbsp;
													{/if}
													<small style="font-size:10px;">{$inbox.messages[inst].created_on|date_format}</small>
												</td>
												<td class="col-second"><a href="/message/view/{$inbox.messages[inst].id}">{$inbox.messages[inst].title|truncate:30}</a></td>
												<td >{$inbox.messages[inst].message|strip_tags|truncate:28}</td>


												<td class="col-second">
													
														<a href="/{$inbox.messages[inst].sender_id}">{$inbox.messages[inst].name} {$inbox.messages[inst].surname}</a>

												</td>
		
											</tr>
										{/section}
									</tbody>
								</table>
							</div>
							<br />
							



							</div>

							<div class="box-container" id="outbox">

								<h3 class="green">Outbox <div class="right">	<input type="input" name="search" id="outbox_search" class="right" value="Search..." onclick="if(this.value=='Search...') this.value =''; " /></div></h3>
							<div id="outbox_items">
										<table class="table-short" style="width:100%">
											<thead>
												<tr>
													<td>Date</td>
													<td>Title</td>
													<td>Message</td>
													
												</tr>
											</thead>

											<tbody>
												{section name=inst loop=$outbox.messages}
													<tr {cycle values="class='odd',"}>
														<td >
															{if $outbox.messages[inst].opened eq 0 and $box neq 'outbox'}
																<img src="/views/app/images/unread.png" style="position:relative;top:8px;">&nbsp;
															{/if}
															<small style="font-size:10px;">{$outbox.messages[inst].created_on|date_format}</small>
														</td>
														<td class="col-second"><a href="/message/view/{$outbox.messages[inst].id}">{$outbox.messages[inst].title|truncate:30}</a></td>
														<td >{$outbox.messages[inst].message|strip_tags|truncate:28}</td>

													</tr>
												{/section}
											</tbody>
								</table>
							</div>


							</div>

							<div class="box-container" id="sms">
              					{include file="sms.tpl"}
							</div>

							<div class="box-container" id="attach_in">
									{if $received_attachments}
										<h3 class="green">Attachments sent</h3>
										{section name=inst loop=$received_attachments}
											<div class="attachment" style="float:left">
												<a href="/message/download_attachment/{$received_attachments[inst].id|@md5}" class="tips" title="{$received_attachments[inst].created_on}">	{mime_type filename=$received_attachments[inst].filename size=16} {$received_attachments[inst].filename}
												</a>
											</div>
										{/section}
										<div style="clear:both"></div>
										<br />
									{/if}
									


							</div>

							<div class="box-container" id="attach_out">

									{if $sent_attachments}
										<h3 class="green">Attachments received</h3>

										{section name=inst loop=$sent_attachments}
											<div class="attachment" style="float:left">
												<a href="/message/download_attachment/{$sent_attachments[inst].id|@md5}" class="tips" title="{$sent_attachments[inst].created_on}">	{mime_type filename=$sent_attachments[inst].filename size=16} {$sent_attachments[inst].filename}
												</a>
											</div>
										{/section}
										<div style="clear:both"></div>
										<br />
									{/if}

							</div>



					</div>

				</div>
				<div class="" id="profile-info">
					<div class="box">

						<div class="box" id="to-do">
							<ul class="tab-menu">
								<li><a href="#personal">Personal</a></li>
								<li><a href="#banking">Bank</a></li>
								{if $is_alumni}
									<li><a href="#alumni">Alumni</a></li>
								{/if}
								<li><a href="#contact">Contact</a></li>
								<li><a href="#scholarship">Scholarship</a></li>
								<li><a href="#academics">Academics</a></li>  
								<li><a href="#internship">Work</a></li>
								<li><a href="#letter">Letters</a></li>
								<li><a href="#notes">Notes</a></li>
								{if !$is_alumni}
									<li><a href="#feed">Log</a></li>
								{/if}

							</ul>




							<div class="box-container" id="personal">
								<h3 class="green">Personal Details
										
								{if strlen($profile.passport_image)}
										<div style="float:right">
									<a style="font-size:12px;margin-top:8px" href="/media/passport/{$profile.passport_image}">View Passport</a>
									</div>
									<div style="clear:both"></div>
								{/if}


										
								</h3>

								{if $invalid|default:no eq 'personal'}
								<div class="error">Could not save your personal infomation. Please make sure all fields are filled out correctly</div>
								{/if}
								<form action="/profile/add/{$data.id|default:0}/0/#personal" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<fieldset class='fieldset-profile'>
										<legend>{if $profile.id|default:0 eq 0}Create a new{else}Update current{/if} Profile</legend>
										<ol>
											                                <li >
                                    <label class="field-title" for="field_initial">Name:</label>
                                    <label>{$u_profile.name}</label>
                                    <span class="clearFix">&nbsp;</span>
                                </li>
                                <li >
                                    <label class="field-title" for="field_initial">Surname:</label>
                                    <label>{$u_profile.surname}</label>
                                    <span class="clearFix">&nbsp;</span>
                                </li>

                                <li >
                                    <label class="field-title" for="field_salutation">Preferred Name:</label>
                                    <label>{$profile.salutation}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=salutation}
                                </li>
                                <li >
                                    <label class="field-title" for="field_title">Title:</label>
                                    <label>{$profile.title}</label>

                                    {error field=title}
                                </li>
                                <li >
                                    <label class="field-title" for="field_id_num">Cellphone number:</label>
                                    <label>{$profile.cell_number}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=cell_number equal=10}
                                </li>

                                <li >
                                    <label class="field-title" for="field_id_num">Id number:</label>
                                    <label>{$profile.id_num}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=id_num}
                                </li>
                                <li >
                                    <label class="field-title" for="field_id_type">Id type:</label>
                                    <label>{$profile.id_type}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=id_type}
                                </li>
                                <li >
                                    <label class="field-title" for="field_date_of_birth">Date of birth:</label>
                                    <label>{$profile.date_of_birth}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=date_of_birth}
                                </li>

                              
                                <li >
                                    <label class="field-title" for="field_race">Race:</label>
                                    <label>{$profile.race}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=race}
                                </li>
                               

                                    <li >
                                        <label class="field-title" for="field_race">Ethnic Group:</label>
                                        <label>{$profile.ethnic_group}</label>
                                        <span class="clearFix">&nbsp;</span>
                                        {error field=ethnic_group}
                                    </li>

                                <li >
                                    <label class="field-title" for="field_nationality">Religion:</label>
                                    <label>{$profile.religion}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=religion}
                                </li>


                                <li >
                                    <label class="field-title" for="field_nationality">Nationality:</label>
                                    <label>{$profile.nationality}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=nationality}
                                </li>



                                <li >
                                    <label class="field-title" for="field_marital_status">Marital status:</label>
                                    <label>{$pofile.marital_status}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=marital_status}
                                </li>
                                <li >
                                    <label class="field-title" for="field_gender">Gender:</label>
                                    <label>{$profile.gender}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=gender}
                                </li>
                                <li >
                                    <label class="field-title" for="field_first_language">First language:</label>
                                    <label>{$profile.first_language} </label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=first_language}
                                </li>


                                <li >
                                    <label class="field-title" for="field_drivers">How many children do you have:</label>
                                    <label>{$profile.have_children}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=have_children}
                                </li>
                                <li >
                                    <label class="field-title" for="field_passport">Passport:</label>
                                    <label>{$porfile.passport}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=passport}
                                </li>
                               
										</ol>
									</fieldset>

									<br /> <br />
									
									<br />
									<h3 class="green">More About Yourself</h3>
								{if $invalid|default:no eq 'misc'}
								<div class="error">Could not save your `More About Yourself` infomation. Please make sure all fields are filled out correctly</div>
								{/if}
								<form action="/profile/add/{$data.id|default:0}/3#intrests" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<fieldset>
										<ol>
											<li >
												<label class="field-title" for="field_hobbies">Awards/Prizes:</label>
												<label>{$profile.awards}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li class='even'>
												<label class="field-title" for="field_hobbies">Family background:</label>
												<label>{$profile.family_background}</label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title" for="field_hobbies">Interests / Hobbies / Extra Curricular Activities:</label>
												<label>{$profile.hobbies}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											{**
											<li >
												<label class="field-title" for="field_bank_boot_size">Boot Size:</label>
												<label>{$profile.bootsize}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li class='even'>
												<label class="field-title" for="field_bank_branch_name">Overall Size:</label>
												<label>{$profile.overallsize}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											**}
										</ol>
									</fieldset>

								</form>
							</div>

							<div class="box-container" id="banking">
							<form action="/profile/add/{$data.id|default:0}/3#intrests" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<h3 class="green">Banking Details</h3>

									<fieldset class='fieldset-profile'>
										<ol>
											<li >
												<label class="field-title" for="field_bank">Bank:</label>
												<label>{$profile.bank}</label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title" for="field_bank_acc">Account number:</label>
												<label>{$profile.bank_acc}</label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li>
												<label class="field-title" for="field_bank_branch">Branch code:</label>
												<label>{$profile.bank_branch}</label>
												<span class="clearFix">&nbsp;</span>
											</li>
											<li >
												<label class="field-title" for="field_bank_branch_name">Branch Name:</label>
												<label>{$profile.bank_branch_name}</label>
												<span class="clearFix">&nbsp;</span>
											</li>

											<li >
												<label class="field-title" for="field_bank_branch_name">Account Type:</label>
												<label>
													{if $profile.account_type eq 1}
													Cheque
													{/if}
													{if $profile.account_type eq 2}
													Savings
													{/if}
												</label>
												<span class="clearFix">&nbsp;</span>
											</li>

										</ol>
									</fieldset>
								</form>
							</div>

							<div class="box-container" id="contact">
								{if $invalid|default:no eq 'contact'}
								<div class="error">Could not save your contact infomation. Please make sure all fields are filled out correctly</div>
								{/if}
								<form action="/profile/add/{$data.id|default:0}/1#contact" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<table width="100%">
										<tr>
											<td valign="top">
												<span class="clearFix">&nbsp;</span>
												<h3 class="green">Home</h3>
												<fieldset>
													<ol>
 <li class='even'>
                                                <label class="field-title" for="field_home_address">Address:</label>
                                                <label>{$profile.home_address}</label>
                                                <span class="clearFix">&nbsp;</span>
						                          {error field=home_address}
                                            </li>
                                            <li >
                                                <label class="field-title" for="field_home_relationship">Emergency contact:</label>
                                                <label>{$profile.home_relationship}</label>
                                                <span class="clearFix">&nbsp;</span>
                                            </li>

                                            <li {if $data.home_relationship neq 'Other'} style="display:none" {/if} >
                                                <label class="field-title" for="field_home_relationship">Emergency contact other:</label>
                                                <label>{$profile.home_relationship}</label>
                                                <span class="clearFix">&nbsp;</span>
                                            </li>

                                            <li class='even'>
                                                <label class="field-title" for="field_home_cell">Emergency contact name:</label>
                                                <label>{$profile.home_cell}</label>
                                                <span class="clearFix">&nbsp;</span>
                                            </li>
                                            <li >
                                                <label class="field-title" for="field_home_email">Emergency contact number:</label>
                                                <label>{$profile.home_email}</label>
                                                <span class="clearFix">&nbsp;</span>
                                            </li>

													</ol>
												</fieldset>
											</td>
											<td valign="top">
												<span class="clearFix">&nbsp;</span>
												<h3 class="green">University</h3>
												<fieldset>
													<ol>
														<li >
															<label class="field-title" for="field_uni_address">Address:</label>
															<label>{$profile.uni_address}</label>
															<span class="clearFix">&nbsp;</span>

														</li>
														<li>
															<label class="field-title" for="field_uni_cell">Cellphone Number:</label>
															<label>{$profile.uni_cell}</label>
															<span class="clearFix">&nbsp;</span>

														</li>
														<li >
															<label class="field-title" for="field_uni_email">Email:</label>
															<label>{$profile.uni_email}</label>
															<span class="clearFix">&nbsp;</span>

														</li>
														<li>
															<label class="field-title" for="field_address_to_use">Address to use:</label>
															<label>{$profile.address_to_use}</label>
															<span class="clearFix">&nbsp;</span>
														</li>
													</ol>
												</fieldset>
											</td>
										</tr>
									</table>
									<br />

								</form>
							</div>

							<div class="box-container" id="alumni">
									<form action="/profile/add/{$data.id|default:0}/0/#personal" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<h3 class="green">Alumni information</h3>
									<fieldset>
										<legend></legend>
										<ol>
					<li class='even  '>
						<label class="field-title" for="field_work_for">Are you working:</label>
						<label>{$alumni.are_you_working}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=are_you_working}
					</li>
					{if $alumni.are_you_working eq 'Yes'}

					<li  >
						<label class="field-title" for="field_work_for">What organisation do you work for:</label>
						<label>{$alumni.work_for}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=work_for}
					</li>
					<li class='even  '>
						<label class="field-title" for="field_hired_after">How long did it take you to get the job after graduating:</label>
						<label>{$alumni.hired_after}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=hired_after}
					</li>
					<li >
						<label class="field-title" for="field_monthly_salary">Monthly salary:</label>
						{$alumni.monthly_salary}
						<span class="clearFix">&nbsp;</span>
						{error field=monthly_salary}
					</li>
					<li class='even  '>
						<label class="field-title" for="field_have_contributed">Have you contributed to the Moshal Scholarship Program or to a charity:</label>
						<label>{$alumni.have_contributed}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=have_contributed}
					</li>
					{if $alumni.have_contributed eq 'Yes'}

					<li class=' '  id='contribution'>
						<label class="field-title" for="field_contributed">What have you contributed?</label>
						<label>{$alumni.contributed}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=contributed}
					</li>
					{/if}

					
					{/if}
											
										</ol>
									</fieldset>
									</form>
							</div>

							<div class="box-container" id="scholarship">
								<form action="/profile/add/{$data.id|default:0}/0/#personal" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<h3 class="green">Scholarship information</h3>
									<fieldset>
										<legend></legend>
										<ol>
											<li class='even'>
												<label class="field-title" for="field_student_number">Student number:</label>
												<label>{$scholarship.student_number}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li >
												<label class="field-title" for="field_award_date">Award date:</label>
												<label>{$scholarship.award_date}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li class='even'>
												<label class="field-title" for="field_year_of_study">Study Year:</label>
												<label>{$scholarship.year_of_study}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li >
												<label class="field-title" for="field_grad_date">Graduate date:</label>
												<label>{$scholarship.grad_date}</label>
												<span class="clearFix">&nbsp;</span>

											</li>

											<li >
												<label class="field-title" for="field_grad_date">Are you currently studying a postgraduate degree:</label>
												<label>{$scholarship.postgrad}</label>
												<span class="clearFix">&nbsp;</span>

											</li>

											{if $scholarship.postgrad eq 'Yes'}
											<li >
												<label class="field-title" for="field_grad_date">Postgraduate date</label>
												<label>{$scholarship.postgrad_date}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
																						<li >
												<label class="field-title" for="field_grad_date">Are you studying part-time/full-time:</label>
												<label>{$scholarship.postgrad_type}</label>
												<span class="clearFix">&nbsp;</span>

											</li>




											{/if}
											<li class='even'>
												<label class="field-title" for="field_years_to_complete">Years to complete:</label>
												<label>{$scholarship.years_to_complete}</label>
												<span class="clearFix">&nbsp;</span>

											</li>


											<li >
												<label class="field-title" for="field_residence">Where do you stay:</label>
												<label>{$scholarship.residence}</label>
												<span class="clearFix">&nbsp;</span>

											</li>

											<li >
												<label class="field-title" for="field_degree">Your Degree:</label>
												<label>{$scholarship.degree}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li class='even'>
												<label class="field-title" for="field_university">Your University:</label>
												<label>{$scholarship.university}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li >
												<label class="field-title" for="field_campus">Your Campus:</label>
												<label>{$scholarship.campus}</label>
												<span class="clearFix">&nbsp;</span>

											</li>
											<li class='even'>
												<label class="field-title" for="field_discipline">Your Discipline:</label>
												<label>{$scholarship.discipline}</label>
												<span class="clearFix">&nbsp;</span>
											</li>
										</ol>
									</fieldset>
								</form>
							</div>




							<div class="box-container" id="academics">
								<form action="/profile/add/{$data.id|default:0}/0/#personal" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<h3 class="green">Academic Information</h3>

									{if $academic_results}
									    <strong>Academic History</strong><br /><br />
	
										{section name=inst loop=$academic_results}

											{if $academic_results[inst].result neq 'Pending'}
														{if $academic_results[inst].result eq 'Yes'} Passed {else} Failed {/if} on {$academic_results[inst].created_on}<br /><br />

											{/if}
								
										{/section}

									{/if}

									{section name=inst loop=$academics}
									<fieldset class='fieldset-profile'>
										<legend></legend>
										<ol>
											<li class='even' style="width:95%">
												<table border="1">
													<tr>
														{if $academics[inst].university_year eq 'Grade 12'}
														<td width="400"><b>Grade 12 Results:</b> {$academics[inst].school_name} - {$academics[inst].calendar_year}</a></td>
														<td><b>Address:</b> {$academics[inst].school_address}
														{else}
														<td><b>{$academics[inst].calendar_year}:</b> {$academics[inst].university_year} - {$academics[inst].acadmic_record_type}
														{/if}

														{if strlen($academics[inst].file)}
															- <a  href="/media/academics/{$academics[inst].file}">Download Results</a>
														{/if}

														{if strlen($academics[inst].acadmic_record_type eq 'Final results')}
														<td width="50" ></td>
														<td  >
															<b>Academic Progress Result:</b>
															{cfield field=acadmic_progress_result value=$data.acadmic_progress_result}
															
														{if field-acadmic_progress_result eq 'Other'}
															
									                          <td id='acadmic_record_type_other' >
									                          <input type="text" value="{$data.acadmic_progress_result}" name="data[acadmic_progress_result]" id="acadmic_progress_result_other" />
									                          </td>
									                        
									                        
									                    {/if}
														</td>	
														{/if}


														</td>
													</tr>

												</table>

												<span class="clearFix">&nbsp;</span>
											</li>

										</ol>
									</fieldset>
									<br />
									<table width="100%" style="margin-left:30px;">
										<tr>
											<td><b>Subject</b></td>
											<td><b>Result</b></td>
											<td><b>Credit</b></td>
										</tr>
										<tr><td colspan="4"><br /></td></tr>
										{section name=subject_inst loop=$academics[inst].subjects}
										<tr>
											<td>{$academics[inst].subjects[subject_inst].subject}</td>
											<td>{$academics[inst].subjects[subject_inst].mark}</td>
											<td>{$academics[inst].subjects[subject_inst].credits}</td>
										</tr>
										{/section}
									</table>

									{/section}

								</form>
							</div>

							<div class="box-container" id="internship">

								<h3 class="green">Part-time/Vac work</h3><br />


								{section name=inst loop=$internships}
								<h5 style="padding-left:0px;margin-left:0">{$internships[inst].date_started|date_format} - {$internships[inst].date_ended|date_format}</h5>
								<form action="/profile/add/{$data.id|default:0}/0/#personal" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
									<fieldset class='fieldset-profile'>
										<legend></legend>
										<ol>
											<li class='even' style="width:95%;height:30px;">
												<table width="100%">
													<tr>
														<td width="33%"><b>Company:</b> {$internships[inst].name}</td>
														<td width="33%"><b>Location:</b> {$internships[inst].location}</td>
														<td width="33%"><b>Work type:</b> {$internships[inst].work_type}</td>
													</tr>
													<tr>

														<td width="33%"><b>Reported to:</b> {$internships[inst].reported_to}</td>
														<td  width="33%"><b>Email for work contact person:</b> {$internships[inst].reported_to_num}</td>
														<td  width="33%">&nbsp;</td>

													</tr>

												</table>
												<span class="clearFix">&nbsp;</span>
											</li>
										</ol>
									</fieldset>
								</form>

								<div style="padding:10px 20px">
									<p>{$internships[inst].description}</p><br />
									<a class="comment"  id="add_comment_{$internships[inst].id}">Comment</a>
									<div id="comment_container_{$internships[inst].id}" style="display:none">
										<form action="/comment/add/internship/{$internships[inst].id}/" method="POST">
											<textarea id="intern_comment_{$internships[inst].id}" rows="5" style="width:98%" cols="25" name="data[comment]" id='note' rows="5"></textarea>
											<input type="button" id="comment_save_{$internships[inst].id}" class="submit comment-save" value="Create Comment">
										</form>
									</div><br /><br />

									<div id='comments-content-{$internships[inst].id}'>
										{section name=inst_comments loop=$comments}
										{if $comments[inst_comments].ident_id eq $internships[inst].id}
										<div id='note-{$comments[inst_comments].id}'>
											<div class='note-header'>
												<div class='note-by'>{$comments[inst_comments].name} {$comments[inst_comments].surname} {if $comments[inst_comments].group_id eq 7} (Mentor) {/if}</div>
												<div class='note-date'>{$comments[inst_comments].created_on|date_format}</div>
												<div style="clear:both"></div>
											</div>
											<p class="note">{$comments[inst_comments].comment}</p>
											<div class='note-options'>
												<a href='/comment/edit/{$comments[inst_comments].comment_id}/{$u_profile.id}' title='Edit comment' class='table-edit-link'></a>
												<a title='Create Comment'  class='table-delete-link' href='/comment/delete/{$comments[inst_comments].comment_id}/{$u_profile.id}'></a>&nbsp;&nbsp;
											</div>
											<div style="clear:both"></div>
										</div>
										{/if}
										{/section}
									</div>
								</div>

								{/section}

							</div>
							<div class="box-container" id="social">

								<h3 class="green">Social bookmark information</h3><br />
									{if strlen($profile.facebook_url)}
										<img src="/views/app/social/facebook.png" align="left" /> &nbsp;&nbsp; <a href="{$profile.facebook_url}" target="_blank">View facebook profile page</a> <br /><br />
									{/if}
									{if strlen($profile.twitter_url)}
										<img src="/views/app/social/twitter.png" align="left"  /> &nbsp;&nbsp; <a href="{$profile.twitter_url}" target="_blank">View Twitter profile page</a><br /><br />

									{/if}									
									{if strlen($profile.linkedin_url)}
										<img src="/views/app/social/linkedin.png" align="left"  /> &nbsp;&nbsp;<a href="{$profile.linkedin_url}" target="_blank">View LinkedIn profile page</a><br /><br />

									{/if}

							</div>
							<div class="box-container" id="letter">
								
								<div id="actions"> 
									{section name=inst loop=$letters}
										<h3 class="green">Letters to Martin: {$letters[inst].letter_date}</h3>
										{$letters[inst].letter}
										<div class="clear"></div>
									{sectionelse}
									<h3 class="green">Annaul letters to Martin</h3>
									No Letters were submitted
									{/section}
								</div>
							</div>

							<div class="box-container" id="notes">

								<h3 class="green">Notes({$note_count})</h3>

								<form id="comment-form-serialize">
									<div id="comment-body">
										<textarea id="wysiwyg" rows="5" style="width:98%" cols="25" name="data[note]" id='note' rows="5"></textarea>
									</div>

									{cfield field='note_type' value=''}&nbsp;&nbsp;

									<input type="button" id='note-save' class="submit" value="Create note">
								</form>
								<div style="clear:both"></div>
								<br /><br />

								<div id='notes-content'>
									{section name=inst loop=$notes}
									{if $notes[inst].parent_id eq 0}
									<form action="/note/add/0/{$u_profile.id}/{$notes[inst].id}/" method="POST">
										<div id='note-{$notes[inst].id}'>
											<div class='note-header'>
												<div class='note-by'><b>{$notes[inst].note_type}</b>&nbsp;:
													{if $notes[inst].created_by eq 64}
													Careerwise - John
													{else}
													{$notes[inst].created} {if $notes[inst].group_id eq 7} (Mentor) {/if}
													{/if}</div>
													<div class='note-date'>{$notes[inst].created_on|date_format}</div>
													<div style="clear:both"></div>
												</div>
												<p class="note">{$notes[inst].note}</p>
												<div class='note-options'>
													<div style="position: relative; top: -4px; float: left;">
														<select id="{$notes[inst].id}" class="follow" name="data[note_type]">
															<option value="">Create a new:</option>
															<option value="Requests">Request</option>
															<option value="Follow up">Follow up</option>
														</select>
													</div>&nbsp;&nbsp;
													{if $user->can_access('note','edit')}<a href='/note/edit/{$notes[inst].id}/{$u_profile.id}' title='Edit Note' class='table-edit-link'></a>{/if}
													{if $user->can_access('note','delete')}<a title='Delete Note'  class='table-delete-link' href='/note/delete/{$notes[inst].id}/{$u_profile.id}'></a>&nbsp;&nbsp;{/if}
												</div>
												<div style="clear:both"></div>
											</div>
											<div id="followup_container_{$notes[inst].id}" style="display:none">
												<textarea id="note_comment_{$notes[inst].id}" rows="5" style="width:98%" cols="25" name="data[note]" id='note' rows="5"></textarea>
												<input type="submit" id="note_save_{$notes[inst].id}" class="submit follow-up-save" value="">
											</div>
											{section name=inst2 loop=$notes}
											{if $notes[inst2].parent_id eq $notes[inst].id}
											<div id='note-{$notes[inst2].id}' style="margin-left:50px">
												<div class='note-header'>
													<div class='note-by'><b>{$notes[inst2].note_type} {if $notes[inst].group_id eq 7} (Mentor) {/if}</b>: {$notes[inst2].created}</div>
													<div class='note-date'>{$notes[inst2].created_on|date_format}</div>
													<div style="clear:both"></div>
												</div>
											</div>
											<p class="note" style="margin-left:50px">{$notes[inst2].note}</p>
											<div class='note-options'>
												{if $user->can_access('note','edit')}<a href='/note/edit/{$notes[inst2].id}/{$u_profile.id}' title='Edit Note' class='table-edit-link'></a>{/if}
												{if $user->can_access('note','delete')}<a title='Delete Note'  class='table-delete-link' href='/note/delete/{$notes[inst2].id}/{$u_profile.id}'></a>&nbsp;&nbsp;{/if}
											</div>
											<div style="clear:both"></div>

											{/if}
											{/section}
										</form>
										{/if}
										{/section}
									</div>



								</div>

								<div class="box-container" id="feed">




									<h3 class="green">Activity Feed</h3>
									<div id="actions"> 
										{section name=inst loop=$actions}
										<div id="action_{$actions[inst].id}" class="action">
											<table cellpadding="5" cellspacing="5" width="100%">
												<tbody><tr>
													<td valign="top">
														<img src="{$template_dir}/images/feed/{$actions[inst].type_id}.gif" alt="{$actions[inst].type_id}" class="icon" border="0">
													</td>
													<td valign="top" width="100%">
														<div class="home_action_date">{$actions[inst].created_on|date_format}</div>
														{$actions[inst].action}
													</td>
												</tr>
											</tbody></table>
										</div>
										{sectionelse}
										No Activity feeds found
										{/section}
									</div>
								</div>

							</div>

						</div>
					</div> 
				</div>
			</div>
				<span class="clearFix">&nbsp;</span>    
				{include file="footer.tpl"}
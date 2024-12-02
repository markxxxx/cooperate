{include file="header.tpl"}
{head}
<script type='text/javascript' src='/include/js/jquery/jquery.bgiframe.min.js'></script> 
<script type='text/javascript' src='/include/js/jquery/jquery.dimensions.js'></script> 
<script type='text/javascript' src='/include/js/jquery/jquery.autocomplete.js'></script> 
<script type='text/javascript' src='/include/js/jquery/jquery.autocompletefb.js'></script> 
<script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>

<script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" href="/include/js/jquery/jquery.autocompletefb.css" /> 
<link href="/include/js/tool/tipsy.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/views/app/css/attachment.css?v=1" media="screen" rel="stylesheet" type="text/css" />


<script src="/include/uploader/jquery.ui.widget.js"></script>
<script src="/include/uploader/jquery.iframe-transport.js"></script>
<script src="/include/uploader/jquery.fileupload.js"></script>

<script type='text/javascript' src='/views/app/js/home.js?new=6'></script>
<script type='text/javascript' src='/views/app/js/attachment.js?new=8'></script>

{/head}


{include file="filter_options.tpl"}


<div id="content">
	<div id="content-top">
		{if count($filters)}
		<h2 style="font-size:20px;margin-right:10px">{if $user->is_admin()} Filters: {else}Tomorrow Trust Scholarship Program {/if}</h2>
			{include file="filter_list.tpl"}

		{else}
			{if $user->is_admin()}
				<h2 style="font-size:20px;margin-right:10px">Filters: </h2>
				<a class="minibutton">All users</a>
			{/if}
		{/if}


		{if $user->can_access('domain', 'select')}


			<div type="submit"  class="minibutton bblue modal_dashboard right" style="text-shadow:none"> {$user_count} Scholars: Change filters</div>


		{/if}

		{if $user->is_bursar()}
			{if $incomplete_tasks}
				<div class="error" style="width:260px;float:right; position:relative;top:5px; background-position: 3px 5px;">&nbsp;&nbsp;Please note: You have {$incomplete_tasks|@count} Incomplete Tasks</div>
			{/if}
		{/if}
		<span class="clearFix">&nbsp;</span>
	</div>
	<div id="left-col">


		<div class="box">
			<h4 class="yellow">Compose Message</h4>
			<div class="box-container">


				<div id="quick-send-message-container">
					<h5>
						{if $attachment_count neq 0}
							{$attachment_count} files attached
							<a href="/message/remove_attachments" class="selected" title="Remove attachments"><img src="/views/app/images/icon-delete.gif"></a>
						{else}
							{if $user->can_access('sms', 'send')}
								<legend><a id="message-type" href="#" style="float:left;text-decoration:none;">Click here to send SMS's</a> </legend>
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
									<p><label><input name="send-everyone" id='send-everyone' type="checkbox" value="" />To Everyone</label>

									</label> </p>
									<ul id="message" class="first acfb-holder">
										<input type="text" id="id_message_text" class="city acfb-input"/>
									</ul>

									<div id="add_cc" style="display:none">
										<p><br/><label>CC</label></p>
										<ul id="cc" class="first acfb-holder">
											<input type="text" id="id_cc_text" class="city acfb-input"/>
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
									<input name="title" id="message-title" type="text" /></p>
								<p><label>Content:</label>
									<textarea name="message" id='message-body' cols="10" rows="5"></textarea></p>
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

	{if $user->can_access('task','add')}
		<div class="box">
			<h4 class="light-blue">New task</h4>
			<div class="box-container">

				<div id="quick-task-container">

					<h5>Quick Task </h5>
					<form id="form2"  method="get" action="" autocomplete="off">
						<p><label><input name="task-everyone" id='task-everyone' type="checkbox" value="" />To Everyone</label> </p>
						<ul id="task" class="first acfb-holder">
							<input type="text" id="id_task_text" class="city acfb-input"/>
						</ul><br />
						<p><label>Task:</label></p>
						<select id="task-type" style="width:100%">
							<option value=''>Select task:</option>
							<option value="u_upload">Request Latest Transcript upload</option>
							<option value="u_academic">Request Latest Academic information</option>
							<option value="u_work">Request Part-time/Vac work information</option>
							<option value="scolar">Request update on Scholarship information</option>
							<option value="a_result">Request passing information</option>


						</select>
						<span class="clearFix">&nbsp;</span>

							<br />
							<div class="align-right"><a href="#" id="send-task" class="minibutton bblue">Create task</a></div>
							<span class="clearFix">&nbsp;</span>
					</form>
				</div>
			</div>
		</div>
	{/if}



		{if $user->is_bursar()}
		<div class="box" id="to-do">
			<ul class="tab-menu">
				<li><a href="#to-dos">To Do</a></li>
				<li><a href="#completed">Completed</a></li>
			</ul>
			<div class="box-container" id="to-dos">
				<div id="to-do-list">
					<ul>
					{section name=inst loop=$incomplete_tasks}
						<li {cycle values="class='odd',class='even'"}>
							{$incomplete_tasks[inst].task}<br />
						</li>
					{sectionelse}
						<li {cycle values="class='odd',class='even'"}>
							All tasks completed
						</li>
					{/section}
					</ul>    

				</div>
			</div>

			<div class="box-container" id="completed">
				<div id="to-do-list">
					<ul>
						{section name=inst loop=$complete_tasks}
							<li {cycle values="class='odd',class='even'"}>
							{$complete_tasks[inst].task}<br />
							</li>
						{sectionelse}
						{/section}
					</ul>
				</div>
			</div>  
		</div>
	{/if}
	</div> 

	<div id="mid-col">
		

	{if $user->is_bursar() && $user->can_access('event','rsvp')}
		{if count($event_rsvps)}
			<div class="box">
				<h4 class="white">Please provide us with your RSVP</h4>
				<div class="box-container">
					<div id="actions">
						{section name=inst loop=$event_rsvps}
							<div id="action_{$event_rsvps[inst].id}" class="action">
								<table cellpadding="5" cellspacing="5">
									<tbody><tr>
											<td valign="top">
												<img src="{$template_dir}/images/approvals/schedule.png"  class="icon" align="left" border="0">
											</td>
											<td valign="top" width="100%">
												<div class="home_action_date"><span style="margin-right:10px">{$event_rsvps[inst].event_date|date_format}</span> <a href="/event/rsvp/{$event_rsvps[inst].id}" class="cb_rsvp">RSVP now</a></div>
												{$event_rsvps[inst].name}  
											</td>
										</tr>
									</tbody></table>
							</div>
						{/section}
					</div>
				</div>
			</div>
		{/if}
	{/if}

		{if $user->is_bursar()  }
		{if isset($academic_results.Pending)}
			<div class="box">
				<h4 class="white">Have you passed your most recent semester/year/exams?</h4>
				<div class="box-container">
					<div id="actions">
						{section name=inst loop=$academic_results.Pending}
							<div id="action_{$event_rsvps[inst].id}" class="action">
								<table cellpadding="5" cellspacing="5">
									<tbody><tr>
											<td valign="top">
												<img src="{$template_dir}/images/approvals/schedule.png"  class="icon" align="left" border="0">

											</td>
											<td valign="top" width="100%">
												<div class="left"></div> <div style="font-size:11px" class="left">{$academic_results.Pending[inst].created_on|date_format}:  Have you passed?</div>
												<div class="home_action_date"><span style="margin-right:10px"></span> 
													
													<select name="passed" id="passed_{$academic_results.Pending[inst].id}" class="passed">
														<option>Pending</option>
														<option value="Yes">Yes</option>
														<option value="No">No</option>
													</select>
												</div>
												{$event_rsvps[inst].name}  
											</td>
										</tr>
									</tbody></table>
							</div>
						{/section}
					</div>
				</div>
			</div>
		{/if}
	{/if}

		{if $user->is_admin()}
			{if $approvals}
				<div class="box">      
					<h4 class="white">Please approve the following</h4>
					<div class="box-container">
						<div id="actions">
							{section name=inst loop=$approvals}
								<div id="action_{$approvals[inst].id}" class="action">
									<table cellpadding="5" cellspacing="5">
										<tbody><tr>
												<td valign="top">
													<img src="{$template_dir}/images/approvals/{$approvals[inst].ident}.png"  class="icon" align="left" border="0">
												</td>
												<td valign="top" width="100%">
													<div class="home_action_date"><a href="/approval/view/{$approvals[inst].id}">Approve</a></div>
													{$approvals[inst].notification}
												</td>
											</tr>
										</tbody></table>
								</div>

							{/section}
						</div>
					</div>
				</div>
			{/if}
		{/if}
		<div class="box">      
			<h4 class="white">Messages <a href="/dashboard/home/inbox" class="heading-link">Inbox</a> | <a style="padding-left:0px;" href="/dashboard/home/outbox" class="heading-link">Outbox</a></h4>
			<div class="box-container">
				<form action="" method="post" class="middle-forms">
					<h3 class="green">My {if $box eq 'inbox'}Inbox{else}Outbox{/if}</h3>
						{if $messages}
					<table class="table-short">
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
									<td class="col-second">
										{if strlen($messages[inst].title)}
											<a href="/message/view/{$messages[inst].id}">
												{$messages[inst].title|truncate:30}
											</a>
										{else}
											<a href="/message/view/{$messages[inst].id}">
												No title
											</a>
										{/if}
									</td>
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
						{pager url="dashboard/home/`$box`" current_page=$page total_rows=$total_messages per_page=$per_page}
					{else}
					You have not recieved any messages yet.
					{/if}
				</form>

			</div>
		</div>



		{if $user->is_admin()}
			<div class="box">      
				<h4 class="white">Activity Feed</h4>
				<div class="box-container">
					<div id="actions">
						{section name=inst loop=$actions}
							<div id="action_{$actions[inst].id}" class="action">
								<table cellpadding="5" cellspacing="5">
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
	{/if}

	</div>

	<div id="right-col">

	{if count($reminders)}

		<div class="box" id="to-do">
			<ul class="tab-menu">
				{if isset($reminders.mine)}
					<li><a href="#my_reminder">My Reminders({$reminders.mine|@count})</a></li>
				{/if}
				{if isset($reminders.all)}
					<li><a href="#all_reminders">All({$reminders.all|@count})</a></li>
				{/if}
			</ul>
			{if isset($reminders.mine)}
				<div class="box-container" id="my_reminder">
					<div id="to-do-list" >
						<ul >
							{section name=inst loop=$reminders.mine}
								<li {cycle values="class='odd',class='even'"}>
									<a href="/reminder/edit/{$reminders.mine[inst].id}">{$reminders.mine[inst].reminder|truncate:60}</a>
								</li>
							{/section}
						</ul>    

					</div>
				</div>
			{/if}
			{if isset($reminders.all)}
					<div class="box-container" id="completed">
						<div id="to-do-list">
							<ul>
								{section name=inst loop=$reminders.all}
									<li {cycle values="class='odd',class='even'"}>
									<a href="/reminder/edit/{$reminders.all[inst].id}">{$reminders.all[inst].task}<br />
									</li>
								{sectionelse}
								{/section}
							</ul>
						</div>
					</div>
			{/if}
			</div>

		{/if}



	{if $user->is_admin()}
		<div class="box">   
			<h4 class="light-blue">Quick Links</h4>
			<div class="box-container">

				<ul id="quick-visual-links">
					{if $user->can_access('payment','add')}<li><a href="/payment/add" class="modal_payment"><img src="{$template_dir}/images/ql-databases.gif" alt="" /><br/>Pay</a></li>{/if}
					{if $user->can_access('stats','index')}<li><a href="/stats"><img src="{$template_dir}/images/ql-users.gif" alt="" /><br/>Stats</a></li>{/if}
					{if $user->can_access('report','report')}<li ><a style="padding-right:0;margin-right:0px" href="/report"><img src="{$template_dir}/images/ql-settings.gif" alt="" /><br/>Reporting</a></li>{/if}
					{if $user->can_access('sms', 'stats')}
						<li ><a  href="/sms/stats"><img src="{$template_dir}/images/phone.png" alt="" /><br/>SMS staticstics</a></li>
					{/if}


					{if $user->can_access('letter', 'index')}
						<li ><a class="colorbox" href="/report/letter"><img src="{$template_dir}/images/ql-messages.gif" alt="" /><br/>Letters to martin</a></li>
					{/if}
					{if $user->can_access('cron_jobs','index')}<li ><a style="padding-right:0;margin-right:0px" href="/cron_job/"><img src="{$template_dir}/images/time.png"  /><br/>System Schedule </a></li>{/if}

					
				</ul>

				<span class="clearFix">&nbsp;</span> <br />

			</div>          
		</div>
	{/if}

		<div class="box">
			<h4 class="light-grey">
				{if $upcoming_events|default:0}
					You have <span class="selected" title="{foreach from=$upcoming_events key=month item=count}You have <b>{$count}</b> events in <b>{$month}</b><br /> {/foreach}.To view upcoming events use the next button on the calendar and hover over the highlighted date to get its details" id="event_counter">
					{$total_upcoming_events}</span> Upcoming Events.
					{else}
					My Calendar Events
				{/if}
			</h4>
			<div class="box-container">
				<div id="calendar-container">
					  {**  <h5 style="padding-left:0"><a href="/event/sync" style="color:#508DB8">Sync calendar with: <img border="none" alt="Outlook" src="{$template_dir}/images/outlook.jpg">&nbsp; 
					<img border="none" alt="ICal" src="{$template_dir}/images/icon-calendar.gif">&nbsp;
					<img border="none" alt="Google calendar" src="{$template_dir}/images/goolge.gif"></a></h5>**}
						{if $user->can_access('event', 'quick_add')}
					
					{/if}
					
					<div id="calendar">
						{$calendar}
					</div>


					{if $user->can_access('event', 'quick_add')}
						<div class="align-left"><a href="/event/add" class="minibutton bblue" id="new_event" >New Event</a></div>
					{/if}
					<span class="clearFix">&nbsp;</span>
					</div> 
				</div>
			</div>


		

		{if $annual_user_summary && $user->is_bursar() }
			<div class="box">
			  <h4 class="white">Financial Summary</h4>
			  <div class="box-container">
				{foreach from=$annual_user_summary key=year item=details}
					<div class="finantial_header" data-year={$year}>
						<img style="position:relative; top: -1px;left:-2px" src="/views/app/images/bg-toplevel.gif"/>&nbsp;<b>{$year} Overview:</b>&nbsp;&nbsp; R {$details.summary} 
					</div>
					<table  width="100%" id="report_{$year}" class="hidden report_break_down">
						{section name=inst loop=$details.rows}
							<tr>
								<td><b>{$details.rows[inst].reference	}: </b></td>
								<td>R {$details.rows[inst].total_expenditure}</td>
							</tr>
						{/section}
						<tr>
							<td colspan=2>
								<hr size="1" color="#CCC">
								
							<td>
						</tr>
					 </table>
				{/foreach}

			</div>
			</div>
		{/if}


	</div>

	<span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
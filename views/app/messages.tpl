{include file="header.tpl"}
{head}
<script type='text/javascript' src='/include/js/jquery/jquery.bgiframe.min.js'></script> 
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

<script type='text/javascript' src='/views/app/js/attachment.js?new=7'></script>


{/head}



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

				{if count($filters)}



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
				{/if}

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


{if $user->can_access('dashboard','set_filters')}

<div class="hidden">
	<div id="change_dashboard" style=" margin:20px"><h3 class="green" style="border-bottom:1px solid silver;padding-bottom:5px;margin-bottom:5px">Dashboard options<div style="float:right" >Total users: <span id="user_count">{$user_count}</span></div></h3>
		<br />
		<form action="/dashboard/set_filters/" id="message_counter" method="POST" />
			<table width="100%" style="border-spacing:5px;">
				<tr>
					<td>
						{if $user->can_access('domain', 'select')}
							{if $domains|count > 1 }
								<b>Domains:</b><Br />
								<ul class="checklist">
									{section name=inst loop=$domains}
										<li><label for="ck_domain_{$domains[inst].id}"><input type="checkbox"  name="domains[]"  {if in_array($domains[inst].id, $filter_domains )} checked {/if} value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}"/>{$domains[inst].domain}</label></li>
									{/section}
								</ul>
							{/if}
						{/if}
					</td>
					<td>
						<b>Universities:</b><Br />

						<ul class="checklist">
							{section name=inst loop=$universities}
								<li><label for="ck_universities_{$universities[inst]}"><input type="checkbox"  name="universities[]"
								 {if in_array($universities[inst], $filter_universities )} checked {/if}  value="{$universities[inst]}" id="ck_universities_{$universities[inst]}"/>{$universities[inst]}</label></li>
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
								{if in_array($study_years[inst], $filter_study_years )} checked {/if}
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
								{if in_array($groups[inst].id, $filter_groups )} checked {/if}
								/>{$groups[inst].name}</label></li>
							{/section}


						</ul>

					</td>
					<td valign="top">


					</td>

			   <tr>


			   </tr>
			</table>
			<input type="submit" class="minibutton" Value="Change Dashbord filter">

			<input type="button" class="minibutton bblue" value="Clear all" id="clear-filters">

		<br /><br />

		
	</div>
		</form>
		
</div>
{/if}

<div id="content-top" style="margin-top:20px">
		{if count($filters)}
		<h2 style="font-size:20px;margin-right:10px">Filters: </h2>

			{foreach from=$filters key=k item=v}

				{if count($v) > 1}
					<div id="dropdown-{$k}" class="dropdown dropdown-tip has-icons dropdown-relative">
						<ul class="dropdown-menu">

							{section name=inst loop=$v}
								{if $k == 'domains'}
									{section name=inst2 loop=$domains}
										{if $domains[inst2].id eq $v[inst]}
											<li class="{$v[inst]}"><a href="/dashboard/remove_filters/domains/{$domains[inst2].id}">{$domains[inst2].domain}<img src="/views/app/images/cross2.png" align="right"></a></li>
										{/if}
									{/section}
								{elseif $k == 'groups'}
									{section name=inst2 loop=$groups}
										{if $groups[inst2].id eq $v[inst]}
											<li class="{$v[inst]}"><a href="/dashboard/remove_filters/groups/{$groups[inst2].id}">{$groups[inst2].name}<img src="/views/app/images/cross2.png" align="right"></a></li>
										{/if}
									{/section}

								{else}
									<li class="{$v[inst]}"><a href="/dashboard/remove_filters/{$k}/{$v[inst]}">{$v[inst]}<img src="/views/app/images/cross2.png" align="right"></a></li>
								{/if}
							{/section}
							<li class="{$v[inst]}"><a href="/dashboard/remove_filters/{$k}/">Remove all<img src="/views/app/images/cross2.png" align="right"></a></li>
						</ul>
					</div>
				{/if}

			{/foreach}

			{foreach from=$filters key=k item=v}
			   {if count($v) eq 1}
					{if $k == 'domains'}
						{section name=inst loop=$domains}
							{if $domains[inst].id eq $v[0]}
								<a class="minibutton ajax-tip2" title="Remove filter" href="/dashboard/remove_filters/{$k}/{$domains[inst].id}" >{$domains[inst].domain}<img src="/views/app/images/cross2.png" align="right"></a>
							{/if}
						{/section}
					{elseif $k == 'groups'}
						{section name=inst loop=$groups}
							{if $groups[inst].id eq $v[0]}
								<a class="minibutton ajax-tip2" title="Remove filter" href="/dashboard/remove_filters/{$k}/{$groups[inst].id}" >{$groups[inst].name}<img src="/views/app/images/cross2.png" align="right"></a>
							{/if}
						{/section}

					{else}
						<a class="minibutton ajax-tip2" href="/dashboard/remove_filters/{$k}/{$v[0]}" title="Remove filter">{$v[0]}<img src="/views/app/images/cross2.png" align="right"></a>
					{/if}
					
			   {else}
					<a class="minibutton" data-dropdown="#dropdown-{$k}">{$v|@count} {$k|ucfirst|replace:'_':' '} selected<img src="/views/app/images/down_2.png" align="right"></a>
					
			   {/if}
			{/foreach}
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

<div class="box">      
	<h4 class="white">Messages 




<div class="minibutton right send_message"  style="position:relative;top:-5px;text-transform:none;margin-left:10px" >Send Message</div>




	</h4>
	<div class="box-container">
		<form action="" method="post" class="middle-forms">
			<h3 class="green">My {if $box eq 'inbox'}Inbox{else}Outbox{/if}</h3>
				{if $messages}
			<table class="table-short" style="width:100% !important">
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
</div>




{include file="footer.tpl"}
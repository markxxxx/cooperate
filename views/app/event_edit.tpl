{include file="header.tpl"}

{head}
	<link rel="stylesheet" type="text/css" href="/include/js/jquery/jquery.autocompletefb.css" />
	<script type='text/javascript' src='/include/js/jquery/jquery.autocomplete.js'></script> 
	<script type='text/javascript' src='/include/js/jquery/jquery.autocompletefb.js'></script> 
	<script type='text/javascript' src='/include/js/jquery/jquery.bgiframe.min.js'></script> 
	<script type='text/javascript' src='/include/js/jquery/jquery.dimensions.js'></script> 
	<script src="http://maps.googleapis.com/maps/api/js?key={$config.maps.api_key}&libraries=places&sensor=false"></script>

	{literal}
		<script>
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
			
			google.maps.event.addDomListener(window, 'load', initialize);

			$(function(){



				$('.rsvp_attended').change(function(){
					
					rsvp = $(this);
					id = rsvp.attr('id').split('_').pop();
					status = rsvp.is(':checked') ? 1 : 0;
					is_contact = rsvp.hasClass('is_contact') ? 1 : 0;
					$.get('/event/confirm_attended/'+$('#event_id').val()+'/'+id+'/'+status+'/'+is_contact);

				});

				$('.read_more').click(function(){
		            $(this).hide().next().show('slow');
		            return false;
		        });


		        $('.rsvp-update').change(function(){
					rsvp = $(this);
					id = rsvp.attr('contact-id');
					status = rsvp.val();
					$.get('/event/rsvp_update/'+$('#event_id').val()+'/'+id+'/'+status+'/');
					_alert('confirmation', 'RSVP updated');

				});


				var invite = $("#invite.acfb-holder").autoCompletefb({urlLookup:{/literal}{$uninvited_users}{literal}});

				var invite_contact = $("#invite_contact.acfb-holder").autoCompletefb({urlLookup:{/literal}{$uninvited_contacts}{literal}});

				// var search_invited = $("#search_invited.acfb-holder").autoCompletefb({urlLookup:{/literal}{$invited}{literal}});


				if($(".send_message").length) {
					$(".send_message").colorbox({fixedWidth:"50%", transitionSpeed:"100", inline:true, href:"#send_message"});
				}

				if($(".edit_event").length) {
					$(".edit_event").colorbox();
				}

				$('#send-invite').click(function(e){
					e.preventDefault();
					$(this).css('disabled',true);
					
					if( invite.getData().length == 0 ) {
						_alert("warning",'Invite requires recipients');
						return;
					}

					
					$.post("/event/invite/"+$('#event_id').val(), { 
						to: invite.getData(),
						save:true,
						send: $('#sendinvite').is(':checked')
					},
					function(data) {
						parent.location.href = '/event/edit/'+$('#event_id').val()+'?confirmation=Contacts invited successfully';
					});

				});

				// $('#add-invitee').click(function(e){
				// 	e.preventDefault();
				// 	$(this).css('disabled',true);
					
				// 	if( invite.getData().length == 0 ) {
				// 		_alert("warning",'Add requires recipients');
				// 		return;
				// 	}

				// 	$.post("/event/add_invitee/"+$('#event_id').val(), { 
				// 		to: invite.getData(),
				// 		save:true
				// 	},
				// 	function(data) {
				// 		parent.location.href = '/event/edit/'+$('#event_id').val()+'?confirmation=Contacts invited successfully';
				// 	});
				// });

				$('#send_contact-invite').click(function(e){
					e.preventDefault();
					$(this).css('disabled',true);
					
					if( invite_contact.getData().length == 0 ) {
						_alert("warning",'Invite requires recipients');
						return;
					}

					$.post("/event/invite_contact/"+$('#event_id').val(), { 
						to: invite_contact.getData(),
						save:true,
						send: $('#sendcontactinvite').is(':checked')
					},
					function(data) {
						parent.location.href = '/event/edit/'+$('#event_id').val()+'?confirmation=Contacts invited successfully';
					});
				});

				// $('#add_contact-invitee').click(function(e){
				// 	e.preventDefault();
				// 	$(this).css('disabled',true);
					
				// 	if( invite_contact.getData().length == 0 ) {
				// 		_alert("warning",'Add requires recipients');
				// 		return;
				// 	}

				// 	$.post("/event/add_contact/"+$('#event_id').val(), { 
				// 		to: invite_contact.getData(),
				// 		save:true
				// 	},
				// 	function(data) {
				// 		parent.location.href = '/event/edit/'+$('#event_id').val()+'?confirmation=Contacts invited successfully';
				// 	});
				// });

				// $('#search_invited_btn').click(function(e){

				// 	e.preventDefault();
				// 	$(this).css('disabled',true);
					
				// 	if( search_invited.getData().length == 0 ) {
				// 		_alert("warning",'Enter search criteria');
				// 		return;
				// 	}

				// 	$.post("/event/search_invited/"+$('#event_id').val(), { 
				// 		searchfor: search_invited.getData(),
				// 		search:true
				// 	},
				// 	function(data) {
				// 		parent.location.href = '/event/edit/'+$('#event_id').val()+'?confirmation=Contacts invited successfully';

				// 	});
				// });

				
				$('#search_invited_txt').keyup(function() {
				    
					var $rows = $('#invited_tbl tr');
					var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

				    $rows.show().filter(function() {
				        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				        return !~text.indexOf(val);

				    }).hide();

				    var pad_default_val = "0px";
      				$(".actiontbl").css("padding", pad_default_val);

				});


				$('#send').click(function(e){

					e.preventDefault();
					$(this).css('disabled',true);
					var input_error = '';


					if(!$('#message-title').val().length) {
						input_error = 'Message requires a title<br />';
						$('#message-title').css('border','1px solid red');
					}

					if(!$('#message-body').val().length) {
						input_error += 'Message requires a body<Br />';
						$('#message-body').css('border','1px solid red');
					}

					if(input_error.length) {

						$(this).css('disabled',false);
						_alert("warning", input_error);

					} else {
						$.post("/event/send_message/"+$('#event_id2').val(), { 
							title: $('#message-title').val(), 
							message: $('#message-body').val(), 
							send_to: $('#send_to').val()
						}, function(data) {
							$('#message-body').val('');
							$('#message-title').val('');
							_alert("confirmation",'Message sent successfully');
						});
					}
				});



			});
		</script>
	{/literal}
{/head}


<input type="hidden" value="{$event.id}" id="event_id" />


{if $user->can_access('event','message_send')}
<div class="hidden">
	<div id="send_message" style="width:500px;padding:20px;"><h3 class="green" style="border-bottom:1px solid silver">Send {$u_profile.name|ucfirst} {$u_profile.surname|ucfirst} a message</h2>
		<input type="hidden" value="{$event.id}" id="event_id2" />


		Send message to:
		<select id="send_to">
			<option value="all">Everyone invited</option>
			<option value="Pending">Pending</option>
			<option value="Yes">Yes</option>
			<option value="No">No</option>
		</select> <br />

		<br />
		Message Title:<br />
		<input name="title" id="message-title" type="text" /><br />
		Content: <br />
		<textarea name="message" id='message-body' cols="10" rows="5" style="width:100%"></textarea></p>
		<div class="inner-nav">
			<input  style="float:right;" name="send" class="minibutton bblue" type="button" value="Send Message" id="send" />
			<span class="clearFix">&nbsp;</span>
		</div>    
	</div>
</div>

{/if}

<div id="content">
	<div id="content-top">
		{if $user->can_access('event','export')}
			<a type="button" href="/event/export/{$event.id}"  style="float:left;margin-right:10px;text-decoration:none;color:gray" class="submit new_export" >Export</a>
		{/if}
		<h2>{$event.name}</h2>

	<div style="float:right;margin-top:3px;">


		{if count($event_domains) > 0}
			<div id="dropdown-events" class="dropdown dropdown-tip has-icons dropdown-relative">
				<ul class="dropdown-menu">
					{section name=inst2 loop=$event_domains}
						<li class=""><a href="#">{$event_domains[inst2].domain}</a></li>
					{/section}
				</ul>
			</div>

		{/if}

		Event managed by:
		{if $event_domains > 1}
			<div class="minibutton" data-dropdown="#dropdown-events">{$event_domains|@count} Domains <img src="/views/app/images/down_2.png" style="position:relative;top:3px"></div>
		{else}
			<div class="minibutton">{$event_domains[0].domain}</div>
		{/if}

		{if $user->can_access('event','resend_invite')}
			&nbsp;&nbsp;<a class="minibutton bblue" href="/event/resend_invite/{$event.id}">Resend event invitation</a>

		{/if}
	</div>
	  <span class="clearFix">&nbsp;</span>
	  </div>

	  <div id="map_canvas" style="width:100%; height:175px; "></div>
	  <Br /><Br />

	<div id="left-col">
		<div class="box">
			<h4 class="yellow"> Event details:&nbsp; {$event.event_date}</h4>
			<div class="box-container">

				{$event.event|read_more:150}
				<br /><br />
				<b>Created by:</b> {$owner->get_title()}<br />
				<br />
				<b>Location:</b><br /> <br />{$event.location}

				{if $user->can_access('event','quick_edit')}
					<br /><br />
					<a href="/event/quick_edit/{$event.id}" class="minibutton bblue edit_event" style="float:right">Edit event</a>
					<div style="clear:both"></div>
				{/if}

			</div>
		</div>

		<div id="left-col">
			<div class="box">
				<h4 class="yellow"> Invite Scholars</h4>
				<div class="box-container">
					<form action="/event/invite/{$event.id}">
						<ul id="invite" class="first acfb-holder">
							<input type="text" id="id_message_text" name="to" class="city acfb-input"/>
						</ul>
						<br />
						<input type="button" id="send-invite" class="minibutton bblue right" style="float:right" name="save" value="Invite">
						<!-- <input type="button" id="add-invitee" class="minibutton bblue right" style="float:right" name="save" value="Add invitees"> -->
						<input type="checkbox" id="sendinvite"   name="sendinvite" value="Send Invite" checked>Send Invite
						<div style="clear:both"></div>
					
					</form>
				</div>
			</div>
		</div>


		<div id="left-col">
			<div class="box">
				<h4 class="yellow"> Invite Contacts</h4>
				<div class="box-container">
					<form action="/event/invite_contact/{$event.id}">
						<ul id="invite_contact" class="first acfb-holder">
							<input type="text" id="id_message_text" name="to" class="city acfb-input"/>
						</ul>
						<br />
						<input type="button" id="send_contact-invite" class="minibutton bblue right" style="float:right" name="save" value="Invite">
						<!-- <input type="button" id="add_contact-invitee" class="minibutton bblue right" style="float:right" name="save" value="Add invitees"> -->
						<input type="checkbox" id="sendcontactinvite"   name="sendinvite" value="Send Invite" checked>Send Invite
						<div style="clear:both"></div>

					
					</form>
				</div>
			</div>
		</div>
	</div>



	<div id="mid-col" class="full-col">
		<div style="float:right"></div>
		<div class="box" id="to-do">
			<a href="#" class="send_message minibutton" style="float:right;position:relative;top:-6px"><img src="/views/app/images/mailmini.png" style="margin-left:0px" ></a>
			<ul class="tab-menu">
				<li><a href="#Feed">Feeds</a></li>
				<li><a href="#Yes">Yes ({$rsvp.Yes|@count})</a></li>
				<li><a href="#No">No ({$rsvp.No|@count})</a></li>
				<li><a href="#Pending">Pending ({$rsvp.Pending|@count})</a></li>
				{if $contacts}
					<li><a href="#Contact">Contacts ({$contacts|@count})</a></li>  
				{/if}
				<li><a href="#Search">Search </a></li>

				
				</li>

			</ul>

			<div class="box-container" id="Contact" >
				<h3 class="green">Contacts</h3>
				<div id="actions">
					{section name=inst loop=$contacts}
						<div  class="action">
							<table cellpadding="5" cellspacing="5">
								<tbody><tr>
										<td valign="top">
											<img src="/views/app/images/feed/group_action_joingroup.gif" alt="RSVP" class="icon" border="0" /> 
										</td>
										<td valign="top" width="100%">
											<div class="home_action_date">{$contacts[inst].invited_on|date_format}</div>
											{if strlen(!$contacts[inst].rsvp)}
												<a href="/contact/edit/{$contacts[inst].id}">{$contacts[inst].name}</a> has not responed.
											{else}
												<a href="/contact/edit/{$contacts[inst].id}">{$contacts[inst].name}</a> has responed
												{$contacts[inst].rsvp} 
												{if $contacts[inst].food_option|strlen && $contacts[inst].rsvp neq 'No'}
													and dietary are {$contacts[inst].food_option}
												{/if}


											{/if}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					{sectionelse}
							No Activity feeds found
					{/section}
				</div>
			</div>

			<div class="box-container" id="Feed" >
				<h3 class="green">Feeds</h3>

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
								</tbody>
							</table>
						</div>
					{sectionelse}
							No Activity feeds found
					{/section}
				</div>
			</div>



				{foreach from=$rsvp key=option item=r}
				
					<div class="box-container" id="{$option}">
						<h3 class="green">{$option}</h3>
						{section name=inst loop=$r}

							<div id="actions">

								{if $r[inst].rsvp eq 'Pending'}
									<div  class="action">
										<table cellpadding="5" cellspacing="5">
											<tbody><tr>
													<td valign="top">

														{if !isset($r[inst].surname)}
															<img src="/views/app/images/feed/group_action_joingroup.gif" alt="RSVP" class="icon" border="0" /> 
														{else}
															<img src="{$template_dir}/images/feed/u_rsvp.gif" alt="RSVP" class="icon" border="0">
														{/if}

													</td>
													<td valign="top" width="100%">
														<div class="home_action_date"><label for="rsvp_{$r[inst].id}"><input type="checkbox" {if $r[inst].attended} checked {/if} class="rsvp_attended {if !isset($r[inst].surname)} is_contact{/if}" id="rsvp_{$r[inst].id}" value="" name="rsvp_{$r[inst].id}">Attended this event</label>

														<select contact-id="{$r[inst].id}"  class="rsvp-update">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
															<option selected value="Pending">Pending</option>
														</select>


														</div>
														<span style="color:gray;font-size:smaller"></span>  <a {if isset($r[inst].surname)} href="/{$r[inst].id}" {else} href="/contact/edit/{$r[inst].id}" {/if}>{$r[inst].name} {$r[inst].surname}</a> has not responed.

														<!-- {$r[inst].name}<a>,</a>{$r[inst].email}<a>;</a> -->

													</td>
												</tr>
											</tbody>
										</table>
									</div>
								{/if}
								{if $r[inst].rsvp eq 'No'}
									<div  class="action">
										<table cellpadding="5" cellspacing="5">
											<tbody><tr>
													<td valign="top">
														{if !isset($r[inst].surname)}
															<img src="/views/app/images/feed/group_action_joingroup.gif" alt="RSVP" class="icon" border="0" /> 
														{else}
															<img src="{$template_dir}/images/feed/u_rsvp.gif" alt="RSVP" class="icon" border="0">
														{/if}
													</td>
													<td valign="top" width="100%">
														<div class="home_action_date"><label for="rsvp_{$r[inst].id}"><input type="checkbox" {if $r[inst].attended} checked {/if} class="rsvp_attended {if !isset($r[inst].surname)} is_contact{/if}" id="rsvp_{$r[inst].id}" value="" name="rsvp_{$r[inst].id}">Attended this event</label>

														<select contact-id="{$r[inst].id}"  class="rsvp-update">
															<option value="Yes">Yes</option>
															<option selected value="No">No</option>
															<option value="Pending">Pending</option>
														</select>
														</div>

														


														<span style="color:gray;font-size:smaller">{$r[inst].rsvp_on|date_format}:</span> <a {if isset($r[inst].surname)} href="/{$r[inst].id}" {else} href="/contact/edit/{$r[inst].id}" {/if}>{$r[inst].name} {$r[inst].surname}</a> has responed no.
														<br />
														{if strlen($r[inst].feedback)}
															<p class="feedback">{$r[inst].feedback}</p>
														{/if}
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								{/if}

								{if $r[inst].rsvp eq 'Yes'}
									<div  class="action">
										<table cellpadding="5" cellspacing="5">
											<tbody><tr>
													<td valign="top">
														{if !isset($r[inst].surname)}
															<img src="/views/app/images/feed/group_action_joingroup.gif" alt="RSVP" class="icon" border="0" /> 
														{else}
															<img src="{$template_dir}/images/feed/u_rsvp.gif" alt="RSVP" class="icon" border="0">
														{/if}
													</td>
													<td valign="top" width="100%">
														<div class="home_action_date"><label for="rsvp_{$r[inst].id}"><input type="checkbox" {if $r[inst].attended} checked {/if} class="rsvp_attended {if !isset($r[inst].surname)} is_contact{/if}" id="rsvp_{$r[inst].id}" value="" name="rsvp_{$r[inst].id}">Attended this event</label>

													<select contact-id="{$r[inst].id}"  class="rsvp-update">
															<option selected value="Yes">Yes</option>
															<option value="No">No</option>
															<option value="Pending">Pending</option>
														</select>

														</div>

														
		
														<span style="color:gray;font-size:smaller">{$r[inst].rsvp_on|date_format}:</span> <a {if isset($r[inst].surname)} href="/{$r[inst].id}" {else} href="/contact/edit/{$r[inst].id}" {/if}> {$r[inst].name} {$r[inst].surname}</a> has responed Yes
														{if $r[inst].food_option|strlen}
															and dietary are {$r[inst].food_option}
														{/if}
														<br />
														
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								{/if}
							</div>
						{/section}

					</div>
				
				{/foreach}

				
				
				<div class="box-container" id="Search" >
				<h3 class="green">Search Users and Contacts in this Event</h3>

				<div id="actions">
					<!-- <form action="/event/searchInvited/{$event.id}"> -->
						<!-- <ul id="search_invited_txt" class="first acfb-holder"> -->
							<input type="text" id="search_invited_txt" name="searchfor" tooltipText="search text" placeholder="search text" />
							<br/><br/>
							<!-- <input type="button" id="search_invited_btn" class="minibutton bblue "  name="search" value="Search"> -->
						<!-- </ul> -->
					<!-- </form> -->
				</div>
				
				{foreach from=$rsvp key=option item=r}
					{section name=inst loop=$r}

									<div  class="actiontbl" >
										<table id="invited_tbl">
											<tbody><tr >
													<td valign="top">

														{if !isset($r[inst].surname)}
															<img src="/views/app/images/feed/group_action_joingroup.gif" alt="RSVP" class="icon" border="0" /> 
														{else}
															<img src="{$template_dir}/images/feed/u_rsvp.gif" alt="RSVP" class="icon" border="0">
														{/if}

													</td>
													<td valign="top" width="100%">
														<div class="home_action_date"><label for="rsvp_{$r[inst].id}"><!-- <input type="checkbox" {if $r[inst].attended} checked {/if} class="rsvp_attended {if !isset($r[inst].surname)} is_contact{/if}" id="rsvp_{$r[inst].id}" value="" name="rsvp_{$r[inst].id}">Attended this event</label> -->

														<select contact-id="{$r[inst].id}"  class="rsvp-update">
															<option value="Yes">Yes</option>
															<option value="No">No</option>
															<option selected value="Pending">Pending</option>
														</select>


														</div>
														<span style="color:gray;font-size:smaller"></span>  <a {if isset($r[inst].surname)} href="/{$r[inst].id}" {else} href="/contact/edit/{$r[inst].id}" {/if}>{$r[inst].name} {$r[inst].surname}</a> RSVP - {$r[inst].rsvp}

													</td>
												</tr>
											</tbody>
										</table>
									</div>
						
					{sectionelse}
							
					{/section}
				{/foreach}
	
			</div>
			</div>
			




	</div>   
	<span class="clearFix">&nbsp;</span>     
</div>
{include file="footer.tpl"}
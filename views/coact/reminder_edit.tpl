{include file="header.tpl"}
{head}
<script type="text/javascript" src="/include/js/datepicker/javascript/zebra_datepicker.js"></script>
<link rel="stylesheet" href="/include/js/datepicker/css/zebra_datepicker.css" type="text/css">
{literal}
	<script>
		$(function(){
			$('#datepicker-example2').Zebra_DatePicker({
				direction: 1,
				offset: [20,200],
				onSelect: function(){
					$('#event-search').submit();
				}
			});

			$('#edit_form').click(function(){
				$('.display_form').hide();
				$('.edit_form').show('fast');
			});

			$('.comment-save').click(function(){
				var id = $(this).attr('id').split('_').pop();
				$(this).css('disabled', true);

				if(!$('#intern_comment_'+id).val().length) {
					_alert('warning','Please enter a comment');
					return false;
				} 

				$.post('/comment/add/0/0/reminder/'+id, {comment: $('#intern_comment_'+id).val()},
					function(data) {
						$('#comments-content-'+id).prepend(data);
						$('#intern_comment_'+id).val('');
						_alert('confirmation','Comment Created');
					}
				);
				$(this).css('disabled', false);
			});



			$('#mark_as_complete').click(function(){
				$.get('/reminder/complete/'+$('#reminder_id').val(), function(){
					_alert('confirmation','Reminder marked as complete');
					$('#mark_as_complete').hide();
					$('#edit_form').hide();

				});
			});
		});
	</script>
{/literal}
{/head}

<input type="hidden" id="reminder_id" value="{$reminder->id}" />
<div id="content">
	<input type="hidden" value="{$data.id}" id="reminder_id" />
	<div id="content-top">
    <h2 style="width:100%">Reminders</h2>
	<div class="clear"></div>
      </div>
      <div id="left-col">


		{if $payment_summary }
		<div class="box">
			<h4 class="white">Financial Summary</h4>
			<div class="box-container">
				{foreach from=$payment_summary key=year item=details}
				<b>{$year} Overview:</b>&nbsp;&nbsp; R {$details.summary} <small>(paid)</small><br />
				<hr size="1" color="#CCC">
				<table  width="100%">
					{section name=inst loop=$details.rows}
					<tr>
						<td><b>{$details.rows[inst].reference}: </b></td>
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
				{if is_object($ident)}
					<div class="box">
						<h4 class="yellow">Reminder info</h4>
						<div class="box-container">
							<table width="100%" style="border-spacing:3px" >
								<tr>
									<td ><b>Type</b></td>
									<td>: {$reminder->ident|ucfirst}</td>
								</tr>
								<tr>
									<td>
										<b>Reference</b>
									</td>
									<td>
										: <a href="{$ident->get_guid()}">{$ident->get_title()}</a>
									</td>
								</tr>
								<tr>
									<td>
										<b>Date</b>
									</td>
									<td>
										: {$reminder->reminder_date|date_format}
									</td>
								</tr>
								<tr>
									<td>
										<b>Privacy</b>
									</td>
									<td>
										{if $reminder->privacy eq 0}
											: Only me
										{else}
											: All administrator
										{/if}
									</td>
								</tr>
							</table>
						</div>
					</div>
				{/if}
		

      		      </div>


      
      <div id="mid-col" class="full-col">
			<div class="box" id="to-do">
				<ul class="tab-menu">
					<li><a href="#current">Current reminder</a></li>
					{if count($completed)}<li><a href="#completed">Completed reminders({$completed|@count})</a></li>{/if}
					{if count($incomplete)}<li><a href="#outstanding">Outstanding reminders({$incomplete|@count})</a></li>{/if}
				</ul>
							
				<div class="box-container" id="current">

<div class="edit_form {if !isset($smarty.post.data)} hidden {/if}">
							<form action="/reminder/edit/{$data.id|default:0}" method="post" name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">

					

										        	<h3>Reminder {if $reminder->ident} for <a href="{$ident->get_guid()}">{$ident->get_title()}</a> {/if}</h3>

	<fieldset>
		<legend>{if $reminder->id|default:0 eq 0}Create a new{else}Update current{/if} Reminder </legend>
		<ol>

			<li >
				<label class="field-title" for="field_reminder">Privacy:</label>
				<label>
					<select name="data[privacy]">
						<option {if $data.privacy eq '0'} selected {else} {/if} value="0">Me({$user->name} {$user->surname})</option>
						<option {if $data.privacy eq '1'} selected {else} {/if} value="1">All Administators</option>
					</select>

				<span class="clearFix">&nbsp;</span>
				{error field=reminder}
			</li>
			<li >
				<label class="field-title" for="field_reminder">Reminder:</label>
				<label><textarea name="data[reminder]" id="field_reminder" rows="8"/>{$data.reminder}</textarea>
				<span class="clearFix">&nbsp;</span>
				{error field=reminder}
			</li>
			<div class="clear"></div>
			<li >
				<label class="field-title" for="field_reminder_date">Reminder date:</label>
				<input type="input" name="data[reminder_date]" id="datepicker-example2" value="{$data.reminder_date}" />
				<span class="clearFix"></span>

			</li>

		</ol>
	</fieldset>
	<input type="submit" class="minibutton " id="" value="Update Reminder" />
	</form>
	</div>



				        <div class="display_form {if isset($smarty.post.data)} hidden {/if}" >

				        <h3 class="green">Reminder {if $reminder->ident} for <a href="{$ident->get_guid()}">{$ident->get_title()}</a> {/if}
						{if ($reminder->user_id eq $user->id) && $reminder->completed neq 1}
							<input type="button" value="Mark as complete" class="minibutton right" id="mark_as_complete"/>

				        	<input type="button" value="Edit reminder" class="minibutton bblue right" id="edit_form"/>
				        {/if}
				        </h3>
				        {if $reminder->completed}
				        	<div style="width:100%;background-color:#f0ffed;border:1px solid #d2fdc8; text-align:center;padding:10px 0px;">
				        		Reminder has been marked as completed on {$reminder->completed_date|date_format}
				        	</div>
				        {/if}
				        <div class="clear"></div>
				        <form  name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">
							<fieldset>
									<legend></legend>
									<ol id="contact">
										<ol id="contact">
										<li>
											<label class="field-title" for="field_bank_acc">Privacy:</label>
											<label>
												{if $reminder->privacy eq 0}
													: Only me
												{else}
													: All administrator
												{/if}
											</label>
											<span class="clearFix">&nbsp;</span>
											{error field=bank_acc}
										</li>
					
										<li class='even'>
											<label class="field-title" for="field_supplier">Reminder:</label>
											<label>: {$reminder->reminder}</label>
											<span class="clearFix">&nbsp;</span>
											{error field=reminder}
										</li>
										<li >
											<label class="field-title" for="field_bank">Reminder date:</label>
											<label>: {$reminder->reminder_date|date_format}</label>
											<span class="clearFix">&nbsp;</span>
											{error field=bank}
										</li>

									</ol>
								</fieldset>

								<br />

								</form>

								<div style="padding:10px">{$data.description}</div>

													<div id="comment_container_{$reminder->id}" >
														<form action="/comment/add/internship/{$reminder->id}" method="POST">
															<textarea id="intern_comment_{$reminder->id}" rows="5" style="width:98%" cols="25" name="data[comment]" id='note' rows="5"></textarea>
															<input type="button" id="comment_save_{$reminder->id}" class="submit comment-save" value="Create Comment">
														</form>
													</div><br /><br />

													<div id='comments-content-{$reminder->id}'>
														{section name=inst_comments loop=$comments}
														{if $comments[inst_comments].ident_id}
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

				     
												</div>
							
							<div class="box-container" id="completed">
							
					       		<div id="actions"> 
									{section name=inst loop=$completed}
									<div id="action_{$completed[inst].id}" class="action">
										<table cellpadding="5" cellspacing="5" width="100%">
											<tbody><tr>
												<td valign="top" style="width:100px !important">
													By {$completed[inst].name} {$completed[inst].surname}
												</td>
												<td valign="top" width="500">
													<div class="home_action_date">
														Completed on {$completed[inst].completed_date|date_format}
													</div>
													{$completed[inst].created_on|date_format}<a href="/reminder/edit/{$completed[inst].id}">{$completed[inst].reminder|truncate:60}</a>
													
												</td>
											</tr>
										</tbody></table>
									</div>
									{sectionelse}
									No Activity feeds found
									{/section}
								</div>
							</div>	

														<div class="box-container" id="outstanding">
							
					       		<div id="actions"> 
									{section name=inst loop=$incomplete}
									<div id="action_{$completed[inst].id}" class="action">
										<table cellpadding="5" cellspacing="5" width="100%">
											<tbody><tr>
												<td valign="top" style="width:100px !important">
													By {$incomplete[inst].name} {$incomplete[inst].surname}
												</td>
												<td valign="top" width="500">
													<div class="home_action_date">
														Reminder for {$incomplete[inst].reminder_date|date_format}
													</div>
													{$incomplete[inst].created_on|date_format}<a href="/reminder/edit/{$incomplete[inst].id}">{$incomplete[inst].reminder|truncate:60}</a>
													
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
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
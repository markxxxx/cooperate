{include file="header.tpl"}
{head}
<style type="text/css">
	{literal}
	#contact li {
		float:left;
		width:320px;
		height: 40px;
	}
	.display_form li {height:15px !important;}
	.wysiwyg{width: 680px !important;}
	div.wysiwyg iframe {width: 680px !important; }
	{/literal}

</style>
<link href="/include/js/tool/tipsy.css" media="screen" rel="stylesheet" type="text/css" />
<link href="/include/js/tool/tipsy.hovercard.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/include/js/jquery/jquery.autocompletefb.css" />


<script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>
<script src="/include/js/tool/jquery.tipsy.hovercard.js" type="text/javascript"></script>

<script type='text/javascript' src='/include/js/jquery/jquery.autocomplete.js'></script> 
<script type='text/javascript' src='/include/js/jquery/jquery.autocompletefb.js'></script> 
<script type='text/javascript' src='/include/js/jquery/jquery.bgiframe.min.js'></script> 



<script type="text/javascript">
{literal}
	$(function(){

		var invite = $("#invite.acfb-holder").autoCompletefb({urlLookup:{/literal}{$free_contacts}{literal}});


		$('#send-invite').click(function(e){
			e.preventDefault();
			$(this).css('disabled',true);
			
			if( invite.getData().length == 0 ) {
				_alert("warning",'Please select a contact');
				return;
			}

			$.post("/supplier/add_contact/"+$('#supplier_id').val(), { 
				to: invite.getData(),
				save:true
			},
			function(data) {
				parent.location.href = '/supplier/edit/'+$('#supplier_id').val()+'?message=contact_add';
			});
		});

		$(".message_view").colorbox();
		$('.tips2').tipsy();

		$('#edit_form').click(function(){
			$('.display_form').hide();
			$('.edit_form').show('fast');
		});

		$('#form_document').submit(function(){
			error = false;
			if($('#field_document_title').val().length == 0) {
				error = 'Please provide us with a document title<br />';
			}

			if($('.field_document_description').val().length == 0) {
				error = 'Please provide us with a document description';
			}
			if($('#uploadfile').val() == '' && $('#document_id').val() == 0) {
				error = 'Please select a file';
			}

			if(!error) {

			} else {
				_alert('warning', error);
				return false;
			}
		});

		$('#upload_document').click(function(){
			$('#document_form').hide();
			$('#document_add').show('fast');
		});


		$('#upload_document').click(function(){
			$('#document_form').hide();
			$('#document_add').show('fast');
		});


		$('.comment-save').click(function(){
			var id = $(this).attr('id').split('_').pop();
			$(this).css('disabled', true);

			if(!$('#intern_comment_'+id).val().length) {
				_alert('warning','Please enter a comment');
				return false;
			} 

			$.post('/comment/add/0/0/supplier/'+id, {comment: $('#intern_comment_'+id).val()},
				function(data) {
					$('#comments-content-'+id).prepend(data);
					$('#intern_comment_'+id).val('');
					_alert('confirmation','Comment Created');
				}
			);
			$(this).css('disabled', false);
		});
	});
{/literal}
</script>


{/head}

<input type="hidden" id="supplier_id" value="{$data.id}" />
<div id="content">
	<input type="hidden" value="{$data.id}" id="contact_id" />
	<div id="content-top">
    <h2 style="width:100%">Supplier - {$data.supplier} 
	{if $user->can_access('reminder','add')}
		<a class="right minibutton colorbox" href="/reminder/add/0/supplier/{$data.id}" style="margin-left:10px;">Add reminder
		</a>
	{/if}
	{**
    {if $user->can_access('contact','delete')}<a class="minibutton right" href="/supplier/delete/{$data.id}"> Delete</a>{/if}
    **}


    </h2>
	<div class="clear"></div>
      </div>
      <div id="left-col">


		{if $payment_summary }
		<div class="box">
			<h4 class="white">Financial Summary</h4>
			<div class="box-container">
				{foreach from=$payment_summary key=year item=details}
				<div class="finantial_header" data-year={$year}>
					<img style="position:relative; top: -1px;left:-2px" src="/views/app/images/bg-toplevel.gif"/> <b>{$year} Overview:</b>&nbsp;&nbsp; R {$details.summary|money}<br />
				</div>
				<table  width="100%"  id="report_{$year}" class="hidden report_break_down">
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
				{if $user->can_access('report','supplier')}
					<center><a href="/report/supplier/{$data.id}">Download supplier report</a></center>
				{/if}
						
					</div>
				</div>
				{/if}
				{if $user->can_access('supplier', 'add_contact')}
					<div class="box">
						<h4 class="yellow"> Link contact</h4>
						<div class="box-container">
							<form action="/event/invite/{$event.id}">
								<ul id="invite" class="first acfb-holder">
									<input type="text" id="id_message_text" name="to" class="city acfb-input"/>
								</ul>
								<br />
								<input type="button" id="send-invite" class="minibutton bblue right" style="float:right" name="save" value="Add contact">
								<div style="clear:both"></div>
							
							</form>
						</div>
					</div>
				{/if}
		

          {if $contacts}
           <div class="box">
              <h4 class="white">Related contacts</h4>
          <div class="box-container">		
    
              
              {if $contacts|@count > 0}
             
              
              <ul class="list-links">
				{section name=inst loop=$contacts}
					<li><a href="/contact/edit/{$contacts[inst].id}">{$contacts[inst].name}</a></li>
				{/section}
              </ul>


              {/if}
              
          </div>
          </div>
      	  {/if}
      		      </div>



      
      <div id="mid-col" class="full-col">

			<div class="box" id="to-do">
							<ul class="tab-menu">
								<li><a href="#contact2">Supplier info</a></li>
								<li><a href="#document">Uploaded docs</a></li>
								<li><a href="#payment">Payment log</a></li>
							</ul>
							
							<div class="box-container" id="contact2">


				        <div class="display_form {if isset($smarty.post.data)} hidden {/if}" >

				        <h3 class="green">Contact information<input type="button" value="Edit details" class="minibutton bblue right" id="edit_form"/>

				        </h3>
				        <div class="clear"></div>
				        <form  name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">
							<fieldset>
									<legend></legend>
									<ol id="contact">
										<ol id="contact">
					<li>
						<label class="field-title" for="field_supplier">Supplier name:</label>
						<label>{$data.supplier}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=supplier}
					</li>

					<li class="even">
						<label class="field-title" for="field_supplier">Supplier type:</label>
						<label>

								{section name=inst loop=$supplier_types}
									{if $supplier_types[inst].id eq $data.supplier_type_id} {$supplier_types[inst].type} {/if} 
								{/section}

						</label>
						<span class="clearFix">&nbsp;</span>
						{error field=supplier_type_id}
					</li>


					<li  class="even">
						<label class="field-title" for="field_bank">Bank:</label>
						<label>{$data.bank}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank}
					</li>

					<li>
						<label class="field-title" for="field_bank_acc">Account name:</label>
						<label>{$data.bank_acc}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_acc}
					</li>


					<li>
						<label class="field-title" for="field_bank_acc">IBAN number:</label>
						<label>{$data.iban}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=iban}
					</li>


					<li class="even">
						<label class="field-title" for="field_bank_acc">SWIFT number:</label>
						<label>{$data.swift}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=swift}
					</li>

					<li  class="even">
						<label class="field-title" for="field_bank_branch">Branch number:</label>
						<label>{$data.bank_branch}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_branch}
					</li>
					{**
					<li >
						<label class="field-title" for="field_bank_branch_name">Bank branch name:</label>
						<label>{$data.bank_branch_name}</label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_branch_name}
					</li>

					**}
                    <li>
						<label class="field-title" for="field_bank_branch_name">Account type:</label>
						<label>

                               {if $data.account_type eq 2} Savings {/if} 
                               {if $data.account_type eq 1} Cheque {/if} 

                        </label>
						<span class="clearFix">&nbsp;</span>
						{error field=account_type}
					</li>


									</ol>
								</fieldset>

								<br />

								</form>

								<div style="padding:10px">{$data.description}</div>

													<div id="comment_container_{$data.id}" >
														<form action="/comment/add/internship/{$data.id}/" method="POST">
															<textarea id="intern_comment_{$data.id}" rows="5" style="width:98%" cols="25" name="data[comment]" id='note' rows="5"></textarea>
															<input type="button" id="comment_save_{$data.id}" class="submit comment-save" value="Create Comment">
														</form>
													</div><br /><br />

													<div id='comments-content-{$data.id}'>
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

				     

				        <div class="edit_form {if !isset($smarty.post.data)} hidden {/if}">
							<form action="/supplier/edit/{$data.id|default:0}" method="post" name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">

								<h3>Update supplier</h3>
								<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
								<fieldset>
									<legend>{if $contact.id|default:0 eq 0}Create a new{else}Update current{/if} Contact</legend>
									<ol id="contact">
					<li>
						<label class="field-title" for="field_supplier">Supplier name:</label>
						<label><input name="data[supplier]" type="text" class="element text large" id="field_supplier" value="{$data.supplier}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=supplier}
					</li>

					<li class="even">
						<label class="field-title" for="field_supplier">Supplier type:</label>
						<label>
							<select name="data[supplier_type_id]">
								<option value="">Select</option>
								{section name=inst loop=$supplier_types}
									<option {if $supplier_types[inst].id eq $data.supplier_type_id} selected {/if} 
									value="{$supplier_types[inst].id}">{$supplier_types[inst].type}</option>
								{/section}
							</select>

						</label>
						<span class="clearFix">&nbsp;</span>
						{error field=supplier_type_id}
					</li>


					<li  class="even">
						<label class="field-title" for="field_bank">Bank:</label>
						<label><input name="data[bank]" type="text" class="element text large" id="field_bank" value="{$data.bank}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank}
					</li>

					<li>
						<label class="field-title" for="field_bank_acc">Account name:</label>
						<label><input name="data[bank_acc]" type="text" class="element text large" id="field_bank_acc" value="{$data.bank_acc}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_acc}
					</li>


					<li>
						<label class="field-title" for="field_bank_acc">IBAN number:</label>
						<label><input name="data[iban]" type="text" class="element text large" id="field_bank_acc" value="{$data.iban}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=iban}
					</li>


					<li class="even">
						<label class="field-title" for="field_bank_acc">SWIFT number:</label>
						<label><input name="data[swift]" type="text" class="element text large" id="field_bank_acc" value="{$data.swift}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=swift}
					</li>

					<li  class="even">
						<label class="field-title" for="field_bank_branch">Branch number:</label>
						<label><input name="data[bank_branch]" type="text" class="element text large" id="field_bank_branch" value="{$data.bank_branch}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_branch}
					</li>
					{**
					<li >
						<label class="field-title" for="field_bank_branch_name">Bank branch name:</label>
						<label><input name="data[bank_branch_name]" type="text" class="element text large" id="field_bank_branch_name" value="{$data.bank_branch_name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_branch_name}
					</li>

					**}
                    <li>
						<label class="field-title" for="field_bank_branch_name">Account type:</label>
						<label>
                            <select name="data[account_type]">
                                <option value="">Select account type:</option>
                                <option {if $data.account_type eq 2} selected {/if} value="2">Savings</option>
                                <option {if $data.account_type eq 1} selected {/if} value="1">Cheque</option>
                            </select>
                        </label>
						<span class="clearFix">&nbsp;</span>
						{error field=account_type}
					</li>

				</ol>
			</fieldset>


									</ol>
								</fieldset>
								<br />
								<input type="submit" class="minibutton bblue" value="Update" />


							</div>
							<div class="clear"></div>
							</form>

							</div>
							
							<div class="box-container" id="document">
					            
							<div id="document_form" {if isset($smarty.get.edit)} class="hidden" {/if}>
					         	   <h3 class="green">Documents
					         			<input type="button" value="Upload document" class="minibutton bblue right" id="upload_document"/>

					         	   </h3>
					         	   {section name=inst loop=$documents}
										<div style="padding:0px;border:0px;" class="doc_files">
										    <a class='selected tips2' title='{$documents[inst].created_on|date_format} - <b>{$documents[inst].description|escape:'html'}<b/>' href='/media/documents/{$documents[inst].file}'>
										        {$documents[inst].title|truncate:25}<br /><br />
										            {mime_type filename=$documents[inst].file}</a>

										    {if $user->can_access('document', 'delete')}
										    <br />
										    <a title="Delete Document"  class="tips2 table-delete-link" href="/document/delete/{$documents[inst].id}"></a>&nbsp;&nbsp;
										    {/if}
										    {if $user->can_access('contact','upload_document')}
										    	<a title="Edit Document"  class="tips2 table-edit-link" href="/supplier/edit/{$data.id}/{$documents[inst].id}?edit=1#document"></a>
										    {/if}
										</div>
					         	   {/section}
				        		<div class="clear"></div>
				        	</div>


							<div {if !isset($smarty.get.edit)} class="hidden" {/if} id="document_add">
					                <form action="/supplier/upload_document/{$data.id|default:0}/{$document.id|default:0}" method="post" name="form_document" enctype="multipart/form-data" class="middle-forms" id="form_document">
					                    <h3>{if $document.id|default:0 eq 0}Create a new{else}Update current{/if} Document</h3>
					                    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
					                    <input value="{$document.id|default:0}" type="hidden" id="document_id" />
					                    <fieldset style="width:700px"> 
					                        <legend>{if $document.id|default:0 eq 0}Create a new{else}Update current{/if} Document</legend>
					                        <ol>
					                            <li class='even'>
					                                <label class="field-title" for="field_title">Title:</label>
					                                <label><input name="data[title]" type="text" class="element text large" id="field_document_title" value="{$document.title}" /></label>
					                                <span class="clearFix">&nbsp;</span>
									{error field=title}
					                            </li>
					                            <li >
					                                <label class="field-title" for="field_description">Description:</label>
					                                <label><textarea id="wysiwyg" class="field_document_description" rows="7" cols="25" name="data[description]" rows="5">{$document.description}</textarea></label>
					                                <span class="clearFix">&nbsp;</span>
									{error field=description}
					                            </li>
					                            <li class='even'>
					                                <label class="field-title" for="field_image">Document:</label>
					                                <label><input type='file' name="uploadedfile" id="uploadfile" value='Browse'></label>
					                                <span class="clearFix">&nbsp;</span>
									{error field=file}
									{if isset($upload_error)}
					                                    <br />
					                                    <span style='color:red'>{$upload_error}</span>
									{/if}
					                            </li>

					                        </ol>
					                    </fieldset>
					                    <br />
					                    <input type="submit" class="minibutton " alt="Upload" />
					                    <div class="clear"></div>
					            </form>
								</div>
							</div>

							<div class="box-container" id="event">
								<h3 class="green">Have attended/is going to the following events</h3>
								<div id="actions">
									{section name=inst loop=$events}
										<div id="action_{$events[inst].id}" class="action">
											<table cellpadding="5" cellspacing="5">
												<tbody><tr>
														<td valign="top">
															<img src="{$template_dir}/images/approvals/schedule.png"  class="icon" align="left" border="0">
														</td>
														<td valign="top" width="100%">
															<div class="home_action_date"><span style="margin-right:10px">{$events[inst].event_date|date_format}</span> </div>
															{$events[inst].name}  
														</td>
													</tr>
												</tbody></table>
										</div>
									{/section}
								</div>
							</div>

							<div class="box-container" id="payment">
								<h3 class="green">Payment Feed</h3>
								<div id="actions"> 
									{section name=inst loop=$payment_logs}
									<div id="action_{$payment_logs[inst].id}" class="action">
										<table cellpadding="5" cellspacing="5" width="100%">
											<tbody><tr>
												<td valign="top">
													<img src="{$template_dir}/images/feed/money.gif" class="icon" border="0">
												</td>
												<td valign="top" width="100%">
													<div class="home_action_date">{$payment_logs[inst].created_on|date_format}</div>
													R {$payment_logs[inst].amount} was paid to <a href="/{$payment_logs[inst].user_id}">{$payment_logs[inst].full_name}</a> allocated for {$payment_logs[inst].reference} on <a href="payment/batch_edit/{$payment_logs[inst].id}">{$payment_logs[inst].name}</a>
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
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
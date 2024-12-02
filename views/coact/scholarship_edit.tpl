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
<script src="/include/js/tool/jquery.tipsy.js" type="text/javascript"></script>
<script src="/include/js/tool/jquery.tipsy.hovercard.js" type="text/javascript"></script>
<script type="text/javascript">
{literal}
	$(function(){
			$(".message_view").colorbox();
			function search_sent() {
				if($('#sent_search').val() == 'Search...') {
					search = '';

				} else {
					search = $('#sent_search').val();
				}

				$.post('/contact/search_mail/'+$('#contact_id').val(),{message_type:'sent',user_id:$('#sent_user_id').val(),search:search},function(mails){
					$('#sent_table').html(mails);
					$(".message_view").colorbox();
				});
			}

			function search_received() {

				if($('#received_search').val() == 'Search...') {
					search = '';
				} else {
					search = $('#received_search').val();
				}

				$.post('/contact/search_mail/'+$('#contact_id').val(),{message_type:'received',user_id:$('#received_user_id').val(),search:search},function(mails){
					$('#received_table').html(mails);
					$(".message_view").colorbox();
				});
			}

			$('#sent_user_id').change(function(){
				search_sent();
			});

			$('#sent_search').keyup(function(){
				search_sent();
			});

			$('#received_user_id').change(function(){
				search_received();
			});

			$('#received_search').keyup(function(){
				search_received();
			});



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

			$.post('/comment/add/0/0/contact/'+id, {comment: $('#intern_comment_'+id).val()},
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

<link rel="stylesheet" href="http://www.studentvillage.co.za/views/docs/highlight/styles/default.css">
<script src="http://www.studentvillage.co.za/views/docs/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
{/head}

{if $smarty.get.document}
	<script>_alert('confirmation', 'Document added successfully');</script>
{/if}

{if $smarty.get.event}
	<script>_alert('confirmation', 'Event added successfully');</script>
{/if}

<div id="content">
	<input type="hidden" value="{$data.id}" id="contact_id" />
	<div id="content-top">
    <h2>Contact - {$data.name}</h2>
	<div class="clear"></div>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">{$data.name}</h4>
          <div class="box-container">		
              <ul class="list-links">
              		<center>
					{if $data.facebook_url}
						<img src="http://graph.facebook.com/{$data.facebook_url}/picture?type=large" />
					{else}

					{/if}<br />
					
					{if $full_contact}
					<div class="clear"></div><br />
						{if isset($full_contact->socialProfiles)}
							{section name=inst loop=$full_contact->socialProfiles}
								<a href="{$full_contact->socialProfiles[inst]->url}" style="padding-right:10px"><img src="/views/app/images/sm/{$full_contact->socialProfiles[inst]->type}-16x16.png"/></a>

							{/section}

						{/if}


					{/if}
					</center>

					

              </ul>
          </div>


          </div>


          {if $none_subcribed_events}
          <div class="box">
              <h4 class="white">Invite contact to event <div class="right"><img class="tips2" title="Adding contacts to an event will not send them an RSVP or any email. This feature is coming shortly. Please use this just to keep track of which contacts have attended an event." src="/views/app/images/help.png" /></div></h4>
			<div class="box-container">		
				<form action="/contact/event_add/{$data.id}" method="POST"/>
					<ul class="checklist" style="width:200px;">
						{section name=inst loop=$none_subcribed_events}
							<li><label for="ck_domain_{$none_subcribed_events[inst].id}"><input type="checkbox"  name="events[]" value="{$none_subcribed_events[inst].id}" id="ck_domain_{$none_subcribed_events[inst].id}"/>{$none_subcribed_events[inst].name}</label></li>
						{/section}
					</ul>
					<br />
					<input type="submit" class="minibutton right" value="Invite">
					<div class="clear"></div>
				</form>
          </div>
          </div>


          {/if}


          {if $data.supplier_id}
           <div class="box">
              <h4 class="white">Supplier details</h4>
          <div class="box-container">		
              <ul class="list-links">
              		<li> <a href="/supplier/edit/{$supplier.id}">{$supplier.supplier}</a></li>
              </ul>
              
              {if $contacts|@count > 0}
             
              <div style="margin-top:12px;margin-bottom:12px;font-size:15px;">Related contacts</div>
              
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
								<li><a href="#contact2">Contact info</a></li>
								{if $full_contact}
									<li><a href="#extended">Extended info</a></li>
								{/if}
								<li><a href="#document">Uploaded docs</a></li>
								<li><a href="#event">Events</a></li>
								{if $sent_count}
									<li><a href="#sent">Sent ({$sent_count})</a></li>
								{/if}
								{if $received_count}
									<li><a href="#received">Received ({$received_count})</a></li>
								{/if}
							</ul>
							
							<div class="box-container" id="contact2">



				        <div class="display_form {if isset($smarty.post.data)} hidden {/if}" >

				        <h3 class="green">Contact information<input type="button" value="Edit details" class="minibutton bblue right" id="edit_form"/></h3>
				        <div class="clear"></div>
				        <form  name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">
							<fieldset>
									<legend></legend>
									<ol id="contact">
										<li >
											<label class="field-title" for="field_contact_type">Contact type:</label>
											<label>
												{$data.contact_type}
											</label>

										</li>
										<li class='even left'>
											<label class="field-title" for="field_name">Full name:</label>
											<label>{$data.name}</label>
											<span class="clearFix">&nbsp;</span>
											{error field=name}
										</li>
										<li class='even'>
											<label class="field-title" for="field_email">Email:</label>
											<label>{$data.email}</label>
											<span class="clearFix">&nbsp;</span>
											{error field=email}
										</li>

										<li >
											<label class="field-title" for="field_mobile">Mobile number:</label>
											<label>{$data.mobile}</label>
											<span class="clearFix">&nbsp;</span>
											{error field=mobile}
										</li>

										<li >
											<label class="field-title" for="field_mobile">Work number:</label>
											<label>{$data.office}</label>
											<span class="clearFix">&nbsp;</span>
											{error field=office}
										</li>
										<li class='even'>
											<label class="field-title" for="field_website">Website:</label>
											<label><a href="/">{$data.website}</a></label>
											<span class="clearFix">&nbsp;</span>
											{error field=website}
										</li>

										<li class='even'>
											<label class="field-title" for="field_supplier_id">Supplier:</label>
												{if $supplier}
													{$supplier.supplier}
												{else}
													none
												{/if}
											</select>
											</label>

										</li>
										<li >
											<label class="field-title" for="field_domain_id">Domain:</label>
											<label>
												{if $domain}
													{$domain.domain}
												{else}
													none
												{/if}
											</label>
											{error field=domain_id}
										</li>

									</ol>
								</fieldset>
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
							<form action="/contact/edit/{$data.id|default:0}" method="post" name="form_contact" enctype="multipart/form-data" class="middle-forms" id="form_contact">


								<h3>Update contact</h3>
								<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
								<fieldset>
									<legend>{if $contact.id|default:0 eq 0}Create a new{else}Update current{/if} Contact</legend>
									<ol id="contact">
										<li >
											<label class="field-title" for="field_contact_type">Contact type:</label>
											<label>
												{cfield field=contact_type value=$data.contact_type}
											</label>
											<span class="clearFix">&nbsp;</span>
											{error field=contact_type}
										</li>
										<li class='even left'>
											<label class="field-title" for="field_name">Full name:</label>
											<label><input name="data[name]" type="text" class="element text large" id="field_name" value="{$data.name}" /></label>
											<span class="clearFix">&nbsp;</span>
											{error field=name}
										</li>
										<li class='even'>
											<label class="field-title" for="field_email">Email:</label>
											<label><input name="data[email]" type="text" class="element text large" id="field_email" value="{$data.email}" /></label>
											<span class="clearFix">&nbsp;</span>
											{error field=email}
										</li>

										<li >
											<label class="field-title" for="field_mobile">Mobile number:</label>
											<label><input name="data[mobile]" type="text" class="element text large" id="field_mobile" value="{$data.mobile}" /></label>
											<span class="clearFix">&nbsp;</span>
											{error field=mobile}
										</li>

										<li >
											<label class="field-title" for="field_mobile">Work number:</label>
											<label><input name="data[office]" type="text" class="element text large" id="field_mobile" value="{$data.office}" /></label>
											<span class="clearFix">&nbsp;</span>
											{error field=office}
										</li>
										<li class='even'>
											<label class="field-title" for="field_website">Website:</label>
											<label><input name="data[website]" type="text" class="element text large" id="field_website" value="{$data.website}" /></label>
											<span class="clearFix">&nbsp;</span>
											{error field=website}
										</li>

										<li class='even'>
											<label class="field-title" for="field_supplier_id">Supplier:</label>
											<label>
											<select name=data[supplier_id] id="field_supplier_id" style="width:150px;">
												<option value=''>Select supplier:</option>
												{section name=inst loop=$suppliers}
													<option value="{$suppliers[inst].id}" {if $data.supplier_id eq $suppliers[inst].id}selected{/if}>{$suppliers[inst].supplier}</option>
												{/section}
											</select>
											</label>
											{error field=supplier_id}
										</li>
										<li >
											<label class="field-title" for="field_domain_id">Domain:</label>
											<label>
											<select name=data[domain_id] id="field_domain_id">
												<option value=''>Select domain:</option>
												{section name=inst loop=$domains}
													<option value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
												{/section}
											</select>
											</label>
											{error field=domain_id}
										</li>

									</ol>
								</fieldset>
									<br />
									<b>Description:</b><br /><Br />
									<label><textarea id="wysiwyg" rows="7" cols="25" name="data[description]" rows="5" style="width:100%">{$data.description}</textarea></label>
									<span class="clearFix">&nbsp;</span>
									{error field=description}
									<Br />
									<input type="submit" name="save" class="minibutton  bblue" value="Update details"  />
									<div class="clear"></div>
							</div>
							<div class="clear"></div>
							</form>

							</div>
							{if $full_contact}
							<div class="box-container" id="extended">
								{if isset($full_contact->photos)}
								<h3 class="green">Photos</h3>

									{section name=inst loop=$full_contact->photos}
										<div style="position:relative;floaT:left; margin-right:10px;">
											<span style="position:absolute;bottom:0px; color:#FFF; background:black;width:90px;padding:5px;text-align:center;">{$full_contact->photos[inst]->type}</span>
											<img src="{$full_contact->photos[inst]->url}" width="100px" height="100px" />
										</div>

									{/section}
									<div class="clear"></div>

								{/if}
								<br /><br />
									<h3 class="green">More info</h3>
									{if isset($full_contact->demographics)}
										Location: {$full_contact->demographics->locationGeneral}<br />
										Gender: {$full_contact->demographics->gender}<br />

									{/if}

									{if isset($full_contact->contactInfo)}
										{$full_contact->contactInfo->fullName} 
									{/if}
									<br /><Br />
									<h3 class="green">Raw info dump</h3>
									<pre><code style="width:700px; overflow:scroll;">
									{$data.full_contact}
									</code></pre>
									



							</div>
							{/if}
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
										    	<a title="Edit Document"  class="tips2 table-edit-link" href="/contact/edit/{$data.id}/{$documents[inst].id}?edit=1#document"></a>
										    {/if}
										</div>
					         	   {/section}
				        		<div class="clear"></div>
				        	</div>


							<div {if !isset($smarty.get.edit)} class="hidden" {/if} id="document_add">
					                <form action="/contact/upload_document/{$data.id|default:0}/{$document.id|default:0}" method="post" name="form_document" enctype="multipart/form-data" class="middle-forms" id="form_document">
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



								

				      	</div>


      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
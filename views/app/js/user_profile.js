$(document).ready(function(){

	$('#group').change(function(){
		$.get('/user/update_group/'+$('#profile-id').val()+'/'+$(this).val(), function(){
			_alert('confirmation', "Group has been updated successfully!");
		});
	});

	$('#domain').change(function(){
		$.get('/user/update_domain/'+$('#profile-id').val()+'/'+$(this).val(), function(){
			_alert('confirmation', "Domain has been updated successfully!");
		});
	});

	$('.message_template_show').click(function(){
		$(this).hide();
		$('#message_templates').show();
	});


	$('#message_template').change(function(){
		$.getJSON('/message_template/load/'+$(this).val(), function(message) {
			$('#message-title').val(message.title);
			$('#message-body').val(message.message);


		});
	});


	$('.toggle_view').click(function(){
		if($('#message-info').is(':visible')) {
			$('#message-info').hide();
			$('#profile-info').show();
			$(this).html("View Messages");
		} else {
			$('#message-info').show();
			$('#profile-info').hide();
			$(this).html("View Profile");

		}
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
			$.post("/message/send", { 
				title: $('#message-title').val(), 
				message: $('#message-body').val(), 
				send_all: 0,
				to: $('#to').val()},
				function(data) {
					$('#message-body').val('');
					$('#message-title').val('');
								//$('#id_message_text').css('display','inline');

					$('#files').html('');
					$('#progress').hide();
					$('.progress-bar-success').css('width','0%');
					_alert("confirmation",'Message sent successfully');
				});
		}
	});

	$('#send-sms').click(function(e){

		e.preventDefault();
		$(this).css('disabled',true);
		var input_error = '';


		if(!$('#sms-body').val().length) {
			input_error += 'SMS requires a body<Br />';
			$('#sms-body').css('border','1px solid red');
		}

		if(input_error.length) {
			$(this).css('disabled',false);
			_alert("warning", input_error);
		} else {


			$.post("/sms/send", { 
				message: $('#sms-body').val(), 
				send_all: 0,
				to: $('#to').val()},
			function(data) {
				$('#sms_credits').html('');
				$('#sms-body').val('');
				$('#sms-everyone').attr('checked', false);
				$('#id_sms_text').css('display','inline');
				_alert("confirmation",'SMS sent successfully');
			});
		}


	});


	$('#sms-body').keyup(function(){

	    if(this.value.length > 160){
	        return false;
	    }
	    $("#remaining").html("Remaining characters : " +(160 - this.value.length));

	});

	$('#inbox_search').keyup(function() {

		if($(this).val() == 'Search...') {
			search = '';
		} else {
			search = $(this).val();
		}

		$.post('/message/search/'+$('#profile-id').val()+'/inbox/', {'search': search},function(mails){
			$('#inbox_items').html(mails);
		});

	});

	$('#outbox_search').keyup(function() {
		
		if($(this).val() == 'Search...') {
			search = '';
		} else {
			search = $(this).val();
		}

		$.post('/message/search/'+$('#profile-id').val()+'/outbox/', {'search': search},function(mails){
			$('#outbox_items').html(mails);
		});
	});



	$(".new_export").colorbox({fixedWidth:"50%", transitionSpeed:"100", inline:true, href:"#new_export"});
	$(".send_message").colorbox({fixedWidth:"50%", transitionSpeed:"100", inline:true, href:"#send_message"});
	$(".send_sms").colorbox({fixedWidth:"50%", transitionSpeed:"100", inline:true, href:"#send_sms"})


	$('.selected, .tips').tooltip( {delay: 0,showURL: false} );
	$('#prev ,#next').live('click', function() {
		$('#calendar').load('/event/ajax_calendar/'+$(this).attr('href').split('=').pop(),function(){
			$('.selected').tooltip( {delay: 0} );
		});
		return false;
	});

	$('#field-account_status').change(function(){
		$.post('/user/update_status/'+$('#profile-id').val()+'/'+$(this).val());
	});



	$('.follow').change(function(){
		id = $(this).attr('id').split('_').pop();
		$("#followup_container_"+id).css('display','block');
		$("#note_save_"+id).val('Post ' + $(this).val());
		$(this).css('display', 'none');
	});

	$('.comment').click(function(){
		$("#comment_container_"+$(this).attr('id').split('_').pop()).css('display','block');
		$(this).css('display', 'none');
	});

	$('.comment-save').click(function(){
		var id = $(this).attr('id').split('_').pop();
		$(this).css('disabled', true);

		if(!$('#intern_comment_'+id).val().length) {
			alert('Please enter a comment');
			return false;
		} 

		$.post('/comment/add/0/'+$('#profile-id').val()+'/intern/'+id, {comment: $('#intern_comment_'+id).val()},
			function(data) {
				$('#comments-content-'+id).prepend(data);
				$('#intern_comment_'+id).val('');
				alert('Comment Created');
			}
			);
		$(this).css('disabled', false);
	});

	$('#note-save').click(function(e){

		$(this).css('disabled', true);

		e.preventDefault();

		if(!$('#wysiwyg').val().length) {
			alert('Please enter a note');
			return false;
		}

		if(!$('#field-note_type').val().length) {
			alert('Please enter a note type');
			return false;
		}

		$.post('/note/add/0/'+$('#profile-id').val(), $("#comment-form-serialize").serialize(), function(data){
			$('#notes-content').prepend(data);
			$('#field-note_type').val('');
			$('#wysiwyg').wysiwyg('clear');
			alert('Note created');

		});

		$(this).css('disabled', false);

	});


});
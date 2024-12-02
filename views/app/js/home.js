

$(document).ready(function(){
	
	var message, task, calendar , domain_users, is_admin = false, sms, cc;

	$(".modal_payment").colorbox({onOpen:function(){$('#trigger').dropdown('hide');}});
	$(".modal_dashboard").colorbox({fixedWidth:"900px", transitionSpeed:"100", inline:true, href:"#change_dashboard",onOpen:function(){$('#trigger').dropdown('hide');}});
	$("#new_event").colorbox({onOpen:function(){$('#trigger').dropdown('hide');}});
	$(".cb_rsvp").colorbox({onClosed:function(){location.reload();}});


	$('.passed').change(function(){
		
		id = $(this).attr('id').split('_').pop();
		$.get('/user/update_academic_result/'+id+'/'+$(this).val());
		_alert("confirmation",'Thanks for your input');



	});

	$('#message-type').click(function(){
		if($(this).attr('message-type') == 'sms') {
			$(this).attr('message-type','message');
			$(this).html("Click here to send SMS's");
		} else {
			$(this).attr('message-type','sms');
			$(this).html('Click here to send messages');
		}

		$('#sms-form').hide();
		$('#message-form').hide();
		$('#sms_credits').load('/sms/get_credits')

		$('#'+ $(this).attr('message-type')+'-form').show();

	});


	$('.add_cc').click(function(){
		$(this).hide();
		$('#add_cc').show();
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

	function update_filter_count() {
		form = $('#message_counter');
		$.ajax({
			type: "POST",
			url: '/dashboard/user_count',
			data: $('#message_counter').serialize(),
			dataType: 'json',
			success: function(data){
				$('#user_count').html(data.total_users);
			}
		});
	}

	$("#message_counter ul").click(function(){
		update_filter_count();
	});


	$('#clear-filters').click(function(){
		$("#message_counter input[type='checkbox'] ").attr('checked', false);
		update_filter_count();
	});

	$('.selected , .ajax-tip2').tipsy({html: true });
	
	$('#prev ,#next').live('click', function() {
		$('#calendar').load('/event/ajax_calendar/'+$(this).attr('href').split('=').pop(),function(){
			$('.selected').tooltip( {delay: 0} );
		});
		return false;
	});
	
	$.getJSON('/dashboard/get_users', function(data) {

		if($("#message.acfb-holder").length != 0) {
			message = $("#message.acfb-holder").autoCompletefb({urlLookup:data});
			is_admin = true;
		}
		
		if($("#task.acfb-holder").length != 0) {
			task = $("#task.acfb-holder").autoCompletefb({urlLookup:data});
		}

		if($("#sms.acfb-holder").length != 0) {
			sms = $("#sms.acfb-holder").autoCompletefb({urlLookup:data});
		}
					
	});

	$.getJSON('/contact/get_users', function(data) {

		if($("#cc.acfb-holder").length != 0) {
			cc = $("#cc.acfb-holder").autoCompletefb({urlLookup:data});

		}
					
	});
	
	$('#send-everyone').click(function() {
		if($(this).attr('checked')) {
			message.clearData();
			$('#id_message_text').css('display','none');
		} else {
			$('#id_message_text').css('display','inline');
		}
	});

	$('#sms-everyone').click(function() {
		if($(this).attr('checked')) {
			sms.clearData();
			$('#id_sms_text').css('display','none');
		} else {
			$('#id_sms_text').css('display','inline');
		}
	});
	
	$('#task-everyone').click(function() {

		if($(this).attr('checked')) {
			task.clearData();
			$('#id_task_text').css('display','none');
		} else {
			$('#id_task_text').css('display','inline');
		}
	});



	$("#new_payment_save").click(function(e){
		if(!$('#new_payment_title').val().length) {
			_alert("warning",'Please provide a title');
			e.preventDefault();
		}
	});

	$('#send-task').click(function(e){
		e.preventDefault();
		$(this).css('disabled',true);
		var task_el = $('#task-type');

		if(task_el.val().length == 0) {
			$(this).css('disabled',false);
			_alert("warning",'Please select a task');
			return;
		}
	
		if(!$('#task-everyone').is(':checked') && task.getData().length ==0) {
			_alert("warning",'Task requires recipients');
			return;
		}

		$.post("/task/add", { 
			type: task_el.val(),
			send_all:$('#task-everyone').attr('checked'),
			to: task.getData()},
		function(data) {
			task_el.val('select');
			$('#task-everyone').attr('checked', false);
			$('#id_task_text').css('display','inline');
			task.clearData();
			
			_alert("confirmation",'Task created');
		});

	});
	


	$('#send-advanced').click(function(e){

		e.preventDefault();
		$(this).css('disabled',true);
		var input_error = '';
		
		if(!$('#message-title-advanced').val().length) {
			input_error = 'Message requires a title<br />';
			$('#message-title-advanced').css('border','1px solid red');
		}
		
		if(!$('#message-body-advanced').val().length) {
			input_error += 'Message requires a body<Br />';
			$('#message-body-advanced').css('border','1px solid red');
		}

		if(input_error.length) {
			
			$(this).css('disabled',false);
			_alert("warning", input_error);

		}

	});

	$('#sms-body').keyup(function(){

	    if(this.value.length > 160){
	        return false;
	    }
	    $("#remaining").html("Remaining characters : " +(160 - this.value.length));

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
			if(!$('#sms-everyone').is(':checked') && sms.getData().length ==0) {
				_alert("warning",'SMS requires recipients');
				return false;
			}

			$.post("/sms/send", { 
				message: $('#sms-body').val(), 
				send_all:$('#sms-everyone').attr('checked'),
				to: sms.getData()},
			function(data) {
				$('#sms_credits').html('');
				$('#sms-body').val('');
				$('#sms-everyone').attr('checked', false);
				$('#id_sms_text').css('display','inline');
				sms.clearData();
				_alert("confirmation",'SMS sent successfully');
			});
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

		} else if(!is_admin) {
			$.post("/message/send", { 
				title: $('#message-title').val(), 
				message: $('#message-body').val() },
			function(data) {
				$('#message-body').val('');
				$('#message-title').val('');
				_alert("confirmation",'Message sent successfully');
			});
		} else {
			if(!$('#send-everyone').is(':checked') && message.getData().length ==0) {
				_alert("warning",'Message requires recipients');
			} else {
				$.post("/message/send", { 
					title: $('#message-title').val(), 
					message: $('#message-body').val(), 
					send_all:$('#send-everyone').attr('checked'),
					to: message.getData(),
					cc: cc.getData()
				},
				function(data) {
					$('#message-body').val('');
					$('#message-title').val('');
					$('#send-everyone').attr('checked', false);
					$('#id_message_text').css('display','inline');
					cc.clearData();
					message.clearData();
					$('#add_cc').hide();
					$('.add_cc').show();
					$('.message_template_show').show();
					$('#message_templates').hide();
					$('#files').html('');
					$('#progress').hide();
					$('.progress-bar-success').css('width','0%');

					_alert("confirmation",'Message sent successfully');
				});
			}
		
		}
		
	});

});



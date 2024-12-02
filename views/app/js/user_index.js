$(document).ready(function(){
	$('.ajax-tip').tipsyHoverCard();
	$('.ajax-tip2').tipsy();


	$('.relation').change(function(){
		var element = $(this);
		var field = element.attr('id').split('_').shift();
		var id = element.attr('id').split('_').pop();
		$.get('/user/update_'+field+'/'+id+'/'+element.val(), function(){
			element.css('color','red');
			_alert('confirmation', field + " has been updated successfully!");
		});
	});

	$('#export_selected').click(function(){
		$('#form_user').attr('action', '/user/export_batch/0').submit();
	});

	$('#export').click(function(){
		$('#form_user').attr('action', '/user/export_batch/1').submit();
	});

	$('#batch_update_selected').click(function(){
		$.ajax({
			type     : 'POST',
			url      : "/user/update_batch/0",
			data     : $('#form_user').serialize(),
			success: function( data ) {
				$.colorbox({html: data});
		}});
	});

	$('#batch_update').click(function(){
		$.ajax({
			type     : 'POST',
			url      : "/user/update_batch/",
			success: function( data ) {
				$.colorbox({html: data});
		}});
	});

	$('.toggle_update').live('click',function(){
		css = $(this).attr('checked') ? 'block' : 'none';
		$('#'+$(this).attr('id')+'_select').css('display', css);

		if($('.toggle_update:checked').length) {
			$('#update_all').show();
		} else {
			$('#update_all').hide();
		}

	});

	$(".modal_dashboard").colorbox({fixedWidth:"900px", transitionSpeed:"100", inline:true, href:"#change_dashboard",onOpen:function(){$('#trigger').dropdown('hide');}});


	function update_filter_count() {
		form = $('#message_counter');
		$.ajax({
			type: "POST",
			url: '/dashboard/user_count/0',
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


});
$(function(){

	$('#send-calendar').click(function(e){

		e.preventDefault();
		$(this).css('disabled',true);
		var body_el = $('#calendar-body');
		var body_el = $('#calendar-body');

		var start_day = $('#Date_Day');
		var start_month = $('#Date_Month');
		
		
		if(body_el.val().length == 0) {
			$(this).css('disabled',false);
			_alert("warning",'Please provide event details');
			return;
		}

		if($('#location').val().length == 0) {
			$(this).css('disabled',false);
			_alert("warning",'Please provide event location');
			return;
		}

		if($('#name').val().length == 0) {
			$(this).css('disabled',false);
			_alert("warning",'Please provide event name');
			return;
		}
		
		if(!start_day.val().length || !start_month.val().length) {
			_alert("warning",'date not valid')
		}
		
		
		if($('#caldendar-everyone').attr('checked') == false && calendar.getData().length ==0) {
			_alert("warning",'Event requires recipients');
			return;
		}
		
		var now = new Date();
		is_valid = isValidDate(start_month.val()+'-'+start_day.val()+'-'+now.getFullYear());
		if(!is_valid) {
			return false;
		}
		
		var user_date = new Date(now.getFullYear(), start_month.val() ,start_day.val() );
		
		if(user_date < now) {
			_alert("warning",'Event is in the past');
			return false;
		}
		
		$.post("/event/quick_edit/"+$('#event_id').val(), { 
			location: $('#location').val(),
			name: $('#name').val(),
			event: body_el.val(),
			food: $('#food-option').attr('checked'),
			date: start_month.val()+'-'+start_day.val()+'-'+now.getFullYear(),
			domains: $('input[name="domain_admins[]"]').serialize()
		},
		function(data) {
			_alert("confirmation",'Event created successfully');
			$('.event_add').hide();
			$('#complete').show('slow');

		});

	});
});

function isValidDate(dateStr) {
	var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{2}|\d{4})$/;
	var matchArray = dateStr.match(datePat); // is the format ok?
	if (matchArray == null) {
		_alert("warning","Date is not in a valid format.")
		return false;
	}
	month = matchArray[1];
	day = matchArray[3];
	year = matchArray[4];
	if (month < 1 || month > 12) {
		_alert("warning","Month must be between 1 and 12.");
		return false;
	}
	if (day < 1 || day > 31) {
		_alert("warning","Day must be between 1 and 31.");
		return false;
	}
	if ((month==4 || month==6 || month==9 || month==11) && day==31) {
		_alert("warning","Month "+month+" doesn't have 31 days!")
		return false
	}
	if (month == 2) { 
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day>29 || (day==29 && !isleap)) {
			_alert("warning","February " + year + " doesn't have " + day + " days!");
			return false;
		}
	}
	return true;
}
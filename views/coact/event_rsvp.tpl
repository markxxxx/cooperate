<html>
<head>
	{literal}

	<style>
		.pac-container {z-index:40000 !important;}
	</style>
	<script>

		function loadScript(src,callback){
			var script = document.createElement("script");
			script.type = "text/javascript";
			if(callback)script.onload=callback;
			document.getElementsByTagName("head")[0].appendChild(script);
			script.src = src;
		}

		if(typeof google == 'undefined') {
			loadScript('http://maps.googleapis.com/maps/api/js?key={/literal}{$config.maps.api_key}{literal}&sensor=false&callback=initialize',function(){});
		} else {
			initialize();
		}

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

		$(function(){
			$('#rsvp').change(function(){
				if($(this).val() == 'Yes') {
					if($('#food_option').val() == 1) {
						$('#food-tr').show();
					}
					$('#no-tr').hide();

				} else if($(this).val() == 'No') {
					$('#no-tr').show();
					if($('#food_option').val() == 1) {
						$('#food-tr').hide();
					}
				}
			});
		});


		function submit_rsvp() {

			var post_data = {};

			rsvp = $('#rsvp').val();
			feedback = $('#feedback').val();

			if(rsvp == 'Pending') {
				_alert("warning",'Please select an RSVP option: Yes or No');
				return false;
			}


			if(rsvp == 'No' && !feedback.length) {
				_alert("warning",'Please specify why you cannot make this event');
				return false;
			} else {
				post_data.feedback = feedback;
			}

			if(rsvp == 'Yes' && $('#food_option').val() == 1) {

				if($('#field-food_option').val() == '') {
					_alert("warning",'Please specify a food option');
					return false;
				} else {
					post_data.food_option = $('#field-food_option').val();
				}
			} 

			post_data.rsvp = rsvp;
			post_data.save = true;

			rsvp_form = $('#rsvp_form');

			$.post(rsvp_form.attr('action'), post_data ,  function(){ 
				_alert("confirmation",'Your RSVP has been saved!');
				$('.rsvp-box').hide();
				$('#complete').show('slow');
			});
		}
			

	{/literal}
	</script>
 
<body>

	<div id="complete" style="display:none;">
		<br /> <br />
		<center>
		Your RSVP has been saved.<br /><br />
		<a href="/" class="bblue minibutton">Close</a>
		</center>
	</div>

	<div id="quick-send-message-container" class="rsvp-box">
			<div class='form' id='form-calendar' style="width:600px;padding:10px;">
				
				<div style="float:right">
					<a class="minibutton ajax-tip2 bblue" style="position:relative;top:-4px;" >
						<img src="/views/app/images/approvals/schedule.png" align="left"/>&nbsp;&nbsp;
						{$event.event_date|date_format}
					</a>
				</div>	
				<h3 class="green" style="border-bottom:1px solid #DDD; padding-bottom:10px; margin-bottom:10px;">{$event.name}</h3>


				<input type="hidden" id="food_option" value="{$event.food_option}"/>

				<form action="/event/rsvp/{$event.id}" id="rsvp_form" method="POST">
					<table width="100%">
						<tr>
							<td width="230px" valign="top">
								<b>Will you be attending this event: </b> 
							</td>
							<td valign="top">
								<select name="data[rsvp]" id='rsvp'>
									{if $event_user.rsvp eq 'Pending'}
										<option  selected value="Pending">Pending</option>
									{/if}
									<option {if $event_user.rsvp eq "Yes" } selected {/if} value="Yes">Yes</option>
									<option {if $event_user.rsvp eq "No"} selected {/if} value="No">No</option>	
								</select>
							</td>
						</tr>
						{if $event.food_option}
							<tr id="food-tr">
								<td valign="top">
									<b>What are your dietary requirements:</b>
								</td>
								<td valign="top">
									{cfield field=food_option value=$event_user.food_option}
								</td>
							</tr>
						{/if}

						<tr id="no-tr" style="display:none">
							<td valign="top">
								<b>Why can you not attend this event:</b>
							</td>
							<td valign="top">
								<textarea name="data[feedback]" id='feedback' cols="10" rows="5" style="width:90%"></textarea>
							</td>
						</tr>

						<tr>
							<td>

							</td>
							<td>
								<br />
								<input type="button" onclick='submit_rsvp()' class="minibutton ajax-tip2 bblue " name="save" value="Submit my RSVP" />
									
								</a>
							</td>
						</tr>
					</table>

				 


				<br /><br />

				<b>Event details:</b><br />
				{$event.event}<Br /><br />


				<b>Location:</b><br /> {$event.location}
				<br /><br />

                <div id="map_canvas" style="width:100%; height:175px; "></div>
			</div>
		</form>
	</body>
</html>
 	

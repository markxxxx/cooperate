<html>
<head>
	{literal}
	<script type='text/javascript' src='/views/app/js/event_edit.js?new=1'></script> 

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



		function initialize() {

			var input = (document.getElementById('location'));
			var searchBox = new google.maps.places.SearchBox(input);

			google.maps.event.addListener(input, 'bounds_changed', function() {
				var bounds = map.getBounds();
				searchBox.setBounds(bounds);
			});
		}

		initialize();
	{/literal}
	</script>
 
<body>

	<div id="complete" style="display:none;">
		<br /> <br />
		<center>
		Your Event has been updated!<br /><br />
		<a href="/event/edit/{$event.id}" class="bblue minibutton">Close</a>
		</center>
	</div>

	<input type="hidden" id="event_id" value="{$event.id}" />	
	<div id="quick-send-message-container" class="event_add">
		<form >
			<div class='form' id='form-calendar' style="width:600px;padding:10px;">
				<h3 class="green" style="border-bottom:1px solid #DDD; padding-bottom:10px; margin-bottom:10px;">Edit event: {$event.name}</h3>


				
					{if $domains|count > 1 }
					<b>Which domain administrators can manage this event:</b><Br />
						<ul class="checklist" style="width:98%;margin-top:5px;padding:8px;height:40px">
						{section name=inst loop=$domains}
							<li style="float:left; margin-right:15px;width:150px">
								<label for="ck_domain2_{$domains[inst].id}">
									<input {if in_array($domains[inst].id, $event_domains)} checked {/if} type="checkbox"  name="domain_admins[]" value="{$domains[inst].id}" id="ck_domain2_{$domains[inst].id}"/>{$domains[inst].domain}
								</label>
							</li>
						{/section}
						</ul>
					{/if}
					<br />
			

				<br />

				<table width="100%">
					<tr>
						<td width="50%" valign="top">
							<p><label style="display:inline;">Date:</label>
								<select id="Date_Month">
									<option {if $event_month eq '01'} selected {/if}label="January" value="01">January</option>
									<option {if $event_month eq '02'} selected {/if}label="February" value="02">February</option>
									<option {if $event_month eq '03'} selected {/if}label="March" value="03">March</option>
									<option {if $event_month eq '04'} selected {/if}label="April" value="04">April</option>
									<option {if $event_month eq '05'} selected {/if}label="May" value="05" selected="selected">May</option>
									<option {if $event_month eq '06'} selected {/if}label="June" value="06">June</option>
									<option {if $event_month eq '07'} selected {/if}label="July" value="07">July</option>
									<option {if $event_month eq '08'} selected {/if}label="August" value="08">August</option>
									<option {if $event_month eq '09'} selected {/if}label="September" value="09">September</option>
									<option {if $event_month eq '10'} selected {/if}label="October" value="10">October</option>
									<option {if $event_month eq '11'} selected {/if}label="November" value="11">November</option>
									<option {if $event_month eq '12'} selected {/if}label="December" value="12">December</option>

								</select>
								<select id="Date_Day">
									<option {if $event_day eq '01'} selected {/if}label="01" value="1">01</option>
									<option {if $event_day eq '02'} selected {/if}label="02" value="2">02</option>
									<option {if $event_day eq '03'} selected {/if}label="03" value="3">03</option>
									<option {if $event_day eq '04'} selected {/if}label="04" value="4">04</option>
									<option {if $event_day eq '05'} selected {/if}label="05" value="5">05</option>
									<option {if $event_day eq '06'} selected {/if}label="06" value="6">06</option>
									<option {if $event_day eq '07'} selected {/if}label="07" value="7">07</option>
									<option {if $event_day eq '08'} selected {/if}label="08" value="8">08</option>
									<option {if $event_day eq '09'} selected {/if}label="09" value="9">09</option>
									<option {if $event_day eq '10'} selected {/if}label="10" value="10">10</option>
									<option {if $event_day eq '11'} selected {/if}label="11" value="11">11</option>
									<option {if $event_day eq '12'} selected {/if}label="12" value="12">12</option>
									<option {if $event_day eq '13'} selected {/if}label="13" value="13">13</option>
									<option {if $event_day eq '14'} selected {/if}label="14" value="14">14</option>
									<option {if $event_day eq '15'} selected {/if}label="15" value="15">15</option>
									<option {if $event_day eq '16'} selected {/if}label="16" value="16">16</option>
									<option {if $event_day eq '17'} selected {/if}label="17" value="17">17</option>
									<option {if $event_day eq '18'} selected {/if}label="18" value="18">18</option>
									<option {if $event_day eq '19'} selected {/if}label="19" value="19">19</option>
									<option {if $event_day eq '20'} selected {/if}label="20" value="20">20</option>
									<option {if $event_day eq '21'} selected {/if}label="21" value="21">21</option>
									<option {if $event_day eq '22'} selected {/if}label="22" value="22">22</option>
									<option {if $event_day eq '23'} selected {/if}label="23" value="23">23</option>
									<option {if $event_day eq '24'} selected {/if}label="24" value="24">24</option>
									<option {if $event_day eq '25'} selected {/if}label="25" value="25">25</option>
									<option {if $event_day eq '26'} selected {/if}label="26" value="26">26</option>
									<option {if $event_day eq '27'} selected {/if}label="27" value="27">27</option>
									<option {if $event_day eq '28'} selected {/if}label="28" value="28">28</option>
									<option {if $event_day eq '29'} selected {/if}label="29" value="29">29</option>
									<option {if $event_day eq '30'} selected {/if}label="30" value="30">30</option>
									<option {if $event_day eq '31'} selected {/if}label="31" value="31">31</option>
								</select><br /><Br />
								</p>
						</td>
						<td valign="top">
							<p><label><input name="send-everyone" id='food-option' {if $event.food_option eq '1'} checked {/if} type="checkbox" value="" />Include food requirments:</label>
							<br />
						</td>
					</tr>
				</table>
				<p><label>Location:</label>
					<input name="location" id="location" type="text" style="width:98%" value="{$event.location}"/></p>

					<br />
					<p><label>Name:</label>
						<input name="name" id="name" type="text" value="{$event.name}" style="width:98%"/></p>
						<br />
						<p><label>Details:</label>
							<textarea name="message" id='calendar-body' cols="10" rows="5" style="width:98%">{$event.event}</textarea></p>
							<br />
							<a href="#" id="send-calendar" class="bblue minibutton">Update event</a>
							<span class="clearFix">&nbsp;</span>

						</form>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
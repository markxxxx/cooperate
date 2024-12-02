<html>
<head>
	{literal}
	<script type='text/javascript' src='/views/app/js/event.js?new=1'></script> 

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
			loadScript('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&callback=initialize',function(){});
		} else {
			initialize();
		}

		function initialize() {

			var input = (document.getElementById('location'));
			var searchBox = new google.maps.places.SearchBox(input);

			google.maps.event.addListener(input, 'bounds_changed', function() {
				var bounds = map.getBounds();
				searchBox.setBounds(bounds);
			});
		}
	{/literal}
	</script>
 
<body>
	<div style="width:600px">
	<div id="complete" style="display:none;">
		<br /> <br />
		<center>
		Your Event has been created!.<br /><br />
		<a href="/" class="bblue minibutton">Close</a>
		</center>
	</div>

	<div id="quick-send-message-container" class="event_add">
		<form >
			<div class='form' id='form-calendar' style="width:600px;padding:10px;">
				<h3 class="green" style="border-bottom:1px solid #DDD; padding-bottom:10px; margin-bottom:10px;">Create a new event</h3>


				<p><label><input name="send-everyone" id='caldendar-everyone' type="checkbox"  />Send invites to:
				{if count($filters)}



					{foreach from=$filters key=k item=v}
						{if count($v) eq 1}
							{if $k == 'domains'}
								{section name=inst loop=$domains}
									{if $domains[inst].id eq $v[0]}
										<a class="minibutton ajax-tip2 " title="Remove filter"  >{$domains[inst].domain}</a>
									{/if}
								{/section}
							{else}
								<a class="minibutton ajax-tip2 " >{$v[0]}</a>
							{/if}

							{else}
								<a class="minibutton " data-dropdown="#dropdown2-{$k}">{$v|@count} {$k|ucfirst|replace:'_':' '} selected<img src="/views/app/images/down_2.png" align="right"></a>
							{/if}
					{/foreach}

										{foreach from=$filters key=k item=v}

						{if count($v) > 1}
							<div id="dropdown2-{$k}" class="dropdown dropdown-tip has-icons dropdown-relative">
								<ul class="dropdown-menu">
									{section name=inst loop=$v}
										{if $k == 'domains'}
											{section name=inst2 loop=$domains}
												{if $domains[inst2].id eq $v[inst]}
													<li class="{$v[inst]}"><a>{$domains[inst2].domain}</a></li>
												{/if}
											{/section}
										{else}
											<li class="{$v[inst]}"><a>{$v[inst]}</a></li>
										{/if}
									{/section}
								</ul>
							</div>
						{/if}

					{/foreach}
				{else}
					<a class="minibutton">All users</a>
				{/if}



				</label> </p>
				<form autocomplete="off">
					<ul id="caldendar-ac" class="first acfb-holder">
						<input type="text" id="id_calendar_text" class="city acfb-input"/>
					</ul>
				</form>
					<br />
				<br />

					{if $domains|count > 1 }
					<b>Which domain administrators can manage this event:</b><Br />
						<ul class="checklist" style="width:98%;margin-top:5px;padding:8px;height:40px">
						{section name=inst loop=$domains}
							<li style="float:left; margin-right:15px;width:150px;">
								<label  for="ck_domain2_{$domains[inst].id}"><input type="checkbox"  name="domain_admins[]" value="{$domains[inst].id}" id="ck_domain2_{$domains[inst].id}"/>{$domains[inst].domain}</label>
							</li>
						{/section}
						</ul>
					{/if}
					<br />
				

				<table width="100%">
					<tr>
						<td width="50%" valign="top">
							<p><label style="display:inline;">Date:</label>
								<select id="Date_Month">
									<option label="January" value="01">January</option>
									<option label="February" value="02">February</option>
									<option label="March" value="03">March</option>
									<option label="April" value="04">April</option>
									<option label="May" value="05" selected="selected">May</option>
									<option label="June" value="06">June</option>
									<option label="July" value="07">July</option>
									<option label="August" value="08">August</option>
									<option label="September" value="09">September</option>
									<option label="October" value="10">October</option>
									<option label="November" value="11">November</option>
									<option label="December" value="12">December</option>

								</select>
								<select id="Date_Day">
									<option label="01" value="1">01</option>
									<option label="02" value="2">02</option>
									<option label="03" value="3">03</option>
									<option label="04" value="4">04</option>
									<option label="05" value="5">05</option>
									<option label="06" value="6">06</option>
									<option label="07" value="7">07</option>
									<option label="08" value="8">08</option>

									<option label="09" value="9">09</option>
									<option label="10" value="10">10</option>
									<option label="11" value="11">11</option>
									<option label="12" value="12">12</option>
									<option label="13" value="13">13</option>
									<option label="14" value="14">14</option>
									<option label="15" value="15">15</option>
									<option label="16" value="16">16</option>
									<option label="17" value="17">17</option>

									<option label="18" value="18">18</option>
									<option label="19" value="19">19</option>
									<option label="20" value="20">20</option>
									<option label="21" value="21">21</option>
									<option label="22" value="22">22</option>
									<option label="23" value="23">23</option>
									<option label="24" value="24">24</option>
									<option label="25" value="25">25</option>
									<option label="26" value="26">26</option>

									<option label="27" value="27">27</option>
									<option label="28" value="28">28</option>
									<option label="29" value="29">29</option>
									<option label="30" value="30">30</option>
									<option label="31" value="31">31</option>
								</select><br /><Br />
								</p>
						</td>
						<td valign="top">
							<p><label><input name="send-everyone" id='food-option' type="checkbox" value="" />Include food requirments:</label>
							<br />
						</td>
					</tr>
				</table>
				<p><label>Location:</label>
					<input name="location" id="location" type="text" style="width:98%"/></p>

					<br />
					<p><label>Name:</label>
						<input name="name" id="name" type="text" style="width:98%"/></p>
						<br />
						<p><label>Details:</label>
							<textarea name="message" id='calendar-body' cols="10" rows="5" style="width:98%"></textarea></p>
							<br />
							<a href="#" id="send-calendar" class="bblue minibutton" >Create event</a>
							<span class="clearFix">&nbsp;</span>

						</form>
					</div>
				</div>
			</form>
		</div>
	</body>
	</html>
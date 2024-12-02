<div stlye="width:600px">
<form action="/appointment/add/{$data.id|default:0}" method="post" name="form_appointment" enctype="multipart/form-data" class="middle-forms" id="form_appointment">
		<h3>

					{if $data.id}<a href="/appointment/delete/{$data.id}" class="minibutton right">

						Delete</a>{/if}
		{if $data.id|default:0 eq 0}Create a new{else}Update {/if} Appointment</h3>
		<fieldset>
			<legend>




			</legend>
			<ol>

				<li >
					<label class="field-title" for="field_start_time">Calender description:</label>
					<label>	
						<input type="input" name="data[title]" value="{$data.title}" />
					</label>
					<span class="clearFix">&nbsp;</span>

					{error field=title}
				</li>

				<li class='even'>
					<label class="field-title" for="field_start_time">Start_time:</label>
					<label>
						{$selected_time_formatted}
						<input type="hidden" name="data[start_time]" value="{$selected_time}"/>
					</label>
					<span class="clearFix">&nbsp;</span>
					{error field=start_time}
				</li>
				<li >
					<label class="field-title" for="field_duration">Duration:</label>
					<label>	

						<select name="data[duration]" class="form-control m-b">
							<option selected="" value="">Select</option>
							<option {if $data.duration eq '30'} SELECTED {/if} value="30">30 Minutes</option>
							<option {if $data.duration eq '60'} SELECTED {/if} value="60">An Hour</option>
							<option {if $data.duration eq '90'} SELECTED {/if} value="90">Hour and a half</option>
							<option {if $data.duration eq '120'} SELECTED{/if} value="120">2 hours</option>
							<option {if $data.duration eq '150'} SELECTED{/if} value="150">2 and a half hours</option>
							<option {if $data.duration eq '180'} SELECTED {/if} value="180">3 Hours</option>
							<option {if $data.duration eq '210'} SELECTED {/if} value="210">3 and a half hours</option>
							<option {if $data.duration eq '240'} SELECTED {/if} value="240">4 hours</option>
							<option {if $data.duration eq '270'} SELECTED {/if} value="270">4 and a half hours</option>
							<option {if $data.duration eq '300'} SELECTED{/if} value="300">5 hours</option>
							<option {if $data.duration eq '1000'} SELECTED {/if} value="1000">Full day</option>

						</select>

					</label>
					<span class="clearFix">&nbsp;</span>
					{error field=duration}
				</li>

			</ol>
		</fieldset>
		<input type="submit" value="Save" class="minibutton right"/>
		<br /><br /><br /><br /><br /><br />

	</div>
</form>
</div>


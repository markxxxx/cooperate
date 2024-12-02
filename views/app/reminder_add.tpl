{literal}
	
<script type="text/javascript" src="/include/js/datepicker/javascript/zebra_datepicker.js"></script>
<link rel="stylesheet" href="/include/js/datepicker/css/zebra_datepicker.css" type="text/css">

<script>
	$(function(){
		$('#datepicker-example2').Zebra_DatePicker({
	        direction: 1,
	        offset: [20,200],
	        onSelect: function(){
	            $('#event-search').submit();
	        }
	    });

	    $('#form_reminder').submit(function(){
	    
	    	$.post($(this).attr('action'),$(this).serialize(),function() {
	    		_alert('confirmation', "Reminder added successfully");
	    		$('#form_reminder').hide();
	    		$('#complete').show('slow');
	    	});
	    	return false;

	    });

	});

</script>
	       


{/literal}
	<div id="complete" style="display:none;">
		<br /> <br />
		<center>
		Your Reminder has been added.<br /><br />
		<a href="#" class="bblue minibutton" onclick="$(window).colorbox.close();">Close</a>
		</center>
	</div>

<form action="/reminder/add/{$data.id|default:0}/{if isset($ident)}{$ident}/{$ident_id}{/if}" method="post" name="form_reminder" enctype="multipart/form-data" class="middle-forms" id="form_reminder">
	<h3>{if $reminder.id|default:0 eq 0}Create a new{else}Update current{/if} Reminder {if is_object($obj)}  for {$obj->get_title()} {/if}</h3>
	<fieldset>
		<legend>{if $reminder.id|default:0 eq 0}Create a new{else}Update current{/if} Reminder </legend>
		<ol>

			<li >
				<label class="field-title" for="field_reminder">Privacy:</label>
				<label>
					<select name="data[privacy]">
						<option value="0">Me({$user->name} {$user->surname})</option>
						<option value="1">All Administators</option>
					</select>

				<span class="clearFix">&nbsp;</span>
				{error field=reminder}
			</li>
			<li >
				<label class="field-title" for="field_reminder">Reminder:</label>
				<label><textarea name="data[reminder]" id="field_reminder" rows="8"/>{$data.reminder}</textarea>
				<span class="clearFix">&nbsp;</span>
				{error field=reminder}
			</li>
			<li >
				<label class="field-title" for="field_reminder_date">Reminder date:</label>
				<input type="input" name="data[reminder_date]" id="datepicker-example2"  />
				<span class="clearFix"></span>

			</li>

		</ol>
	</fieldset>
	<input type="submit" class="minibutton " id="" value="Create Reminder" />

</div>
</form>


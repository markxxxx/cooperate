{include file="header.tpl"}

{head}
{literal}
<style>
	.list-links li a {
		background-image:none !important;
	}

	.wysiwyg {width:650px !important;}
	.cancel {color:#508db8;text-decoration: none; }
</style>

<script>


	$(function(){

		$('#approve_choise').change(function() {
			if($(this).val() == 1) {
				$(this).parent().hide();
				$('#not_approved').hide()
				$('#confim_approved').slideDown('slow');
			} else {
				$(this).parent().hide();
				$('#not_approved').slideDown('slow');
				$('#confim_approved').hide();
			}
		});

		$('.cancel').click(function(){
			$('#approve_changes').slideDown('slow');
			$('#confim_approved').hide();
			$('#not_approved').hide();
		});

	});
</script>
{/literal}
{/head}
<div id="content">
	<div id="content-top">
    <h2>{$approval.notification}</h2>
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Details</h4>
          <div class="box-container">
              <ul class="list-links">
              	<li><a href="#">Ref number: {$approval.id}</a></li>
              	<li><a href="#">Created by: {$owner->name} {$owner->surname}</a></li>
				<li><a href="#">Created on: {$approval.created_on|date_format}</a></li>
				<li><a href="#">Object: {$approval.ident|ucfirst}</a></li>
				<li><a href="#">Object ref: {$approval.ident_id}</a></li>

              </ul>
          </div>
          </div>

          <div class="box">
              <h4 class="yellow">Who can approve this</h4>
          <div class="box-container">
              <ul class="list-links">
				{section name=inst loop=$admins}
					<li><a href="#">{$admins[inst].name} {$admins[inst].surname}</a></li>
				{/section}
              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Please approve the following changes</h4>
        <div class="box-container">
		<form action="/approval/approve/{$approval.id}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
			<h3>Motivation/reason for change</h3>
			<p>{$approval.reason}</p>
	
			<fieldset>
				<legend>{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} User</legend>
				<ol>

					{foreach from=$approval.changes key=k item=v}
						<li  class='{cycle values="even,"}' >
							<label class="field-title" for="field_group_id">{$k}:</label>
							<label>{$object[$k]} <b>to</b> {$v}</label>
							<div style="clear:both;"></div>
						</li>
					{/foreach}
			</fieldset>

			<br /><Br />
			<div style="background-color:#EFEFEF; padding:10px; border:1px solid silver">
				<div style="float:left" id="approve_changes">Are you happy with these changes: 
					<select name="approve_choise" id="approve_choise">
						<option value="">Please Select:</option>
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>

				<div id="not_approved" style="display:none">
					    <p>Please provide a reason why this was not approved</p>
						<textarea id="wysiwyg" name="reason_not_approved"></textarea><br /> 
						 <input type="submit" class="submit"/>&nbsp;<a href="" class="cancel">Cancel</a> 
				</div>
				<div id="confim_approved" style="display:none">
						Confirm changes: <input type="button" class="submit" value="Yes"/>&nbsp;<a href="" class="cancel">Cancel</a> 
				</div>

				<div style="clear:both"></div>
			</div>
			<br /><Br />
			<h3>Original {$approval.ident|ucfirst}</h3> 

			<fieldset>
				<legend>{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} User</legend>
				<ol>

					{foreach from=$object key=k item=v}
						<li  class='{cycle values="even,"}' >
							<label class="field-title" for="field_group_id">{$k}:</label>
							<label>{$v}</label>
							<div style="clear:both;"></div>
						</li>
					{/foreach}
			</fieldset>
		</div>
		</form>
      	</div>
      	</div> 
      </div> 
      <span class="clearFix">&nbsp;</span>
{include file="footer.tpl"}
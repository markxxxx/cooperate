<html>

<head>
<script>
	{literal}
		$(function(){



			$('#form_payment').submit(function(e){
				e.preventDefault();
				send_payment = $('#send_payment');

				send_payment.css('disabled',true);
				
				if($('#name').val().length == 0) {
					send_payment.css('disabled',false);
					_alert("warning",'Please provide payment name');
					return;
				}

				if($('#description').val().length == 0) {
					send_payment.css('disabled',false);
					_alert("warning",'Please provide payment description');
					return;
				}

				$.ajax({
			        type: "POST",
			        url: $(this).attr('action'),
			        data: $(this).serialize(),
			        success: function() {
			            send_payment.css('disabled',false);
			            if($('#payment_id').val() == 0) {
			            	parent.location.href = "/payment/";
			            } else {
			          		parent.location.href = "/payment/edit/"+$('#payment_id').val();
			            }
			            
			        }
				});
			});
		});
	{/literal}
</script>
 

<body>

	<input type="hidden" id="payment_id" value="{$data.id|default:0}" />


	<div id="quick-send-message-container" class="event_add">
		<form action="/payment/add/{$data.id|default:0}" method="POST" id="form_payment">
			<div class='form' id='form-calendar' style="width:600px;padding:10px;">


				<h3 class="green" style="border-bottom:1px solid #DDD; padding-bottom:10px; margin-bottom:10px;">Create a new Payment</h3>
				
				{** 
				{if !$data.id} 
				<p><label><input name="send_all" id='send_all' type="checkbox"  />Automatically add the following users to the new payment file:
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
				{/if}

				**}
				<br /><br />


				{if $domains|count > 1 }
					<b>Which domain administrators can manage this payment:</b><Br />
					<ul class="checklist" style="width:98%;margin-top:5px;padding:8px;height:40px">
					{section name=inst loop=$domains}
						<li style="float:left; margin-right:15px;width:150px">
							<label for="ck_domain2_{$domains[inst].id}"><input type="checkbox" {if in_array($domains[inst].id, $payment_domains)} checked {/if}  name="domain_admins[]" value="{$domains[inst].id}" id="ck_domain2_{$domains[inst].id}"/>{$domains[inst].domain}</label>
						</li>
					{/section}
					</ul>
				{/if}
				<br />
				<div style="float:left; width:230px" >
					<b>Name:</b><br />
					<input name="data[name]" type="text"  id="name" class="textbox"   value="{$data.name}" /></p><br />
					<p><b>Description</b><br />
					<textarea name="data[description]" id='description' cols="10" rows="5" class="textbox">{$data.description}</textarea></p><br />

						<input type="submit" id="send_payment" class="minibutton bblue" value="Create payment"  />
					
				</div>
				<div style="float:left">
					{if $data.id} 
						<input type="checkbox" value="0" name="enabled" id="is_enabled" {if $data.enabled|default:0 eq 1}  checked {/if}/> Enabled
					{else}

						{if $payments}
							<b>Or select a payment that is already open</b>

							<div id="sys-messages-container">
								<br />
								<ul >
								{section name=inst loop=$payments}
									<li {cycle values="class='odd-messages',class='even-messages'"}><a href="/payment/batch_edit/{$payments[inst].id}">{$payments[inst].name} - {$payments[inst].created_on|date_format}</a></li>
								{sectionelse}
									No payment batch's active<br />
									Please create a new one
								{/section}
								</ul>
							</div>
						{/if}


					{/if}
		
								
				</div>
			</div>
			<div style="clear:both"></div>
		</form>
	</div>
</body>
</html>


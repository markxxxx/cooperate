{include file="header.tpl"}

{if $invalid}
	<div class="error_messages"><p></p><h3>Save/Edit failed!</h3> Make sure all required Fields are filled in correctly</div>
{else}
	{if $smarty.get.success}
		<div class="success_messages"><p><h3>Invoice has been Saved/updated Successfully.</h3><br>
			Click here to create a New <a href="/admin/invoice/add">Invoice</a><br>
		</div>
	{/if}
{/if}


<form action="" method="post" name="form_register" enctype="multipart/form-data" class="appnitro" id="form_register">
	<center>
	<div style="text-align:left;width:50%">
		<fieldset class="active">
			<legend>Invoice infomation</legend>

			<input type="hidden" name="_submit_check" value="1" />
			<ul>
				<li>
				<label class="desc" for="company_id">Company: <span class="required">*</span></label> 
                    <select name="data[company_id]" class="full">
						<!-- <option value="0" seleted>Select group</option> -->
                        {section name=inst loop=$companies}
							{if $companies[inst].id neq 0}
								<option {if $companies[inst].id eq $data.company_id} selected {/if} value="{$companies[inst].id}">{$companies[inst].company_name}</option>
							{/if}
                        {/section}

                    </select>
                    <p class="error_small">{error field=company_id}</p>
                </li>
				<li>
					<label class="desc" for="reference">Reference: <span class="required">*</span></label>
					<div align="left">
						<input name="data[reference]" type="text" class="element text large" id="name" value="{$data.reference}" />
					</div><p class="error_small">{error field=reference}</p>
				</li>
				<li>
				<label class="desc" for="batch_id">From Batch: <span class="required">*</span></label> 
                    <select name="data[batch_id]" class="full">
						<!-- <option value="0" seleted>Select group</option> -->
                        {section name=inst loop=$batches}
							{if $batches[inst].id neq 0}
								<option {if $batches[inst].id eq $data.batch_id} selected {/if} value="{$batches[inst].id}">{$batches[inst].id}</option>
							{/if}
                        {/section}

                    </select>
                    <p class="error_small">{error field=product_id}</p>
                </li>
				<li>
					<label class="desc" for="quantity">Quantity (single units or grams): <span class="required"></span></label>
					<div align="left">
						<input name="data[quantity]" type="text" class="element text large" id="name" value="{$data.quantity}" />
					</div><p class="error_small">{error field=quantity}</p>
				</li>
				     
            	<li>
					&nbsp;
				</li>

				<li class="buttons">
					<div class="buttons">
						<button type="submit" name="save" class="positive">
						<img src="/views/admin/images/icons/money.png" alt="Save" />
							Create invoice
						</button>
					</div>
				</li>
			</ul>
		</fieldset>
	</div>
	<div style="clear: both; height: 1px;" ></div>
	</center>
</form>
{include file="footer.tpl"}

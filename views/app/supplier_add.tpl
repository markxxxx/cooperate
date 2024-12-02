{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Supplier Manager</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">

          <div class="box">
              <h4 class="yellow">Supplier Options</h4>
          <div class="box-container">
              <ul class="list-links">
				{if $user->can_access('supplier', 'index')}
					<li><a href="/supplier/index/">View Suppliers</a></li>
				{/if}

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Supplier Manager</h4>
        <div class="box-container">
		<form action="/supplier/add/{$data.id|default:0}" method="post" name="form_supplier" enctype="multipart/form-data" class="middle-forms" id="form_supplier">
			<h3>{if $supplier.id|default:0 eq 0}Create a new{else}Update current{/if} Supplier</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>{if $supplier.id|default:0 eq 0}Create a new{else}Update current{/if} Supplier</legend>
				<ol>
					<li>
						<label class="field-title" for="field_supplier">Supplier name:</label>
						<label><input name="data[supplier]" type="text" class="element text large" id="field_supplier" value="{$data.supplier}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=supplier}
					</li>

					<li class="even">
						<label class="field-title" for="field_supplier">Supplier type:</label>
						<label>
							<select name="data[supplier_type_id]">
								<option value="">Select</option>
								{section name=inst2 loop=$supplier_types}
									<option {if $supplier_types[inst2].id eq $data.supplier_type_id} selected {/if} value="{$supplier_types[inst2].id}">{$supplier_types[inst2].type}</option>
								{/section}
							</select>


						</label>
						<span class="clearFix">&nbsp;</span>
						{error field=supplier_type_id}
					</li>


					<li >
						<label class="field-title" for="field_bank">Bank:</label>
						<label><input name="data[bank]" type="text" class="element text large" id="field_bank" value="{$data.bank}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank}
					</li>

					<li class="even">
						<label class="field-title" for="field_bank_acc">Account name:</label>
						<label><input name="data[bank_acc]" type="text" class="element text large" id="field_bank_acc" value="{$data.bank_acc}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_acc}
					</li>


					<li>
						<label class="field-title" for="field_bank_acc">IBAN number:</label>
						<label><input name="data[iban]" type="text" class="element text large" id="field_bank_acc" value="{$data.iban}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=iban}
					</li>


					<li class="even">
						<label class="field-title" for="field_bank_acc">SWIFT number:</label>
						<label><input name="data[swift]" type="text" class="element text large" id="field_bank_acc" value="{$data.swift}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=swift}
					</li>

					<li>
						<label class="field-title" for="field_bank_branch">Branch number:</label>
						<label><input name="data[bank_branch]" type="text" class="element text large" id="field_bank_branch" value="{$data.bank_branch}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_branch}
					</li>
					{**
					<li >
						<label class="field-title" for="field_bank_branch_name">Bank branch name:</label>
						<label><input name="data[bank_branch_name]" type="text" class="element text large" id="field_bank_branch_name" value="{$data.bank_branch_name}" /></label>
						<span class="clearFix">&nbsp;</span>
						{error field=bank_branch_name}
					</li>

					**}
                    <li class="even">
						<label class="field-title" for="field_bank_branch_name">Account type:</label>
						<label>
                            <select name="data[account_type]">
                                <option value="">Select account type:</option>
                                <option {if $data.account_type eq 2} selected {/if} value="2">Savings</option>
                                <option {if $data.account_type eq 1} selected {/if} value="1">Cheque</option>
                            </select>
                        </label>
						<span class="clearFix">&nbsp;</span>
						{error field=account_type}
					</li>

				</ol>
			</fieldset>
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
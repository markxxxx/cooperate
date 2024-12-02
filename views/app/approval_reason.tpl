{include file="header.tpl"}
{head}
{literal}
<style>
.wysiwyg {width:650px !important;}
</style>
{/literal}
{/head}
<div id="content">
	<div id="content-top">
    <h2>Why did you update the {$data.ident} details?</h2>
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">

          <div class="box">
              <h4 class="yellow">Who can approve your change</h4>
          <div class="box-container">
              <ul class="list-links">
				{section name=inst loop=$admins}
					<li><a href="#">{$admins[inst].name} {$admins[inst].surname}</a></li>
				{/section}
              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col"  class="full-col">

   	  <div class="box">
      	<h4 class="white">Reason for making account modifications</h4>
        <div class="box-container">
		<form action="/approval/reason/{$data.id}?redirect={$smarty.get.redirect}" method="post" name="form_supplier" enctype="multipart/form-data" class="middle-forms" id="form_supplier">
			<p>Please provide us for a reason why modified: {$approval_title}</p>
			<p>Ref no:{$data.id}
			<br />
			<fieldset>
				<legend>{if $supplier.id|default:0 eq 0}Create a new{else}Update current{/if} Supplier</legend>
				<ol>
					<li class='even'>
					<textarea style="width:600" id="wysiwyg" rows="7" cols="40" name="reason">{$data.note}</textarea></label>
						<span class="clearFix">&nbsp;</span>
						{error field=reason}
					</li>
					
				</ol>
			</fieldset><br />
			<input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
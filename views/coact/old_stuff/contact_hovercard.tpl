<a href="/contact/edit/{$contact.id}" class="minibutton right" style="position:relative;top:-15px">View full profile</a>
<div class="clear"></div>
<div class="custom-hovercard">

	{if $contact.facebook_url}
		<img src="https://graph.facebook.com/{$contact.facebook_url}/picture" width="60"  align="right" style="padding-left:20px"/>
	{/if}

	<a href="mailto:{$contact.email}">{$contact.email}</a>
	{if strlen($contact.website)} 
		<p>Website: <a href="{$contact.website}" target="_blank">{$contact.website}</a></p>
	{/if}
	{if strlen($contact.mobile)} 
		<p>Mobile num: {$contact.mobile}</p>
	{/if}
	{if strlen($contact.office)} 
		<p>Office num: {$contact.office}</p>
	{/if}
	{if strlen($contact.facebook_url)} 
		<p>Facebook: <a href="http://www.facebook.com/{$contact.facebook_url}" target="_blank">{$contact.facebook_url}</a></p>
	{/if}

	{if $supplier neq false}
		<p>Linked to: <a href="/supplier/view/{$supplier.id}" target="_blank">{$supplier.supplier}</a>

		{if $contacts|@count > 0}
			with <a href="#" onclick="$('.more-contacts').show('slow');">{$contacts|@count} others</a><br />
			<div class="hidden more-contacts" id="more-contacts">
			{section name=inst loop=$contacts}
				<a href="/contact/view/{$contacts[inst].id}">{$contacts[inst].name}</a><br />
			{/section}
			</div>

		{/if}
		</p>

	{/if}

	<p>
		{$contact.description}
	</p>
	{if strlen($contact.website)} 
		{$contact.website}
	{/if}
	{$contact.supplier_id}
	{$contact.description}
</div>
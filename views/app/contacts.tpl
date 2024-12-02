{section name=inst loop=$contacts}
	{include file="contact.tpl"}
{/section}
<div class="clear"></div>
{pager url='contact/index' current_page=$page total_rows=$total_contacts per_page=$per_page}

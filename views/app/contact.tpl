<div class="contact " >
	<div class="name"><a href="/contact/edit/{$contacts[inst].id}" title="{$contacts[inst].name}"><b data-hovercard="{$contacts[inst].id}"  >{$contacts[inst].name|truncate:20}</b></a></div>
	<div class="header">

		{if strlen($contacts[inst].image_src)}
			<img src="{$contacts[inst].image_src}" width="60" height="60" class="{cycle values="green,red,blue,yellow"} " />
		{else}
			<img src="/views/app/images/silhouette.png" width="60" height="60" class="{cycle values="green,red,blue,yellow"} " />
		{/if}
	</div>
	<div class="info">
		{if $contacts[inst].can_rate}
		<div class="star" data-score="{$contacts[inst].rating}" data-id="{$contacts[inst].id}"></div>
		{/if}
	</div>
</div>
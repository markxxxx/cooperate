{if count($filters)}
	

			{foreach from=$filters key=k item=v}

				{if count($v) > 1}
					<div id="dropdown-{$k}" class="dropdown dropdown-tip has-icons dropdown-relative">
						<ul class="dropdown-menu">

							{section name=inst loop=$v}
								{if $k == 'domains'}
									{section name=inst2 loop=$domains}
										{if $domains[inst2].id eq $v[inst]}
											<li class="{$v[inst]}"><a href="/dashboard/remove_filters/domains/{$domains[inst2].id}">{$domains[inst2].domain}<img src="/views/app/images/cross2.png" align="right"></a></li>
										{/if}
									{/section}
								{elseif $k == 'groups'}
									{section name=inst2 loop=$groups}
										{if $groups[inst2].id eq $v[inst]}
											<li class="{$v[inst]}"><a href="/dashboard/remove_filters/groups/{$groups[inst2].id}">{$groups[inst2].name}<img src="/views/app/images/cross2.png" align="right"></a></li>
										{/if}
									{/section}
								{elseif $k == 'budgets'}
									{section name=inst2 loop=$budgets}
										{if $budgets[inst2].id eq $v[inst]}
											<li class="{$v[inst]}"><a href="/dashboard/remove_filters/budgets/{$budgets[inst2].id}">{$budgets[inst2].budget} <img src="/views/app/images/cross2.png" align="right"></a></li>
										{/if}
									{/section}
								{elseif $k == 'donours'}
									{section name=inst2 loop=$donours}
										{if $donours[inst2].id eq $v[inst]}
											<li class="{$v[inst]}"><a href="/dashboard/remove_filters/donours/{$donours[inst2].id}">{$donours[inst2].donour} <img src="/views/app/images/cross2.png" align="right"></a></li>
										{/if}
									{/section}
								{else}
									<li class="{$v[inst]}"><a href="/dashboard/remove_filters/{$k}/{$v[inst]}">{$v[inst]}<img src="/views/app/images/cross2.png" align="right"></a></li>
								{/if}
							{/section}
							<li class="{$v[inst]}"><a href="/dashboard/remove_filters/{$k}/">Remove all<img src="/views/app/images/cross2.png" align="right"></a></li>
						</ul>
					</div>
				{/if}

			{/foreach}

			{foreach from=$filters key=k item=v}
			   {if count($v) eq 1}
					{if $k == 'domains'}
						{section name=inst loop=$domains}
							{if $domains[inst].id eq $v[0]}
								<a class="minibutton ajax-tip2" title="Remove filter" href="/dashboard/remove_filters/{$k}/{$domains[inst].id}" >{$domains[inst].domain}<img src="/views/app/images/cross2.png" align="right"></a>
							{/if}
						{/section}
					{elseif $k == 'groups'}
						{section name=inst loop=$groups}
							{if $groups[inst].id eq $v[0]}
								<a class="minibutton ajax-tip2" title="Remove filter" href="/dashboard/remove_filters/{$k}/{$groups[inst].id}" >{$groups[inst].name}<img src="/views/app/images/cross2.png" align="right"></a>
							{/if}
						{/section}
					{elseif $k == 'budgets'}
						{section name=inst loop=$budgets}
							{if $budgets[inst].id eq $v[0]}
								<a class="minibutton ajax-tip2" title="Remove filter" href="/dashboard/remove_filters/{$k}/{$budgets[inst].id}" >{$budgets[inst].budget}<img src="/views/app/images/cross2.png" align="right"></a>
							{/if}
						{/section}

					{elseif $k == 'donours'}
						{section name=inst loop=$donours}
							{if $donours[inst].id eq $v[0]}
								<a class="minibutton ajax-tip2" title="Remove filter" href="/dashboard/remove_filters/{$k}/{$donours[inst].id}" >{$donours[inst].donour}<img src="/views/app/images/cross2.png" align="right"></a>
							{/if}
						{/section}

					{elseif is_array($v[0])}

						<a class="minibutton ajax-tip2" href="/dashboard/remove_filters/{$k}/{$v[0]}" title="Remove filter">{$v[0]}<img src="/views/app/images/cross2.png" align="right"></a>
					{else}
						<a class="minibutton ajax-tip2" href="/dashboard/remove_filters/{$k}/{$v}" title="Remove filter">{$v}<img src="/views/app/images/cross2.png" align="right"></a>	

					{/if}
					
			   {else}
					<a class="minibutton" data-dropdown="#dropdown-{$k}">{$v|@count} {$k|ucfirst|replace:'_':' '} selected<img src="/views/app/images/down_2.png" align="right"></a>
					
			   {/if}
			{/foreach}
		{else}
			{if $user->is_admin()}
				
				<a class="minibutton">All users</a>
			{/if}
		{/if}
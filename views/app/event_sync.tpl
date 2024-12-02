{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Synchronize calender with Outlook, ICal, Google Calendar</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Calendar help</h4>
          <div class="box-container">
              <ul class="list-links">
              
                <p style="padding:6px;">dshas kjd hasjkg dhs gjhas dgkasjdgas kdgasd khjd gsjhdgjhas dgjhas dgkhs ga djhas dg</p>

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Synchronize calender
            {if $domains|@count > 1 && !$data.id}
				<div style="float:right">
					<form id="select-domain" method="get" action="">
						<select name="domain_id" onchange="parent.location.href='/domain/select/'+this.value+'?redirect=event/sync'">
							<option>Select domain:</option>
							{section name=inst loop=$domains}
								<option {if $domains[inst].id eq $user->current_domain()} selected {/if} value="{$domains[inst].id}" {if $data.domain_id eq $domains[inst].id}selected{/if}>{$domains[inst].domain}</option>
							{/section}
						</select>
					</form>
				</div>
			{/if}
        
        </h4>
        <div class="box-container">
		<form action="/domain/add/{$data.id|default:0}" method="post" name="form_domain" enctype="multipart/form-data" class="middle-forms" id="form_domain">
			<h3>How to Synchronize calender your calendar</h3>
            <div id='event-feed'>{$feed}</div>
			
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
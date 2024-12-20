{include file="header.tpl"}

{literal}
<script>
$(function(){
  $("#message_counter ul").click(function(){
      form = $('#message_counter');
      $.ajax({
          type: "POST",
          url: '/dashboard/user_count',
          data: $('#message_counter').serialize(),
          dataType: 'json',
          success: function(data){
              $('#user_count').html(data.total_users);
          }
      });
    });
});
</script>
{/literal}


<div id="content">
	<div id="content-top">
    <h2>Report generator</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>

      <div id="mid-col" class="full-col" style="width:100% !important;"><!-- end of div.box -->
    
   	  <div class="box">
      	<h4 class="white">Report generator</h4>
        <div class="box-container">
        
        
            <form action="/report/generate" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="message_counter">
			<h3>Use the below form to create your financial reports
      <div style="float:right" >Total users: <span id="user_count">{$user_count}</span></h3>
           <table width="100%" style="border-spacing:10px;">
                <tr>
                    <td>
                        {if $domains|count > 1 }
                            <b>Domains:</b><Br />
                            <ul class="checklist">
                                {section name=inst loop=$domains}
                                    <li><label for="ck_domain_{$domains[inst].id}"><input type="checkbox"  name="domains[]"  value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}"/>{$domains[inst].domain}</label></li>
                                {/section}
                            </ul>
                        {/if}
                    </td>
                    <td>
                        <b>Universities:</b><Br />

                        <ul class="checklist">
                            {section name=inst loop=$universities}
                                <li><label for="ck_universities_{$universities[inst]}"><input type="checkbox"  name="universities[]"
                                  value="{$universities[inst]}" id="ck_universities_{$universities[inst]}"/>{$universities[inst]}</label></li>
                            {/section}

                        </ul>

                    </td>

                    <td>

                    </td>
                    <td>
                     
                        <b>Year of study:</b><Br />

                        <ul class="checklist">
                            {section name=inst loop=$study_years}
                                <li><label for="ck_study_years_{$study_years[inst]}"><input type="checkbox"  name="study_years[]"  value="{$study_years[inst]}" id="ck_study_years_{$study_years[inst]}"
                               
                                />{$study_years[inst]}</label></li>
                            {/section}


                        </ul>

                    </td>
               </tr>
                    <td>
                     
                        <b>Groups:</b><Br />
                        <ul class="checklist">
                            {section name=inst loop=$groups}
                                <li><label for="ck_groups_{$groups[inst].id}"><input type="checkbox"  name="groups[]"  value="{$groups[inst].id}" id="ck_groups_{$groups[inst].id}"
                                
                                />{$groups[inst].name}</label></li>
                            {/section}


                        </ul>

                    </td>
                    <td valign="top">
                     
                        <b>Select a financial year:</b><Br />
                        <select name="year">
                          <option value="-1">All years</option>
                            {section name=inst loop=$years}
                                <option value="{$years[inst].year}">{$years[inst].year}</option>
                            {/section}
                        </select>

                    </td>
                    <td valign="top">


                    </td>

               <tr>
            </table>
			<br /><Br />
			<input type="submit" class="minibutton bblue" value="Generate report" />
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}


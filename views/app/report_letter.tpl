  {literal}
<script>
$(function(){
  $("#message_counter3 ul").click(function(){
      form = $('#message_counter');
      $.ajax({
          type: "POST",
          url: '/report/letter_count',
          data: $('#message_counter3').serialize(),
          dataType: 'json',
          success: function(data){
              $('#user_count2').html(data.total_users);
          }
      });
    });
});
</script>
{/literal}
        
            <form action="/report/letter/1" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="message_counter3">
            <h3>Letter to Martin
      <div style="float:right" >Total users: <span id="user_count2">{$user_count}</span></h3>
           <table width="100%" style="border-spacing:10px;">
                <tr>
                    <td>
                        {if $domains|count > 1 }
                            <b>Domains:</b><Br />
                            <ul class="checklist">
                                {section name=inst loop=$domains}
                                    <li><label for="ck_domain_{$domains[inst].id}s"><input type="checkbox"  name="domains[]"  value="{$domains[inst].id}" id="ck_domain_{$domains[inst].id}s"/>{$domains[inst].domain}</label></li>
                                {/section}
                            </ul>
                        {/if}
                    </td>
                    <td>
                        <b>Universities:</b><Br />

                        <ul class="checklist">
                            {section name=inst loop=$universities}
                                <li><label for="ck_universities_{$universities[inst]}s"><input type="checkbox"  name="universities[]"
                                  value="{$universities[inst]}" id="ck_universities_{$universities[inst]}s"/>{$universities[inst]}</label></li>
                            {/section}

                        </ul>

                    </td>

                    <td>

                    </td>
                    <td>
                     
                        <b>Year of study:</b><Br />

                        <ul class="checklist">
                            {section name=inst loop=$study_years}
                                <li><label for="ck_study_years_{$study_years[inst]}s"><input type="checkbox"  name="study_years[]"  value="{$study_years[inst]}" id="ck_study_years_{$study_years[inst]}s"
                               
                                />{$study_years[inst]}</label></li>
                            {/section}


                        </ul>

                    </td>
               </tr>
                    <td>
                     
                        <b>Groups:</b><Br />
                        <ul class="checklist">
                            {section name=inst loop=$groups}
                                <li><label for="ck_groups_{$groups[inst].id}s"><input type="checkbox"  name="groups[]"  value="{$groups[inst].id}" id="ck_groups_{$groups[inst].id}s"
                                
                                />{$groups[inst].name}</label></li>
                            {/section}


                        </ul>

                    </td>
                    <td valign="top">
                     
                        <b>Select a year:</b><Br />
                        <select name="year">
                          <option value="-1">All years</option>
                            {section name=inst loop=$years}
                                <option value="{$years[inst].letter_date}">{$years[inst].letter_date}</option>
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
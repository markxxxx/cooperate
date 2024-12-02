{include file="header.tpl"}
<script>
{literal}

var numShown = 10; // Initial rows shown & index
var numRows = $('tbody').find('tr').length;
var numLeft = numRows - numShown;

$(document).ready(function(){
 // Hide rows and add clickable div
 $('tbody')
  .find('tr:gt(' + (numShown - 1) + ')').hide().end() 
  $('.table_truc').after('<div id="more" style="color:red">Show all</div>');

  $('#more').toggle(
     function(){
       numShown = 1000;
       $('tbody').find('tr:lt('+numShown+')').show(); 
       $("#more").html("");
     }, function() {

     });
  });

{/literal}


</script>


{literal}

<style>
.segmented-button {
  
}
.segmented-button input[type="radio"] {
  width: 0px;
  height: 0px;
  display: none;
}
.segmented-button label {
  display: -moz-inline-box;
  -moz-box-orient: vertical;
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  -o-border-radius: 4px;
  -ms-border-radius: 4px;
  -khtml-border-radius: 4px;
  border-radius: 4px;
  text-shadow: white;
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #e4e4e4));
  background: -webkit-linear-gradient(#ffffff, #e4e4e4);
  background: -moz-linear-gradient(#ffffff, #e4e4e4);
  background: -o-linear-gradient(#ffffff, #e4e4e4);
  background: -ms-linear-gradient(#ffffff, #e4e4e4);
  background: linear-gradient(#ffffff, #e4e4e4);
  border: 1px solid #b2b2b2;
  color: #666666;
  padding: 5px 24px;
  padding-bottom: 3px;
  font-size: 12px;
  cursor: pointer;
  font-family: Helvetica;
  -moz-border-radius: 0px;
  -webkit-border-radius: 0px;
  -o-border-radius: 0px;
  -ms-border-radius: 0px;
  -khtml-border-radius: 0px;
  border-radius: 0px;
  margin-right: -5px;
}
.segmented-button label {
  *display: inline;
}
.segmented-button label:hover {
  -moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.1);
  -o-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.1);
  box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.1);
  color: #333333;
}
.segmented-button label:active, .segmented-button label.active {
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e4e4e4), color-stop(100%, #ffffff));
  background: -webkit-linear-gradient(#e4e4e4, #ffffff);
  background: -moz-linear-gradient(#e4e4e4, #ffffff);
  background: -o-linear-gradient(#e4e4e4, #ffffff);
  background: -ms-linear-gradient(#e4e4e4, #ffffff);
  background: linear-gradient(#e4e4e4, #ffffff);
}
.segmented-button label:disabled, .segmented-button label.disabled {
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #efefef));
  background: -webkit-linear-gradient(#ffffff, #efefef);
  background: -moz-linear-gradient(#ffffff, #efefef);
  background: -o-linear-gradient(#ffffff, #efefef);
  background: -ms-linear-gradient(#ffffff, #efefef);
  background: linear-gradient(#ffffff, #efefef);
  cursor: default;
  color: #b2b2b2;
  border-color: #cccccc;
  -moz-box-shadow: none;
  -webkit-box-shadow: none;
  -o-box-shadow: none;
  box-shadow: none;
}
.segmented-button label.first {
  -moz-border-radius-topleft: 4px;
  -webkit-border-top-left-radius: 4px;
  -o-border-top-left-radius: 4px;
  -ms-border-top-left-radius: 4px;
  -khtml-border-top-left-radius: 4px;
  border-top-left-radius: 4px;
  -moz-border-radius-bottomleft: 4px;
  -webkit-border-bottom-left-radius: 4px;
  -o-border-bottom-left-radius: 4px;
  -ms-border-bottom-left-radius: 4px;
  -khtml-border-bottom-left-radius: 4px;
  border-bottom-left-radius: 4px;
}
.segmented-button label.last {
  -moz-border-radius-topright: 4px;
  -webkit-border-top-right-radius: 4px;
  -o-border-top-right-radius: 4px;
  -ms-border-top-right-radius: 4px;
  -khtml-border-top-right-radius: 4px;
  border-top-right-radius: 4px;
  -moz-border-radius-bottomright: 4px;
  -webkit-border-bottom-right-radius: 4px;
  -o-border-bottom-right-radius: 4px;
  -ms-border-bottom-right-radius: 4px;
  -khtml-border-bottom-right-radius: 4px;
  border-bottom-right-radius: 4px;
}
.segmented-button input:checked + label, .segmented-button label.selected {
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e4e4e4), color-stop(100%, #ffffff));
  background: -webkit-linear-gradient(#e4e4e4, #ffffff);
  background: -moz-linear-gradient(#e4e4e4, #ffffff);
  background: -o-linear-gradient(#e4e4e4, #ffffff);
  background: -ms-linear-gradient(#e4e4e4, #ffffff);
  background: linear-gradient(#e4e4e4, #ffffff);
}
.segmented-button input:disabled + label {
  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #efefef));
  background: -webkit-linear-gradient(#ffffff, #efefef);
  background: -moz-linear-gradient(#ffffff, #efefef);
  background: -o-linear-gradient(#ffffff, #efefef);
  background: -ms-linear-gradient(#ffffff, #efefef);
  background: linear-gradient(#ffffff, #efefef);
  cursor: default;
  color: #b2b2b2;
  border-color: #cccccc;
  -moz-box-shadow: none;
  -webkit-box-shadow: none;
  -o-box-shadow: none;
  box-shadow: none;
}

#hor-minimalist-a
{
  font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
  font-size: 12px;
  background: #fff;
  
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-a th
{
  font-size: 14px;
  font-weight: normal;
  color: #039;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-a td
{
  color: #669;
  padding: 9px 8px 0px 8px;
}
#hor-minimalist-a tbody tr:hover td
{
  color: #009;
}


#hor-minimalist-b
{
  font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
  font-size: 12px;
  background: #fff;
  margin: 45px;
  width: 480px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 14px;
  font-weight: normal;
  color: #039;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b td
{
  border-bottom: 1px solid #ccc;
  color: #669;
  padding: 6px 8px;
}
#hor-minimalist-b tbody tr:hover td
{
  color: #009;
}


#ver-minimalist
{
  font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
  font-size: 12px;
  margin: 45px;
  width: 480px;
  text-align: left;
  border-collapse: collapse;
}
#ver-minimalist th
{
  padding: 8px 2px;
  font-weight: normal;
  font-size: 14px;
  border-bottom: 2px solid #6678b1;
  border-right: 30px solid #fff;
  border-left: 30px solid #fff;
  color: #039;
}
#ver-minimalist td
{
  padding: 12px 2px 0px 2px;
  border-right: 30px solid #fff;
  border-left: 30px solid #fff;
  color: #669;
}


#box-table-a
{
  font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
  font-size: 12px;
  margin: 45px;
  width: 480px;
  text-align: left;
  border-collapse: collapse;
}
#box-table-a th
{
  font-size: 13px;
  font-weight: normal;
  padding: 8px;
  background: #b9c9fe;
  border-top: 4px solid #aabcfe;
  border-bottom: 1px solid #fff;
  color: #039;
}
#box-table-a td
{
  padding: 8px;
  background: #e8edff; 
  border-bottom: 1px solid #fff;
  color: #669;
  border-top: 1px solid transparent;
}
#box-table-a tr:hover td
{
  background: #d0dafd;
  color: #339;
}

</style>
{/literal}



<form action="" method="POST" id="stat-filter">

<div id="content">
	<div id="content-top">
    <h2>Stats Manager</h2> 
    <nav class="segmented-button right">
<input type="radio" name="seg-1"  id="GBP" onclick="document.location='/stats/set_currency/GBP';" {if $currency->convert_to eq 'GBP'} checked {/if}>
          <label for="GBP">GBP</label>

      <input type="radio" name="seg-1"  id="ILS" onclick="document.location='/stats/set_currency/ILS';" {if $currency->convert_to eq 'ILS'} checked {/if}>
          <label for="ILS" class="first">ILS</label>
      
      <input type="radio" name="seg-1"  id="USD" onclick="document.location='/stats/set_currency/USD';" {if $currency->convert_to eq 'USD'} checked {/if}>
          <label for="USD">USD</label>
      
      <input type="radio" name="seg-1"  id="UAH" onclick="document.location='/stats/set_currency/UAH';" {if $currency->convert_to eq 'UAH'} checked {/if}>
          <label for="UAH">UAH</label>
      
      <input type="radio" name="seg-1"  id="ZAR" onclick="document.location='/stats/set_currency/ZAR';" {if $currency->convert_to eq 'ZAR'} checked {/if}>
        <label for="ZAR" class="last">ZAR</label>
      
      <input type="radio" name="seg-1"  id="RESET" onclick="document.location='/stats/set_currency';" {if $currency->convert_to eq ''} checked {/if}>
        <label for="RESET" class="last">RESET</label>
    </nav>



<!--     <a class="segmented-button left" href="/stats/set_currency/ILS">ILS</a>
    <a class="segmented-button left" href="/stats/set_currency/USD">USD</a>
    <a class="segmented-button left" href="/stats/set_currency/UAH">UAH</a>
    <a class="segmented-button left" href="/stats/set_currency/ZAR">ZAR</a>&nbsp
     <a class="segmented-button left" href="/stats/set_currency">RESET</a> -->
      


      <span class="clearFix">&nbsp;</span>
      </div>


      
      <div id="mid-col" class="full-col" style="width:100% !important;">

      <div class="box" id="to-do">
              <ul class="tab-menu">
                <li><a href="#present">Present scholars</a></li>
                <li><a href="#past">Alumni</a></li>
                <li><a href="#future">Future graduates</a></li>
                <li><a href="#cost_average">Costs average</a></li>
                <li><a href="#cost_totals">Costs total</a></li>
                <li><a href="#supplier">Supplier</a></li>
               <!--  <li><a href="#academics">Academics</a></li>
                <li><a href="#graduate">Graduate</a></li> -->
                <li><a href="#kpi">KPI's</a></li>

                <a class="minibutton right" href="/stats/export">Export</a>

              </ul>



              <div class="box-container" id="present">

                <h3 class='green'>Present Scholars</h3>
                <b>Total students:{$stats->total_scholars()}</b>

                {$stats->bursar_domain_graph()}
                {$stats->bursar_status_graph()}
                {$stats->bursar_gender_graph2()}
                {$stats->bursar_final_year()}

                <br /><br />



                <ul class="tab-menu">
                  {section name=inst loop=$domains}
                      <li><a href="#domain_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                  {/section}
                </ul>


                {section name=inst loop=$domains}
                  <div class="box-container" id="domain_{$domains[inst].id}">
                      {$stats->bursar_university_graph($domains[inst].id)}
                      {$stats->bursar_study_field_graph($domains[inst].id)}

                      {if $domains[inst].id eq 9}
                        {$stats->bursar_ethnic_graph($domains[inst].id)}
                      {else}
                         {$stats->bursar_race_graph($domains[inst].id)}
                      {/if}

                      {$stats->bursar_gender_graph($domains[inst].id)}
                      {$stats->bursar_status_graph($domains[inst].id)}

                      <br /><br />
                      {$stats->bursar_kpi_faculty_inst_table($domains[inst].id)}
                      <br /><br />

                      {$stats->bursar_kpi_inst_year_table($domains[inst].id)}

                  </div>
                {/section}

              </div>
              
              <div class="box-container" id="past">
                <h3 class='green'>Past scholars</h3>
                <b>Total students:{$stats->total_grads()}</b>

                {$stats->grad_domain_graph()}

                <ul class="tab-menu">
                  {section name=inst loop=$domains}
                      <li><a href="#grad_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                  {/section}
                </ul>


                {section name=inst loop=$domains}
                  <div class="box-container" id="grad_{$domains[inst].id}">
                      {$stats->grad_university_graph($domains[inst].id)}
                      {$stats->grad_study_field_graph($domains[inst].id)}

                      {if $domains[inst].id eq 9}
                        {$stats->grad_ethnic_graph($domains[inst].id)}
                      {else}
                         {$stats->grad_race_graph($domains[inst].id)}
                      {/if}
                     
                      {$stats->grad_gender_graph($domains[inst].id)}
                      {$stats->employer_graph($domains[inst].id)}
                      <br /><br />
                      {$stats->grad_kpi_faculty_inst_table($domains[inst].id)}
                      <br /><br />

                      {$stats->grad_kpi_inst_year_table($domains[inst].id)}
                  </div>
                {/section}
              </div>


              <div class="box-container" id="future">
                  {section name=inst loop=$domains}
                      <h3 class='green'>{$domains[inst].domain} Future scholars</h3>
                      {$stats->future_bursar_graph($domains[inst].id)}
                  {/section}
              </div>
              
              <div class="box-container" id="cost_average">
                <br /><br /><br />
                <ul class="tab-menu">
                  {section name=inst loop=$domains}
                      <li><a href="#cost_average_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                  {/section}
                </ul>


                {section name=inst loop=$domains}
                  <div class="box-container" id="cost_average_{$domains[inst].id}">

                      {assign var="cost_average_degree" value=$stats->cost_average_degree($domains[inst].id)}
                      {assign var="cost_average_reference" value=$stats->cost_average_reference($domains[inst].id)}
                      {assign var="cost_average" value=$stats->cost_average($domains[inst].id)}
                      {assign var="cost_average_uni" value=$stats->cost_average_uni($domains[inst].id)}


                      <br /><Br />

                      {if $cost_average}
                        <h3 class='green'>Averages cost per student <div class="right">{if !$currency->convert_to} {$domains[inst].currency}  {else} {$currency->convert_to} {/if}{array_total field='average_spend' data=$cost_average}</div>
                            
                        </h3>
                        <table class='table-short' style='width:100% !important'>
                          <thead>
                            <tr>
                              <td>Year</td>
                              <td>Average</td>
                            </tr>
                          </thead>
                          <tbody>
                            {section name=inst2 loop=$cost_average}
                              <tr>
                                <td width="50%">
                                  {$cost_average[inst2].year_s}
                                </td>

                                <td>
                                  {$cost_average[inst2].average_spend|money}
                                </td>
                              </tr>
                            {/section}
                          </tbody>
                        </table>
                        <br />
                        <div class=""></div>



                      {/if}


                    {if $cost_average_uni}
                      <br /><Br />
                      <a class="right colorbox" href="/stats/compare/uni/average/{$domains[inst].id}">Compare annually</a>

                      <h3 class='green'>University Averages</h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>University</td>
                            <td>Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_average_uni}
                            <tr>
                              <td width="50%">
                                {$cost_average_uni[inst2].university}
                              </td>

                              <td>
                                {$cost_average_uni[inst2].total_expenditure|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>
                      {/if}

                      <br /><br />



                      {if $cost_average_reference}
                      <a class="right colorbox" href="/stats/compare/reference/average/{$domains[inst].id}">Compare annually</a>

                      <h3 class='green'>Reference Averages
                      </h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>Reference</td>
                            <td>Average</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_average_reference}
                            <tr>
                              <td width="50%">
                                {$cost_average_reference[inst2].reference}
                              </td>

                              <td>
                                {$cost_average_reference[inst2].total_expenditure|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>
                    <br />


                    {/if}
                    {if $cost_average_degree}
                    <a class="right colorbox" href="/stats/compare/degree/average/{$domains[inst].id}">Compare annually</a>

                      <h3 class='green'>Degree averages
                         
                      </h3>
                        <table class='table-short' style='width:100% !important'>
                          <thead>
                            <tr>
                              <td>Reference</td>
                              <td>Degree</td>
                            </tr>
                          </thead>
                          <tbody>
                            {section name=inst2 loop=$cost_average_degree}
                              <tr>
                                <td width="50%">
                                  {$cost_average_degree[inst2].discipline}
                                </td>

                                <td>
                                  {$cost_average_degree[inst2].total_expenditure|money}
                                </td>
                              </tr>
                            {/section}
                          </tbody>
                        </table>

                  {/if}
                                      </div>

                {/section}

                

              </div>

              <div class="box-container" id="cost_totals">
                   <br /><br /><br />
                <ul class="tab-menu">
                  {section name=inst loop=$domains}
                      <li><a href="#cost_total_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                  {/section}
                </ul>


                {section name=inst loop=$domains}
                  <div class="box-container" id="cost_total_{$domains[inst].id}">

                      {assign var="cost_total_degree" value=$stats->cost_total_degree($domains[inst].id)}
                      {assign var="cost_total_reference" value=$stats->cost_total_reference($domains[inst].id)}
                      {assign var="cost_total" value=$stats->cost_total($domains[inst].id)}
                      {assign var="cost_total_uni" value=$stats->cost_total_uni($domains[inst].id)}


                      <br /><Br />
                      {if $cost_total}
                      <h3 class='green'>Yearly Totals <div class="right">{if !$currency->convert_to} {$domains[inst].currency}  {else} {$currency->convert_to} {/if}{array_total field='average_spend' data=$cost_total}</div></h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>Year</td>
                            <td>Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_total}
                            <tr>
                              <td width="50%">
                                {$cost_total[inst2].year_s}
                              </td>

                              <td>
                                {$cost_total[inst2].average_spend|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>

                      {/if}
                    <br />

                      {if $cost_total_uni}
                      <br /><Br />
                      <a class="right colorbox" href="/stats/compare/uni/total/{$domains[inst].id}">Compare annually</a>

                      <h3 class='green'>University Totals</h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>University</td>
                            <td>Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_total_uni}
                            <tr>
                              <td width="50%">
                                {$cost_total_uni[inst2].university}
                              </td>

                              <td>
                                {$cost_total_uni[inst2].total_expenditure|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>
                      {/if}
                    <br />

                      {if $cost_total_reference}
                        <br />
                        <a class="right colorbox" href="/stats/compare/reference/total/{$domains[inst].id}">Compare annually</a>

                        <h3 class='green'>Reference Totals</h3>
                        <table class='table-short' style='width:100% !important'>
                          <thead>
                            <tr>
                              <td>Reference</td>
                              <td>Total</td>
                            </tr>
                          </thead>
                          <tbody>
                            {section name=inst2 loop=$cost_total_reference}
                              <tr>
                                <td width="50%">
                                  {$cost_total_reference[inst2].reference}
                                </td>
                                <td>
                                  {$cost_total_reference[inst2].total_expenditure|money}
                                </td>
                              </tr>
                            {/section}
                          </tbody>
                        </table>
                      {/if}
                    <br />                    <br />


                    {if $cost_total_degree}
                    <a class="right colorbox" href="/stats/compare/degree/total/{$domains[inst].id}">Compare annually</a>

                    <h3 class='green'>Degree Totals</h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>Reference</td>
                            <td>Degree</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_total_degree}
                            <tr>
                              <td width="50%">
                                {$cost_total_degree[inst2].discipline}
                              </td>

                              <td>
                                {$cost_total_degree[inst2].total_expenditure|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>
                    {/if}

                  </div>
                {/section}


              </div>

              <div class="box-container" id="supplier">
                
                <br /><br /><br />
                <ul class="tab-menu">
                  {section name=inst loop=$domains}
                      <li><a href="#cost_supplier_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                  {/section}
                </ul>


                {section name=inst loop=$domains}
                  <div class="box-container" id="cost_supplier_{$domains[inst].id}">

                      {assign var="cost_total_supplier" value=$stats->cost_total_supplier($domains[inst].id)}
                      {assign var="cost_average_supplier" value=$stats->cost_average_supplier($domains[inst].id)}
      
                      {if $cost_total_supplier}
                      <br /><Br />
                      <a class="right colorbox" href="/stats/compare/supplier/total/{$domains[inst].id}">Compare annually</a>

                      <h3 class='green'>Supplier totals</h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>Supplier</td>
                            <td>Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_total_supplier}
                            <tr>
                              <td width="50%">
                                {$cost_total_supplier[inst2].supplier}
                              </td>

                              <td>
                                {$cost_total_supplier[inst2].total_expenditure|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>
                      {/if}





                      <!-- <br /><Br />
                      {if $cost_average_supplier}
                      <a class="right colorbox" href="/stats/compare/supplier/average/{$domains[inst].id}">Compare annually</a>

                      <h3 class='green'>Supplier average</h3>
                      <table class='table-short' style='width:100% !important'>
                        <thead>
                          <tr>
                            <td>Supplier</td>
                            <td>Total</td>
                          </tr>
                        </thead>
                        <tbody>
                          {section name=inst2 loop=$cost_average_supplier}
                            <tr>
                              <td width="50%">
                                {$cost_average_supplier[inst2].supplier}
                              </td>

                              <td>
                                {$cost_average_supplier[inst2].total_expenditure|money}
                              </td>
                            </tr>
                          {/section}
                        </tbody>
                      </table>
                     {/if} -->


                  </div>
                {/section}


              </div>

              <div class="box-container" id="academics">

                  <br /><br /><br />
                  <ul class="tab-menu">
                    {section name=inst loop=$domains}
                        <li><a href="#cost_academics_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                    {/section}
                  </ul>


                  {section name=inst loop=$domains}
                    <div class="box-container" id="cost_academics_{$domains[inst].id}">
                      {$stats->pass_rate_yearly($domains[inst].id)}
                    </div>

                  {/section}
            </div>


              <div class="box-container" id="graduate" >


                  % of graudates that keep in contact: {$stats->graduate_contact()}
                  <br /><br /><br />
                  <ul class="tab-menu">
                    {section name=inst loop=$domains}
                        <li><a href="#graduate_contributed_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                    {/section}
                  </ul>

                    <br /><Br />
                  {section name=inst loop=$domains}
                    <div class="box-container" id="graduate_contributed_{$domains[inst].id}">
                      
                      {$stats->graduate_contributed($domains[inst].id)}<br /><br /><Br />
                      {$stats->graduate_jobs($domains[inst].id)}<br /><br /><br />

                      {$stats->graduate_ontime($domains[inst].id)}<br /><br /><Br />


                    </div>
                  {/section}

            </div>


            <div class="box-container" id="kpi" >
               <br /><Br />
                  <ul class="tab-menu">
                    {section name=inst loop=$domains}
                        <li><a href="#1graduate_contributed_{$domains[inst].id}">{$domains[inst].domain}</a></li>
                    {/section}
                  </ul>
                    <br /><Br />
                  {section name=inst loop=$domains}
                    <div class="box-container" id="1graduate_contributed_{$domains[inst].id}">

                        % of graduates that keep in contact: {$stats->graduate_contact()}

                      {$stats->pass_rate_yearly($domains[inst].id)}
                       <br /><br /><br />
                      {$stats->graduate_contributed($domains[inst].id)}<br /><br /><Br />
                      {$stats->graduate_jobs($domains[inst].id)}<br /><br /><br />
                      {$stats->graduate_ontime($domains[inst].id)}<br /><br /><Br />


                    </div>
                  {/section}

            </div>


            

      	 </div>
      	</div>  
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>
</form>
{include file="footer.tpl"}

{include file="header.tpl"}

{head}
{literal}
<script>
  $(function(){
    $('.tab-menu li a').click(function(){
      to_fetch = $(this).attr('data-url');
      hash = to_fetch.split('#').pop();
      $('#'+hash).load(to_fetch);
    });
  });
</script>
{/literal}
{/head}

<div id="content">
    <h3 class="green left" style="width:100%;font-size:200%">SMS statistics
    	<div class="right" style="font-size:smaller;">{$credits}: Credits</div>
    </h3>


      <div id="mid-col" class="full-col" style="width:100% !important;">
      <div class="box" id="to-do">
          <ul class="tab-menu">
            <li><a href="#All" data-url="/sms/stats/0#All">All ({$sms_count})</a></li>
            <li><a href="#Sent" data-url="/sms/stats/Sent#Sent" >Sent ({$stats.Sent.cnt})</a></li>
            <li><a href="#Pending" data-url="/sms/stats/Pending#Pending">Pending ({$stats.Pending.cnt})</a></li>
            <li><a href="#Error" data-url="/sms/stats/Error#Error">Error ({$stats.Error.cnt})</a></li>
          </ul>
          <div class="box-container" id="All">
              {include file="sms.tpl"}
          </div>
          
          <div class="box-container" id="Sent">
            

          </div>


          <div class="box-container" id="Pending">

          </div>

          <div class="box-container" id="Error">

          </div>


       </div>

       </div>


</div>
<div class="clear"></div>

{include file="footer.tpl"}
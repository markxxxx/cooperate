{include file="header.tpl"}
<script>
{literal}
function load_month(month) {
    $('#month_ajax').load('/stats/ajax_month/'+month);
}{/literal}


</script>

<div id="content">
	<div id="content-top">
    <h2>An Error has occurred</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>

      <div id="mid-col" class="full-col" style="width:100% !important;"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Error</h4>
        <div class="box-container">
            <center><img src='/views/app/images/error.jpg' /></center>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}


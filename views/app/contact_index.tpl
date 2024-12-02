{include file="header.tpl"}
{head}{literal}

    <link href="/views/app/css/hovercard.css" media="screen" rel="stylesheet" type="text/css" />    
    <script type="text/javascript" src="/views/app/js/hovercard.js"></script>
    <script type="text/javascript" src="/include/js/rate/jquery.raty.min.js"></script>


	<script>

		$(document).ready(function(){

			function search() {
				$.get('/contact/',$('#search-form').serialize(),function(contacts){
					$('.contacts').html(contacts);
					run_rating();
				});
			}


			$('#reset').click(function(){
				$('#search-form select').val('');
				$('#search-form input[type="text"]').val('');
				search();
			});

			$('#search-form select').change(function(){
				search();
			});

			$('#search-form input').keyup(function(){
				search();
			});
/*
			function run_hovercard (){
				$(".contact .name b").hovercard({
					detailsHTML: '',
					width: 350,
					cardImgSrc: '',
					showCustomCard: true,
					openOnTop:false ,

					onHoverIn: function (e) {
					// set your twitter id

						$.ajax({
							url: '/contact/hovercard/' + $(this).children('b').attr('data-hovercard'),
							type: 'GET',
							beforeSend: function () {
								$("#demo-cb-tweets").prepend('<p class="loading-text">Loading latest tweets...</p>');
							},
							complete: function (data) {
								$(".hc-details").html(data.responseText);
							}
						});
					}
				});
			}*/

			function run_rating() {
				$('.star').raty({
					score: function() {
						return $(this).attr('data-score');
					},
					path: '/include/js/rate/img',
					click : function(score){
						$.get('/contact/rate/'+$(this).attr('data-id')+'/'+score);
						_alert("confirmation",'Rating changed!!');

					}
				});
			}

			run_rating();
			//run_hovercard();


		});

	</script>
{/literal}{/head}

<div id="content">
	<div id="content-top">

    <h2>Contact Manager</h2>
    <a href="/contact/add" class="minibutton bblue right">New Contact</a>
    <div class="clear"></div>
    </div>

      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Search</h4>
          <div class="box-container"><!-- use no-padding wherever you need element padding gone -->


				<div id="quick-send-message-container">
					<h5>Quick search</h5> 
						<fieldset>
							<form id="search-form" name="search" method="get" action="/contact/export" autocomplete="off">

							<legend>Quick Send Message</legend>

								<p><label>Search:</label>
									<input name="search" id="message-title" type="text" />
								</p>
								{if count($suppliers)}
								<p><label>Supplier:</label>
									<select name="supplier_id" style="width:190px">
										<option value="">Select</option>

										{section name=inst loop=$suppliers}
											<option value="{$suppliers[inst].id}">{$suppliers[inst].supplier}</option>
										{/section}
									</select><br />
								</p>
								{/if}
								<p style="margin-top:5px;"><label>Contact type:</label>
									{cfield field=contact_type value=$data.contact_type name=contact_type title="." style="width:190px"}
								</p>
								
								<p style="margin-top:5px;"><label>Rating above:</label>
									<select name="rating" style="width:190px">
										<option value="">Select</option>
										{section name=inst loop=5}
											<option value="{$smarty.section.inst.rownum}">{$smarty.section.inst.rownum}</option>
										{/section}
									</select><br />
								</p>
								<br />

								<input type="button" class="minibutton right" id="reset" value="Clear" />
								{if $user->can_access('event','export')}
									<input type="submit" class="minibutton left bblue" id="reset" value="Export" />
								{/if}

							<div  class="clear"></div>

							</form>




							
						</fieldset>


				</div>
		</div>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box --><!--end of div.box --><!-- end of div.box -->
      </div> <!-- end of div#left-col -->
      
      <div id="mid-col" class="full-col"><!-- end of div.box -->
      	
   	  <div class="box">
      	<h4 class="white">Contact </h4>
        <div class="box-container">
		<form action="/contact/delete_selected" name="form_contact" id="form_contact" method="POST">
			<div class="contacts">
				{include file="contacts.tpl"}
				<div class="clear"></div>
				
			</div>

			</form>


      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}



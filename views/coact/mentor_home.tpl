{include file="header.tpl"}

<div id="content">
	<div id="content-top">
    <h2>Dashboard - {$domain_name}</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Mentorship Module</h4>
          <div class="box-container">
              <ul class="list-links">
              
                <p style="padding:8px;">
                    <img src="/views/app/images/mentorship.jpg" width="208"/>
                </p>

              </ul>
          </div>
          </div>
      </div> 
      
      <div id="mid-col" class="full-col">

   	  <div class="box">
      	<h4 class="white">Mentorship module alpha</h4>
        <div class="box-container">
		<form action="" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
			<h3>Mentorship module  </h3>
			<p>Hi {$user->name|ucfirst} {$user->surname|ucfirst}</p>
            <p>Click on the user tab to view users that you would like to manage</p>

            
            
		</div>
		</form>
      	</div>
      	</div> 
      </div>   
      <span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
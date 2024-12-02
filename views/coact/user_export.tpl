<html>
<head>
<style>{literal}
body {
    margin:0px;
    padding:0px;
}


A:link {color:#db3251; text-decoration:none; }
A:visited {color:#db3251; text-decoration:none;}
A:active {color:#db3251; text-decoration:none;}
A:hover {color:#db3251; text-decoration:none;}

a {
    color:#0784BA;
    text-decoration:none;
}

#header {
    width:960px;
    margin:0px auto;
    
}

#cv-details {
    width:700px;
    margin:0px auto;
    padding-top:50px;
}

#logo {
    margin-top:15px;
    float:left;

}

#options {
    float:right;
    margin-top:13px;
}

body,table,tr,td,a,h1,h2,h3,h4 {
    font-family:tahoma,arial,serif;
    font-size:12px;
    color: #5F5F5F; 
}

body {
    padding:20px;
}

b { color: #000000; }

h2 {
    text-align:left;
    padding-top:0px;
    padding-bottom:3px;
    width:99%;
    border-top:1px solid silver;
    border-bottom:1px solid silver;
    letter-spacing:0.3px;
    margin-bottom:5px;
    font-weight: normal;
    font-size: 14px;

color: #022871;
}


h1 {
    margin-bottom: 2px;
    font-size:16px;
}

h1,h2 em {
    font-style:normal;
    color:#022873;
}

em {
    color:gray;
    font-style:normal;
}

.indent {
    padding-left:30px;
    padding-top:10px;
}

.content_indent {
    padding-left:30px;
}

div.doc_files {float:left;text-align:center; width:120px;padding:10px;}
div.doc_files a  {color:#508DB8;text-decoration:none;}

{/literal}
</style>

 
<body>
	<div id="cv-details">
		<table width="550px" >
		    <tr>
		        <td align="right" >
		            <h1>{$u_profile.name} <em>{$u_profile.surname}</em></h1>
		            <em>{$profile.cell_number} - {$profile.home_email}<em>
		            <br />
		            <br />
		        </td>
		    </tr>
		</table>
		{if $profile}
			<table width="550px" >
			    <tr>
			        <td><h2>Personal Information</h2></td>
			    </tr>
			    <tr>
			        <td class="content_indent">  
						<table width="500px">
							<tr>
								<td width="250px">Initial:</td>
								<td>{$profile.initial}</td>
							</tr>
							<tr>
								<td>Preferred Name:</td>
								<td>{$profile.salutation}</td>
							</tr>
							<tr>
								<td>Title:</td>
								<td>{$profile.title}</td>
							</tr>
							<tr>
								<td>Cellphone number:</td>
								<td>{$profile.cell_number}</td>
							</tr>
							<tr>
								<td>Id number:</td>
								<td>{$profile.id_num}</td>
							</tr>
							<tr>
								<td>Id type:</td>
								<td>{$profile.id_type}</td>
							</tr>
							<tr>
								<td>Date of birth:</td>
								<td>{$profile.date_of_birth}</td>
							</tr>
							<tr>
								<td>Race:</td>
								<td>{$profile.race}</td>
							</tr>
							<tr>
								<td>Nationality:</td>
								<td>{$profile.nationality}</td>
							</tr>
							<tr>
								<td>Gender:</td>
								<td>{$profile.gender}</td>
							</tr>
							<tr>
								<td>First language:</td>
								<td>{$profile.first_language}</td>
							</tr>
							<tr>
								<td>Drivers:</td>
								<td>{$profile.drivers}</td>
							</tr>
							<tr>
								<td>Passport:</td>
								<td>{$profile.passport}</td>
							</tr>
						</table>
					</td>
			    </tr>
			</table>
		{/if}

		{if isset($profile.home_address)}
			<table width="550px" >
			    <tr>
			        <td><h2>Contact Details</h2></td>
			    </tr>
			    <tr>
			        <td class="content_indent">  
						<table width="500px">
							<tr>
								<td width="250px">Address:</td>
								<td>{$profile.home_address}</td>
							</tr>
							<tr>
								<td>Next of kin:</td>
								<td>{$profile.bank_acc}</td>
							</tr>
							<tr>
								<td>Contact:</td>
								<td>{$profile.home_contact}</td>
							</tr>
							<tr>
								<td>Landline:</td>
								<td>{$profile.home_landline}</td>
							</tr>
							<tr>
								<td>Cellphone Number:</td>
								<td>{$profile.home_cell}</td>
							</tr>
							<tr>
								<td>Email:</td>
								<td>{$profile.home_email}</td>
							</tr>
							
						</table>
					</td>
			    </tr>
			    <tr>
			        <td><h2>University Contact Details</h2></td>
			    </tr>
			    <tr>
					<td class="content_indent">  
						<table width="500px">
							<tr>
								<td width="250px">Address:</td>
								<td>{$profile.uni_address}</td>
							</tr>
							<tr>
								<td>Cellphone Number:</td>
								<td>{$profile.uni_cell}</td>
							</tr>
							<tr>
								<td>Email:</td>
								<td>{$profile.uni_email}</td>
							</tr>
							<tr>
								<td>Address to use:</td>
								<td>{$profile.address_to_use}</td>
							</tr>					
						</table>
					</td>

			    </tr>
			</table>
		{/if}
		{if isset($profile.bank)}
			<table width="550px" >
			    <tr>
			        <td><h2>Banking Details</h2></td>
			    </tr>
			    <tr>
			        <td class="content_indent">  
						<table width="500px">
							<tr>
								<td width="250px">Bank:</td>
								<td>{$profile.bank}</td>
							</tr>
							<tr>
								<td>Account number:</td>
								<td>{$profile.bank_acc}</td>
							</tr>
							<tr>
								<td>Brach code:</td>
								<td>{$profile.bank_branch}</td>
							</tr>
							<tr>
								<td>Branch Name:</td>
								<td>{$profile.bank_branch_name}</td>
							</tr>
							<tr>
								<td>Account Type:</td>
								<td>
									{if $profile.account_type eq 1}
										Cheque
									{/if}
									{if $profile.account_type eq 2}
										Savings
									{/if}
                            	</td>
							</tr>
							
						</table>
					</td>
			    </tr>
			</table>
		{/if}
		{if isset($profile.hobbies)}
			<table width="550px" >
			    <tr>
			        <td><h2>More About Yourself</h2></td>
			    </tr>
			    <tr>
			        <td class="content_indent">  
						<table width="500px">
							<tr>
								<td width="250px">Intrests / Hobbies:</td>
								<td>{$profile.hobbies}</td>
							</tr>
							<tr>
								<td>Extra Curricular Activities:</td>
								<td>{$profile.activities}</td>
							</tr>
							<tr>
								<td>Awards/Prizes:</td>
								<td>{$profile.awards}</td>
							</tr>
							<tr>
								<td>Boot Size:</td>
								<td>{$profile.bootsize}</td>
							</tr>
							<tr>
								<td>Overall Size:</td>
								<td>
									{$profile.overallsize}
                            	</td>
							</tr>
							
						</table>
					</td>
			    </tr>
			</table>
			{/if}
			{if $scholarship}
			<table width="550px" >
			    <tr>
			        <td><h2>Scholarship information</h2></td>
			    </tr>
			    <tr>
			        <td class="content_indent">  
						<table width="500px">
							<tr>
								<td width="250px">Student number:</td>
								<td>{$scholarship.student_number}</td>
							</tr>
							<tr>
								<td>Award date:</td>
								<td>{$scholarship.award_date}</td>
							</tr>
							<tr>
								<td>Study Year:</td>
								<td>{$scholarship.year_of_study}</td>
							</tr>
							<tr>
								<td>Graduate date:</td>
								<td>{$scholarship.grad_date}</td>
							</tr>
							<tr>
								<td>Years to complete:</td>
								<td>
									{$scholarship.years_to_complete}
                            	</td>
							</tr>
							<tr>
								<td>Where do you stay:</td>
								<td>
									{$scholarship.residence}
                            	</td>
							</tr>

							<tr>
								<td>Your Degree:</td>
								<td>
									{$scholarship.degree}
                            	</td>
							</tr>
							<tr>
								<td>Your University:</td>
								<td>
									{$scholarship.university}
                            	</td>
							</tr>

							<tr>
								<td>Your Campus:</td>
								<td>
									{$scholarship.campus}
                            	</td>
							</tr>
							<tr>
								<td>Your Discipline:</td>
								<td>
									{$scholarship.discipline}
                            	</td>
							</tr>


						</table>
					</td>
			    </tr>
			</table>
			{/if}

			
			<div style="page-break-before: always;"></div>
			{if $academics}
			<table width="550px" >
			    <tr>
			        <td><h2>Academic information</h2></td>
			    </tr>
			    <tr>
			    	<td class="content_indent">
			    		<br />
					    {section name=inst loop=$academics}

		                        <table bgcolor="#f3f3f3" width="100%">
		                            <tr>
		                                {if $academics[inst].university_year eq 'Matric'}
		                                      <td width="400"><b>Matric results:</b> {$academics[inst].school_name} - {$academics[inst].calendar_year}</a></td>
		                                      <td><b>Address:</b> {$academics[inst].school_address}</td>
		                                {else}
		                                      <td><b>{$academics[inst].calendar_year}:</b> {$academics[inst].university_year} - {$academics[inst].acadmic_record_type}</td>
		                                {/if}
		                            </tr>

		                        </table>

			                    <table width="100%" class="content_indent">
			                        <tr>
			                            <td><b>Subject</b></td>
			                            <td><b>Mark</b></td>
			                            <td><b>Symbol</b></td>
			                        </tr>
			                        
			                        {section name=subject_inst loop=$academics[inst].subjects}
			                            <tr>
			                                <td>{$academics[inst].subjects[subject_inst].subject}</td>
			                                <td>{$academics[inst].subjects[subject_inst].mark}</td>
			                                <td>{$academics[inst].subjects[subject_inst].symbol}</td>
			                            </tr>
			                        {/section}
			                    </table>
			                    <br />
			                    <br />
			                    
			                {/section}
	            	</td>
	        </tr>

	    </table>
	    {/if}

	{if $articles}
  <div style="page-break-before: always;"></div>
			<table width="550px" >
			    <tr>
			        <td><h2>Article information</h2></td>
			    </tr>
			    <tr>
			    	<td class="content_indent">
						{section name=inst loop=$articles}
								<h5 style="padding-left:0px;margin-left:0">{$articles[inst].year_to_start}: {$articles[inst].company}</h5>

	
											
												<table width="100%">
													<tr>
														<td><b>Signed a final agreement:</b> {$articles[inst].agreement}<br />

														<b>Reported to:</b> {$articles[inst].contact_name}<br />
														<b>Contact:</b> {$articles[inst].contact_number}<br /><br /><Br />
													</td>
													<tr>
													<td><b>Job description:</b><br /> {$articles[inst].description}<br /><br /></td>
													</tr>


												</table>
	

								
									
						</div>
					</td>
				</tr>


		{/section}
		</table>
	{/if}





	    {if $internships}
	    <div style="page-break-before: always;"></div>
			<table width="550px" >
			    <tr>
			        <td><h2>Work information</h2></td>
			    </tr>
			    <tr>
			    	<td class="content_indent">
			    		<br />
	     {section name=inst loop=$internships}
                    <h5 style="padding-left:0px;margin-left:0">{$internships[inst].date_started|date_format} - {$internships[inst].date_ended|date_format}</h5>

                    <table width="100%" bgcolor="#f3f3f3" style="border-top:1px solid silver; ">
                        <tr>
                            <td width="33%"><b>Company:</b> {$internships[inst].name}</td>
                            <td width="33%"><b>Location:</b> {$internships[inst].location}</td>
                            <td width="33%"><b>Work type:</b> {$internships[inst].work_type}</td>
                        </tr>
                        <tr>
                           
                            <td width="33%"><b>Reported to:</b> {$internships[inst].reported_to}</td>
                            <td  width="33%"><b>Contact:</b> {$internships[inst].reported_to_num}</td>
                            <td  width="33%">&nbsp;</td>
                            
                        </tr>

                    </table>

                        <p>{$internships[inst].description}</p><br />
                        {assign var="has_comments" value="0"}
                        {section name=inst_comments loop=$comments}
                            {if $comments[inst_comments].ident_id eq $internships[inst].id}
                            	{assign var="has_comments" value="1"}
                            {/if}
                        {/section}
                        
                        <div  class="content_indent" >
                            {section name=inst_comments loop=$comments}
                                {if $comments[inst_comments].ident_id eq $internships[inst].id}
                                    <div style="font-size:12px;background-color:#f3f3f3;padding:5px;margin-bottom:10px" >
                                    	{$comments[inst_comments].comment|strip_tags|nl2br}
                                    	<small><br />
                                            By: {$comments[inst_comments].name} {$comments[inst_comments].surname},  {$comments[inst_comments].modified_on|date_format} 

                                    	</small>
                                    </div>

                                    <div style="clear:both"></div>
                                    
                                {/if}

                            {/section}

                        </div>
                    </div>
                    <br /><br />
                {/section}
                </td>
            </tr>
        </table>
        {/if}
        {if $notes}
			   	 <div style="page-break-before: always;"></div>
			   	 
						<table width="550px" >
						    <tr>
						        <td><h2>Notes</h2></td>
						    </tr>
						    <tr>
						    	<td class="content_indent">
								{section name=inst loop=$notes}
									{if $notes[inst].parent_id eq 0}
										<table bgcolor="#f3f3f3" width="100%">
											<tr>
												<td width="70%">
												
													<b>{$notes[inst].note_type}:</b>
													{if $notes[inst].created_by eq 64}
														Careerwise - John
													{else}
														{$notes[inst].created} {if $notes[inst].group_id eq 7} (Mentor) {/if}
													{/if}
												</td>
												<td width="30%" align="right">
													{$notes[inst].created_on|date_format}
													
												</td>
											</tr>
										</table>
									<br />
									{$notes[inst].note|strip_tags|nl2br}<br /><br />

									
										{section name=inst2 loop=$notes}
											{if $notes[inst2].parent_id eq $notes[inst].id}
											<table bgcolor="#f3f3f3" width="100%">
												<tr>
													<td width="70%">
												{$notes[inst2].note_type} {if $notes[inst].group_id eq 7} (Mentor) {$notes[inst2].created}{/if}
													</td>
													<td width="30%" align="right">
													<small >{$notes[inst2].created_on|date_format}</small>
												</td>
											</tr>
											</table>
												{$notes[inst].note|strip_tags|nl2br}
												<br /><br />
											{/if}
										{/section}
									
									{/if}
								{/section}
								</td>
							</tr>
						</table>
				{/if}		



{if $annual_user_summary}
	    <div style="page-break-before: always;"></div>
			<table width="550px" >
			    <tr>
			        <td><h2>Payment information</h2></td>
			    </tr>
			    <tr>
				    <td class="content_indent">
					    {foreach from=$annual_user_summary key=year item=details}
					        <div style="background-color:#f3f3f3;margin-bottom:5px;border-bottom:1px solid #CCC;padding:2px"><b>{$year} Overview:&nbsp;&nbsp; R {$details.summary} <small>(paid)</small></b></div>
					
					        <table  width="100%">
					            {section name=inst loop=$details.rows}
					                <tr>
					                    <td>{$details.rows[inst].reference}: </td>
					                    <td>R {$details.rows[inst].total_expenditure}</td>
					                </tr>
					            {/section}
					            <tr>
					                <td colspan=2>
					                    &nbsp;
					                <td>
					            </tr>
					         </table>
					    {/foreach}
					</td>
			</tr>
		</table>
	{/if}

{if $documents}
			   	 <div style="page-break-before: always;"></div>
						<table width="550px" >
						    <tr>
						        <td><h2>Documents</h2></td>
						    </tr>
						    <tr>
						    	<td>

							                    {section name=inst loop=$documents}
							                        <div style="float:left;text-align:center; border:1px solid #EFEFEF; margin:10px; width:100%">
							                        	<table>
							                        		<tr>
							                        			<td>
							                            {mime_type filename=$documents[inst].file rel_path=1} 
							                        </td>
							                        <td><a class='selected' href='{$config.site.domain}/media/documents/{$documents[inst].file}'>
							                        	{$documents[inst].title} - {$documents[inst].created_on|date_format}</a><br />
														{$documents[inst].description}
							                        </td>
							                    </tr>
							                </table>
							                        </div>
							                    {/section}


							        
							   </td>
						</tr>
					</table>
	{/if}





            </td>
        </tr>
   	</table>
	</div>
</body>
</html>
    


        




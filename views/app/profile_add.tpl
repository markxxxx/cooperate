{include file="header.tpl"}

{literal}
<script>
    $(function(){
        $('#field-volunteer').change(function(){
            if($(this).val() == 'Yes') {
                $('#volunteer_comment').show();
            } else {
                $('#volunteer_comment').hide();

            }
        });

        $('#field-medical').change(function(){
            if($(this).val() == 'Yes') {
                $('#medical_comment').show();

            } else {
                $('#medical_comment').hide();

            }
        });

        $('#field-marital_status').change(function(){
            el = $(this);
            if(el.val() == 'Other') {
                $('#marital_status_other').show();
            } else {
                $('#marital_status_other').hide();
            }
        });

        $('#field-home_relationship').change(function(){

            el = $(this);
            if(el.val() == 'Other') {
                $('#home_relationship_other').show();
            } else {
                $('#home_relationship_other').hide();
            }

        });

    });

</script>
{/literal}



<div id="content">
    <div id="content-top">
        <h2>Profile Manager</h2>
        <a href="#" id="topLink"></a> 
        <span class="clearFix">&nbsp;</span>
    </div>
    <div id="left-col">
        {include file="profile_menu.tpl"}
    </div> 

    <div id="mid-col" class="full-col">
        <div class="box">

            <div class="box" id="to-do">
                <ul class="tab-menu">
                    <li><a href="#personal">Personal</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#social">Social</a></li>
                    <li><a href="#banking">Banking</a></li>
                    <li><a href="#intrests">More About Yourself</a></li>
                </ul>

                <div class="box-container" id="personal">
                    <h3 class="green">Personal Details</h3>

                    {if $invalid|default:no eq 'personal'}
                        <div class="error">Could not save your personal infomation. Please make sure all fields are filled out correctly</div>
                    {/if}
                    <form action="/profile/add/{$data.id|default:0}/0/#personal" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
                        <fieldset>
                            <legend>{if $profile.id|default:0 eq 0}Create a new{else}Update current{/if} Profile</legend>
                            <ol>
                                <li class='even'>
                                    <label class="field-title" for="field_initial">Name:</label>
                                    <label><input name="user[name]" type="text" class="element text large" id="field_name" value="{$user->name}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                </li>
                                <li >
                                    <label class="field-title" for="field_initial">Surname:</label>
                                    <label><input name="user[surname]" type="text" class="element text large" id="field_surname" value="{$user->surname}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                </li>

                                <li >
                                    <label class="field-title" for="field_salutation">Preferred Name:</label>
                                    <label><input name="data[salutation]" type="text" class="element text large" id="field_salutation" value="{$data.salutation}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=salutation}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_title">Title:</label>
                                    <label>{cfield field=title value=$data.title}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=title}
                                </li>
                                <li >
                                    <label class="field-title" for="field_id_num">Cellphone number:</label>
                                    <label><input name="data[cell_number]" type="text" class="element text large" id="field_id_num" value="{$data.cell_number}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=cell_number eqaul=10}
                                </li>

                                <li >
                                    <label class="field-title" for="field_id_num">Id number:</label>
                                    <label><input name="data[id_num]" type="text" class="element text large" id="field_id_num" value="{$data.id_num}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=id_num}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_id_type">Id type:</label>
                                    <label>{cfield field=id_type value=$data.id_type}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=id_type}
                                </li>
                                <li >
                                    <label class="field-title" for="field_date_of_birth">Date of birth:</label>
                                    <label>{html_select_date start_year=1950 field_array=dob time=$data.date_of_birth}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=date_of_birth}
                                </li>

                                {if $user->is_south_african()}
                                    <li class='even'>
                                        <label class="field-title" for="field_race">Race:</label>
                                        <label>{cfield field=race value=$data.race}</label>
                                        <span class="clearFix">&nbsp;</span>
                                        {error field=race}
                                    </li>
                                {/if}

                                {if $user->is_israelie()}
                                    <li class='even'>
                                        <label class="field-title" for="field_race">Ethnic Group:</label>
                                        <label>{cfield field=ethnic_group value=$data.ethnic_group}</label>
                                        <span class="clearFix">&nbsp;</span>
                                        {error field=ethnic_group}
                                    </li>
                                {/if}

                                <li >
                                    <label class="field-title" for="field_nationality">Religion:</label>
                                    <label><input type="input" name="data[religion]"  value="{$data.religion}"></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=religion}
                                </li>


                                <li >
                                    <label class="field-title" for="field_nationality">Nationality:</label>
                                    <label>{cfield field=nationality value=$data.nationality}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=nationality}
                                </li>



                                <li class='even'>
                                    <label class="field-title" for="field_marital_status">Marital status:</label>
                                    <label>{cfield field=marital_status value=$data.marital_status}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=marital_status}
                                </li>

                                <li class='even' id="marital_status_other" {if $data.marital_status neq 'Other'} style="display:none;" {/if} >
                                    <label class="field-title" for="field_marital_status">Marital status other:</label>
                                    <label><input type="input" name="data[marital_status_other]"  value="{$data.marital_status_other}"></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=marital_status_other}
                                </li>

                                <li >
                                    <label class="field-title" for="field_gender">Gender:</label>
                                    <label>{cfield field=gender value=$data.gender}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=gender}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_first_language">First language:</label>
                                    <label>{cfield field=first_language value=$data.first_language} </label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=first_language}
                                </li>


                                <li class='even'>
                                    <label class="field-title" for="field_drivers">How many children do you have:</label>
                                    <label>{cfield field=have_children value=$data.have_children}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=have_children}
                                </li>
                                <li >
                                    <label class="field-title" for="field_passport">Do you have a passport:</label>
                                    <label>{cfield field=passport value=$data.passport}</label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=passport}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_image">Upload profile photo:</label>
                                    <label><input type='file' name="uploadedfile" value='Browse'></label>
                                    {if $data.image|@strlen}
                                        {image src="media/profiles/`$data.image`" width="60"}
                                    {/if}
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=image}
                                </li>

                                <li class='even'>
                                    <label class="field-title" for="field_image">Upload Passport/ID :</label>
                                    <label><input type='file' name="uploadedfile2" value='Browse'></label>
                                    {if $data.passport_image|@strlen}
                                        {image src="media/passport/`$data.passport_image`" width="60"}
                                    {/if}
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=passport_image}
                                </li>

                            </ol>
                        </fieldset>
                        <br /><br />
                        <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
                    </form>
                </div>

                <div class="box-container" id="contact">
                {if $invalid|default:no eq 'contact'}
                    <div class="error">Could not save your contact infomation. Please make sure all fields are filled out correctly</div>
                {/if}
                    <form action="/profile/add/{$data.id|default:0}/1#contact" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
                        <table>
                            <tr>
                                <td valign="top">
                                    <span class="clearFix">&nbsp;</span>
                                    <h3 class="green">Home</h3>
                                    <fieldset>
                                        <ol>
                                            <li class='even'>
                                                <label class="field-title" for="field_home_address">Address:</label>
                                                <label><textarea rows="7" cols="20" name="data[home_address]" rows="5">{$data.home_address}</textarea></label>
                                                <span class="clearFix">&nbsp;</span>
						                          {error field=home_address}
                                            </li>
                                            <li >
                                                <label class="field-title" for="field_home_relationship">Emergency contact:</label>
                                                <label>{cfield field=home_relationship value=$data.home_relationship}</label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=home_relationship}
                                            </li>

                                            <li id="home_relationship_other" {if $data.home_relationship neq 'Other'} style="display:none" {/if} >
                                                <label class="field-title" for="field_home_relationship">Emergency contact other:</label>
                                                <label><input name="data[home_relationship_other]" type="text" class="element text large" id="field_home_cell" value="{$data.home_relationship_other}" /></label>
                                                <span class="clearFix">&nbsp;</span>
                                            </li>

                                            <li class='even'>
                                                <label class="field-title" for="field_home_cell">Emergency contact name:</label>
                                                <label><input name="data[home_cell]" type="text" class="element text large" id="field_home_cell" value="{$data.home_cell}" /></label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=home_cell }
                                            </li>




                                            <li >
                                                <label class="field-title" for="field_home_email">Emergency contact number:</label>
                                                <label><input name="data[home_email]" type="text" class="element text large" id="field_home_email" value="{$data.home_email}" /></label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=home_email}
                                            </li>

                                        </ol>
                                    </fieldset>
                                </td>
                                <td valign="top">
                                    <span class="clearFix">&nbsp;</span>
                                    <h3 class="green">University</h3>
                                    <fieldset>
                                        <ol>
                                            <li >
                                                <label class="field-title" for="field_uni_address">Address:</label>
                                                <label><textarea  rows="7" cols="20" name="data[uni_address]" rows="5">{$data.uni_address}</textarea></label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=uni_address}
                                            </li>
                                            <li class='even'>
                                                <label class="field-title" for="field_uni_cell">Cellphone Number:</label>
                                                <label><input name="data[uni_cell]" type="text" class="element text large" id="field_uni_cell" value="{$data.uni_cell}" /></label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=uni_cell eqaul=10}
                                            </li>
                                            <li >
                                                <label class="field-title" for="field_uni_email">Email:</label>
                                                <label><input name="data[uni_email]" type="text" class="element text large" id="field_uni_email" value="{$data.uni_email}" /></label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=uni_email}
                                            </li>

                                            <li class='even'>
                                                <label class="field-title" for="field_address_to_use">Address to use:</label>
                                                <label>{cfield field=address_to_use value=$data.address_to_use}</label>
                                                <span class="clearFix">&nbsp;</span>
						{error field=address_to_use}
                                            </li>
                                        </ol>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                        <br /><br />
                        <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
                    </form>
                </div>



                <div class="box-container" id="social">
                    <h3 class="green">Social bookmarks</h3>
                    {if $invalid|default:no eq 'banking'}
                    <div class="error">Could not save your social bookmark infomation. Please make sure all fields are filled out correctly</div>
                    {/if}
                    <form action="/profile/add/{$data.id|default:0}/4#social" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
                        <fieldset>
                            <ol>
                                <li >
                                    <label class="field-title" for="field_bank">Facebook:</label>
                                    <label><input name="data[facebook_url]" type="text" class="element text large" id="field_bank" value="{$data.facebook_url}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=facebook_url}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_bank">Twitter:</label>
                                    <label><input name="data[twitter_url]" type="text" class="element text large" id="field_bank" value="{$data.twitter_url}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=twitter_url}
                                </li>
                                <li >
                                    <label class="field-title" for="field_bank">LinkedIn:</label>
                                    <label><input name="data[linkedin_url]" type="text" class="element text large" id="field_bank" value="{$data.linkedin_url}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=linkedin_url}
                                </li>
                                
                            </ol>
                        </fieldset>
                        <br /><br />
                        <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
                    </form>
                </div>





                <div class="box-container" id="banking">
                    <h3 class="green">Banking Details</h3>
                    {if $invalid|default:no eq 'banking'}
                    <div class="error">Could not save your banking infomation. Please make sure all fields are filled out correctly</div>
                    {/if}
                    <form action="/profile/add/{$data.id|default:0}/2#banking" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
                        <fieldset>
                            <ol>
                                <li >
                                    <label class="field-title" for="field_bank">Bank:</label>
                                    <label><input name="data[bank]" type="text" class="element text large" id="field_bank" value="{$data.bank}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=bank}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_bank_acc">Account number:</label>
                                    <label><input name="data[bank_acc]" type="text" class="element text large" id="field_bank_acc" value="{$data.bank_acc}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=bank_acc}
                                </li>
                                <li >
                                    <label class="field-title" for="field_bank_branch">Branch code:</label>
                                    <label><input name="data[bank_branch]" type="text" class="element text large" id="field_bank_branch" value="{$data.bank_branch}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=bank_branch}
                                </li>
                                <li >
                                    <label class="field-title" for="field_bank_branch_name">Branch Name:</label>
                                    <label><input name="data[bank_branch_name]" type="text" class="element text large" id="field_bank_branch" value="{$data.bank_branch_name}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=bank_branch_name}
                                </li>
                                
                                <li >
                                    <label class="field-title" for="field_bank_branch_name">Account type:</label>
                                    <label>
                                        <select name="data[account_type]">
                                            <option value="">Select account type:</option>
                                            <option {if $data.account_type eq 2} selected {/if} value="2">Savings</option>
                                            <option {if $data.account_type eq 1} selected {/if} value="1">Cheque</option>
                                        </select>
                                    </label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=account_type}
                                </li>

                            </ol>
                        </fieldset>
                        <br /><br />
                        <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
                    </form>
                </div>

                <div class="box-container" id="intrests">
                    <h3 class="green">More About Yourself</h3>
                    {if $invalid|default:no eq 'misc'}
                    <div class="error">Could not save your `More About Yourself` infomation. Please make sure all fields are filled out correctly</div>
                    {/if}
                    <form action="/profile/add/{$data.id|default:0}/3#intrests" method="post" name="form_profile" enctype="multipart/form-data" class="middle-forms" id="form_profile">
                                                <legend>Please complete these blocks as detailed as possible</legend>
                                                <Br />

                        <fieldset>
                            <ol>

                                <li >
                                    <label class="field-title" for="field_hobbies">Family background:</label>
                                    <label><textarea rows="7" cols="20" name="data[family_background]" rows="5">{$data.family_background}</textarea></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=family_background}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_hobbies">University Awards/Prizes:</label>
                                    <label><textarea rows="7" cols="20" name="data[awards]" rows="5">{$data.awards}</textarea></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=awards}
                                </li>

                                <li >
                                    <label class="field-title" for="field_hobbies">Interests / Hobbies / Extra Curricular Activities:</label>
                                    <label><textarea rows="7" cols="20" name="data[hobbies]" rows="5">{$data.hobbies}</textarea></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=hobbies}
                                </li>


                                <li class='even'>
                                    <label class="field-title" for="field_hobbies" >Do you volunteer:</label>
                                    <label>{cfield field=volunteer value=$data.volunteer} </label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=volunteer}
                                </li>

                                <li {if $data.volunteer neq 'Yes'} style="display:none" {/if} id="volunteer_comment">
                                    <label class="field-title" for="field_hobbies">Please comment on your volunteer work:</label>
                                    <label><textarea rows="7" cols="20" name="data[volunteer_comment]" rows="5">{$data.volunteer_comment}</textarea></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=volunteer_comment}
                                </li>

                                <li >
                                    <label class="field-title" for="field_hobbies">Do you have any medical conditions that we need to know about:</label>
                                    <label>{cfield field=medical value=$data.medical} </label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=medical}
                                </li>

                                <li id="medical_comment" {if $data.medical neq 'Yes'} style="display:none" {/if}>
                                    <label class="field-title" for="field_hobbies">Please comment on your medical condition:</label>
                                    <label><textarea rows="7" cols="20" name="data[medical_comment]" rows="5">{$data.medical_comment}</textarea></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=medical_comment}
                                </li>






                                {**
                                <li >
                                    <label class="field-title" for="field_bank_boot_size">Boot Size:</label>
                                    <label><input name="data[bootsize]" type="text" class="element text large" id="field_bootsize" value="{$data.bootsize}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=bootsize}
                                </li>
                                <li class='even'>
                                    <label class="field-title" for="field_bank_branch_name">Overall Size:</label>
                                    <label><input name="data[overallsize]" type="text" class="element text large" id="field_overallsize" value="{$data.overallsize}" /></label>
                                    <span class="clearFix">&nbsp;</span>
                                    {error field=overallsize}
                                </li>
                                **}
                            </ol>
                        </fieldset>
                        <br /><br />
                        <input type="image" src="/views/app/images/bt-send-form.gif" alt="Save" />
                    </form>	
                </div>
            </div>
        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>    
{include file="footer.tpl"}
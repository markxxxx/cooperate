{include file="header.tpl"}

{head}
<link rel="stylesheet" type="text/css" href="/views/app/js/jquery.tooltip.css" /> 
<script type='text/javascript' src='/views/app/js/jquery.tooltip.min.js'></script> 
{literal}
    <script>
            $(document).ready(function(){
                    $('.selected').tooltip( {delay: 0} );
            });
    </script>
{/literal}
{/head}

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
            <h4 class="white">{$domain_name}</h4>

            <div class="box-container">

            {if $smarty.get.success eq 'personal'}
                <div class="success">Personal Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'banking'}
                <div class="success">Banking Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'misc'}
                <div class="success">`More about yourself` Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'contact'}
                <div class="success">Contact Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'article'}
                <div class="success">Article Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'scholarship'}
                <div class="success">Scholarship Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'internship'}
                <div class="success">Part-time/Vac work Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'letter'}
                <div class="success">Annaul letter to martin saved</div><br />
            {/if}

            {if $smarty.get.success eq 'academic'}
                <div class="success">Academic Information updated Successfully</div><br />
            {/if}

            {if $smarty.get.success eq 'alumni'}
                <div class="success">Alumni Information updated Successfully</div><br />
            {/if}

                <h3 class="green">My Profile</h3>
                <p>Below is a list of sections to be completed. Please complete them by clicking on each heading and filling in the required information. Once completed, a section will have a <img src="{$template_dir}/images/tick.png" alt="completed"> visible next to the heading. 
                    If information is still outstanding within a particular section, a <img src="{$template_dir}/images/not_complete.png" alt="not completed"> will be visible.<br /><br />
                <p>Here is a list of sections that you have to complete below. Please complete the below sections by clicking on each heading.</p>
                <br />


                <h3 class="profile-page">Profile Information</h3>

                <ul class='profile_information'>
                    <li>{if !strlen($profile.title)} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/profile/add/0/0">Personal</a></li>
                    <li>{if !strlen($profile.home_address)} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/profile/add/0/1#contact">Contact</a></li>

                    <li>{if !strlen($profile.facebook_url)} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/profile/add/0/1#social">Social</a></li>

                    <li>{if !strlen($profile.bank)} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/profile/add/0/2#banking">Banking</a></li>
                    <li>{if !strlen($profile.hobbies)} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/profile/add/0/3#intrests">More About Yourself</a></li>
                    <li>{if !$scholarship} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/scholarship/add">Scholarship</a></li>

                    {if $user->is_alumni()}
                        <li>{if !$alumni} <img src="{$template_dir}/images/not_complete.png" alt="not completed">{else}<img src="{$template_dir}/images/tick.png" alt="completed">{/if}&nbsp;<a href="/alumni/add">Alumni</a></li>
                    {/if}
                </ul>
                <br />

                <h3 class="profile-page">Letters to Martin</h3>

                <ul class='profile_information'>
                {if !$completed_letter}
                    <li><img src="{$template_dir}/images/not_complete.png" alt="not completed">
                        &nbsp;&nbsp;Click <a href="/letter/add">here</a> to submit your {$smarty.now|date_format:"%Y"} letter to Martin</li>
                {/if}
                    {section name=inst loop=$letters}
                        <li><a href="/letter/add/{$letters[inst].id}">{$letters[inst].letter_date} letter to martin</a></li>

                    {/section}
                </ul>
                <br />

                <h3 class="profile-page">Part-time/Vac work <a href="/internship/add/"><img src="{$template_dir}/images/add_new.png">Add New</a></h3>
                
                <ul class='profile_information'>
                {section name=inst loop=$internships}
                    <li><a href="/internship/edit/{$internships[inst].id}">{$internships[inst].name} - {$internships[inst].date_started|date_format}</a></li>
                {sectionelse}
                    <li><img src="{$template_dir}/images/not_complete.png" alt="not completed">&nbsp; Click <a href="/internship/add">here</a> to add a New Part-time/Vac work</li>
                {/section}

                </ul><br />
 





                <h3 class="profile-page">Academics <a href="/academic/add/"><img src="{$template_dir}/images/add_new.png">Add New </a></h3>

                <ul class='profile_information'>

                {section name=inst loop=$academics}

                    {if $academics[inst].university_year eq 'Matric'}
                    <li><a href="/academic/edit/{$academics[inst].id}">{$academics[inst].calendar_year}: Matric results</a></li>
                    {else}
                    <li><a href="/academic/edit/{$academics[inst].id}">{$academics[inst].calendar_year}: {$academics[inst].university_year} - {$academics[inst].acadmic_record_type}</a></li>
                    {/if}

                 {sectionelse}
                    <li><img src="{$template_dir}/images/not_complete.png" alt="not completed">&nbsp;You have no academic records.<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Click <a href="/academic/add">here</a> to add a new Academic record</li>
                {/section}
                    <li></li>
                </ul>

                <br />
                <h3 class="profile-page">Documents <a href="/document/add/"><img src="{$template_dir}/images/add_new.png">Add New</a></h3>

                <ul class='profile_information'>
                {if $documents}	
                    {section name=inst loop=$documents}
                    <div style="padding:0px;border:0px;" class="doc_files">
                        <a class='selected' title='{$documents[inst].created_on|date_format} - <b>{$documents[inst].description}<b/>' href='/media/documents/{$documents[inst].file}'>
                            {$documents[inst].title|truncate:25}<br /><br />
                                {mime_type filename=$documents[inst].file}</a>

                            {if $user->can_access('document', 'delete')}
                        <br />
                        <input type="checkbox" name="id[{$documents[inst].id}]" />&nbsp;&nbsp;<a title="Delete Edit Document"  class="table-delete-link" href="/document/delete/{$documents[inst].id}"></a>&nbsp;&nbsp;
                            {/if}
                    </div>
                    {/section}
                {else}
                    <li><img src="{$template_dir}/images/not_complete.png" alt="not completed">&nbsp; Click <a href="/document/add">here</a> to add a new Documents</li>
                {/if}
                </ul>
                <div style="clear:both;"></div>


            </div>
        </div> 
    </div>   
    <span class="clearFix">&nbsp;</span>     
</div>

{include file="footer.tpl"}
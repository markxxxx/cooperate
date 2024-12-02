{head}{literal}
        <script>
            $(document).ready(function(){
                $("ul.list-links").accordion();
            });
        </script>
    {/literal}{/head}
<div class="box">
  <h4 class="yellow">Your profile</h4>
    <div class="box-container">
        <ul class="list-links">
            <li><a href="#">Profile</a>
                <ul>
                    <li><a href="/profile/add/0/0#personal">Personal</a></li>
                    <li><a href="/profile/add/0/1#contact">Contact</a></li>
                    <li><a href="/profile/add/0/4#social">Social</a></li>
                    <li><a href="/profile/add/0/2#banking">Banking</a></li>
                    <li><a href="/profile/add/0/3#intrests">More About Yourself</a></li>
                    {if $user->is_alumni()}
                      <li><a href="/alumni/add" onclick="parent.location.href='/alumni/add'">Alumni</a></li>
                    {/if}
                </ul>
          </li>
          <li ><a href="/scholarship/add" onclick="parent.location.href='/scholarship/add'">Scholarship</a></li>
          <li><a href="#">Part-time/Vac work</a>
                <ul>
                    {section name=inst loop=$internships}
                        <li><a href="/internship/edit/{$internships[inst].id}">{$internships[inst].name} - {$internships[inst].date_started|date_format}</a></li>
                    {/section}
                    <li><a href="/internship/add/"><img src="{$template_dir}/images/add_new.png">Add New </a></li>
                </ul>
          </li>
          
          <li><a href="#">Academics</a>
                <ul>
                    {section name=inst loop=$academics}
                        {if $academics[inst].university_year eq 'Matric'}
                            <li><a href="/academic/edit/{$academics[inst].id}">{$academics[inst].calendar_year}: Matric results</a></li>
                        {else}
                            <li><a href="/academic/edit/{$academics[inst].id}">{$academics[inst].calendar_year}: {$academics[inst].university_year} - {$academics[inst].acadmic_record_type}</a></li>
                        {/if}
                    {/section}
                    <li><a href="/academic/add/"><img src="{$template_dir}/images/add_new.png">Add New </a></li>
                </ul>
          </li>

          <li><a href="#">Documents</a>
                <ul>
                    <li><a href="/document/add/"><img src="{$template_dir}/images/add_new.png">Add New </a></li>
                </ul>
          </li>

        </ul>
    </div>
</div>


<div class="box" id="to-dos-2">
  <ul class="tab-menu">
      <li><a href="#to-dos">To Do</a></li>
      <li><a href="#completed">Completed</a></li>
  </ul>
  <div class="box-container" id="to-dos">
     <div id="to-do-list">
        <ul>
            {section name=inst loop=$incomplete_tasks}
                <li {cycle values="class='odd',class='even'"}>
                    {$incomplete_tasks[inst].task}<br />
                </li>
            {sectionelse}
                <li {cycle values="class='odd',class='even'"}>
                    All tasks completed
                </li>
            {/section}
        </ul>    
         
      </div>
  </div>

  <div class="box-container" id="completed">
    <div id="to-do-list">
        <ul>
            {section name=inst loop=$complete_tasks}
                <li {cycle values="class='odd',class='even'"}>
                    {$complete_tasks[inst].task}<br />
                </li>
            {sectionelse}

            {/section}
        </ul>
    </div>
  </div>  
</div>

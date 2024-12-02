{include file='header.tpl'}

{head}
{literal}
<script>

    $(document).ready(function(){
       $('.tohide').css('display','none');
    });

    function toggle(unhide) {
        classname = '.'+unhide;
        visable = $(classname+':first').css('display');
        if(visable == 'none') {
            $(classname).css('display','table-row');
        } else {
            $(classname).css('display','none');
        }
    }
    
    function change_access(g_id,p_id,el) {
	
        src = el.src.split('/').pop();
        if(src == 'tick.png') {
            enable_option = 0;
            src = '/views/app/images/cross.png';
        } else {
            enable_option = 1;
            src = '/views/app/images/tick.png';
        }
        el.src = '/views/app/images/spinner.gif';

        $.ajax({
            type: "GET",
            url: "/group/update_permission/"+g_id+'/'+p_id+'/'+enable_option,
            success: function(){
                el.src = src;
            }
          });
    }
    
</script>
{/literal}
{/head}
<div id="content">
	<div id="content-top">
    <h2>Group permissions</h2>
      <a href="#" id="topLink"></a> 
      <span class="clearFix">&nbsp;</span>
      </div>
      <div id="left-col">
          <div class="box">
              <h4 class="yellow">Permission Options</h4>
          <div class="box-container">
              <ul class="list-links">
                <li><a href="/group/generate_permissions/">Generate new permissions</a></li>
                <li><a href="/group/">View Groups</a></li>
                <li><a href="/group/add/">New Group</a></li>
                <li><a href="/user/index/">View Users</a></li>			
              </ul>
          </div>
          </div>
      </div>
      
      <div id="mid-col" class="full-col">
        <div class="box">
      	<h4 class="white">Permissions manager</h4>
        <div class="box-container">

        <table class="table-long">

            <thead>
                <tr>
                    <td >Permission</td>
                    {section name=inst loop=$groups}
                        <td class="col-second">
                            {if $user->can_access('group','edit')} 
                                <a href="/group/edit/{$groups[inst].id}">{$groups[inst].name}</a>
                            {else}
                                {$groups[inst].name}
                            {/if}
                        </td>
                    {/section}
                </tr>
            </thead>
        <tbody>
            {foreach name=parent from=$permissions key=p_k item=p_v}
                {if $prev eq $p_v.class}
                    {assign var=hidden value=true}
                {else}
                    {assign var=hidden value=false}
                {/if}
                {if !$hidden}
                    <tr >
                        <td class="col-second" style="padding:10px;" colspan="{math equation="x + 1" x=$groups|@count}" ><a href="javascript: toggle('s_{$p_v.class}')">{$p_v.class|pluralize}</a></td>
                    </tr>
                {/if}
                <tr class="s_{$p_v.class} tohide {cycle values="odd,"}" >
                    <td class="lft">{$p_v.method}</td>
                        {foreach from=$groups key=g_k item=g_v}
                            <td class="col-second">
                                {if $group_permission[$g_v.id][$p_v.id].can_access && $g_v.id eq 1}
                                    <img src="/views/app/images/tick_disabled.png" />
                                {elseif $group_permission[$g_v.id][$p_v.id].can_access}
                                    <a><img onclick="change_access('{$g_v.id}','{$p_v.id}', this)" border="none" src="/views/app/images/tick.png" /></a>
                                {else}
                                    <a><img  onclick="change_access('{$g_v.id}','{$p_v.id}', this)" src="/views/app/images/cross.png" /></a>
                                {/if}
                            </td>
                        {/foreach}
                </tr>
                {assign var=prev value=$p_v.class}
            {/foreach}
        </tbody>
        </table>

        </div>
    </div> 
</div>   
<span class="clearFix">&nbsp;</span>     
</div>
{include file='footer.tpl'}
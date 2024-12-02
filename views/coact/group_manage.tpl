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
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!--<i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - -->Permissions Manager</h4>
            </div>
            <div class="heading-elements">
                <div class="heading-btn-group">
                    {if $user->can_access('quote', 'index')}
                        <a href="/quote" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Quotes</span></a>
                    {/if}
                    {if $user->can_access('invoice', 'index')}
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    {/if}
                    {if $user->can_access('appointment', 'index')}
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar text-primary"></i> <span>Appointments</span></a>
                    {/if}
                </div>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Permissions Manager</li>
            </ul>
            <ul class="breadcrumb-elements">
                <!-- <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-gear position-left"></i>
                                    Settings
                                    <span class="caret"></span>
                                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
                        <li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
                        <li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
                    </ul> -->
                </li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                <ul class="icons-list">
                    <a href="/group/generate_permissions/" class="btn bg-teal-400 legitRipple btn-default btn-sm" >
                                        <i class="icon-statistics position-left"></i> Generate permisions</a>
                </ul>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <!-- <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li> -->
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <table class="table datatable-basic table-hover">
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
        </div>

    </div>
    <!-- /end content -->
    {include file="footer.tpl"}
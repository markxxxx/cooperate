{include file="header.tpl"}
{head}
    {*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>

{/head}

{include file="filter_options.tpl"}

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Quote Manager</h4>
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
                    <li><a href="/project">Quote Manager</a></li>
                    <li class="active">{if $data.id|default:0 eq 0}Add{else}Edit{/if}</li>
                </ul>
                <ul class="breadcrumb-elements">
                    <!--   <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
                </ul>
                </li> -->
                </ul>
            </div>
        </div>
        <!-- /Page header -->

        <!-- Content area -->
        <div class="content">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Quote</h5>
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
                        <form action="/quote/add/{$data.id|default:0}" method="post" name="form_quote" enctype="multipart/form-data" class="middle-forms" id="form_quote">
                            <div class="col-lg-12">
                                <fieldset>
                                    <ol style="list-style: none;">
                                        <li>
                                            <!-- <span class="label bg-teal help-inline">User Domain Selection</span>                                                -->
                                            <select name="data[project_id]" id="field_project_id" class="form-control" >
                                                <option value=''>Select Project:</option>
                                                {section name=inst loop=$projects}
                                                    <option value="{$projects[inst].project_id}" {if $data.project_id eq $projects[inst].project_id}selected{/if}>{$projects[inst].project_name}, {$projects[inst].customer_name} {$projects[inst].customer_surname} </option>
                                                {/section}
                                            </select>
                                            <span class="clearFix">&nbsp;</span> {error field=project_id}
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Quote Document</span>
                                            <input class="file-input" data-browse-class="btn btn-primary btn-block" data-show-remove="false" data-show-caption="false" data-show-upload="false" type="file" name="quote" required>
                                            {error field=file}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Plan Documents</span>
                                            <input class="file-input" data-browse-class="btn btn-primary btn-block" data-show-remove="false" data-show-caption="false" data-show-upload="false" type="file" name="project_plan" multiple="multiple" required>
                                            {error field=file}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        {*<li>*}
                                            {*{if $plans}*}
                                                {*<table class="table datatable-basic-6 dataTable">*}
                                                    {*<thead>*}
                                                    {*<tr>*}
                                                        {*<th>Document</th>*}
                                                        {*<th></th>*}
                                                    {*</tr>*}
                                                    {*</thead>*}
                                                    {*<tbody>*}
                                                        {*{section name=inst loop=$plans}*}
                                                            {*<tr>*}
                                                                {*<td>{$plans[inst].document}</td>*}
                                                                {*<td class="text-center">*}
                                                                    {*{if $user->can_access('plan', 'delete')}*}
                                                                        {*<a href="/quote/delete_plan/{$plans[inst].plan_id}" onclick="return confirm('Are you sure you want to Remove?');"><i class="icon-database-remove"></i> Delete</a>*}
                                                                    {*{/if}*}
                                                                {*</td>*}
                                                            {*</tr>*}
                                                        {*{/section}*}
                                                    {*</tbody>*}
                                                {*</table>*}
                                            {*{else}*}
                                                {*No plans found!*}
                                            {*{/if}*}
                                        {*</li>*}
                                    </ol>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-link" href="/quote"><i class="icon-cross"></i> Close</a>
                                <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content area -->

{include file="footer.tpl"}

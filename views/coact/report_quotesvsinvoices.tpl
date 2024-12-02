{include file="header.tpl"}
{head}
        {*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/daterangepicker.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="{$template_dir}/assets/js/pages/datatables_basic.js"></script>
{literal}

{/literal}

{/head}

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Report: Quotes Vs Invoices</h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
<!--                                 <a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a> -->

                    </div>
                </div>
            </div>

            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li><a href="/report">Report Manager</a></li>
                    <!-- <li class="active">{if $data.id|default:0 eq 0}Add{else}Edit{/if}</li> -->
                </ul>

                <ul class="breadcrumb-elements">
                   <!--  <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                    <ul class="icons-list">
<!--                                     <a href="#" class="btn bg-teal-400 legitRipple btn-default btn-sm" data-toggle="modal" data-target="#modal_iconified">
                                <i class="icon-statistics position-left"></i> Add New Layout</a>   -->
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
                    <form action="/report/quotesvsinvoices" method="POST" accept-charset="utf-8" id="form_date_filter">
                        <span class="label bg-teal help-inline">Date From</span>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                            <input name="data[filter_date_from]" class="form-control daterange-single-submit" value="{$data.filter_date_from}" type="text" id="field_date_filter" value="{$data.filter_date_from}" placeholder="Filter Date" required style="width: 170px;">
                        </div>
                        <span class="label bg-teal help-inline">Date to</span>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                            <input name="data[filter_date_to]" class="form-control daterange-single-submit" value="{$data.filter_date_to}" type="text" id="field_date_filter" value="{$data.filter_date_to}" placeholder="Filter Date" required style="width: 170px;">
                            <button class="btn btn-primary submit"><i class="icon-check"></i> Submit</button>
                        </div>
                    </form>
                    <br/>

                    <div class="row">
                        <div class="col-lg-12">

                            {*{if $quotes}*}
                            {if $counts}
                                <table class="table datatable-basic dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>No. of Quotes</th>
                                            <th>No. of Invoices</th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {*{section name=inst loop=$quotes}   *}
                                    {section name=inst loop=$counts}
                                        <tr>
                                            <td>{$counts[inst].Rep}</td>
                                            <td>{$counts[inst].qcount}</td>
                                            <td>{$counts[inst].icount}</td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                        </tr>
                                    {/section}
                                    </tbody>
                                </table>

                    </form>
                            {else}
                                No Data Found!
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /end content -->

{include file="footer.tpl"}
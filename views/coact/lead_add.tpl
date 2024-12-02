<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{if $site_title|default:false}{$site_title}{else}{$controller|ucfirst} {if $method eq 'index'}Manager{else}{$method|ucfirst}{/if}{/if} - CoAct</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{$template_dir}/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="{$template_dir}/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="{$template_dir}/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="{$template_dir}/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="{$template_dir}/assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
     <!-- Theme JS files -->
    <script type="text/javascript" src="{$template_dir}/assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/core/app.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/moment/moment.min.js"></script>

    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/daterangepicker.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/headroom/headroom.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/headroom/headroom_jquery.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/ui/nicescroll.min.js"></script>
    <!-- <script type="text/javascript" src="{$template_dir}/assets/js/pages/dashboard.js"></script> -->
    <!-- <script type="text/javascript" src="{$template_dir}/assets/js/pages/layout_fixed_custom.js"></script> -->
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/layout_navbar_hideable_sidebar.js"></script>
    <!-- Core JS files -->
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/components_modals.js"></script>
    <!-- /theme JS files -->    
</head>
<body class="navbar-top">

   <!-- Main navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top bg-blue-600">
        <div class="navbar-header">
            <a class="navbar-brand" href="/"><!-- <img src="{$template_dir}/assets/images/logo_light.png" alt=""> -->COACT</a>


        </div>
    </div>
    <!-- /main navbar -->

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">



                <!-- Content area -->
                <div class="content">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Customer Lead</h5>
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
                                    <form action="/lead/add/{$data.id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                                <input type="hidden" name="is_admin" value="{$is_admin}" id ="is_admin"/>
                                <fieldset>
                                     <ol style="list-style: none;">                                        
                                        <li>
                                            <span class="label bg-teal help-inline">Name</span>
                                            <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/>
                                            {error field=name}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>

                                        <li>
                                            <span class="label bg-teal help-inline">Surname</span>
                                            <input name="data[surname]" type="text" class="form-control" id="field_surname" value="{$data.surname}" placeholder="Surname" required/>
                                            {error field=surname}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">Company</span>
                                            <input name="data[company]" type="text" class="form-control" id="field_company" value="{$data.company}" placeholder="Company" required />
                                            {error field=company}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">Contact Number</span>
                                            <input name="data[contact_number]" type="text" class="form-control" id="field_contact_number" value="{$data.contact_number}" placeholder="Contact Number" required />
                                            {error field=contact_number}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">Email</span>
                                            <input name="data[email]" type="text" class="form-control" id="field_email" value="{$data.email}" placeholder="Email" required />
                                            {error field=email}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">Address</span>
                                            <input name="data[address]" type="text" class="form-control" id="field_address" value="{$data.address}" placeholder="Address" required />
                                            {error field=address}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">User Selection</span>                                               
                                            <select name="data[user_id]" id="field_user_id" class="form-control">
                                                <option value=''>Select your Name:</option>
                                                {section name=inst loop=$users}
                                                    <option value="{$users[inst].id}" {if $data.user_id eq $users[inst].id}selected{/if}>{$users[inst].surname}, {$users[inst].name} </option>
                                                {/section}
                                            </select>                                           
                                            <span class="clearFix">&nbsp;</span>
                                            {error field=user_id}
                                        </li>
                                    </ol>
                                </fieldset>
                            </div>
                            

                            <div class="modal-footer">
                              <!-- <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross"></i> Close</button> -->
                              <button class="btn btn-primary submit"><i class="icon-check"></i> Save</button>
                            </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /end content -->

{include file="footer.tpl"}


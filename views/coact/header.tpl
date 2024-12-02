<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{if $site_title|default:false}{$site_title}{else}{$controller|ucfirst} {if $method eq 'index'}Manager{else}{$method|ucfirst}{/if}{/if} - Cooperate</title>
    <!-- Global stylesheets -->
    <link rel="icon" href="{$template_dir}/assets/images/favicon.png" >
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
    <script type="text/javascript" src="{$template_dir}/assets/js/core/libraries/jquery_ui/full.min.js"></script>
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
    <script type="text/javascript" src="{$template_dir}/assets/js/jquery.cookie.js"></script>
    <!-- /theme JS files -->    
</head>
<body class="navbar-top">

   <!-- Main navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top magnadarkgrey">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html"><!-- <img src="{$template_dir}/assets/images/logo_light.png" alt=""> -->Cooperate</a>

            <ul class="nav navbar-nav visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
               <!--  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-puzzle3"></i>
                        <span class="visible-xs-inline-block position-right">Git updates</span>
                        <span class="status-mark border-orange-400"></span>
                    </a>
                    
                    <div class="dropdown-menu dropdown-content">
                        <div class="dropdown-content-heading">
                            Git updates
                            <ul class="icons-list">
                                <li><a href="#"><i class="icon-sync"></i></a></li>
                            </ul>
                        </div>

                        <ul class="media-list dropdown-content-body width-350">
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
                                </div>

                                <div class="media-body">
                                    Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                    <div class="media-annotation">4 minutes ago</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn border-warning text-warning btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-commit"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    Add full font overrides for popovers and tooltips
                                    <div class="media-annotation">36 minutes ago</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn border-info text-info btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-branch"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    <a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch
                                    <div class="media-annotation">2 hours ago</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn border-success text-success btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-merge"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    <a href="#">Eugene Kopyov</a> merged <span class="text-semibold">Master</span> and <span class="text-semibold">Dev</span> branches
                                    <div class="media-annotation">Dec 18, 18:36</div>
                                </div>
                            </li>

                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
                                </div>
                                
                                <div class="media-body">
                                    Have Carousel ignore keyboard events
                                    <div class="media-annotation">Dec 12, 05:46</div>
                                </div>
                            </li>
                        </ul>

                        <div class="dropdown-content-footer">
                            <a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
                        </div>
                    </div>
                </li> -->
            </ul>

            <div class="navbar-right">

<!--                 {if isset($smarty.session.admin)}
                   You are currently logged in as {$user->name} {$user->surname}, Return as: <a style="color:#508DB8;" href='/user/login_as/0/{$user->id}'>{$smarty.session.admin.full_name}</a>
                {else}                    
                    <p class="navbar-text">Hi, {$user->name} {$user->surname}!</p>
                    <p class="navbar-text"><span class="label bg-success-400">Online</span></p>
                {/if} -->
                
<!--                 <ul class="nav navbar-nav">             
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-bell2"></i>
                            <span class="visible-xs-inline-block position-right">Activity</span>
                            <span class="status-mark border-orange-400"></span>
                        </a>

                        <div class="dropdown-menu dropdown-content">
                            <div class="dropdown-content-heading">
                                Activity
                                <ul class="icons-list">
                                    <li><a href="#"><i class="icon-menu7"></i></a></li>
                                </ul>
                            </div>

                            <ul class="media-list dropdown-content-body width-350">
                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-success-400 btn-rounded btn-icon btn-xs"><i class="icon-mention"></i></a>
                                    </div>

                                    <div class="media-body">
                                        <a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks"
                                        <div class="media-annotation">4 minutes ago</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-pink-400 btn-rounded btn-icon btn-xs"><i class="icon-paperplane"></i></a>
                                    </div>
                                    
                                    <div class="media-body">
                                        Special offers have been sent to subscribed users by <a href="#">Donna Gordon</a>
                                        <div class="media-annotation">36 minutes ago</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-blue btn-rounded btn-icon btn-xs"><i class="icon-plus3"></i></a>
                                    </div>
                                    
                                    <div class="media-body">
                                        <a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch in <span class="text-semibold">Limitless</span> repository
                                        <div class="media-annotation">2 hours ago</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-purple-300 btn-rounded btn-icon btn-xs"><i class="icon-truck"></i></a>
                                    </div>
                                    
                                    <div class="media-body">
                                        Shipping cost to the Netherlands has been reduced, database updated
                                        <div class="media-annotation">Feb 8, 11:30</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-warning-400 btn-rounded btn-icon btn-xs"><i class="icon-bubble8"></i></a>
                                    </div>
                                    
                                    <div class="media-body">
                                        New review received on <a href="#">Server side integration</a> services
                                        <div class="media-annotation">Feb 2, 10:20</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-teal-400 btn-rounded btn-icon btn-xs"><i class="icon-spinner11"></i></a>
                                    </div>
                                    
                                    <div class="media-body">
                                        <strong>January, 2016</strong> - 1320 new users, 3284 orders, $49,390 revenue
                                        <div class="media-annotation">Feb 1, 05:46</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-bubble8"></i>
                            <span class="visible-xs-inline-block position-right">Messages</span>
                            <span class="status-mark border-orange-400"></span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-content width-350">
                            <div class="dropdown-content-heading">
                                Messages
                                <ul class="icons-list">
                                    <li><a href="#"><i class="icon-compose"></i></a></li>
                                </ul>
                            </div>

                            <ul class="media-list dropdown-content-body">
                                <li class="media">
                                    <div class="media-left">
                                        <img src="{$template_dir}/assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                        <span class="badge bg-danger-400 media-badge">5</span>
                                    </div>

                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">James Alexander</span>
                                            <span class="media-annotation pull-right">04:58</span>
                                        </a>

                                        <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <img src="{$template_dir}/assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                        <span class="badge bg-danger-400 media-badge">4</span>
                                    </div>

                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Margo Baker</span>
                                            <span class="media-annotation pull-right">12:16</span>
                                        </a>

                                        <span class="text-muted">That was something he was unable to do because...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="{$template_dir}/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Jeremy Victorino</span>
                                            <span class="media-annotation pull-right">22:48</span>
                                        </a>

                                        <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="{$template_dir}/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Beatrix Diaz</span>
                                            <span class="media-annotation pull-right">Tue</span>
                                        </a>

                                        <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="{$template_dir}/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Richard Vango</span>
                                            <span class="media-annotation pull-right">Mon</span>
                                        </a>
                                        
                                        <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                                    </div>
                                </li>
                            </ul>

                            <div class="dropdown-content-footer">
                                <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
                            </div>
                        </div>
                    </li>                   
                </ul> -->
            </div>
        </div>
    </div>
    <!-- /main navbar -->

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-main sidebar-fixed">
                <div class="sidebar-content">

                    <!-- User menu -->
                    <div class="sidebar-user-material" >
                        <div class="category-content">
                            <div class="sidebar-user-material-content" style="height: 44px;">
                                <!-- <a href="#"><img src="assets/images/placeholder.jpg" class="img-circle img-responsive" alt=""></a> -->
                                <h6></h6>
                                <!-- <span class="text-size-small">JHB, South Africa</span> -->
                            </div>
                                                        
                            <div class="sidebar-user-material-menu">
                                <a href="#user-nav" data-toggle="collapse"><span>{$user->name} {$user->surname}</span> <i class="caret"></i></a>
                            </div>
                        </div>
                        
                        <div class="navigation-wrapper collapse" id="user-nav">
                            <ul class="navigation">
<!--                                 <li><a href="#"><i class="icon-user-plus"></i> <span>My profile</span></a></li>
                                <li><a href="#"><i class="icon-coins"></i> <span>My balance</span></a></li>
                                <li><a href="#"><i class="icon-comment-discussion"></i> <span><span class="badge bg-teal-400 pull-right">58</span> Messages</span></a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="icon-cog5"></i> <span>Account settings</span></a></li> -->
                                <li><a href="/auth/logout"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /user menu -->

                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">

                                <!-- Main -->
                                <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>

                                {if $user->can_access('dashboard', 'home')}
                                <li><a href="/"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                {/if}

                                {if $user->can_access('appointment', 'team_week_view')}
                                <li><a href="/appointment/team_week_view"><i class="icon-collaboration"></i> <span>Class Schedule</span></a></li>
                                {/if}

                                {if $user->can_access('appointment', 'index') || $user->can_access('appointment', 'events')}
                                <li>
                                    <a href="#"><i class="icon-calendar"></i> <span>Time Table</span></a>
                                    <ul>
                                        {if $user->can_access('appointment', 'index')}
                                        <li><a href="/appointment">Manage Appointments</a></li>
                                        {/if}
                                        {if $user->can_access('appointment', 'events')}
                                        <li><a href="/appointment/events">Manage Events</a></li>
                                        {/if}
                                        {*<li><a href="/appointment/team_week_view">Class Schedule</a></li>*}
                                        <!-- <li><a href="">Add Event cards</a></li> -->
                                    </ul>
                                </li>
                                {/if}

                                {* {if $user->can_access('user', 'home') && !$user->is_mentor()} *}
                                {if $user->can_access('user', 'home')}
                                <li>
                                    <a href="#"><i class="icon-mailbox"></i> <span>Messages</span></a> {*icon-stack*}
                                    <ul>
                                        {if $user->can_access('message', 'inbox')}
                                        <li><a href="/message/inbox">Inbox</a></li>
                                        {/if}
                                        {if $user->can_access('message', 'outbox')}
                                        <li><a href="/message/outbox">Outbox</a></li>
                                        {/if}
                                    </ul>
                                </li>
                                {/if}

                                {if $user->can_access('project', 'index') || $user->can_access('quote', 'index') || $user->can_access('invoice', 'index')}
                                <li>
                                    <a href="#"><i class="icon-stack2"></i> <span>Subjects</span></a>
                                    <ul>
                                        
                                        {if $user->can_access('task', 'index')}
                                            <li><a href="/task">Manage Lessons</a></li>
                                        {/if}
                                        {if $user->can_access('project', 'index')}
                                            <li><a href="/project">Manage Subjects</a></li>
                                        {/if}
                                        <!-- <li><a href="/project/add">Add Subject</a></li> -->
                                        {*<li><a href="/task">View Classes</a></li>*}
                                        <!-- <li><a href="/task/add">Add Task</a></li> -->
                                        {*<li><a href="/snag">View Issues</a></li>*}
                                        <!-- <li><a href="/snag/add">Add Snag</a></li> -->
                                        {if $user->can_access('quote', 'index')}
                                        {* <li><a href="/quote">Manage Quotes</a></li> *}
                                        {/if}
                                        <!-- <li><a href="/quote/add">Add Quote</a></li> -->
                                        {if $user->can_access('invoice', 'index')}
                                        {* <li><a href="/invoice">Manage Invoices</a></li> *}
                                        {/if}
                                        <!-- <li><a href="/quote/add">Add Quote</a></li> -->
                                    </ul>
                                </li>
                                {/if}

                                {if $user->can_access('task', 'index')}
                                 <!--<li><a href="/task"><i class="icon-clipboard3"></i> <span>Lessons</span></a></li> {*icon-checkbox-checked *} -->
                                {/if}
                                {if $user->can_access('snag', 'index')}
                                {* <li><a href="/snag"><i class="icon-wrench"></i> <span>Issues</span></a></li> *}
                                {/if}

                                {if $user->can_access('report', 'index')}
                                <li>
                                    <a href="#"><i class="icon-pie-chart"></i> <span>Reports</span></a> {*icon-stack*}
                                    <ul>
                                        {if $user->can_access('report', 'newclients')}
                                        <li><a href="/report/newclients">New Clients</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'oldclients')}
                                        <li><a href="/report/oldclients">Old Clients</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'snagsperproject')}
                                        <li><a href="/report/snagsperproject">Issues per Subject</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'quotesvsinvoices')}
                                        <li><a href="/report/quotesvsinvoices">Quotes Vs Invoices / Sales</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'jobsvsfreebies')}
                                        <li><a href="/report/jobsvsfreebies">Jobs Vs Freebies</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'projectcompleted')}
                                        <li><a href="/report/projectscompleted">Subjects Completed</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'leadtime')}
                                        <li><a href="/report/leadtime">Lead Time</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'snagsperteam')}
                                        <li><a href="/report/snagsperteam">Issues per Team</a></li>
                                        {/if}
                                        {if $user->can_access('report', 'jobsperteam')}
                                        <li><a href="/report/jobsperteam">Jobs per Team</a></li>
                                        {/if}
                                    </ul>
                                </li>
                                {/if}

                                {if $user->can_access('setup', 'index')}
                                <li>
                                    <a href="#"><i class="icon-cog"></i> <span>Setup</span></a>
                                    <ul>
                                        {* {if $user->can_access('setup', 'accessory')}
                                        <li><a href="/setup/accessory">Accessories</a></li>
                                        {/if} *}
                                        {if $user->can_access('setup', 'jobtype')}
                                        {* <li><a href="/setup/jobtype">Job Types</a></li> *}
                                        {/if}
                                        {if $user->can_access('setup', 'colour')}
                                        {* <li><a href="/setup/colour">Colours</a></li> *}
                                        {/if}
                                        {if $user->can_access('customer', 'index')}
                                        <li>
                                            <a href="/customer"><i class="icon-man-woman"></i> <span>Guardians</span></a> {*icon-people*}
                                            <!-- <ul>
                                                <li><a href="/customer" id="layout1">View Customers</a></li>
                                                <li><a href="/customer/add" id="layout2">Add Customer <span class="label bg-warning-400">Current</span></a></li>
                                            </ul> -->
                                        </li>
                                        {/if}

                                        {if $user->can_access('user', 'index') || $user->can_access('group', 'index') || $user->can_access('group', 'manage')}
                                        <li>
                                            <a href="#"><i class="icon-users"></i> <span>Users</span></a>
                                            <ul>
                                                {if $user->can_access('user', 'index')}
                                                <li><a href="/user">Manage Users</a></li>
                                                {/if}
                                                <!-- <li><a href="/user/add/0">Add User</a></li> -->
                                                {if $user->can_access('group', 'index')}
                                                <li><a href="/group">Manage Groups</a></li>
                                                {/if}
                                                {if $user->can_access('group', 'manage')}
                                                <li><a href="/group/manage">Manage Permissions</a></li>
                                                {/if}
                                                <!-- <li><a href="/group">User permissions</a></li> -->
                                            </ul>
                                        </li>
                                        {/if}
                                    </ul>
                                </li>
                                {/if}

                                

                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>
            <!-- /main sidebar -->

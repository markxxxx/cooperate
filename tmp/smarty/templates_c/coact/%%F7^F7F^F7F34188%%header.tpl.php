<?php /* Smarty version 2.6.29, created on 2022-06-01 08:50:21
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'header.tpl', 8, false),array('modifier', 'ucfirst', 'header.tpl', 8, false),)), $this); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (((is_array($_tmp=@$this->_tpl_vars['site_title'])) ? $this->_run_mod_handler('default', true, $_tmp, false) : smarty_modifier_default($_tmp, false))): ?><?php echo $this->_tpl_vars['site_title']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['controller'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
 <?php if ($this->_tpl_vars['method'] == 'index'): ?>Manager<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['method'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)); ?>
<?php endif; ?><?php endif; ?> - Cooperate</title>
    <!-- Global stylesheets -->
    <link rel="icon" href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/favicon.png" >
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/css/colors.css" rel="stylesheet" type="text/css">
    
    <!-- /global stylesheets -->
     <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/libraries/jquery_ui/full.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/moment/moment.min.js"></script>

    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/pickers/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/headroom/headroom.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/headroom/headroom_jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/ui/nicescroll.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/dashboard.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/layout_fixed_custom.js"></script> -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/layout_navbar_hideable_sidebar.js"></script>
    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/js/jquery.cookie.js"></script>
    <!-- /theme JS files -->    
</head>
<body class="navbar-top">

   <!-- Main navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top magnadarkgrey">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html"><!-- <img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/logo_light.png" alt=""> -->Cooperate</a>

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

<!--                 <?php if (isset ( $_SESSION['admin'] )): ?>
                   You are currently logged in as <?php echo $this->_tpl_vars['user']->name; ?>
 <?php echo $this->_tpl_vars['user']->surname; ?>
, Return as: <a style="color:#508DB8;" href='/user/login_as/0/<?php echo $this->_tpl_vars['user']->id; ?>
'><?php echo $_SESSION['admin']['full_name']; ?>
</a>
                <?php else: ?>                    
                    <p class="navbar-text">Hi, <?php echo $this->_tpl_vars['user']->name; ?>
 <?php echo $this->_tpl_vars['user']->surname; ?>
!</p>
                    <p class="navbar-text"><span class="label bg-success-400">Online</span></p>
                <?php endif; ?> -->
                
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
                                        <img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
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
                                        <img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
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
                                    <div class="media-left"><img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Jeremy Victorino</span>
                                            <span class="media-annotation pull-right">22:48</span>
                                        </a>

                                        <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Beatrix Diaz</span>
                                            <span class="media-annotation pull-right">Tue</span>
                                        </a>

                                        <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="<?php echo $this->_tpl_vars['template_dir']; ?>
/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
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
                                <a href="#user-nav" data-toggle="collapse"><span><?php echo $this->_tpl_vars['user']->name; ?>
 <?php echo $this->_tpl_vars['user']->surname; ?>
</span> <i class="caret"></i></a>
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

                                <?php if ($this->_tpl_vars['user']->can_access('dashboard','home')): ?>
                                <li><a href="/"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('appointment','team_week_view')): ?>
                                <li><a href="/appointment/team_week_view"><i class="icon-collaboration"></i> <span>Team Schedule</span></a></li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('appointment','index') || $this->_tpl_vars['user']->can_access('appointment','events')): ?>
                                <li>
                                    <a href="#"><i class="icon-calendar"></i> <span>Appointments</span></a>
                                    <ul>
                                        <?php if ($this->_tpl_vars['user']->can_access('appointment','index')): ?>
                                        <li><a href="/appointment">Manage Appointments</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('appointment','events')): ?>
                                        <li><a href="/appointment/events">Manage Events</a></li>
                                        <?php endif; ?>
                                                                                <!-- <li><a href="">Add Event cards</a></li> -->
                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('project','index') || $this->_tpl_vars['user']->can_access('quote','index') || $this->_tpl_vars['user']->can_access('invoice','index')): ?>
                                <li>
                                    <a href="#"><i class="icon-stack2"></i> <span>Projects</span></a>
                                    <ul>
                                        <?php if ($this->_tpl_vars['user']->can_access('project','index')): ?>
                                        <li><a href="/project">Manage Projects</a></li>
                                        <?php endif; ?>
                                        <!-- <li><a href="/project/add">Add Project</a></li> -->
                                                                                <!-- <li><a href="/task/add">Add Task</a></li> -->
                                                                                <!-- <li><a href="/snag/add">Add Snag</a></li> -->
                                        <?php if ($this->_tpl_vars['user']->can_access('quote','index')): ?>
                                        <li><a href="/quote">Manage Quotes</a></li>
                                        <?php endif; ?>
                                        <!-- <li><a href="/quote/add">Add Quote</a></li> -->
                                        <?php if ($this->_tpl_vars['user']->can_access('invoice','index')): ?>
                                        <li><a href="/invoice">Manage Invoices</a></li>
                                        <?php endif; ?>
                                        <!-- <li><a href="/quote/add">Add Quote</a></li> -->
                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('task','index')): ?>
                                <li><a href="/task"><i class="icon-clipboard3"></i> <span>Tasks</span></a></li>                                 <?php endif; ?>
                                <?php if ($this->_tpl_vars['user']->can_access('snag','index')): ?>
                                <li><a href="/snag"><i class="icon-wrench"></i> <span>Snags</span></a></li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('report','index')): ?>
                                <li>
                                    <a href="#"><i class="icon-pie-chart"></i> <span>Reports</span></a>                                     <ul>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','newclients')): ?>
                                        <li><a href="/report/newclients">New Clients</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','oldclients')): ?>
                                        <li><a href="/report/oldclients">Old Clients</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','snagsperproject')): ?>
                                        <li><a href="/report/snagsperproject">Snags per Project</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','quotesvsinvoices')): ?>
                                        <li><a href="/report/quotesvsinvoices">Quotes Vs Invoices / Sales</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','jobsvsfreebies')): ?>
                                        <li><a href="/report/jobsvsfreebies">Jobs Vs Freebies</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','projectcompleted')): ?>
                                        <li><a href="/report/projectscompleted">Projects Completed</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','leadtime')): ?>
                                        <li><a href="/report/leadtime">Lead Time</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','snagsperteam')): ?>
                                        <li><a href="/report/snagsperteam">Snags per Team</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('report','jobsperteam')): ?>
                                        <li><a href="/report/jobsperteam">Jobs per Team</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('setup','index')): ?>
                                <li>
                                    <a href="#"><i class="icon-cog"></i> <span>Setup</span></a>
                                    <ul>
                                                                                <?php if ($this->_tpl_vars['user']->can_access('setup','jobtype')): ?>
                                        <li><a href="/setup/jobtype">Job Types</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('setup','colour')): ?>
                                        <li><a href="/setup/colour">Colours</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('customer','index')): ?>
                                <li>
                                    <a href="/customer"><i class="icon-man-woman"></i> <span>Guardians</span></a>                                     <!-- <ul>
                                        <li><a href="/customer" id="layout1">View Customers</a></li>
                                        <li><a href="/customer/add" id="layout2">Add Customer <span class="label bg-warning-400">Current</span></a></li>
                                    </ul> -->
                                </li>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['user']->can_access('user','index') || $this->_tpl_vars['user']->can_access('group','index') || $this->_tpl_vars['user']->can_access('group','manage')): ?>
                                <li>
                                    <a href="#"><i class="icon-users"></i> <span>Users</span></a>
                                    <ul>
                                        <?php if ($this->_tpl_vars['user']->can_access('user','index')): ?>
                                        <li><a href="/user">Manage Users</a></li>
                                        <?php endif; ?>
                                        <!-- <li><a href="/user/add/0">Add User</a></li> -->
                                        <?php if ($this->_tpl_vars['user']->can_access('group','index')): ?>
                                        <li><a href="/group">Manage Groups</a></li>
                                        <?php endif; ?>
                                        <?php if ($this->_tpl_vars['user']->can_access('group','manage')): ?>
                                        <li><a href="/group/manage">Manage Permissions</a></li>
                                        <?php endif; ?>
                                        <!-- <li><a href="/group">User permissions</a></li> -->
                                    </ul>
                                </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>
            <!-- /main sidebar -->
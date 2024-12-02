<?php /* Smarty version 2.6.29, created on 2022-06-01 08:50:21
         compiled from /home/yourtctw/public_html/cooperate/views/coact/dashboard_home.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>                  

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if ($this->_tpl_vars['user']->can_access('quote','index')): ?>
                        <a href="/quote" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Quotes</span></a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['user']->can_access('invoice','index')): ?>
                        <a href="/invoice" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['user']->can_access('appointment','index')): ?>
                        <a href="/appointment" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar text-primary"></i> <span>Appointments</span></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="breadcrumb-line">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li class="active">Dashboard</li>
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

            <!-- Main 1 -->
            <?php if ($this->_tpl_vars['user']->can_access('appointment','team_week_view') || $this->_tpl_vars['user']->can_access('appointment','index') || $this->_tpl_vars['user']->can_access('project','index')): ?>
            <div class="row">

                <?php if ($this->_tpl_vars['user']->can_access('appointment','team_week_view')): ?>
                <div class="col-lg-4">
                    <a href="/appointment/team_week_view"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>TEAM SCHEDULE</h1></button></a>
                </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['user']->can_access('appointment','index')): ?>
                <div class="col-lg-4">
                    <a href="/appointment"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>APPOINTMENTS</h1></button></a>
                </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['user']->can_access('project','index')): ?>
                <div class="col-lg-4">
                  <a href="/project"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>PROJECTS</h1></button></a>
                </div>
                <?php endif; ?>

            </div>
            <!-- /main Top -->

            <!-- Main middle -->
            <div class="row">
               &nbsp;
            </div>
            <?php endif; ?>

            <!-- Main 2 -->
            <?php if ($this->_tpl_vars['user']->can_access('snag','index') || $this->_tpl_vars['user']->can_access('task','index') || $this->_tpl_vars['user']->can_access('report','index')): ?>
            <div class="row">

                <?php if ($this->_tpl_vars['user']->can_access('task','index')): ?>
                    <div class="col-lg-4">
                        <a href="/task"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>TASKS</h1></button></a>
                    </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['user']->can_access('snag','index')): ?>
                <div class="col-lg-4">
                    <a href="/snag"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>SNAGS</h1></button></a>
                </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['user']->can_access('report','index')): ?>
                <div class="col-lg-4">
                    <a href="/report"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>REPORTS</h1></button></a>
                </div>
                <?php endif; ?>

            </div>
            <!-- /main Top -->

            <!-- /main middle -->

            <!-- Dashboard content -->
            <div class="row">
                &nbsp;
            </div>
            <?php endif; ?>

            <!-- Main 3 -->
            <?php if ($this->_tpl_vars['user']->can_access('report','index') || $this->_tpl_vars['user']->can_access('user','index') || $this->_tpl_vars['user']->can_access('customer','index')): ?>
            <div class="row">

                <?php if ($this->_tpl_vars['user']->can_access('setup','index')): ?>
                <div class="col-lg-4">
                    <a href="/setup"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>SETUP</h1></button></a>
                </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['user']->can_access('user','index')): ?>
                <div class="col-lg-4">
                    <a href="/user"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>USERS</h1></button></a>
                </div>
                <?php endif; ?>

                <?php if ($this->_tpl_vars['user']->can_access('customer','index')): ?>
                <div class="col-lg-4">
                    <a href="/customer"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>CUSTOMERS</h1></button></a>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>
            <!-- main 3 -->

                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!-- /main bottom -->

        </div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
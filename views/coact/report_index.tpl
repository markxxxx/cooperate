{include file="header.tpl"}                  

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Report Manager</h4>
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
                    <li class="active">Report Manager</li>
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
        <!-- /page Header -->

        <!-- Content Area -->
        <div class="content">

            <!-- Main 1 -->
            {if $user->can_access('report', 'newclients') || $user->can_access('report', 'oldclients') || $user->can_access('report', 'snagsperproject')}
            <div class="row">
                {if $user->can_access('report', 'newclients')}
                <div class="col-lg-4">
                  <a href="/report/newclients"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>New Clients</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('report', 'oldclients')}
                <div class="col-lg-4">
                  <a href="/report/oldclients"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Old Clients</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('report', 'snagsperproject')}
                <div class="col-lg-4">
                  <a href="/report/snagsperproject"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Snags per Project</h1></button></a>
                </div>
                {/if}
            </div>
            <div class="row">
               &nbsp;
            </div>
            {/if}
            <!-- /main 1 -->

            <!-- Main 2 -->
            {if $user->can_access('report', 'quotesvsinvoices') || $user->can_access('report', 'jobsvsfreebies') || $user->can_access('report', 'projectcompleted')}
            <div class="row">
                {if $user->can_access('report', 'quotesvsinvoices')}
                <div class="col-lg-4">
                  <a href="/report/quotesvsinvoices"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Quotes Vs Invoices</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('report', 'jobsvsfreebies')}
                <div class="col-lg-4">
                  <a href="/report/jobsvsfreebies"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Jobs Vs Freebies</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('report', 'projectcompleted')}
                <div class="col-lg-4">
                  <a href="/report/projectscompleted"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Project Completed</h1></button></a>
                </div>
                {/if}
            </div>
             <div class="row">
               &nbsp;
            </div>
            {/if}
            <!-- /main 2 -->

            <!-- Main 3 -->
            {if $user->can_access('report', 'leadtime') || $user->can_access('report', 'snagsperteam') || $user->can_access('report', 'jobsperteam')}
            <div class="row">
                {if $user->can_access('report', 'leadtime')}
                <div class="col-lg-4">
                  <a href="/report/leadtime"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Lead Time</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('report', 'snagsperteam')}
                <div class="col-lg-4">
                  <a href="/report/snagsperteam"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Snags per Team</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('report', 'jobsperteam')}
                <div class="col-lg-4">
                  <a href="/report/jobsperteam"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Jobs per Team</h1></button></a>
                </div>
                {/if}
            </div>
            <div class="row">
               &nbsp;
            </div>
            {/if}
            <!-- /main 3 -->

        </div>
        <!-- /content Area -->

{include file="footer.tpl"}
{include file="header.tpl"}                  

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Setup Manager</h4>
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
                    <li class="active">Setup Manager</li>
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
            {if $user->can_access('setup', 'accessory') || $user->can_access('setup', 'jobtype') || $user->can_access('setup', 'cupboardheight')}
            <div class="row">
                {if $user->can_access('setup' , 'accessory')}
                <div class="col-lg-4">
                  <a href="/setup/accessory"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Accessories</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('setup', 'jobtype')}
                <div class="col-lg-4">
                  <a href="/setup/jobtype"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Job Types</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('setup', 'cupboardheight')}
                <div class="col-lg-4">
                  <a href="/setup/cupboardheight"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Cupboard Heights</h1></button></a>
                </div>
                {/if}
            </div>
            <div class="row">
               &nbsp;
            </div>
            {/if}
            <!-- /main 1 -->

            <!-- Main 2 -->
            {if $user->can_access('setup', 'finish') || $user->can_access('setup', 'colour') || $user->can_access('setup', 'edging')}
            <div class="row">
                {if $user->can_access('setup', 'finish')}
                <div class="col-lg-4">
                <a href="/setup/finish"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Finishes</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('setup', 'colour')}
                <div class="col-lg-4">
                  <a href="/setup/colour"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Colours</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('setup', 'edging')}
                <div class="col-lg-4">
                  <a href="/setup/edging"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Edging Sizes</h1></button></a>
                </div>
                {/if}
            </div>
             <div class="row">
               &nbsp;
            </div>
            {/if}
            <!-- /main 2 -->

            <!-- Main 3 -->
            {if $user->can_access('setup', 'kickplate') || $user->can_access('setup', 'topthickness') || $user->can_access('setup', 'toptype')}
            <div class="row">
                {if $user->can_access('setup', 'kickplate')}
                <div class="col-lg-4">
                  <a href="/setup/kickplate"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Kickplates</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('setup', 'topthickness')}
                <div class="col-lg-4">
                  <a href="/setup/topthickness"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Top Thicknesses</h1></button></a>
                </div>
                {/if}
                {if $user->can_access('setup', 'toptype')}
                <div class="col-lg-4">
                  <a href="/setup/toptype"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Top Types</h1></button></a>
                </div>
                {/if}
            </div>
            <div class="row">
               &nbsp;
            </div>
            {/if}
            <!-- /main 3 -->

            <!-- Main 4 -->
            {if $user->can_access('setup', 'handlesize') || $user->can_access('setup', 'handletype') || $user->can_access('setup', 'runner')}
                <div class="row">
                    {if $user->can_access('setup', 'handlesize')}
                        <div class="col-lg-4">
                            <a href="/setup/handlesize"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Handle Sizes</h1></button></a>
                        </div>
                    {/if}
                    {if $user->can_access('setup', 'handletype')}
                        <div class="col-lg-4">
                            <a href="/setup/handletype"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Handle Types</h1></button></a>
                        </div>
                    {/if}
                    {if $user->can_access('setup', 'runner')}
                        <div class="col-lg-4">
                            <a href="/setup/runner"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Runners</h1></button></a>
                        </div>
                    {/if}
                </div>
                <div class="row">
                    &nbsp;
                </div>
            {/if}
            <!-- /main 4 -->

            <!-- Main 5 -->
            {if $user->can_access('setup', 'hinge') || $user->can_access('setup', 'sink') || $user->can_access('setup', 'prepbowl')}
                <div class="row">
                    {if $user->can_access('setup', 'hinge')}
                        <div class="col-lg-4">
                            <a href="/setup/hinge"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Hinges</h1></button></a>
                        </div>
                    {/if}
                    {if $user->can_access('setup', 'sink')}
                        <div class="col-lg-4">
                            <a href="/setup/sink"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Sinks</h1></button></a>
                        </div>
                    {/if}
                    {if $user->can_access('setup', 'prepbowl')}
                        <div class="col-lg-4">
                            <a href="/setup/prepbowl"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:100px;"><h1>Prep Bowls</h1></button></a>
                        </div>
                    {/if}
                </div>
                <div class="row">
                    &nbsp;
                </div>
            {/if}
            <!-- /main 5 -->

        </div>
        <!-- /content Area -->

{include file="footer.tpl"}
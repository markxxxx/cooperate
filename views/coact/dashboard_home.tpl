{include file="header.tpl"}                  

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
            {if $user->can_access('appointment', 'team_week_view') || $user->can_access('appointment', 'index') || $user->can_access('project', 'index')}
            <div class="row">

                {if $user->can_access('appointment', 'team_week_view')}
                <div class="col-lg-4">
                    <a href="/appointment/team_week_view"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>CLASS SCHEDULE</h1></button></a>
                </div>
                {/if}

                {if $user->can_access('appointment', 'index')}
                <div class="col-lg-4">
                    <a href="/appointment"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>APPOINTMENTS</h1></button></a>
                </div>
                {/if}

                {if $user->can_access('project', 'index')}
                <div class="col-lg-4">
                  <a href="/project"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>SUBJECTS</h1></button></a>
                </div>
                {/if}

            </div>
            <!-- /main Top -->

            <!-- Main middle -->
            <div class="row">
               &nbsp;
            </div>
            {/if}

            <!-- Main 2 -->
            {if $user->can_access('snag', 'index') || $user->can_access('task', 'index') || $user->can_access('report', 'index')}
            <div class="row">

                {if $user->can_access('task', 'index')}
                    <div class="col-lg-4">
                        <a href="/task"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>LESSONS</h1></button></a>
                    </div>
                {/if}

                {if $user->can_access('snag', 'index')}
                <div class="col-lg-4">
                    <a href="/snag"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>PROBLEMS</h1></button></a>
                </div>
                {/if}

                {if $user->can_access('report', 'index')}
                <div class="col-lg-4">
                    <a href="/report"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>REPORTS</h1></button></a>
                </div>
                {/if}

            </div>
            <!-- /main Top -->

            <!-- /main middle -->

            <!-- Dashboard content -->
            <div class="row">
                &nbsp;
            </div>
            {/if}

            <!-- Main 3 -->
            {if $user->can_access('report', 'index') || $user->can_access('user', 'index') || $user->can_access('customer', 'index')}
            <div class="row">

                {if $user->can_access('setup', 'index')}
                <div class="col-lg-4">
                    <a href="/message/inbox"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>INBOX</h1></button></a>
                </div>
                {/if}

                {if $user->can_access('user', 'index')}
                <div class="col-lg-4">
                    <a href="/user"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>USERS</h1></button></a>
                </div>
                {/if}

                {if $user->can_access('customer', 'index')}
                <div class="col-lg-4">
                    <a href="/customer"><button type="button" class="btn btn-primary btn-lg" style="width:100%;height:150px;"><h1>GUADIANS</h1></button></a>
                </div>
                {/if}

            </div>
            {/if}
            <!-- main 3 -->

            {*<div class="panel panel-flat">*}
                {*<div class="panel-heading">*}
                    {*<h6 class="panel-title">Latest posts</h6>*}
                    {*<div class="heading-elements">*}
                        {*<ul class="icons-list">*}
                            {*<li><a data-action="collapse"></a></li>*}
                            {*<li><a data-action="reload"></a></li>*}
                            {*<li><a data-action="close"></a></li> *}
                        {*</ul>*}
                    {*</div>*}
                {*</div>*}

                {*<div class="panel-body">*}
                    {*<div class="row">*}
                        {*<div class="col-lg-6">*}
                            {*<ul class="media-list content-group">*}
                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Up unpacked friendly</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> Video tutorials</li>*}
                                            {*<li>14 minutes ago</li>*}
                                        {*</ul>*}
                                        {*The him father parish looked has sooner. Attachment frequently gay terminated son...*}
                                    {*</div>*}
                                {*</li>*}

                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">It allowance prevailed</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> Video tutorials</li>*}
                                            {*<li>12 days ago</li>*}
                                        {*</ul>*}
                                        {*Alteration literature to or an sympathize mr imprudence. Of is ferrars subject as enjoyed...*}
                                    {*</div>*}
                                {*</li>*}
                            {*</ul>*}
                        {*</div>*}

                        {*<div class="col-lg-6">*}
                            {*<ul class="media-list content-group">*}
                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Case read they must</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> Video tutorials</li>*}
                                            {*<li>20 hours ago</li>*}
                                        {*</ul>*}
                                        {*On it differed repeated wandered required in. Then girl neat why yet knew rose spot...*}
                                    {*</div>*}
                                {*</li>*}

                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Too carriage attended</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> FAQ section</li>*}
                                            {*<li>2 days ago</li>*}
                                        {*</ul>*}
                                        {*Marianne or husbands if at stronger ye. Considered is as middletons uncommonly...*}
                                    {*</div>*}
                                {*</li>*}
                            {*</ul>*}
                        {*</div>*}

                        {*<div class="col-lg-6">*}
                            {*<ul class="media-list content-group">*}
                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Case read they must</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> Video tutorials</li>*}
                                            {*<li>20 hours ago</li>*}
                                        {*</ul>*}
                                        {*On it differed repeated wandered required in. Then girl neat why yet knew rose spot...*}
                                    {*</div>*}
                                {*</li>*}

                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Too carriage attended</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> FAQ section</li>*}
                                            {*<li>2 days ago</li>*}
                                        {*</ul>*}
                                        {*Marianne or husbands if at stronger ye. Considered is as middletons uncommonly...*}
                                    {*</div>*}
                                {*</li>*}
                            {*</ul>*}
                        {*</div>*}

                        {*<div class="col-lg-6">*}
                            {*<ul class="media-list content-group">*}
                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Case read they must</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> Video tutorials</li>*}
                                            {*<li>20 hours ago</li>*}
                                        {*</ul>*}
                                        {*On it differed repeated wandered required in. Then girl neat why yet knew rose spot...*}
                                    {*</div>*}
                                {*</li>*}

                                {*<li class="media stack-media-on-mobile">*}
                                    {*<div class="media-left">*}
                                        {*<div class="thumb">*}
                                            {*<a href="#">*}
                                                {*<img src="assets/images/placeholder.jpg" class="img-responsive img-rounded media-preview" alt="">*}
                                                {*<span class="zoom-image"><i class="icon-play3"></i></span>*}
                                            {*</a>*}
                                        {*</div>*}
                                    {*</div>*}

                                    {*<div class="media-body">*}
                                        {*<h6 class="media-heading"><a href="#">Too carriage attended</a></h6>*}
                                        {*<ul class="list-inline list-inline-separate text-muted mb-5">*}
                                            {*<li><i class="icon-book-play position-left"></i> FAQ section</li>*}
                                            {*<li>2 days ago</li>*}
                                        {*</ul>*}
                                        {*Marianne or husbands if at stronger ye. Considered is as middletons uncommonly...*}
                                    {*</div>*}
                                {*</li>*}
                            {*</ul>*}
                        {*</div>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
            <!-- /main bottom -->

        </div>

{include file="footer.tpl"}
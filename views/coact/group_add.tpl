{include file="header.tpl"}
{head}
{literal}
	
{/literal}
	

{/head}



{include file="filter_options.tpl"}

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -  -->Group Manager</h4>
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
                            <li class="active">User Manager</li>
                        </ul>

                        <ul class="breadcrumb-elements">
                            <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Group</h5>
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
									<form action="/group/{$method}/{$data.id|default:0}" method="post" name="form_group" enctype="multipart/form-data" class="middle-forms" id="form_group">
										<!-- <h3>{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Group</h3> -->
										<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
										<fieldset>
											
											<ol style="list-style: none;">
    											<li>
                                                    <span class="label bg-teal help-inline">Name</span>
                                                    <input name="data[name]" type="text" class="form-control" id="field_name" value="{$data.name}" placeholder="Name" required/> 
                                                    {error field=name}
                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
                                                <li>
                                                    <span class="label bg-teal help-inline">Account</span>
                                                    <input name="data[account]" type="text" class="form-control" id="field_account" value="{$data.account}" placeholder="Account" required/> 
                                                    {error field=account}
                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
                                                <li>
                                                    <span class="label bg-teal help-inline">Approve Changes?</span>
                                                    <select name="data[approve_changes]" id="field_approve_changes" class="form-control">
                                                        <option value=''>Approve Changes:</option>                                            
                                                        <option value='1' {if $data.approve_changes eq 1}selected{/if}>Yes</option>                                            
                                                        <option value='0' {if $data.approve_changes eq 0}selected{/if}>No</option>  
                                                    </select>
                                                    </label>
                                                    {error field=approve_changes}
                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
                                                <li>
                                                    <span class="label bg-teal help-inline">Recieve Notifications?</span>                                          
                                                    <select name="data[message_notifications]" id="field_message_notifications" class="form-control">
                                                        <option value=''>Recieve notifications:</option>                                            
                                                        <option value='1' {if $data.message_notification eq 1}selected{/if}>Yes</option>                                            
                                                        <option value='0' {if $data.message_notification eq 0}selected{/if}>No</option>  
                                                    </select>
                                                    </label>
                                                    {error field=message_notifications}
                                                    <span class="clearFix">&nbsp;</span>
                                                </li>
											</ol>
										</ol>
                                </fieldset>
                            </div>
                            

                            <div class="modal-footer">
                              <a class="btn btn-link" href="/"><i class="icon-cross"></i> Close</a>
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
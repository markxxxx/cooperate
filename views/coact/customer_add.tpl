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
                            <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Guardian Manager</h4>
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
                            <li><a href="/customer">Guardian Manager</a></li>
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
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Guardian</h5>
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
                                	<form action="/customer/add/{$data.id|default:0}/{$project_id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
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
                                            <input name="data[company]" type="text" class="form-control" id="field_company" value="{$data.company}" placeholder="Company" />
                                            {error field=company}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">Contact Number</span>
                                            <input name="data[contact_number]" type="text" class="form-control" id="field_contact_number" value="{$data.contact_number}" placeholder="Contact Number" required />
                                            {error field=contact_number}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            {*ADP 2019/01/28 : Remove required from email field*}
                                            <span class="label bg-teal help-inline">Email</span>
                                            <input name="data[email]" type="text" class="form-control" id="field_email" value="{$data.email}" placeholder="Email" />
                                            {error field=email}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li >
                                            <span class="label bg-teal help-inline">Address</span>
                                            <input name="data[address]" type="text" class="form-control" id="field_address" value="{$data.address}" placeholder="Address" required />
                                            {error field=address}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                    </ol>
								</fieldset>
							</div>
							

			                <div class="modal-footer">
                                <a class="btn btn-link" href="/customer"><i class="icon-cross"></i> Close</a>
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
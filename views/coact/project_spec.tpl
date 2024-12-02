{include file="header.tpl"}

{head}
    {*<script type="text/javascript" src="{$template_dir}/assets/js/plugins/notifications/jgrowl.min.js"></script>*}
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/anytime.min.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/picker_date.js"></script>
    <script type="text/javascript" src="{$template_dir}/assets/js/pages/form_select2.js"></script>
{/head}

{literal}
    
<script type="text/javascript">
    
    $(function() {
        console.log( "ready!" );
    });

    function getMultipleSelected(fieldID){
        $("#accessories").val($(".select2-hidden-accessible").select2("val") );
    }

</script>

{/literal}

{include file="filter_options.tpl"}

    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Page header -->
        <div class="page-header page-header-default">
            <div class="page-header-content">
                <div class="page-title">
                    <h4><!-- <i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - --> Project Manager</h4>
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
                    <li><a href="/project">Project Manager</a></li>
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
        <!-- /end Page header -->
        <!-- Content area -->
        <div class="content">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="modal-title"><i class="icon-menu7"></i> &nbsp;{if $data.id|default:0 eq 0}Create a new{else}Update current{/if} Technical Specification</h5>
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
                            <form action="/project/spec/{$project.project_id|default:0}/{$technical_id|default:0}" method="post" name="form_user" enctype="multipart/form-data" class="middle-forms" id="form_user">
                                <input type="hidden" name="is_admin" value="{$is_admin}" id ="is_admin"/>
                                <fieldset>
                                    <ol style="list-style: none;">
                                        <li >
                                            <span class="label bg-teal help-inline">Date</span>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                    <input name="data[start_date]" class="form-control daterange-single" value="{$data.start_date}" type="text" id="field_start_date" value="{$data.start_date}" placeholder="Start date" required>
                                                </div>
                                            </div>
                                            {error field=start_date}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <!-- <li >
                                            <span class="label bg-teal help-inline">End Date</span>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                    <input name="data[end_date]" class="form-control daterange-single" value="{$data.end_date}" type="text" id="field_end_date" value="{$data.end_date}" placeholder="End date" required>
                                                </div>
                                            </div>
                                            {error field=end_date}
                                            <span class="clearFix">&nbsp;</span>
                                        </li> -->
                                        <li>
                                            <span class="label bg-teal help-inline">Customer</span>
                                            <input name="data[customer]" type="text" class="form-control" id="field_customer" value="{$project.customer_name} {$project.customer_surname}" placeholder="customer" readonly/>
                                            {error field=customer}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Sales Rep</span>
                                            <input name="data[sales_rep]" type="text" class="form-control" id="field_sales_rep" value="{$project.sales_name} {$project.sales_surname}" placeholder="sales_rep" readonly/>
                                            {error field=sales_rep}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Sales Rep Contact</span>
                                            <input name="data[sales_contact]" type="text" class="form-control" id="field_sales_contact" value="{$project.sales_contact}" placeholder="sales_contact" readonly/>
                                            {error field=sales_contact}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Installation Address</span>
                                            <input name="data[installation_address]" type="text" class="form-control" id="field_installation_address" value="{if $data.installation_address} {$data.installation_address} {else} {$project.customer_address} {/if}" placeholder="Installation Address" required/>
                                            {error field=installation_address}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Lead Time</span>
                                            <input name="data[lead_time]" type="text" class="form-control" id="field_lead_time" value="{$data.lead_time}" placeholder="Lead Time" required/>
                                            {error field=lead_time}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Job Type</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[job_type]">
                                                    <option value=''>Select Job Type:</option>
                                                    {section name=inst loop=$job_type}
                                                        <option value="{$job_type[inst].job_type_name}" {if $data.job_type eq $job_type[inst].job_type_name}selected{/if} >{$job_type[inst].job_type_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <br><br><br>

                                        <h1>Site Details</h1>
                                        <li>
                                            <span class="label bg-teal help-inline">Ceiling Height</span>
                                            <input name="data[ceiling_height]" type="text" class="form-control" id="field_ceiling_height" value="{$data.ceiling_height}" placeholder="Ceiling Height" required/>
                                            {error field=ceiling_height}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Cupboard Height</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[cupboard_height]">
                                                    <option value=''>Select Cupboard Height:</option>
                                                    {section name=inst loop=$cupboard_height}
                                                        <option value="{$cupboard_height[inst].cupboard_height_name}" {if $data.cupboard_height eq $cupboard_height[inst].cupboard_height_name}selected{/if} >{$cupboard_height[inst].cupboard_height_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Access for Big Units</span>
                                            <div class="form-group">
                                                <select class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[big_unit_access]">
                                                    <option value=''>Select Access for Big Units:</option>
                                                    {section name=inst loop=$yesno}
                                                        <option value="{$yesno[inst]}" {if $data.big_unit_access eq $yesno[inst]}selected{/if} >{$yesno[inst]} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <br><br><br>

                                        <h1>Finish Details</h1>
                                        <li>
                                            <span class="label bg-teal help-inline">Door Finishes</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[finishes]">
                                                    <option value=''>Select Door Finishes:</option>
                                                    {section name=inst loop=$finishes}
                                                        <option value="{$finishes[inst].finish_name}" {if $data.finishes eq $finishes[inst].finish_name}selected{/if} >{$finishes[inst].finish_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Door Colour</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[door_colour]">
                                                    <option value=''>Select Door Colour:</option>
                                                    {section name=inst loop=$colours}
                                                        <option value="{$colours[inst].colour_name}" {if $data.door_colour eq $colours[inst].colour_name}selected{/if} >{$colours[inst].colour_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Edging Size</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[edging]">
                                                    <option value=''>Select Edging Size:</option>
                                                    {section name=inst loop=$edging}
                                                        <option value="{$edging[inst].edging_name}" {if $data.edging eq $edging[inst].edging_name}selected{/if} >{$edging[inst].edging_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Edging Colour</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[edging_colour]">
                                                    <option value=''>Select Edging Colour:</option>
                                                    {section name=inst loop=$colours}
                                                        <option value="{$colours[inst].colour_name}" {if $data.edging_colour eq $colours[inst].colour_name}selected{/if} >{$colours[inst].colour_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Tops</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[top_type]">
                                                    <option value=''>Select Tops:</option>

                                                    <optgroup label="Quartz">
                                                        {section name=inst loop=$Quartz}
                                                            <option value="{$Quartz[inst].variant_name}" {if $data.top_type eq $Quartz[inst].variant_name}selected{/if} >{$Quartz[inst].variant_name} </option>
                                                        {/section}
                                                    </optgroup>
                                                    <optgroup label="Formica">
                                                        {section name=inst loop=$Formica}
                                                            <option value="{$Formica[inst].variant_name}" {if $data.top_type eq $Formica[inst].variant_name}selected{/if} >{$Formica[inst].variant_name} </option>
                                                        {/section}
                                                    </optgroup>
                                                    <optgroup label="Granite">
                                                        {section name=inst loop=$Granite}
                                                            <option value="{$Granite[inst].variant_name}" {if $data.top_type eq $Granite[inst].variant_name}selected{/if} >{$Granite[inst].variant_name} </option>
                                                        {/section}
                                                    </optgroup>
                                                    <optgroup label="Veneer">
                                                        {section name=inst loop=$Veneer}
                                                            <option value="{$Veneer[inst].variant_name}" {if $data.top_type eq $Veneer[inst].variant_name}selected{/if} >{$Veneer[inst].variant_name} </option>
                                                        {/section}
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Top Thickness</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[top_thickness]">
                                                    <option value=''>Select Top Thickness:</option>
                                                    {section name=inst loop=$top_thickness}
                                                        <option value="{$top_thickness[inst].topthickness_name}" {if $data.top_thickness eq $top_thickness[inst].topthickness_name}selected{/if} >{$top_thickness[inst].topthickness_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Kickplates</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[kickplates]">
                                                    <option value=''>Select Kickplates:</option>
                                                    {section name=inst loop=$kickplates}
                                                        <option value="{$kickplates[inst].kickplate_name}" {if $data.kickplates eq $kickplates[inst].kickplate_name}selected{/if} >{$kickplates[inst].kickplate_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Top Filler</span>
                                            <div class="form-group">
                                                <select class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[top_filler]">
                                                    <option value=''>Select Top Filler:</option>
                                                    {section name=inst loop=$yesno}
                                                        <option value="{$yesno[inst]}" {if $data.top_filler eq $yesno[inst]}selected{/if} >{$yesno[inst]} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Top Scotia</span>
                                            <div class="form-group">
                                                <select class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[scotia]">
                                                    <option value=''>Select Top Scotia:</option>
                                                    {section name=inst loop=$yesno}
                                                        <option value="{$yesno[inst]}" {if $data.scotia eq $yesno[inst]}selected{/if} >{$yesno[inst]} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Light Shield</span>
                                            <div class="form-group">
                                                <select class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[light_shield]">
                                                    <option value=''>Select Light Shield:</option>
                                                    {section name=inst loop=$yesno}
                                                        <option value="{$yesno[inst]}" {if $data.light_shield eq $yesno[inst]}selected{/if} >{$yesno[inst]} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Handles</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[handle_type]">
                                                    <option value=''>Select Handles:</option>
                                                    {section name=inst loop=$handle_type}
                                                        <option value="{$handle_type[inst].handletype_name}" {if $data.handle_type eq $handle_type[inst].handletype_name}selected{/if} >{$handle_type[inst].handletype_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Handle Size</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[handle_size]">
                                                    <option value=''>Select Handle Size:</option>
                                                    {section name=inst loop=$handle_size}
                                                        <option value="{$handle_size[inst].handlesize_name}" {if $data.handle_size eq $handle_size[inst].handlesize_name}selected{/if} >{$handle_size[inst].handlesize_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Sink</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[sinks]">
                                                    <option value=''>Select Sink:</option>
                                                    {section name=inst loop=$sinks}
                                                        <option value="{$sinks[inst].sink_name}" {if $data.sinks eq $sinks[inst].sink_name}selected{/if} >{$sinks[inst].sink_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Prep Bowl</span>
                                            <div class="form-group">
                                               <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[prep_bowl]">
                                                    <option value=''>Select Prep Bowl:</option>
                                                    {section name=inst loop=$prepbowls}
                                                        <option value="{$prepbowls[inst].prepbowl_name}" {if $data.prep_bowl eq $prepbowls[inst].prepbowl_name}selected{/if} >{$prepbowls[inst].prepbowl_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Swing Out Bin</span>
                                            <div class="form-group">
                                                <select class="select select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[swing_out_bin]">
                                                    <option value=''>Select Swing Out Bin:</option>
                                                    {section name=inst loop=$yesno}
                                                        <option value="{$yesno[inst]}" {if $data.swing_out_bin eq $yesno[inst]}selected{/if} >{$yesno[inst]} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Hinges</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[hinges]">
                                                    <option value=''>Select Hinges:</option>
                                                    {section name=inst loop=$hinges}
                                                        <option value="{$hinges[inst].hinge_name}" {if $data.hinges eq $hinges[inst].hinge_name}selected{/if} >{$hinges[inst].hinge_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Runners</span>
                                            <div class="form-group">
                                                <select class="select-search select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="data[runners]">
                                                    <option value=''>Select Runners:</option>
                                                    {section name=inst loop=$runners}
                                                        <option value="{$runners[inst].runner_name}" {if $data.runners eq $runners[inst].runner_name}selected{/if} >{$runners[inst].runner_name} </option>
                                                    {/section}
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Accessories</span>
                                            <div class="form-group">
                                                <select multiple="multiple" class="select-results-color select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="" onchange="getMultipleSelected(this.id)">
                                                    <!-- <option value=''>Select Accessories:</option> -->
                                                    {section name=inst loop=$accessories}
                                                        <option name="{$accessories[inst].name}" value="{$accessories[inst].name}"  {section name=inst2 loop=$selected_accessories} {if $selected_accessories[inst2] eq $accessories[inst].name}selected{/if} {/section} >{$accessories[inst].name} </option>
                                                    {/section}
                                                </select>
                                                <input type="hidden" name="data[accessories]" id="accessories">
                                            </div>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Comments</span>
                                            <textarea name="data[comments]" id="field_comments" class="form-control" style="width:100%;height:100px;" placeholder="Comments">{$data.comments}</textarea>
                                            {error field=comments}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                        <li>
                                            <span class="label bg-teal help-inline">Plans</span><br>
                                            {if $project.plan}
                                                <a href="/documents/plans/{$project.plan}" target="_blank">{$project.plan}</a>
                                            {else}
                                                <input type="text" class="form-control" value="No plan linked to this project" readonly/>
                                            {/if}
                                            <span class="clearFix">&nbsp;</span>
                                        </li>
                                    </ol>
                                </fieldset>
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
        <!-- /end Content area -->
    </div>
    <!-- /end Main content -->

{include file="footer.tpl"}
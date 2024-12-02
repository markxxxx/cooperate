<?php /* Smarty version 2.6.29, created on 2022-12-22 10:08:21
         compiled from /home/yourtctw/public_html/cooperate/views/coact/group_manage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'head', '/home/yourtctw/public_html/cooperate/views/coact/group_manage.tpl', 3, false),array('function', 'math', '/home/yourtctw/public_html/cooperate/views/coact/group_manage.tpl', 137, false),array('function', 'cycle', '/home/yourtctw/public_html/cooperate/views/coact/group_manage.tpl', 140, false),array('modifier', 'count', '/home/yourtctw/public_html/cooperate/views/coact/group_manage.tpl', 137, false),array('modifier', 'pluralize', '/home/yourtctw/public_html/cooperate/views/coact/group_manage.tpl', 137, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $this->_tag_stack[] = array('head', array()); $_block_repeat=true;smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
<?php echo '
<script>

    $(document).ready(function(){
       $(\'.tohide\').css(\'display\',\'none\');
    });

    function toggle(unhide) {
        classname = \'.\'+unhide;
        visable = $(classname+\':first\').css(\'display\');
        if(visable == \'none\') {
            $(classname).css(\'display\',\'table-row\');
        } else {
            $(classname).css(\'display\',\'none\');
        }
    }
    
    function change_access(g_id,p_id,el) {
	
        src = el.src.split(\'/\').pop();
        if(src == \'tick.png\') {
            enable_option = 0;
            src = \'/views/app/images/cross.png\';
        } else {
            enable_option = 1;
            src = \'/views/app/images/tick.png\';
        }
        el.src = \'/views/app/images/spinner.gif\';

        $.ajax({
            type: "GET",
            url: "/group/update_permission/"+g_id+\'/\'+p_id+\'/\'+enable_option,
            success: function(){
                el.src = src;
            }
          });
    }
    
</script>
'; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_head($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><!--<i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - -->Permissions Manager</h4>
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
                <li class="active">Permissions Manager</li>
            </ul>
            <ul class="breadcrumb-elements">
                <!-- <li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
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
                    </ul> -->
                </li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <!-- <h6 class="panel-title">This is where you view, add or remove users...</h6> -->
                <ul class="icons-list">
                    <a href="/group/generate_permissions/" class="btn bg-teal-400 legitRipple btn-default btn-sm" >
                                        <i class="icon-statistics position-left"></i> Generate permisions</a>
                </ul>
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

                        <table class="table datatable-basic table-hover">
                            <thead>
                                <tr>
                                    <td >Permission</td>
                                    <?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['inst']['show'] = true;
$this->_sections['inst']['max'] = $this->_sections['inst']['loop'];
$this->_sections['inst']['step'] = 1;
$this->_sections['inst']['start'] = $this->_sections['inst']['step'] > 0 ? 0 : $this->_sections['inst']['loop']-1;
if ($this->_sections['inst']['show']) {
    $this->_sections['inst']['total'] = $this->_sections['inst']['loop'];
    if ($this->_sections['inst']['total'] == 0)
        $this->_sections['inst']['show'] = false;
} else
    $this->_sections['inst']['total'] = 0;
if ($this->_sections['inst']['show']):

            for ($this->_sections['inst']['index'] = $this->_sections['inst']['start'], $this->_sections['inst']['iteration'] = 1;
                 $this->_sections['inst']['iteration'] <= $this->_sections['inst']['total'];
                 $this->_sections['inst']['index'] += $this->_sections['inst']['step'], $this->_sections['inst']['iteration']++):
$this->_sections['inst']['rownum'] = $this->_sections['inst']['iteration'];
$this->_sections['inst']['index_prev'] = $this->_sections['inst']['index'] - $this->_sections['inst']['step'];
$this->_sections['inst']['index_next'] = $this->_sections['inst']['index'] + $this->_sections['inst']['step'];
$this->_sections['inst']['first']      = ($this->_sections['inst']['iteration'] == 1);
$this->_sections['inst']['last']       = ($this->_sections['inst']['iteration'] == $this->_sections['inst']['total']);
?>
                                        <td class="col-second">
                                            <?php if ($this->_tpl_vars['user']->can_access('group','edit')): ?> 
                                                <a href="/group/edit/<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</a>
                                            <?php else: ?>
                                                <?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>

                                            <?php endif; ?>
                                        </td>
                                    <?php endfor; endif; ?>
                                </tr>
                            </thead>
                        <tbody>
                            <?php $_from = $this->_tpl_vars['permissions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['parent'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['parent']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p_k'] => $this->_tpl_vars['p_v']):
        $this->_foreach['parent']['iteration']++;
?>
                                <?php if ($this->_tpl_vars['prev'] == $this->_tpl_vars['p_v']['class']): ?>
                                    <?php $this->assign('hidden', true); ?>
                                <?php else: ?>
                                    <?php $this->assign('hidden', false); ?>
                                <?php endif; ?>
                                <?php if (! $this->_tpl_vars['hidden']): ?>
                                    <tr >
                                        <td class="col-second" style="padding:10px;" colspan="<?php echo smarty_function_math(array('equation' => "x + 1",'x' => count($this->_tpl_vars['groups'])), $this);?>
" ><a href="javascript: toggle('s_<?php echo $this->_tpl_vars['p_v']['class']; ?>
')"><?php echo ((is_array($_tmp=$this->_tpl_vars['p_v']['class'])) ? $this->_run_mod_handler('pluralize', true, $_tmp) : smarty_modifier_pluralize($_tmp)); ?>
</a></td>
                                    </tr>
                                <?php endif; ?>
                                <tr class="s_<?php echo $this->_tpl_vars['p_v']['class']; ?>
 tohide <?php echo smarty_function_cycle(array('values' => "odd,"), $this);?>
" >
                                    <td class="lft"><?php echo $this->_tpl_vars['p_v']['method']; ?>
</td>
                                        <?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['g_k'] => $this->_tpl_vars['g_v']):
?>
                                            <td class="col-second">
                                                <?php if ($this->_tpl_vars['group_permission'][$this->_tpl_vars['g_v']['id']][$this->_tpl_vars['p_v']['id']]['can_access'] && $this->_tpl_vars['g_v']['id'] == 1): ?>
                                                    <img src="/views/app/images/tick_disabled.png" />
                                                <?php elseif ($this->_tpl_vars['group_permission'][$this->_tpl_vars['g_v']['id']][$this->_tpl_vars['p_v']['id']]['can_access']): ?>
                                                    <a><img onclick="change_access('<?php echo $this->_tpl_vars['g_v']['id']; ?>
','<?php echo $this->_tpl_vars['p_v']['id']; ?>
', this)" border="none" src="/views/app/images/tick.png" /></a>
                                                <?php else: ?>
                                                    <a><img  onclick="change_access('<?php echo $this->_tpl_vars['g_v']['id']; ?>
','<?php echo $this->_tpl_vars['p_v']['id']; ?>
', this)" src="/views/app/images/cross.png" /></a>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; endif; unset($_from); ?>
                                </tr>
                                <?php $this->assign('prev', $this->_tpl_vars['p_v']['class']); ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /end content -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
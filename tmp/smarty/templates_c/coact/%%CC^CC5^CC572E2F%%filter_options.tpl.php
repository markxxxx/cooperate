<?php /* Smarty version 2.6.29, created on 2022-12-22 10:18:10
         compiled from filter_options.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'filter_options.tpl', 10, false),array('function', 'cfield', 'filter_options.tpl', 72, false),)), $this); ?>
<?php if ($this->_tpl_vars['user']->can_access('dashboard','set_filters')): ?>
	
<div class="hidden">
	<div id="change_dashboard" style=" margin:20px"><h3 class="green" style="border-bottom:1px solid silver;padding-bottom:5px;margin-bottom:5px">Dashboard options<div style="float:right" >Total users: <span id="user_count"><?php echo $this->_tpl_vars['total_users']; ?>
</span></div></h3>
		<br />
		<form action="/dashboard/set_filters/" id="message_counter" method="POST" />
			<table width="100%" style="border-spacing:5px;">
				<tr>
					<td>
							<?php if (((is_array($_tmp=$this->_tpl_vars['domains'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 1): ?>
								<b>Domains:</b><Br />
								<ul class="checklist">
									<?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['domains']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
										<li><label for="ck_domain_<?php echo $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['id']; ?>
"><input type="checkbox"  name="domains[]"  
										<?php if (isset ( $this->_tpl_vars['filter_domains'] ) && in_array ( $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['id'] , $this->_tpl_vars['filter_domains'] )): ?> checked <?php endif; ?> value="<?php echo $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['id']; ?>
" id="ck_domain_<?php echo $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['id']; ?>
"/><?php echo $this->_tpl_vars['domains'][$this->_sections['inst']['index']]['domain']; ?>
</label></li>
									<?php endfor; endif; ?>
								</ul>
							<?php endif; ?>
					</td>
					<td>
						<b>Universities:</b><Br />

						<ul class="checklist">
							<?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['universities']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<li><label for="ck_universities_<?php echo $this->_tpl_vars['universities'][$this->_sections['inst']['index']]; ?>
"><input type="checkbox"  name="universities[]"
								 <?php if (isset ( $this->_tpl_vars['filter_universities'] ) && in_array ( $this->_tpl_vars['universities'][$this->_sections['inst']['index']] , $this->_tpl_vars['filter_universities'] )): ?> checked <?php endif; ?>  value="<?php echo $this->_tpl_vars['universities'][$this->_sections['inst']['index']]; ?>
" id="ck_universities_<?php echo $this->_tpl_vars['universities'][$this->_sections['inst']['index']]; ?>
"/><?php echo $this->_tpl_vars['universities'][$this->_sections['inst']['index']]; ?>
</label></li>
							<?php endfor; endif; ?>

						</ul>

					</td>


					<td>
					 
						<b>Year of study:</b><Br />

						<ul class="checklist">
							<?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['study_years']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
								<li><label for="ck_study_years_<?php echo $this->_tpl_vars['study_years'][$this->_sections['inst']['index']]; ?>
"><input type="checkbox"  name="study_years[]"  value="<?php echo $this->_tpl_vars['study_years'][$this->_sections['inst']['index']]; ?>
" id="ck_study_years_<?php echo $this->_tpl_vars['study_years'][$this->_sections['inst']['index']]; ?>
"
								<?php if (isset ( $this->_tpl_vars['filter_study_years'] ) && in_array ( $this->_tpl_vars['study_years'][$this->_sections['inst']['index']] , $this->_tpl_vars['filter_study_years'] )): ?> checked <?php endif; ?>
								/><?php echo $this->_tpl_vars['study_years'][$this->_sections['inst']['index']]; ?>
</label></li>
							<?php endfor; endif; ?>


						</ul>

					</td>

			   </tr>


			   <tr>

			   </tr>
					<td>
					 
						<b>Group:</b><Br />
						<ul class="checklist">
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
								<li><label for="ck_groups_<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
"><input type="checkbox"  name="groups[]"  value="<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
" id="ck_groups_<?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id']; ?>
"
								<?php if (isset ( $this->_tpl_vars['filter_groups'] ) && in_array ( $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['id'] , $this->_tpl_vars['filter_groups'] )): ?> checked <?php endif; ?>
								/><?php echo $this->_tpl_vars['groups'][$this->_sections['inst']['index']]['name']; ?>
</label></li>
							<?php endfor; endif; ?>


						</ul>

					</td>
					<td valign="top">
						<b>Account status:</b><Br />
						<?php echo smarty_function_cfield(array('field' => 'account_status','name' => 'account_status','value' => $this->_tpl_vars['filter_status']), $this);?>

					</td>

			   <tr>


			   </tr>
			</table>
			<input type="submit" class="minibutton" Value="Change filters">

			<input type="button" class="minibutton bblue" value="Clear all" id="clear-filters">

		<br /><br />

		
	</div>
		</form>
		
</div>
<?php endif; ?>
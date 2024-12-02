<?php /* Smarty version 2.6.29, created on 2022-06-01 08:50:21
         compiled from profiler.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'profiler.tpl', 127, false),array('modifier', 'var_export', 'profiler.tpl', 184, false),)), $this); ?>
<?php echo '
<style type="text/css">
	#debug { clear: both; position: fixed;  bottom: 0; left: 0; right: 0; z-index: 1000; opacity: 0.85; }
	#codeigniter-profiler { position: relative; clear: both; background: #101010; padding: 0 5px; font-family: Helvetica, sans-serif; font-size: 10px !important; line-height: 12px; }
	#debug:hover { opacity: 1.0; }	
	
	.ci-profiler-box { padding: 10px; margin: 0 0 10px 0; max-height: 400px; overflow: auto; color: #fff; font-family: Monaco, \'Lucida Console\', \'Courier New\', monospace; font-size: 11px !important; }
	.ci-profiler-box h2 { font-family: Helvetica, sans-serif; font-weight: normal; }
	
	#ci-profiler-menu a:link, #ci-profiler-menu a:visited { display: inline-block; padding: 7px 0; margin: 0; color: #ccc; text-decoration: none; font-weight: lighter; cursor: pointer; text-align: center; width: 15.5%; border-bottom: 4px solid #444; }
	#ci-profiler-menu a:hover, #ci-profiler-menu a.current { background-color: #222; border-color: #999; }
	#ci-profiler-menu a span { display: block; font-weight: bold; font-size: 16px !important; line-height: 1.2; }
	
	#ci-profiler-menu-time span, #ci-profiler-benchmarks h2 { color: #B72F09; }
	#ci-profiler-menu-memory span, #ci-profiler-memory h2 { color: #953FA1; }
	#ci-profiler-menu-queries span, #ci-profiler-queries h2 { color: #3769A0; }
	#ci-profiler-menu-vars span, #ci-profiler-vars h2 { color: #D28C00; }
	#ci-profiler-menu-files span, #ci-profiler-files h2 { color: #5a8616; }
	#ci-profiler-menu-console span, #ci-profiler-console h2 { color: #5a8616; }
	
	#codeigniter-profiler table { width: 100%; }
	#codeigniter-profiler table.main td { padding: 7px 15px; text-align: left; vertical-align: top; color: #fff; border-bottom: 1px dotted #444; line-height: 1.5; background: #101010 !important; }
	#codeigniter-profiler table.main tr:hover td { background: #292929 !important; }
	#codeigniter-profiler table.main code { font-family: inherit; padding: 0; background: transparent; border: 0; color: #fff; }
	
	#codeigniter-profiler table td .hilight, #codeigniter-profiler .hilight { color: #FFFD70 !important; }
	#codeigniter-profiler table td .faded { color: #aaa !important; }
	
	#ci-profiler-menu-exit { background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2OtPlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSvX+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65WhbmrnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7uKS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg==) 0% 0% no-repeat; padding-left: 20px; position: absolute; right: 5px; top: 10px; }
</style>

<script type="text/javascript">
var ci_profiler_bar = {

	// current toolbar section thats open
	current: null,
	
	// current vars and config section open
	currentvar: null,
	
	// current config section open
	currentli: null,
	
	// toggle a toolbar section
	show : function(obj, el) {
		if (obj == ci_profiler_bar.current) {
			ci_profiler_bar.off(obj);
			ci_profiler_bar.current = null;
		} else {
			ci_profiler_bar.off(ci_profiler_bar.current);
			ci_profiler_bar.on(obj);
			ci_profiler_bar.remove_class(ci_profiler_bar.current, \'current\');
			ci_profiler_bar.current = obj;
			//ci_profiler_bar.add_class(el, \'current\');
		}
	},
	
	// turn an element on
	on : function(obj) {
		if (document.getElementById(obj) != null)
			document.getElementById(obj).style.display = \'\';
	},
	
	// turn an element off
	off : function(obj) {
		if (document.getElementById(obj) != null)
			document.getElementById(obj).style.display = \'none\';
	},
	
	// toggle an element
	toggle : function(obj) {
		if (typeof obj == \'string\')
			obj = document.getElementById(obj);
			
		if (obj)
			obj.style.display = obj.style.display == \'none\' ? \'\' : \'none\';
	},
	
	// close the toolbar
	close : function() {
		document.getElementById(\'codeigniter-profiler\').style.display = \'none\';
	},
	
	// Add class to element
	add_class : function(obj, klass) {
		alert(obj);
		document.getElementById(obj).className += " "+ klass;
	},
	
	// Remove class from element
	remove_class : function(obj, klass) {
		if (obj != undefined) {
			document.getElementById(obj).className = document.getElementById(obj).className.replace(/\\bklass\\b/, \'\');
		}
	}
};


</script>
'; ?>

<div id="debug">
<div id="codeigniter-profiler">
	
	<div id="ci-profiler-menu">
		
		<!-- Console -->
			<a href="#" id="ci-profiler-menu-console" onclick="ci_profiler_bar.show('ci-profiler-console', 'ci-profiler-menu-console'); return false;">
				<span><?php echo $this->_tpl_vars['__debug']['benchmarks']['application']['time']; ?>
 s</span>
				Console
			</a>
		
		<!-- Benchmarks -->

			<a href="#" id="ci-profiler-menu-time" onclick="ci_profiler_bar.show('ci-profiler-benchmarks', 'ci-profiler-menu-time'); return false;">
				<span>Cache & Hooks </span>
				hits, misses
			</a>
			<a href="#" id="ci-profiler-menu-memory" onclick="ci_profiler_bar.show('ci-profiler-memory', 'ci-profiler-menu-memory'); return false;">
				<span><?php echo $this->_tpl_vars['__debug']['memory']['KB']; ?>
 KB</span>
				Memory Used
			</a>

		
		<!-- Queries -->
		
			<a href="#" id="ci-profiler-menu-queries" onclick="ci_profiler_bar.show('ci-profiler-queries', 'ci-profiler-menu-queries'); return false;">
				<span><?php echo count($this->_tpl_vars['__debug']['database']); ?>
 Queries</span>
				Database
			</a>
		
		
		<!-- Vars and Config -->
			<a href="#" id="ci-profiler-menu-vars" onclick="ci_profiler_bar.show('ci-profiler-vars', 'ci-profiler-menu-vars'); return false;">
				<span>vars</span> &amp; Config
			</a>
		
		<!-- Files -->
			<a href="#" id="ci-profiler-menu-files" onclick="ci_profiler_bar.show('ci-profiler-files', 'ci-profiler-menu-files'); return false;">
				<span><?php echo count($this->_tpl_vars['__debug']['routes']); ?>
 Routes</span> paths
			</a>
		
		<a href="#" id="ci-profiler-menu-exit" onclick="ci_profiler_bar.close(); return false;" style="width: 2em"></a>
	</div>


		<div id="ci-profiler-console" class="ci-profiler-box" style="display: none">
			<h2>Benchmarks</h2>
			<table class="main" cellspacing="0">
			<?php $_from = $this->_tpl_vars['__debug']['benchmarks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
				<tr><td class="hilight" width="150"><span style='color:<?php echo $this->_tpl_vars['value']['color']; ?>
'><?php echo $this->_tpl_vars['value']['time']; ?>
</span></td><td><?php echo $this->_tpl_vars['key']; ?>
</td></tr>
			<?php endforeach; endif; unset($_from); ?>
			</table><br><br />
			<h2>Application state</h2>
			<?php echo $this->_tpl_vars['__debug']['action']; ?>

		</div>
			
	
	
		<div id="ci-profiler-memory" class="ci-profiler-box" style="display: none">
			<h2>Memory Usage</h2>		
				<table class="main">
					<tr>
						<td width="150">BYTES</td>
						<td class="hilight" ><?php echo $this->_tpl_vars['__debug']['memory']['BYTES']; ?>
</td>
					</tr>
					<tr>
						<td width="150">KILOBYTES</td>
						<td class="hilight" ><?php echo $this->_tpl_vars['__debug']['memory']['KB']; ?>
</td>
					</tr>
					<tr>
						<td width="150">MEGABYTES</td>
						<td class="hilight" ><?php echo $this->_tpl_vars['__debug']['memory']['MB']; ?>
</td>
					</tr>

				</table>
		</div>

		<div id="ci-profiler-benchmarks" class="ci-profiler-box" style="display: none">

			<h2>Caching</h2>
				
			<table class="main">
				<?php $_from = $this->_tpl_vars['__debug']['cache']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>						
					<tr><td class="hilight"><?php echo $this->_tpl_vars['key']; ?>
</td><td><?php echo var_export($this->_tpl_vars['value'], 1); ?>
</td></tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>

			<h2>Hooks</h2>
			<table class="main" cellspacing="0">
			<?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['__debug']['hooks']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<tr><td class="hilight"><span style='color:<?php echo $this->_tpl_vars['__debug']['hooks'][$this->_sections['inst']['index']]['color']; ?>
'><?php echo $this->_tpl_vars['__debug']['hooks'][$this->_sections['inst']['index']]['time']; ?>
</span></td><td><?php echo $this->_tpl_vars['__debug']['hooks'][$this->_sections['inst']['index']]['name']; ?>
 - <?php echo $this->_tpl_vars['__debug']['hooks'][$this->_sections['inst']['index']]['hook']; ?>
 - args(<?php echo $this->_tpl_vars['__debug']['hooks'][$this->_sections['inst']['index']]['args']; ?>
)</td></tr>
			<?php endfor; endif; ?>
			</table>

		</div>

	<!-- Queries -->

		<div id="ci-profiler-queries" class="ci-profiler-box" style="display: none">
			<h2>Queries</h2>
			<table class="main" cellspacing="0">
			<?php unset($this->_sections['inst']);
$this->_sections['inst']['name'] = 'inst';
$this->_sections['inst']['loop'] = is_array($_loop=$this->_tpl_vars['__debug']['database']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<tr><td class="hilight"><span style='color:<?php echo $this->_tpl_vars['__debug']['database'][$this->_sections['inst']['index']]['color']; ?>
'><?php echo $this->_tpl_vars['__debug']['database'][$this->_sections['inst']['index']]['time']; ?>
</span></td><td><?php echo $this->_tpl_vars['__debug']['database'][$this->_sections['inst']['index']]['sql']; ?>
</td></tr>
			<?php endfor; endif; ?>
			</table>
		</div>

	<!-- Vars and Config -->
		<div id="ci-profiler-vars" class="ci-profiler-box" style="display: none">
			<?php $_from = $this->_tpl_vars['__debug']['globals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['global'] => $this->_tpl_vars['vars']):
?>
				<h2><?php echo $this->_tpl_vars['global']; ?>
</h2>	
				<table class="main">
					<?php $_from = $this->_tpl_vars['vars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>						
						<tr><td class="hilight"><?php echo $this->_tpl_vars['key']; ?>
</td><td><?php if (is_scalar ( $this->_tpl_vars['value'] )): ?> <?php echo $this->_tpl_vars['value']; ?>
<?php else: ?><?php echo var_export($this->_tpl_vars['value'], 1); ?>
<?php endif; ?></td></tr>
					<?php endforeach; endif; unset($_from); ?>
				</table>
			<?php endforeach; endif; unset($_from); ?>							
		</div>		

	<!-- Files -->
		<div id="ci-profiler-files" class="ci-profiler-box" style="display: none">
			<h2>User defined routes</h2>
				
			<table class="main" >
				<?php $_from = $this->_tpl_vars['__debug']['routes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>						
					<tr><td width="150" class="hilight"><?php echo $this->_tpl_vars['key']; ?>
</td><td><?php echo $this->_tpl_vars['value']; ?>
</td></tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</div>
</div>


</div>	<!-- /codeigniter_profiler -->
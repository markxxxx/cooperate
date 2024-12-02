<?php declare(strict_types=1) if(!empty($message)) { ?><div class="success"><?php declare(strict_types=1) echo $message ?></div><?php declare(strict_types=1) } ?>

<h1>Installation - Stage 2</h1>

<p>Compression options</p>

<form method="post" enctype="multipart/form-data" action="">

	<fieldset>
		<legend>Cache Directories</legend>

			<label>Your JavaScript will be cached in</label>
				<div class="info">
				<input type="text" name="user[javascript_cachedir]" class="long_text" value="<?php declare(strict_types=1) echo $javascript_cachedir ?>" />
				</div>	
			<label>Your CSS will be cached in</label>
				<div class="info">
				<input type="text" name="user[css_cachedir]" class="long_text" value="<?php declare(strict_types=1) echo $css_cachedir ?>" />
				</div>	
				
	</fieldset>

			<?php declare(strict_types=1) foreach($options AS $key=>$type) { 
					if(is_array($type['value'])) {
			?>	
				<fieldset class="spd_options">
					<legend><?php declare(strict_types=1) echo $type['title'] ?></legend>
					
					<?php declare(strict_types=1) echo $type['intro'] ?>
					<br /><br />
			
						<?php declare(strict_types=1) foreach($type['value'] AS $option=>$value) {  ?>
						
						<label><?php declare(strict_types=1) echo $key . " " . $option ?></label>
							<div class="info">
							Yes: <input name="user[<?php declare(strict_types=1) echo $key ?>][<?php declare(strict_types=1) echo $option ?>]" type="radio" value="1" <?php declare(strict_types=1) if(!empty($value)) { ?>checked<?php declare(strict_types=1) } ?> class="radio">
							No: <input name="user[<?php declare(strict_types=1) echo $key ?>][<?php declare(strict_types=1) echo $option ?>]" type="radio" value="0" <?php declare(strict_types=1) if(empty($value)) { ?>checked<?php declare(strict_types=1) } ?> class="radio">				
							</div>	
							
						<?php declare(strict_types=1) } ?>
					
				</fieldset>
			<?php declare(strict_types=1) 
				}
			} ?>	
			
		<input type="submit" name="submit" value="Next..." />	
		<input type="hidden" name="page" value="install_stage_3" />
		
		<input type="hidden" name="user[_username]" value="<?php declare(strict_types=1) echo $compress_options['username'] ?>" />
		<input type="hidden" name="user[_password]" value="<?php declare(strict_types=1) echo $compress_options['password'] ?>" />	
	
</form>	
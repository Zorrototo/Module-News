<?php
// News Lister 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2016
// Check http://www.netartmedia.net/newslister for demos and information
// Released under the MIT license
if(!defined('IN_SCRIPT_ADMIN')) {
	global $db;
	echo '<h3>'.get_lang('no_access').'</h3>';
	$abuse_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$db->logger(get_lang('unauthorized_access').' '.$abuse_link);
}
else {
	?>
	
	<h2><?php echo get_lang('config_options');?></h2>
	<div class="news-row goback"><a href="home.php?m=news&p=admin_news" class="news-btn news-btn-default pull-right"><?php echo get_lang('go_back');?></a></div>
	
	<div class="container">
			<?php
			// Check if the file "modules/news/config.php" is writable
			$value = 'modules/news/config.php';
			if ( !is_writable($value) ) {
				echo "<h3>".$value." : <span class='failure'>".get_lang('write_permission_required')."</span> <a href=\"home.php?m=news&p=admin_news&page=permissions\">".get_lang('check_permissions')."</a></h3><br/><br/>";
			}
			
			$ini_array = parse_ini_file("modules/news/config.php",true);
			
			if(isset($_POST["proceed_save"]))
			{
				$ini_array["website"]["date_format"]=stripslashes($_POST["date_format"]);
				$ini_array["website"]["results_per_page"]=stripslashes($_POST["results_per_page"]);
				$ini_array["website"]["enable_search"]=stripslashes($_POST["enable_search"]);
				$ini_array["website"]["image_quality"]=stripslashes($_POST["image_quality"]);
				$ini_array["website"]["max_image_width"]=stripslashes($_POST["max_image_width"]);
				
				$this->write_ini_file("modules/news/config.php", $ini_array);
			}
			
			?>
			
			<div class="news-row">
				<div class="news-row">
				<br/>
				<form id="main" action="home.php?m=news&p=admin_news" method="post">
					<input type="hidden" name="page" value="settings"/>
					<input type="hidden" name="proceed_save" value="1"/>
						
						<fieldset>
							<ol>
								
								<li>
									<label><?php echo get_lang('date_format');?> (<a href="http://php.net/manual/function.date.php" title="<?php echo get_lang('help_date');?>" target="_blank"><?php echo get_lang('help');?></a>):</label>
									
									<input type="text" name="date_format" value="<?php echo $ini_array["website"]["date_format"];?>"/>
								</li>
								
								<li>
									<label><?php echo get_lang('results_per_page');?>:</label>
									
									<input type="number" name="results_per_page" value="<?php echo $ini_array["website"]["results_per_page"];?>"/>
								</li>
									
								<li>
									<label><?php echo get_lang('enable_search');?>:</label>
									
									<select name="enable_search">
										<option value="0" <?php if($ini_array["website"]["enable_search"]=="0") echo "selected";?>><?php echo get_lang('no_word');?></option>
										<option value="1" <?php if($ini_array["website"]["enable_search"]=="1") echo "selected";?>><?php echo get_lang('yes_word');?></option>
									</select>
									
								</li>
								<script>
								  function handleChange(input) {
									if (input.value < 0) input.value = 0;
									if (input.value > 100) input.value = 100;
								  }
								</script>
								<li>
									<label><?php echo get_lang('image_quality');?>:</label>
									
									<input type="number" name="image_quality" value="<?php echo $ini_array["website"]["image_quality"];?>" onchange="handleChange(this);"/>
								</li>
								<li>
									<label><?php echo get_lang('max_image_width');?>:</label>
									
									<input type="number" name="max_image_width" value="<?php echo $ini_array["website"]["max_image_width"];?>"/>
								</li>
								
							<ol>
						</fieldset>
						
						<div class="clearfix"></div>
						<br/>
						<button type="submit" class="news-btn news-btn-default pull-right"><?php echo get_lang('save');?></button>
						<br/>
						<div class="clearfix"></div>
						<br/>
					</form>
				
				</div>
				
			</div>

	</div>

<?php
}
?>
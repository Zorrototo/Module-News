<?php
// News Lister 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2016
// Check http://www.netartmedia.net/newslister for demos and information
// Released under the MIT license

if(!defined('IN_SCRIPT_ADMIN')) {
	echo '<h3>'.get_lang('no_access').'</h3>';
	//log shit here
}
else {
	?>
	
	<h2><?php echo get_lang('config_options');?></h2>
	
	<a href="home.php?m=news&p=admin_news" style="margin-top:17px" class="btn btn-default pull-right"><?php echo get_lang('go_back');?></a>
	<br/>
	
	<div class="container">

			<br/>
			<?php
			
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
			
			<div class="row">
				<div class="col-md-12">
				
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
						<button type="submit" class="btn btn-primary pull-right"><?php echo get_lang('save');?></button>
						<div class="clearfix"></div>
					</form>
				
				</div>
				
			</div>

	</div>

<?php
}
?>
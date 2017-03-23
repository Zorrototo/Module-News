<?php
// News Lister 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2016
// Check http://www.netartmedia.net/newslister for demos and information
// Released under the MIT license

if(!defined('IN_SCRIPT')) die("");

if(isset($_REQUEST["id"]) && $_REQUEST["id"]!="" && is_numeric($_REQUEST["id"]))
{
	$id=intval($_REQUEST["id"]);
	
	$listings = simplexml_load_file($this->data_file);
	
	if (isset($listings->listing[$id]))
		{
		?>
		
		<h2><?php echo strip_tags(html_entity_decode($listings->listing[$id]->title));?></h2>
		
		<div class="row">
			<?php
		
			
			
			
			if($listings->listing[$id]->images=="")
			{
				?>
				<div class="col-md-12">
				<?php
			}
			else
			{
				?>
				<div class="col-md-8">
				<?php
				
			}
			
			?>
					<br>
				<?php 
					require_once('modules/news/include/library/HTMLPurifier.auto.php');
					$purificateur = new HTMLPurifier();
					echo $purificateur->purify($listings->listing[$id]->description);
					?>

			</div>
			<?php
			if($listings->listing[$id]->images!="")
			{
				/// showing the listing images
				?>
				<div class="col-md-4">
					<br><?php
						$images=explode(",",trim($listings->listing[$id]->images,","));
						
						if(file_exists("modules/news/uploaded_images/".$images[0].".jpg"))
						{							
							echo "<a href=\"modules/news/uploaded_images/".$images[0].".jpg\" rel=\"prettyPhoto[ad_gal]\">";
							echo "<img src=\"modules/news/uploaded_images/".$images[0].".jpg\" alt=\"".strip_tags(html_entity_decode($listings->listing[$id]->title))."\" class=\"final-image\"/>";
							echo "</a>";
						}
						?>
						
						<br/><br/>
						<?php
							
						for($i=1;$i<sizeof($images);$i++)
						{
							if(trim($images[$i])=="") continue;
							
							if($i!=0)
							{
								echo "<a href=\"modules/news/uploaded_images/".$images[$i].".jpg\" rel=\"prettyPhoto[ad_gal]\">";
							}
							echo "<img src=\"modules/news/thumbnails/".$images[$i].".jpg\" width=\"85\" alt=\"\"/>";
							if($i!=0)
							{
								echo "</a>";
							}
						}
						?>
						<link rel="stylesheet" href="modules/news/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
						<script src="modules/news/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
						<script type="text/javascript" charset="utf-8">
						$(document).ready(function()
						{
							$("a[rel='prettyPhoto[ad_gal]']").prettyPhoto({

							});
						});
						</script>
				
				</div>
				<?php
				/// end showing the listing images
			}
			?>



		</div>
		
		<div class="clearfix"></div>
		
		<br/>
		<div class="pull-left">
			<br><strong><?php echo date($this->settings["website"]["date_format"],intval($listings->listing[$id]->time));?></strong> - <?php echo get_lang('written_by');?>: <strong><?php echo strip_tags(html_entity_decode(stripslashes($listings->listing[$id]->written_by)));?></strong>
		</div>
	
		<div class="pull-right">
			<a id="go_back_button" class="btn btn-default pull-right" href="<?php if (!empty($_SESSION['user_id'])) {echo "home";} else {echo "index";}?>.php?m=news&p=news"><?php echo get_lang('go_back');?></a>
		</div>
		
		</div>
		
		<?php
		} else {
			echo "<h2>".get_lang('latest_news')."</h2><br><h3><span class='failure'>".get_lang('ID_invalid')."</span></h3>";
		}
}
else
{
	echo "<h2>".get_lang('latest_news')."</h2><br><h3><span class='failure'>".get_lang('ID_not_set')."</span></h3>";
}
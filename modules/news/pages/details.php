<?php
// News Lister 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2016
// Check http://www.netartmedia.net/newslister for demos and information
// Released under the MIT license
?><?php
if(!defined('IN_SCRIPT')) die("");

if(isset($_REQUEST["id"]))
{
	$id=intval($_REQUEST["id"]);
	$this->ms_i($id);
}
else
{
	die("The listing ID isn't set.");
}

$listings = simplexml_load_file($this->data_file);

?>

		<h2><?php echo $listings->listing[$id]->title;?></h2>
		<div class="pull-right">
		<?php echo date($this->settings["website"]["date_format"],intval($listings->listing[$id]->time));?>
		</div>
		<?php
		$this->Title($listings->listing[$id]->title);
		$this->MetaDescription($listings->listing[$id]->description);
		?>
		<hr/>
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
				<div class="col-md-7">
				<?php
				
			}
			
			?>
				
				<?php echo html_entity_decode($listings->listing[$id]->description);?>
				
			</div>
			<?php
			if($listings->listing[$id]->images!="")
			{
				/// showing the listing images
				?>
				<div class="col-md-5">
					<?php
						$images=explode(",",trim($listings->listing[$id]->images,","));
						
						if(file_exists("modules/news/uploaded_images/".$images[0].".jpg"))
						{							
							echo "<a href=\"modules/news/uploaded_images/".$images[0].".jpg\" rel=\"prettyPhoto[ad_gal]\">";
							echo "<img src=\"modules/news/uploaded_images/".$images[0].".jpg\" alt=\"".$listings->listing[$id]->title."\" class=\"final-image\"/>";
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
							echo "<img src=\"modules/news/thumbnails/".$images[$i].".jpg\" width=\"78\" alt=\"\"/>";
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
		
		<!--Google Maps-->
		<?php
		if($listings->listing[$id]->latitude!=""&&$listings->listing[$id]->latitude!="0"&&$listings->listing[$id]->latitude!="0.00"&&$listings->listing[$id]->longitude!=""&&$listings->listing[$id]->longitude!="0"&&$listings->listing[$id]->longitude!="0.00")
		{
		?>
							
			<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
			<script type="text/javascript">
			  function initMap() 
			  {
				var Latlng = new google.maps.LatLng(<?php echo $listings->listing[$id]->latitude;?>,<?php echo $listings->listing[$id]->longitude;?>);

				var mapDiv = document.getElementById('map');
				var map = new google.maps.Map(mapDiv, {
				  center: {lat: <?php echo $listings->listing[$id]->latitude;?>, lng: <?php echo $listings->listing[$id]->longitude;?>},
				  zoom: 15
				});
				var Marker = new google.maps.Marker({
					position: Latlng,
					map:Map,
					title:""
				});

				Marker.setMap(map);
				
			  }
			</script>

			<br/>
			<div id="map" style="width: 100%; height: 300px"></div>
			<br/>
				
		<?php
		}
	
		if($listings->listing[$id]->address!="")
		{
			echo stripslashes($listings->listing[$id]->address)."<br/><br/>";
		}
		?>

		<!--end Google Maps-->

		<br/>
		<div class="pull-left">
			<?php echo $this->texts["written_by"];?>: 
			<strong><?php echo stripslashes($listings->listing[$id]->written_by);?></strong>
		
		</div>
	
		<div class="pull-right">
			<a id="go_back_button" class="btn btn-default pull-right" href="<?php if (!empty($_SESSION['user_id'])) {echo "home";} else {echo "index";}?>.php?m=news&p=news"><?php echo $this->texts["go_back"];?></a>
		</div>
		
		</div>
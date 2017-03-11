<?php
// News Lister
// http://www.netartmedia.net/newslister
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license

if(!defined('IN_SCRIPT')) die("");
if (!empty($_SESSION['user_id'])) {$homex="home";} else {$homex="index";}?>

<h2>
	<?php
	if(isset($_REQUEST["keyword_search"]))
	{
		echo $this->texts["search_results"];
	}
	else
	{
		echo $this->texts["our_ads"];
	}
	?>
</h2>

<div class="clearfix"></div>		
		

<hr class="no-margin"/>
<br/>
<script src="js/results.js"></script>

	<div class="clearfix"></div>
	<div class="results-container">		
	
	<?php	
	$PageSize = intval($this->settings["website"]["results_per_page"]);
	
	if(!isset($_REQUEST["num"]))
	{
		$num=1;
	}
	else
	{
		$num=$_REQUEST["num"];
		$this->ms_i($num);
	}
	
	$listings = simplexml_load_file($this->data_file);

	//reversing the array with the news to show the latest first
	$xml_results = array();
	foreach ($listings->listing as $xml_element) $xml_results[] = $xml_element;
	$xml_results = array_reverse($xml_results); 
	//end reversing the order of the array
 
 	$iTotResults = 0;
	$listing_counter=sizeof($xml_results); 
	
	foreach ($xml_results as $listing)
	{
		$listing_counter--; 
  
		//refine search
		if(isset($_REQUEST["only_picture"])&&$_REQUEST["only_picture"]==1)
		{
			if(trim($listing->images)=="") continue;
		}	

		if(isset($_REQUEST["keyword_search"])&&trim($_REQUEST["keyword_search"])!="")
		{
			if
			(
				stripos($listing->title, $_REQUEST["keyword_search"])===false
				&&
				stripos($listing->description, $_REQUEST["keyword_search"])===false
			)
			{
				continue;
			}
		}
		//end refine search
		
		
		if($iTotResults>=($num-1)*$PageSize&&$iTotResults<$num*$PageSize)
		{
		
			$images=explode(",",$listing->images);
			
			if($this->settings["website"]["seo_urls"]==1)
			{
				$strLink = "news-".$this->format_str(strip_tags(stripslashes($listing->title)))."-".$listing_counter.".html";
			}
			else
			{
				$strLink = $homex.".php?m=news&p=news&page=details&id=".$listing_counter;
			}
			?>
			
		<div class="panel panel-default search-result">
				<div class="panel-heading">
					<h3 class="panel-title">
						
						<a href="<?php echo $strLink;?>" class="search-result-title"><?php echo strip_tags(html_entity_decode($listing->title));?></a>
						
					</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							<a href="<?php echo $strLink;?>" class="btn-block result-details-link"><img alt="<?php echo strip_tags(html_entity_decode($listing->title));?>" class="img-responsive img-res" src="<?php if($images[0]==""||!file_exists("modules/news/thumbnails/".$images[0].".jpg")) echo "modules/news/images/no_pic.gif";else echo "modules/news/thumbnails/".$images[0].".jpg";?>"/></a>
						</div>
						<div class="col-sm-8 col-xs-12">
							<div class="details">
								
								<p class="description">
									<?php
									require_once('modules/news/include/library/HTMLPurifier.auto.php');
									$purificateur = new HTMLPurifier();
									echo $purificateur->purify($this->text_words($listing->description,80));?>
								</p>
								
							
								
								<span class="is_r_featured"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
						
						</div>
						<div class="col-xs-6">
							<div class="text-right">
								<a href="<?php echo $strLink;?>" class="btn btn-primary"><?php echo $this->texts["details"];?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
				
			
		}
			
		$iTotResults++;
	}
	?>
	</div>
	<div class="clearfix"></div>	
	<?php
	$strSearchString = "";
			
	foreach ($_POST as $key=>$value) 
	{ 
		if($key != "num"&&$value!="")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
	
	foreach ($_GET as $key=>$value) 
	{ 
		if($key != "num"&&$value!="")
		{
			$strSearchString .= $key."=".$value."&";
		}
	}
		
		
	if(ceil($iTotResults/$PageSize) > 1)
	{
		echo '<ul class="pagination">';
		
	
		
		$inCounter = 0;
		
		if($num > 2)
		{
			echo "<li><a class=\"pagination-link\" href=\"".$homex.".php?".$strSearchString."num=1\"> << </a></li>";
			
			echo "<li><a class=\"pagination-link\" href=\"".$homex.".php?".$strSearchString."num=".($num-1)."\"> < </a></li>";
		}
		
		$iStartNumber = $num-2;
		
	
		if($iStartNumber < 1)
		{
			$iStartNumber = 1;
		}
		
		for($i= $iStartNumber ;$i<=ceil($iTotResults/$PageSize);$i++)
		{
			if($inCounter>=5)
			{
				break;
			}
			
			if($i == $num)
			{
				echo "<li><a><b>".$i."</b></a></li>";
			}
			else
			{
				echo "<li><a class=\"pagination-link\" href=\"".$homex.".php?".$strSearchString."num=".$i."\">".$i."</a></li>";
			}
							
			
			$inCounter++;
		}
		
		if(($num+1)<ceil($iTotResults/$PageSize))
		{
			echo "<li><a href=\"".$homex.".php?".$strSearchString."num=".($num+1)."\"> ></b></a></li>";
			
			echo "<li><a href=\"".$homex.".php?".$strSearchString."num=".(ceil($iTotResults/$PageSize))."\"> >> </a></li>";
		}
		
		echo '</ul>';
	}
	
	
	
	
	if($iTotResults==0)
	{
		?>
		<i><?php echo $this->texts["no_results"];?></i>
		<?php
	}
	?>

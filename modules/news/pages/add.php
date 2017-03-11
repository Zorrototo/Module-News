<?php
// News Lister, http://www.netartmedia.net/newslister
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license
?><?php
if(!defined('IN_SCRIPT')) die("");


?>
	<h2><?php echo $this->texts["add_new_listing"];?></h2>
	<a href="home.php?m=news&p=admin_news" style="margin-top:17px" class="btn btn-default pull-right"><?php echo $this->texts["go_back"];?></a>
	<br/>
	<div class="container">
		<br/><br/>
			<?php
			$show_add_form=true;
			
			class SimpleXMLExtended extends SimpleXMLElement 
			{
			  public function addChildWithCDATA($name, $value = NULL) {
				$new_child = $this->addChild($name);

				if ($new_child !== NULL) {
				  $node = dom_import_simplexml($new_child);
				  $no   = $node->ownerDocument;
				  $node->appendChild($no->createCDATASection($value));
				}

				return $new_child;
			  }
			}

			if(isset($_REQUEST["proceed_save"]))
			{
				///images processing
				$str_images_list = "";
				$limit_pictures=25;
				$path="modules/news/";
				$ini_array = parse_ini_file("modules/news/config.php",true);
				$image_quality=$ini_array["website"]["image_quality"];
				$max_image_width=$ini_array["website"]["max_image_width"];
				
				include("modules/news/include/images_processing.php");
				///end images processing
				$listings = simplexml_load_file($this->data_file,'SimpleXMLExtended', LIBXML_NOCDATA);
				$listing = $listings->addChild('listing');
				$listing->addChild('time', time());
				$listing->addChild('title', stripslashes($_POST["title"]));
				$article_content=stripslashes($_POST["description"]);
				$article_content=str_replace("&nbsp;"," ",$article_content);
				
				$listing->addChildWithCDATA('description', $article_content);
				$listing->addChild('images', $str_images_list);
				$listing->addChild('written_by', stripslashes($_POST["written_by"]));
				$listing->addChild('latitude', stripslashes($_POST["latitude"]));
				$listing->addChild('longitude', stripslashes($_POST["longitude"]));
				$listing->addChild('address', stripslashes($_POST["address"]));
				$listings->asXML($this->data_file); 
				?>
				<h3><?php echo $this->texts["new_added_success"];?></h3>
				<br/>
				<a href="home.php?m=news&p=admin_news&page=add" class="underline-link"><?php echo $this->texts["add_another"];?></a>
				<?php echo $this->texts["or_message"];?>
				<a href="home.php?m=news&p=admin_news&page=home" class="underline-link"><?php echo $this->texts["manage_listings"];?></a>
				<br/>
				<br/>
				<br/>
				<?php
				$show_add_form=false;
			}	
			
			

			if($show_add_form)
			{
			?>
			
			
					<br/>
				
					<script src="modules/news/js/nicEdit.js" type="text/javascript"></script>
					<script type="text/javascript">
					bkLib.onDomLoaded(function() {
						new nicEditor({fullPanel : true,iconsPath : 'modules/news/js/nicEditorIcons.gif'}).panelInstance('description');
					});
					</script>
					<style>
					.nicEdit-main{ background-color: white;}
					.nicEdit-selected { border-style:none !important;}
					*{outline-width: 0;}
					</style>
					<form  action="home.php?m=news&p=admin_news" method="post"   enctype="multipart/form-data">
					<input type="hidden" name="page" value="add"/>
					<input type="hidden" name="proceed_save" value="1"/>
				
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["title"];?>:
						</div>
						<div class="col-md-10">
									<input class="form-control" type="text" name="title" required value=""/>
						</div>
					</div>
					<br/>
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["description"];?>:
						</div>
						<div class="col-md-10">
							
							

							<textarea class="form-control" id="description" name="description" cols="40" rows="10" style="width:100%;height:100%"></textarea>
							
						</div>
					</div>		
					
					<br/>
					
					<div class="row">
						<div class="col-md-2">			
							<?php echo $this->texts["images"];?>:
						</div>
						<div class="col-md-10">		
						<?php if (extension_loaded('gd')) { ?>
							<!--images upload-->
							<script src="modules/news/js/jquery.uploadfile.js"></script>

							
								<div id="mulitplefileuploader"><?php echo $this->texts["please_select"];?></div>
								
								
								<div id="status"><i>
									
								</i>
								
								</div>
								<script>
								var uploaded_files="";
								$(document).ready(function()
								{
								var settings = {
									url: "modules/news/upload.php",
									dragDrop:true,
									fileName: "myfile",
									maxFileCount:25,
									allowedTypes:"jpg,png,gif",	
									returnType:"json",
									 onSuccess:function(files,data,xhr)
									{
										if(uploaded_files!="") uploaded_files+=",";
										uploaded_files+=data;
										
									},
									afterUploadAll:function()
									{
										var preview_code="";
										var imgs = uploaded_files.split(",")
										for (var i = 0; i < imgs.length; i++)
										{
											preview_code+='<div class="img-wrap"><img width="120" src="modules/news/uploads/'+imgs[i]+'"/></div>';
										}
										
										document.getElementById("status").innerHTML=preview_code;
										document.getElementById("list_images").value=uploaded_files;
									},
									showDelete:false,
									
									showProgress:true,
									showFileCounter:false,
									showDone:false
								}
								
								

								var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


								});
								</script>
										
							<!--end images upload-->
							<?php
							}else{
								echo "GD extension is NOT loaded on your server. Images upload disabled.<br/>";
								}
							?>
						</div>
					</div>
					
					<br/>
					<div class="row">
						<div class="col-md-2">
							<?php echo $this->texts["written_by"];?>:
						</div>
						<div class="col-md-10">
							<input class="form-control" type="text" name="written_by" required value=""/>
						</div>
					</div>				
									
										
					<input type="hidden" name="list_images" value="<?php if(isset($_POST["list_images"])) echo $_POST["list_images"];?>" id="list_images"/>
				
					<div class="clearfix"></div>
			
						
				<div class="clearfix"></div>
				<br/>
				<button type="submit" class="btn btn-primary pull-right"> <?php echo $this->texts["submit"];?> </button>
				<div class="clearfix"></div>
			</form>
				
			
			<?php
			}
			?>
	</div>
	
	<style>
	textarea{background:white !important}
	</style>
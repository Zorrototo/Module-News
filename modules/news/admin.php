<?php
function exec_ogp_module() {
	define("IN_SCRIPT_ADMIN","1");
	error_reporting(0);

	include("modules/news/include/SiteManager.class.php");
	$website = new SiteManager();
	$website->SetDataFile("modules/news/data/listings.xml");
	$website->LoadSettings();

	$website->LoadTemplate();

	if(isset($_REQUEST["page"]))
	{
		$website->check_word($_REQUEST["page"]);
		$website->SetPage($_REQUEST["page"]);
	}
	else
	{
		$website->SetPage("home");
	}

	$website->Render();

}
?>
<?php
function exec_ogp_module() {
	define("IN_SCRIPT","1");
	error_reporting(0);

	require("modules/news/include/SiteManager.class.php");
	$website = new SiteManager();
	$website->SetDataFile("modules/news/data/listings.xml");
	$website->LoadSettings();

	$website->LoadTemplate();

	if(isset($_REQUEST["page"]))
	{
		$website->check_word($_REQUEST["page"]);
		$website->SetPage($_REQUEST["page"]);
	}

	$website->Render();

}
?>
<?php

 /**
 * Example Application

 * @package Example-application
 */
require_once('includes/engine.php');
if (!$cms->logged_in()) {
	$smarty->display('login.tpl');
} else {
//	$home_timeline = $twitteroauth->get('statuses/home_timeline');  
//print_r($home_timeline); 
	$smarty->display('index.tpl');
}
?>

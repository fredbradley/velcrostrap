<?php

 /**
 * Example Application

 * @package Example-application
 */
require_once('includes/engine.php');
if (!$cms->logged_in()) {
	$smarty->display('login.tpl');
} elseif (empty($user->email)) {
	header("Location: ./updateprofile.php");
} else {
//	$home_timeline = $twitteroauth->get('statuses/home_timeline');  
//print_r($home_timeline);
	if ($_POST) {
		$cms->saveGuess($_POST['guess'], $user->id);
	}
	$smarty->display('index.tpl');
}
?>

<?php

 /**
 * Example Application

 * @package Example-application
 */
require_once('includes/engine.php');
if (!$cms->logged_in()) {
	$smarty->display('login.tpl');
} else {
	$smarty->assign("userdetails", $user);
//var_dump($user);

	$smarty->display('updateprofile.tpl');
}
?>

<?php

 /**
 * Example Application

 * @package Example-application
 */
require_once($SITE_PATH.'includes/engine.php');
if (!$cms->logged_in()) {
	$smarty->display('login.tpl');
} else {
//	$smarty->assign("userdetails", $user);
	if ($_POST) {
		$update = $cms->updateProfile();
//		if ($update) {
			$message = $cms->message("success", "Thanks, that is now updated!");
			$smarty->assign("message", $message);
//		}
	}
                $smarty->assign("userdetails", $user);
//var_dump($user);

	$smarty->display('updateprofile.tpl');
}
?>

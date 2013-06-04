<?php
echo dirname(__FILE__);

exit();

 /**
 * Example Application

 * @package Example-application
 */
require_once('includes/engine.php');
$smarty->display('index.tpl');

?>

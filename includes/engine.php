<?php
 /**
 * The Engine
 * ***************
 * Author: Fred Bradley <hello@fredbradley.co.uk>
 * Project: VelcroStrap
 * Copyright: All Rights Resevered
 *
 * Description: This file is called at the top of every PHP file.
   It loads the database, SMARTY, and some general site generic configs.
 *
 * Note: The 'language file' as such, is stored on the database in `site_configs`
 */

$session_name = "offthewall"; // Must be all one word, lower case, with no spaces or special characters!

// SETTINGS
$host = $_SERVER['SERVER_NAME'];
if ($host == "offthewall.fredb.me") {
        $SITE_PATH = dirname(__FILE__)."/";
} else {
        $SITE_PATH = dirname(__FILE__)."/";
}

$pathtoclass = $SITE_PATH."includes/cms.class.php";

// DO NOT EDIT BELOW THIS LINE
/**********************************************************************************/
session_name($session_name);
session_start();
date_default_timezone_set('Europe/London');


// Set up the database, and load the CMS Class
require_once($SITE_PATH.'includes/db.inc.php');
require_once($pathtoclass);
$cms = new CMS;

// Include the PHPMailer script
require_once($SITE_PATH."/includes/PHPMailer/class.phpmailer.php");
$mail = new PHPMailer(); // defaults to using php "mail()"
$mail->IsSendmail(); // telling the class to use SendMail transport


// Now the database is loaded, lets download the site config from the database!
$siteconfigs = $cms->getSettings();
foreach($siteconfigs as $site_config)
{
        // Define all the settings so you can use them in PHP
        // This is instead of having a language file!
        define($site_config->name, $site_config->value);
}
define("FULL_PATH_TO_SMARTY", $SITE_PATH.PATH_TO_SMARTY);
// Get Smarty Class, then load
// ("PATH_TO_SMARTY" is called from the database above)
require(FULL_PATH_TO_SMARTY);
$smarty = new Smarty;

// Set the folders for Smarty Config
$smarty->setTemplateDir($SITE_PATH.'templates');
$smarty->setCompileDir($SITE_PATH.'templates_c');
$smarty->setCacheDir($SITE_PATH.'cache');
$smarty->setConfigDir($SITE_PATH.'configs');

// Do Smarty Settings, based from results database
$smarty->force_compile = intval(FORCE_COMPILE);
$smarty->debugging = intval(DEBUGGING);
$smarty->caching = intval(CACHING);
$smarty->cache_lifetime = intval(CACHE_LIFETIME);


// Set Site-Wide Smarty Assigns
$smarty->assign("SESH", $_SESSION);
?>

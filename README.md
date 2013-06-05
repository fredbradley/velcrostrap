VelcroStrap
=========

VelcroStrap is a basic 'Bootstrap-style' collection of files that comprise of a Smarty installation, and a basic template which is Bootstrap. Plus a collection of other useful scripts that help to easily knock up a basic site in no time. Developed for my own personal use. If it helps you feel free to download it, and let me know. 

  - Author: Fred Bradley
  - Author Website: http://www.fredbradley.co.uk
  - Author Email: hello@fredbradley.co.uk

Version
-

1.0

Folder Structure
-----------
 - / - the root folder
 - /templates_c/ - Where Cached Templates are stored. Should be set to CHMOD 777
 - /cache/ - Should be set to CHMOD 777
 - /templates/ - Templates are stored here as *.tpl files
 - /configs/ - Not really used in this installation, but recommended in the Smarty install guides.
 - /includes/cms.class.php - Written by Fred Bradley - class that controls most functions
 - /includes/db.in.php - The Database include file. See more details below
 - /includes/engine.php - This is the one file that includes everything else. This file must be required by all accessible *.php files.
 - /includes/PHPMailer - A simple PHPMailer folder to help with Mail Functions
 - /Smarty/ - The Smarty install libs
 - /plugins/ - Default local plugins frolder from Smarty


db.inc.php
-----------
    define('DBHOST', '');   // Database Host
    define('DBUSER', '');   // Database User
    define('DBPASS', '');   // Database Password
    define('DBNAME', '');   // Database Name
    define('DBPREFIX', ''); // Prefix on the tables (like `wp_`)


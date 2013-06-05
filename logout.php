<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */
 
/* Load and clear sessions */
require_once('includes/engine.php');
session_destroy();
 
/* Redirect to page with the connect to Twitter option. */
header('Location: ./index.php');

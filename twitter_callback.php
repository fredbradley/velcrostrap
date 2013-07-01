<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */
require_once('includes/engine.php');

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
    // We've got everything we need  
    // TwitterOAuth instance, with two new parameters we got in twitter_login.php  
	$twitteroauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
	// Let's request the access token  
	$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
	// Save it in a session var 
	$_SESSION['access_token'] = $access_token; 
	// Let's get the user's info 
	$user_info = $twitteroauth->get('account/verify_credentials'); 
	// Print user's info  
	
	if(isset($user_info->error)){
		// Something's wrong, go back to square 1  
		header('Location: ./twitter_login.php'); 
	} else { 
		// Let's find the user by its ID  
		$cms->saveOAuthDetails($user_info, $access_token);
		header('Location: ./index.php');  
	}
} else {  
    // Something's missing, go back to square 1  
    header('Location: ./twitter_login.php');  
} 

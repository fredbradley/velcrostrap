<!-- BEGIN TEMPLATE: HEADER -->
<!DOCTYPE html>
<html>
	<head>
		<title>{$title}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="{$URI}/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="{$URI}/assets/css/style.css" rel="stylesheet">
		<link href="{$URI}/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
	<header>
		{if {$logged_in}==true}
		{$USERNAME} - <a href="./logout.php">Log Out</a>
		{else}
		You are not logged in				<a href="twitter_login.php"><img src="./assets/img/sign-in-with-twitter-gray.png" alt="Sign in with Twitter"/></a>

		{/if}		<a href="https://twitter.com/share" class="twitter-share-button" data-size="large">Tweet</a>
	</header>
<!-- END TEMPLATE: HEADER -->
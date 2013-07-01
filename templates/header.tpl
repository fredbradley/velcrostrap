<!-- BEGIN TEMPLATE: HEADER -->
<!DOCTYPE html>
<html>
	<head>
		<title>{$title}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="{$URI}/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="{$URI}/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
				<link href="{$URI}/assets/css/style.css" rel="stylesheet">

	</head>
	<body>
		<div id="wrap">
		<!-- Fixed navbar -->
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="brand" href="#">Project name</a>
						<div class="nav-collapse collapse">
							<ul class="nav pull-right">
								<li {if {$smarty.server.SCRIPT_NAME}=="/smarty/index.php"}class="active"{/if}><a href="./index.php">Home</a></li>
								<li {if {$smarty.server.SCRIPT_NAME}=="/smarty/updateprofile.php"}class="active"{/if}><a href="./updateprofile.php">Update Profile</a></li>
								{if {$logged_in}}<li><a href="./logout.php" title="Logout">Logout</a></li>{else}
								<li><a href="./twitter_login.php" class="twitter-button"><img src="./assets/img/sign-in-with-twitter-gray.png" alt="Sign in with Twitter"/></a></li>
								{/if}
							
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div> <!-- // End: .navbar -->
      
			<div class="spacer"></div>
			<!-- Begin page content -->
			<div class="container">
				<div class="page-header clearfix">
					<h1>Sticky footer with fixed navbar</h1>
				</div>
				<p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS. A fixed navbar has been added within <code>#wrap</code> with <code>padding-top: 60px;</code> on the <code>.container</code>.</p>
				<p>Back to <a href="./sticky-footer.html">the sticky footer</a> minus the navbar.</p>
			</div>
<!-- END TEMPLATE: HEADER -->
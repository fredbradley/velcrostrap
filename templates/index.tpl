{config_load file="test.conf" section="setup"}
{include file="header.tpl" title="Welcome!"}
	<div class="container">

			<form class="form-signin" method="post">
				<h2 class="form-signin-heading">Guess The Royal Baby's Name</h2>
				<input type="text" name="guess" class="input-block-level" placeholder="Email address">
				<button class="btn btn-large btn-primary" type="submit">Guess</button>
			</form>

		</div> <!-- /container -->
{include file="footer.tpl"}

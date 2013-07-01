{config_load file="test.conf" section="setup"}
{include file="header.tpl" title="Welcome!"}
	<div class="container">
		<form class="form-signin" method="post">
			<input type="hidden" name="userid" value="{$userdetails->id}" />
			<h2 class="form-signin-heading">Update Profile Details</h2>
			<label for="username">Username</label>
			<input type="text" name="username" class="input-block-level" value="{$userdetails->username}" readonly="readonly" />
			<label for="email">Email</label>
			<input type="email" name="email" class="input-block-level" required="required" value="{$userdetails->email}" />
			<button class="btn btn-large btn-primary" type="submit">Guess</button>
		</form>
	</div> <!-- /container -->
{include file="footer.tpl"}

{config_load file="test.conf" section="setup"}
{include file="header.tpl" title="Welcome!"}
	<div class="container">
		<div class="row">
			<div class="span12">
			test
			</div>
		</div>
		<div class="row">
			<div class="span6">
				Test again
			</div>
			<div class="span6">
				Last one
			</div>
		</div>
			<form class="form-signin" method="post">
				<h2 class="form-signin-heading">Update Profile Details</h2>
				<label for="username">Username</label>
				<input type="text" name="username" class="input-block-level" value="{$userdetails->username}" readonly="readonly" />
				<button class="btn btn-large btn-primary" type="submit">Guess</button>
			</form>
			<form class="form-signin" method="post">
				<h2 class="form-signin-heading">Update Profile Details</h2>
				<label for="username">Username</label>
				<input type="text" name="username" class="input-block-level" value="{$userdetails->username}" readonly="readonly" />
				<button class="btn btn-large btn-primary" type="submit">Guess</button>
			</form>
			<form class="form-signin" method="post">
				<h2 class="form-signin-heading">Update Profile Details</h2>
				<label for="username">Username</label>
				<input type="text" name="username" class="input-block-level" value="{$userdetails->username}" readonly="readonly" />
				<button class="btn btn-large btn-primary" type="submit">Guess</button>
			</form>
			<form class="form-signin" method="post">
				<h2 class="form-signin-heading">Update Profile Details</h2>
				<label for="username">Username</label>
				<input type="text" name="username" class="input-block-level" value="{$userdetails->username}" readonly="readonly" />
				<button class="btn btn-large btn-primary" type="submit">Guess</button>
			</form>
	
		</div> <!-- /container -->
{include file="footer.tpl"}

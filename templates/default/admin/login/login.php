<?php require 'header.php' ?>
<body class="login-bg">
<div class="container">
	<div class="row">
		<h1 align="center"><img src="<?=$this->url['assets_url']?>/images/logo.png" width="300"/></h1>
		<div class="col-sm-4"></div>
		<div class="col-sm-4 login-container">
			<h3 align="center">Manager</h3>
			<?php
			if (isset($this->validation->errors)) {
				foreach ($this->validation->errors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
			}
			if (isset($this->message)) {
				echo '<div class="alert alert-danger">' . $this->message . '</div>';
			}
			?>
			<form action="" method="post" enctype="application/x-www-form-urlencoded" id="login">
				<input type="hidden" name="token" value="<?=generateToken()?>" id="token">

				<div class="mb-3">
					<label for="email">Email</label>
					<input type="email" name="email" value="<?=stripField('email')?>" id="email" class="form-control normal"
					       placeholder="Enter your email"/>
				</div>
				<div class="mb-3">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control normal"
					       placeholder="Enter your password"/>
				</div>
				<div class="mb-3">
					<button class="btn btn-primary" name="submit"><i class="fa fa-lock" style="margin-right:10px;"></i> Login</button>
				</div>
			</form>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>

<?php require 'footer.php' ?>

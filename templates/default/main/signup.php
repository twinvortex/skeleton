<?php require 'header.php' ?>
<body class="login-bg">
<div class="container">
	<div class="row">
		<h1 align="center"><a href="<?=$this->url['main_url']?>"><img src="<?=$this->url['assets_url']?>/images/logo.png" width="300"/></a></h1>
		<div class="col-md-4"></div>
		<div class="col-md-4 login-container">
			<h3 align="center">Create your account</h3>
			<?php
			if(isset($this->validation->errors)) {
				foreach($this->validation->errors as $error) {
					echo '<div class="alert alert-danger">'.$error.'</div>';
				}
			}

			if(isset($this->message)) {
				$_POST = null;
				echo '<div class="alert alert-success">'.$this->message.'</div>';
			}
			?>
			<form action="" method="post" enctype="application/x-www-form-urlencoded" id="signup">
				<input type="hidden" name="token" value="<?=generateToken()?>">
				<div class="mb-3">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" class="form-control normal" placeholder="Enter your email" value="<?=stripField('email')?>"/>
				</div>
				<div class="mb-3">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control normal" placeholder="Enter your password"/>
				</div>
				<div class="mb-3">
					<label for="confirmPassword">Confirm Password</label>
					<input type="password" name="confirm_password" id="confirmPassword" class="form-control normal" placeholder="Confirm your password"/>
				</div>
				<div class="mb-3">
					<button class="btn btn-primary" name="submit"><i class="fa fa-user-plus" style="margin-right:10px;"></i> Sign Up</button>
				</div>
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>

<?php require 'footer.php' ?>

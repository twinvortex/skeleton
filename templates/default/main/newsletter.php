<?php require 'header.php' ?>
<body>
<div class="container">
	<h1 align="center"><a href="<?=$this->url['main_url']?>"><img src="<?=$this->url['assets_url']?>/images/logo.png" width="300"/></a></h1>
	<h3  align="center">Join our newsletter and <br>get notified when we launch</h3>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
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
			<form action="" method="post" enctype="application/x-www-form-urlencoded">
				<div class="mb-3">
					<label for="email">Email</label>
					<input type="hidden" name="token" value="<?=generateToken()?>">
					<div align="center" style="margin-bottom: 20px;"><input type="email" name="email" id="email" class="form-control normal" placeholder="Enter your email" value="<?=stripField('email')?>"/></div>
				</div>
				<div class="mb-3">
					<label for="name">Name</label>
					<div align="center"><input type="text" name="name" value="<?=stripField('name')?>" id="name" class="form-control normal" placeholder="Enter your name"></div>
				</div>
				<div align="center"><input type="submit" name="submit" class="btn btn-primary" value="Subscribe" style="text-align: center"></div>
			</form>
		</div>
		<div class="col-sm-4"></div>
	</div>
	<div class="space"></div>
	<div class="col-sm-12" align="center">
		<h3>What is CometGrid?</h3>
		<p style="font-size: 20px;">CometGrid is an extremly fast web application hosting service using <strong>HHVM</strong> or <strong>PHP with opcache</strong>,
			<strong>NGINX</strong> and <strong>Google PageSpeed Module</strong> for top speeds.</p>
		<p>
			<img src="<?=$this->url['assets_url']?>/images/logos/nginx.png" style="margin-top:55px;margin-right:30px;" alt="nginx server hosting">
			<img src="<?=$this->url['assets_url']?>/images/logos/hhvm.png" style="margin-top:55px;margin-right:30px;" alt="hhvm server hosting">
			<img src="<?=$this->url['assets_url']?>/images/logos/phpmysql.png" style="margin-top:55px;margin-right:30px;" alt="php and mysql server hosting">
			<img src="<?=$this->url['assets_url']?>/images/logos/ubuntu.png" style="margin-top:40px" alt="ubuntu server hosting">
		</p>

	</div>
</div>

<?php require 'footer.php' ?>

<?php require 'header.php'; ?>
<?php require 'top-bar.php'; ?>
	<div class="container container-pad">
		<div class="row">
			<?php require 'sidebar.php'; ?>
			<!-- Main -->
			<div class="col-sm-10">
					<div class="col-sm-12">
						<h3><i class="fa fa-user-plus"></i> Create User Account<hr/></h3>
						<div class="col-sm-6">
							<?php
							if (isset($this->validation->errors)) {
								foreach ($this->validation->errors as $error) {
									echo '<div class="alert alert-danger">' . $error . '</div>';
								}
							}
							if (isset($this->message)) {
								echo '<div class="alert alert-success">' . $this->message . '</div>';
							}
							?>
							<form action="" method="post" enctype="application/x-www-form-urlencoded">
								<div class="mb-3">
									<label for="username">Username</label>
									<input class="form-control nr" type="text" id="username" name="username" placeholder="Enter a username" value="<?=stripField('username')?>"/>
								</div>

								<div class="mb-3">
									<label for="email">Email</label>
									<input class="form-control nr" type="text" id="email" name="email" placeholder="Enter your email" value="<?=stripField('email')?>"/>
								</div>

								<div class="mb-3">
									<label for="password">Password</label>
									<input class="form-control nr" type="password" id="password" name="password" placeholder="Enter your password"/>
								</div>

								<div class="mb-3">
									<button class="btn btn-primary nr" name="submit" value="submit"><i class="fa fa-user-plus"></i> Create account</button>
								</div>
							</form>
						</div>
					</div>
			</div>
			<!-- End Main -->
		</div>
	</div>

<?php require 'footer.php'; ?>

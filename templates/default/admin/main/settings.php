<?php require 'header.php'; ?>
<?php require 'top-bar.php'; ?>
	<div class="container container-pad">
		<div class="row">
			<?php require 'sidebar.php'; ?>
			<!-- Main -->
			<div class="col-sm-10">
					<div class="col-sm-12"><h3><i class="fa fa-cog"></i> Settings <a class="btn btn-danger" href="<?=$this->url['manage_url']?>/billing"><i class="fa fa-money"></i> Billing Settings</a></h3><hr/></div>
					<div class="col-sm-12">
					<?php
					if(isset($this->validation->errors)) {
						foreach($this->validation->errors as $error) {
							echo '<div class="alert alert-danger">'.$error.'</div>';
						}
					}
					if(isset($this->message)) {
						echo '<div class="alert alert-success">'.$this->message.'</div>';
					}
					?>
					<form action="" method="post" enctype="application/x-www-form-urlencoded" class="row">
						<div class="col-sm-6">
							<div class="mb-3">
								<label for="username">Username</label>
								<input type="text" name="username" id="username" class="form-control nr" placeholder="Enter Username" value="<?=stripDbField($this->adminData->username)?>"/>
							</div>

							<div class="mb-3">
								<label for="email">Email</label>
								<input type="email" name="email" id="email" class="form-control nr" placeholder="Enter email" value="<?=stripDbField($this->adminData->email)?>"/>
							</div>

							<div class="mb-3">
								<label for="firstName">First Name</label>
								<input type="text" name="first_name" id="firstName" class="form-control nr" placeholder="Enter first name" value="<?=stripDbField($this->adminData->first_name)?>"/>
							</div>

							<div class="mb-3">
								<label for="lastName">Last Name</label>
								<input type="text" name="last_name" id="lastName" class="form-control nr" placeholder="Enter last name" value="<?=stripDbField($this->adminData->last_name)?>"/>
							</div>

						</div>

						<div class="col-sm-6">
							<div class="mb-3">
								<label for="currentPassword">Current Password <small>(Enter your current password to update settings)</small></label>
								<input type="password" name="password" id="password" class="form-control nr" placeholder="Enter your current password"/>
							</div>
							<div class="mb-3">
								<label for="newPassword">New Password <small>(Enter new password if you want to change it)</small></label>
								<input type="password" name="new_password" id="newPassword" class="form-control nr" placeholder="Enter new password"/>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-sm-6">
							<button name="submit" id="submit" class="btn btn-primary" value="submit"><i class="fa fa-pencil"></i> Update</button>
						</div>
					</form>
					</div>
			</div>
			<!-- End Main -->
		</div>
	</div>

<?php require 'footer.php'; ?>

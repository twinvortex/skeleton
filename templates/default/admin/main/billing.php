<?php require 'header.php'; ?>
<?php require 'top-bar.php'; ?>
	<div class="container container-pad">
		<div class="row">
			<?php require 'sidebar.php'; ?>
			<!-- Main -->
			<div class="col-sm-10">
					<div class="col-sm-12">
						<h3><i class="fa fa-money"></i> Billing<hr/></h3>
					</div>
					<div class="col-sm-12">
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
									<label for="payPalEmail"><i class="fa fa-paypal"></i> PayPal Email</label>
									<input type="text" name="paypal_email" id="payPalEmail" class="form-control nr" placeholder="Enter paypal email" value="<?=stripDbField($this->data->paypal_email)?>"/>
								</div>
								<div class="mb-3">
									<label for="salesEmail"><i class="fa fa-support"></i> Sales Email</label>
									<input type="text" name="sales_email" id="salesEmail" class="form-control nr" placeholder="Enter paypal email" value="<?=stripDbField($this->data->sales_email)?>"/>
								</div>
								<button name="submit" id="submit" class="btn btn-primary" value="submit"><i class="fa fa-pencil"></i> Update</button>
							</form>
						</div>
					</div>
			</div>
			<!-- End Main -->
		</div>
	</div>

<?php require 'footer.php'; ?>

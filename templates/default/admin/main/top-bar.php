<div class="top-bar">
	<div class="container">
		<div class="row">
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-8">
						<p>
							<a href="<?=$this->url['manage_url']?>/settings" class="sp"><i class="fa fa-cog"></i> Settings</a>
							<a href="<?=$this->url['manage_url']?>/subscriptions" class="sp"><i class="fa fa-credit-card"></i> Subscriptions</a>
							<a href="<?=$this->url['manage_url']?>/tickets" class="sp"><i class="fa fa-comments-o"></i> Tickets</a>
						</p>
					</div>
					<div class="col-sm-4">
						<form action="" method="post" enctype="application/x-www-form-urlencoded">
							<input type="text" name="search" class="form-control nr" placeholder="Search"/>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<p>Hello, <?=$this->adminData->first_name?> <a href="<?=$this->url['manage_url']?>/logout" style="margin-left:20px"><i class="fa fa-sign-out"></i></a></p>
			</div>
		</div>
	</div>
</div>

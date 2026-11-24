<?php require 'header.php'; ?>
<?php require 'top-bar.php'; ?>
	<div class="container container-pad">
		<div class="row">
			<?php require 'sidebar.php'; ?>

			<!-- Main -->
			<div class="col-sm-10">
					<div class="col-sm-12"><h3><i class="fa fa-users"></i> Latest Users</h3><hr/>
					<?php if($this->message): ?>
						<span class="alert alert-success col-sm-12"><?=$this->message?></span>
					<?php endif; ?>
					<?php
					if($this->usersData): ?>
					<table class="table table-hover space">
						<thead>
							<tr>
								<th>ID</th>
								<th>Email</th>
								<th>Action</th>
								<th>Created</th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach($this->usersData as $user) {
							?>
							<tr>
								<td><?=$user->id?></td>
								<td><?=$user->email?><?php if($user->is_active==0) {echo "<span style=\"color:red\"> (disabled)</span>";} ?></td>
								<td><a href="<?=$this->url['manage_url']?>/user/edit/<?=$user->id?>" class="sp"><i class="fa fa-pencil-square-o"></i> Edit</a> <?php if($user->is_active==1) { ?><a href="<?=$this->url['manage_url']?>/dashboard?is=disable&id=<?=$user->id?>" class="sp"><i class="fa fa-times"></i> Disable</a> <?php } else { ?><a href="<?=$this->url['manage_url']?>/dashboard?is=enable&id=<?=$user->id?>"> <i class="fa fa-plus-square"></i> Enable</a><?php } ?></td>
								<td><?=nicetime($user->created_at)?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
						</div>
					<?php else: ?>
						<div class="col-sm-12">
							<div class="alert alert-info">No users!</div>
						</div>
					<?php endif; ?>
			</div>
			<!-- End Main -->
		</div>
	</div>

<?php require 'footer.php'; ?>

<?php require 'header.php'; ?>
<?php require 'top-bar.php'; ?>
	<div class="container container-pad">
		<div class="row">
			<?php require 'sidebar.php'; ?>
			<!-- Main -->
			<div class="col-sm-10">
				<div class="col-sm-12">
						<h3><i class="fa fa-users"></i> Users<hr></h3>
						<?php if($this->message): ?>
						<span class="alert alert-success col-sm-12"><?=$this->message?></span>
						<?php endif; ?>
						<?php if($this->usersData): ?>
						<form action="" method="post" enctype="application/x-www-form-urlencoded">
						<table class="table table-hover space">
							<thead>
								<tr>
									<th><input type="checkbox" class="checker" name="check_all" id="checkAll"/></th>
									<th>Email</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Country</th>
									<th>Action</th>
									<th>Created</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($this->usersData as $user): ?>
								<tr>
									<td><input type="checkbox" name="id[]" id="checkbox" value="<?=$user->id?>"/></td>
									<td><?=$user->email?><?php if($user->is_active==0) {echo "<span style=\"color:red\"> (disabled)</span>";} ?></td>
									<td><?=$user->first_name?></td>
									<td><?=$user->last_name?></td>
									<td><?=$user->country?></td>
									<td><a href="<?=$this->url['manage_url']?>/user/edit/<?=$user->id?>" class="sp"><i class="fa fa-pencil-square-o"></i> Edit</a> <?php if($user->is_active==1) { ?><a href="<?=$this->url['manage_url']?>/users?is=disable&id=<?=$user->id?>" class="sp"><i class="fa fa-times"></i> Disable</a> <?php } else { ?><a href="<?=$this->url['manage_url']?>/users?is=enable&id=<?=$user->id?>"> <i class="fa fa-plus-square"></i> Enable</a><?php } ?></td>
									<td><?=nicetime($user->created_at)?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
							<div align="center">
								<select name="action" style="margin-top:7px">
									<option value="disable">Disable</option>
									<option value="enable">Enable</option>
								</select>
								<button class="btn btn-secondary btn-sm" name="submit" value="submit" style="width:100px;margin-left:5px;">Submit</button>
							</div>
						</form>
						<?php else: ?>
						<div class="col-sm-12">
							<div class="alert alert-info">No users!</div>
						</div>
						<?php endif; ?>
						<div class="col-sm-12">
							<?php pagination($this->manage->getTotal(), '/manage/users/') ?>
						</div>
				</div>
			</div>
			<!-- End Main -->
		</div>
	</div>

<?php require 'footer.php'; ?>

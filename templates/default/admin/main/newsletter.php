<?php require 'header.php'; ?>
<?php require 'top-bar.php'; ?>
	<div class="container container-pad">
		<div class="row">
			<?php require 'sidebar.php'; ?>
			<!-- Main -->
			<div class="col-sm-10">
					<div class="col-sm-12"><h3><i class="fa fa-newspaper-o"></i> Newsletter Subscriptions<hr></h3></div>
					<?php if($this->message): ?>
						<span class="col-sm-12 alert alert-success"><?=$this->message?></span>
					<?php endif; ?>
					<?php if($this->newsletterData): ?>
					<form action="" method="post" enctype="application/x-www-form-urlencoded">
					<table class="table table-hover space">
						<thead>
							<tr>
								<th><input type="checkbox" class="checker" name="check_all" id="checkAll"/></th>
								<th>Name</th>
								<th>Email</th>
								<th>Subscribed</th>
								<th>Promo Sent</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($this->newsletterData as $newsletter):?>
							<tr>
								<td><input type="checkbox" name="id[]" id="checkbox" value="<?=$newsletter->id?>"/> </td>
								<td><?=$newsletter->name?></td>
								<td><?=$newsletter->email?></td>
								<td><?=nicetime($newsletter->date)?></td>
								<td><?=nicetime($newsletter->date_sent)?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
						<div align="center">
							<select name="action" style="margin-top:7px">
								<option value="delete">Delete</option>
							</select>
							<button class="btn btn-secondary btn-sm" name="submit" value="submit" style="width:100px;margin-left:5px;">Submit</button>
						</div>
					</form>
						<?php else: ?>
						<div class="col-sm-12">
							<div class="alert alert-info">No newsletter emails!</div>
						</div>
					<?php endif; ?>
					<div class="col-sm-12">
						<?php pagination($this->manage->getTotalEmails(), '/manage/newsletter/') ?>
					</div>
			</div>

			<!-- End Main -->
		</div>
	</div>

<?php require 'footer.php'; ?>

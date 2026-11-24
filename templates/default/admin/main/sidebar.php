<!-- Sidebar -->
<div class="col-sm-2">

	<p align="center">
		<a href="<?=$this->url['admin_url']?>"><img src="<?=$this->url['assets_url']?>/images/logo-small.png" alt="" width="100"/></a>
	</p>

	<ul class="nav nav-pills flex-column">
		<li class="nav-item"><a class="nav-link" href="<?=$this->url['manage_url']?>/users"><i class="fa fa-users"></i> Users </a></li>
		<li class="nav-item"><a class="nav-link" href="<?=$this->url['manage_url']?>/users/create"><i class="fa fa-user-plus"></i> Create User</a></li>
		<li class="nav-item"><a class="nav-link" href="<?=$this->url['manage_url']?>/newsletter"><i class="fa fa-newspaper-o"></i> Newsletter</a></li>
		<li class="nav-item"><hr/></li>
		<li class="nav-item"><a class="nav-link" href="<?=$this->url['manage_url']?>/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
	</ul>

</div>
<!-- End Sidebar -->

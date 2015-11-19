<div class="user-profile">
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<img src="/img/<?=$avatar?> " alt="<?=$name?>">
	</div>
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
			<span class="label">Логин: </span><span class="item"><?=$login?></span>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
			<span class="label">Имя: </span><span class="item"><?=$name?></span>
		</div>		
	</div>
	<div class="logout col-xs-12 col-sm-12 col-md-6 col-lg-12">
		<a class="btn btn-primary" href="/user/logout">Выйти <i class="fa fa-sign-out"></i></i></a>
	</div>
	
	
</div>
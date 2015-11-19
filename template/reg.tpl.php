

<div class="form-wrapper ">

	<form id="form_registr" class="form-signin" method="post" action="/user/registr" enctype="multipart/form-data">
		<div class="form-group">
			<label for="login"><?=$LOGIN?></label>
			<input id="login" class="form-control" type="text" name="login"  size="20">
			<div id="login" class="error"></div>
			<p class="help-block"><?=$LOGIN_DESC?></p>
			</div>

		<div class="form-group">	
			<label for="name"><?=$NAME?></label>
			<input id="name" class="form-control" type="text" name="name" size="20">
			<p class="help-block"><?=$NAME_DESC?></p>
			</div>

		<div class="form-group">
			<label for="password"><?=$PASSWORD?></label>
			<input id="password" class="form-control" type="password" name="password" size="20">
			<p class="help-block"><?=$PASSWORD_DESC?></p>
			</div>

		<div class="form-group">
			<label for="password2"><?=$REPEAT.' '.$PASSWORD?></label>
			<input id="password2" class="form-control" type="password" name="password2" size="20">
			<p class="help-block"><?=$PASSWORD_DESC_REPEAT?></p>
			</div>

		<div class="form-group">
			<label for="avatar"><?=$AVATAR?></label>
			<input id="avatar" class="form-control" type="FILE" name="avatar" >
			<p class="help-block"><?=$AVATAR_DESC?></p>
			<div id="avatar" class="error"></div></div>
			


			<button id="reg" type="submit" class="btn btn-success" name="reg"><?=$REGISTRATION?></button>
	</form>
	<div class="alert alert-info">
        <p><?=$AMEMBER?> <a href="/user"><?=$AUTHORIZE?></a></p>
    </div>
</div>


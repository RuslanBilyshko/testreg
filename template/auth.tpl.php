<div id="result" class="alert alert-danger hide"></div>
<div class="form-wrapper ">
    <form id="form-auth" class="form-signin" role="form" method="post" action="/user/login">
        <div class="form-group">
            <label for="login"><?=$LOGIN?></label>
            <input id="login" class="form-control" type="text" name="login" size="20">
        </div>
        <div class="form-group">
            <label for="password"><?=$PASSWORD?></label>
            <input id="password" class="form-control" type="password" name="password" size="20">    
        </div>
        <div class="form-group">
            <label class="remember" for="checkbox"><?=$REMEMBER?></label>
            <input id="remember" type="checkbox" name="remember" value="1" checked>
        </div>               
        <button id="auth" class="btn btn-primary" type="submit" name="auth"><?=$LOG_IN?> <i class="fa fa-sign-in"></i></button>
    </form>
    <div class="alert alert-success">
        <p><?=$NOTACCAUNT?> <a href="/user/add"><?=$JOIN?></a></p>  
    </div>
    
</div>
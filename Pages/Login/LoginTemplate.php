<?= $template->render('Main/Layout', array(
    'title' => 'Login',
    'css' => array(
        '/css/login.css'
    ),
    'js' => array(
    ),
)); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in to continue to Calendar</h1>
            <div class="account-wall">
                <img class="profile-img" src="/img/logo.png"
                    alt="">
                <form class="form-signin">
                <input type="text" class="form-control" placeholder="Email" required autofocus>
                <input type="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    <?php /*<label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label> */?>
                </form>
            </div>
            <a href="/registration" class="text-center new-account">Create an account </a>
        </div>
    </div>
</div>
<?= $template->render('Main/Footer', array(
    'js' => array(
    ),
)); ?>

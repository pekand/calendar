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
                <form class="form-signin" method="POST" action="/login">
                    <div class="form-group <?= ($form->hasError('username')) ? 'has-error' : '' ?> has-feedback">
                        <input name="username" type="text" class="form-control error" placeholder="Email Address" value="<?= $form->getValue('username') ?>" autofocus>
                        <span class="glyphicon glyphicon-remove form-control-feedback <?= (!$form->hasError('username')) ? 'hidden' : '' ?>" aria-hidden="true" style="padding: 6px" ></span>
                    </div>
                    <div class="form-group <?= ($form->hasError('password')) ? 'has-error' : '' ?> has-feedback">
                          <input name="password" type="password" class="form-control error" placeholder="Password" aria-describedby="inputError2Status">
                          <span class="glyphicon glyphicon-remove form-control-feedback <?= (!$form->hasError('password')) ? 'hidden' : '' ?>" aria-hidden="true" style="padding: 6px" ></span>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
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

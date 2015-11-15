<?= $template->render('Main/Layout', array(
    'title' => 'Registration',
    'css' => array(
        '/css/registration.css'
    ),
    'js' => array(
    ),
)); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Please sign up for Calendar</h1>
            <div class="account-wall">
                <img class="profile-img" src="/img/logo.png"
                    alt="">
                <form class="form-signin">

                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address" required autofocus>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Pass...">
                        </div>
                    </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Create an account</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $template->render('Main/Footer', array(
    'js' => array(
    ),
)); ?>

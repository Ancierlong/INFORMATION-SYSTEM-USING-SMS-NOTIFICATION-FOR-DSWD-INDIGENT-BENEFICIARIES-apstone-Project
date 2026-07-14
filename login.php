<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserCustomer.php');
require_once(dirname(__FILE__) . '/Classes/LoginForm.php');

$email = '';

$isPostSignUp = false;
$login = null;

if (isset($_POST['email'])) {
  $isPostSignUp = true;
  $email = $_POST['email'];
  $password = $_POST['password'];
  $login = new LoginForm($email, $password);
  $isLoggedIn = $login->handleSubmit();
  unset($_POST);
}

function getErrorMessage($isPostSignUp, $form, $inputName)
{
  if ($isPostSignUp == true && is_null($form) == false) {
    if (isset($form->getErrors()[$inputName]) == true && count($form->getErrors()[$inputName]) > 0) {
      return $form->getErrors()[$inputName][0];
    }
  }
  return [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <?php require_once('layout/custom.css') ?>
</head>

<body class="hold-transition login-page">
<div class="layer">
    </div>
  <div class="login-box">
    
    <div class=''>
    <!-- /.login-logo -->
    <div class="card" style='height: 20rem'>

    <div class="login-logo mt-2">
      <a href="login.php"><h2>Baranggay Medicion I-B</h2> <h5>Information System</h5></a>
    </div>

      <div class="card-body login-card-body pt-1">
        <p class="login-box-msg">Sign in</p>

        <div class="text-center">
          <?php
          if (empty(getErrorMessage($isPostSignUp, $login, 'email')) == false) { ?>
            <span style="color:red"><?php echo getErrorMessage($isPostSignUp, $login, 'email') ?></span>
            <br>
          <?php
          }
          ?>

          <?php
          if (empty(getErrorMessage($isPostSignUp, $login, 'password')) == false) { ?>
            <span style="color:red"><?php echo getErrorMessage($isPostSignUp, $login, 'password') ?></span>
          <?php
          }
          ?>
        </div>

        <form method="POST" action="#" name="login">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control  <?= (empty(getErrorMessage($isPostSignUp, $login, 'email')) == false) ? 'is-invalid'  : '' ?>" placeholder="Email" value="<?= $email ?>" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control <?= (empty(getErrorMessage($isPostSignUp, $login, 'password')) == false) ? 'is-invalid' : '' ?>" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-block login-btn">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
        </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script src="login.js"></script>
</body>

</html>

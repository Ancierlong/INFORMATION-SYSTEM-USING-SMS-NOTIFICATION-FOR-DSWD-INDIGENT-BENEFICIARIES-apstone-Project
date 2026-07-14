<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');
require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');
$page = 'My Profile';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = '';

$dbConn = (new SystemDatabaseConfig());
$userId = $_SESSION['user']['id'];

$showAlert = $alertMessage = null;

if (isset($_POST['update_my_profile'])) {

  $name = htmlentities(trim($_POST['new_name']));
  $email = htmlentities(trim($_POST['new_email']));

  try {
    $updateQuery = " UPDATE users SET
    email = '{$email}',
    name = '{$name}'
    WHERE id = '{$userId}'";

    $query = $dbConn->getConnection()
      ->query($updateQuery);

    $actions = 'Update Profile';
    $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

    $showAlert = 'success';
    $alertMessage = 'Success!';
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
  } catch (Exception $e) {
    $errorExceptionMessage = $alertMessage = $e->getMessage();
    $showAlert = 'error';
  }
}

if (isset($_POST['change-password-btn'])) {
  $password = htmlentities(trim($_POST['password']));
  $newPassword = password_hash($password, PASSWORD_BCRYPT);
  $currentPasswordInput = htmlentities(trim($_POST['current_password']));

  $currentPasswordOnDbQuery =  $dbConn->getConnection()
  ->query("SELECT * FROM users WHERE id = '{$userId}' ");
  $currentPasswordOnDbResult = $currentPasswordOnDbQuery->fetch_all(MYSQLI_ASSOC);  
  $currentPasswordOnDb = count($currentPasswordOnDbResult) > 0 
  ? $currentPasswordOnDbResult[0]['password']
  : '';
  try {

    $isCurrentPasswordMatch = password_verify($currentPasswordInput, $currentPasswordOnDb);
    if ($isCurrentPasswordMatch !== true){
      throw new Exception('Current Password incorrect');
    }

    $updatePasswordQuery = " UPDATE users SET
    password = '{$newPassword}'
    WHERE id = '{$userId}'";

    $query = $dbConn->getConnection()
      ->query($updatePasswordQuery);

    $actions = 'Change Password';
    $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

    $showAlert = 'success';
    $alertMessage = 'Success!';
  } catch (Exception $e) {
    $errorExceptionMessage = $alertMessage = $e->getMessage();
    $showAlert = 'error';
  }
}

$userName = $_SESSION['user']['name'];
$userEmail = $_SESSION['user']['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | Beneficiaries</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">


  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">


  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->

    <?php require_once('layout/_header.php') ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once('layout/_sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Wrapper. Contains page content -->

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>My Profile</h1>
            </div>
            <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">404 Error Page</li>
            </ol>
          </div> -->
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- /.row -->
          <!-- Main row -->
          <div class="row my-3">
            <!-- Left col -->

            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12 connectedSortable">
              <!-- /.card -->
              <div class="card">
                <!-- <div class="card-header">
                  <h3 class="card-title">Beneficiary</h3>
                </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                      <!-- <div class="row">
                        <div class="col-sm-6">
                          <div class="card-body box-profile">
                            <div class="text-center">
                              <img class="profile-user-img img-fluid img-circle" onerror="if (this.src != 'default.jpeg') this.src = 'default.jpeg';" src="upload_images/<?= $beneficiariesResult['0']['image_file_name']; ?>" alt="User profile picture">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept="image/png, image/jpeg, image/jpg">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> -->
                      <!-- <hr> -->
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                            <label><span style="color:red">* </span>Name</label>
                            <input class="form-control input-name" name="new_name" value="<?= $userName ?>" maxlength="50" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                            <label><span style="color:red">* </span>Email</label>
                            <input class="form-control" name="new_email" value="<?= $userEmail ?>" maxlength="50" required>
                          </div>
                        </div>
                      </div>

                      <div class="">
                        <div class="row">
                          <div class="col">
                            <button type="submit" class="btn btn-primary" name="update_my_profile">Update</button>
                          </div>
                        </div>
                      </div>
                      <!-- <hr> -->
                  </form>
            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
        <form action="" method="POST" enctype="multipart/form-data" onSubmit="validatePassword()">
          <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="">
                <!-- <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label><span style="color:red">* </span>Old Password</label>
                      <input type="password" class="form-control" minlength="8" placeholder="Password" name="old_password" id="old_password" value="" maxlength="20" required>
                      <span id="password_error_old" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                  </div>
                </div> -->
                <div class="row">
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label><span style="color:red">* </span>Current Password</label>
                      <input type="password" class="form-control" minlength="8" placeholder="Password" name="current_password" id="current_password" value="" maxlength="20" required>
                      <span id="password_error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label><span style="color:red">* </span>Password</label>
                      <input type="password" class="form-control" minlength="8" placeholder="Password" name="password" id="password" value="" maxlength="20" required>
                      <span id="password_confirm_error" class="error invalid-feedback" style="display: none;"></span>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label><span style="color:red">* </span>Confirm Password</label>
                      <input type="password" class="form-control" minlength="8" placeholder="Password" name="confirm_password" id="confirm_password" value="" maxlength="20" required>
                    </div>
                  </div>
                </div>

                <!-- <div class="modal-footer"> -->
                <div class="row">
                  <div class="col">
                    <button type="submit" class="btn btn-warning" name="change-password-btn" id="change-password-btn">Change Password</button>
                  </div>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
        </form>
      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer> -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>


  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>


  <script>
    function validatePassword() {
      var password = document.getElementById('password').value
      var confrm_password = document.getElementById('confirm_password').value
      let error = '';
      $('#password_error').hide();
      $('#password_confirm_error').hide();


      if (password != confrm_password) {
        event.preventDefault();
        error = 'Password should match!';
        $('#password_error').text(error);
        $('#password_error').show();
        return;
      }

      var format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
      if (password.search(/\d/) == -1 || password.search(format) == -1 || password.search(/[A-Z]/) == -1) {
        event.preventDefault();
        $('#password_confirm_error').text('Should contain a number, capital letter and a special characters.');
        $('#password_confirm_error').show();
        return;
      }

    }


    $(function() {

      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }

      $(".input-numbers").keypress(function(event) {
        return /\d/.test(String.fromCharCode(event.keyCode));
      });
      $(".input-name").keypress(function(event) {
        return /^[a-zA-Z.\s]*$/.test(String.fromCharCode(event.keyCode));
      });

      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      let showAlert = <?= json_encode($showAlert, true) ?>;

      if (showAlert == 'success') {
        toastr.success(<?= json_encode($alertMessage, true) ?>)
      }

      if (showAlert == 'warning') {
        $(document).Toasts('create', {
          class: 'bg-warning',
          title: 'Warning',
          // subtitle: 'Subtitle',
          body: <?= json_encode($alertMessage, true) ?>
        })
      }

      if (showAlert == 'error') {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Error',
          // subtitle: 'Subtitle',
          body: <?= json_encode($alertMessage, true) ?>
        })
      }

      if (showAlert == 'info') {
        $(document).Toasts('create', {
          class: 'bg-info',
          title: 'Info',
          // subtitle: 'Subtitle',
          body: <?= json_encode($alertMessage, true) ?>
        })
      }
    });
  </script>
</body>

</html>

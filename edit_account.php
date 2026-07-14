<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');

require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');
require_once(dirname(__FILE__) . '/SystemMail.php');

$page = 'Accounts';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = '';

$dbConn = (new SystemDatabaseConfig());
$systemMail = new SystemMail();

if (isset($_GET['id']) == false) {
  header("Location: accounts.php");
}

$targetAccountId = $_GET['id'];
$targetAccountInformationQuery = $dbConn->getConnection()
  ->query("SELECT u1.name, u1.contact_no, u1.role, u1.birthday, u1.email, u1.gender, u1.approval_status, u1.created_at, u2.name as created_by FROM users u1 LEFT JOIN users u2 ON u1.created_by = u2.id
  WHERE u1.id = '{$targetAccountId}'
  ");
$targetAccountInformationResult = $targetAccountInformationQuery->fetch_all(MYSQLI_ASSOC);

if (count($targetAccountInformationResult) == 0) {
  header("Location: accounts.php");
}


$role = null;
$name = null;
$email = null;
$birthday = null;
$gender = null;
$mobile_number = null;
$showAlert = $alertMessage = null;
$isEmailTakenResult = false;

if (isset($_POST['updated_account'])) {

  $role = htmlentities(trim($_POST['role']));
  $name = htmlentities(trim($_POST['name']));
  $email = htmlentities(trim($_POST['email']));
  $birthday = htmlentities(trim($_POST['birthday']));
  $gender = htmlentities(trim($_POST['gender']));
  $approval_status = htmlentities(trim($_POST['approval_status']));
  $mobile_number = htmlentities(trim($_POST['mobile_number']));

  $isEmailTakenQuery = $dbConn->getConnection()
    ->query("SELECT * FROM users WHERE email = '{$email}' AND id != '{$targetAccountId}'");
  $isEmailTakenResult = count($isEmailTakenQuery->fetch_all(MYSQLI_ASSOC)) > 0;


  if ($isEmailTakenResult) {
    $showAlert = 'error';
    $alertMessage = 'Email is taken.';
  } else {
    $passwordString = substr(rand(), 0, 10);
    $password = password_hash($passwordString, PASSWORD_BCRYPT);
    $query = $dbConn->getConnection()
      ->query("update users set
    role = '{$role}',
    name = '{$name}',
    email = '{$email}',
    birthday = '{$birthday}',
    gender = '{$gender}',
    contact_no = '{$mobile_number}',
    approval_status = {$approval_status}
    WHERE id = '{$targetAccountId}'
");
    $lastInsertedId = $dbConn->getConnection()->insert_id;
    $showAlert = 'success';
    $alertMessage = "Account successfully Updated.<br>";

    $role = null;
    $name = null;
    $email = null;
    $birthday = null;
    $gender = null;
    $mobile_number = null;
  }
}

if (isset($_POST['forgot_password'])) {
  $passwordString = substr(rand(), 0, 10);
  $password = password_hash($passwordString, PASSWORD_BCRYPT);
    $query = $dbConn->getConnection()
    ->query("update users set
      password = '{$password}' WHERE id = '{$targetAccountId}'");

  $showAlert = 'success';
  $alertMessage = "Successfully sent Temporary Password.";

  $messageDetails['email'] = $recipientAddress = $email = $targetAccountInformationResult[0]['email'];
  $messageDetails['password'] = $passwordString;
  $systemMail->sendAccountForgotPassword($recipientAddress, $messageDetails);
}


unset($_POST);

$approvalStatusLib = [
  0 => 'Pending', // not used
  1 => 'Active',
  2 => 'Rejected', // not used
  3 => 'Inactive'
];

$roleLib = [
  1 => 'Admin',
  2 => 'Staff',
  3 => 'Super Admin'
];
$targetAccountInformationQuery = $dbConn->getConnection()
  ->query("SELECT u1.name, u1.contact_no, u1.role, u1.birthday, u1.email, u1.gender, u1.approval_status, u1.created_at, u2.name as created_by FROM users u1 LEFT JOIN users u2 ON u1.created_by = u2.id
  WHERE u1.id = '{$targetAccountId}'
  ");
$targetAccountInformationResult = $targetAccountInformationQuery->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | Accounts</title>

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
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Edit Account</h1>
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
          <div class="row my-2">
            <div class="col-md-3 col-sm-6 col-6">
              <a type="button" class="btn btn-primary" href="accounts.php">
                <i class="fas fa-list"></i> Manage Accounts
              </a>
            </div>
            <!-- <div class="col-md-3 col-sm-6 col-6"> -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-default">
              Forgot Password
            </button>
            <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Send temporary password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>By Confirming, the user will receive a temporary password via email. <br>
                      <br>
                      Are you you want to send Temporary Password to the User? <br>
                    </p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <form method="POST">
                    <button type="submit" class="btn btn-primary" name="forgot_password">Confirm</button>
                    </form>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- </div> -->
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->

          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-12 connectedSortable">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- radio -->
                        <div>
                          <label class="col-form-label" for=""><span style="color:red">* </span>Role</label>
                          <div class="form-group">
                          <?php
                          if ($_SESSION['user']['role'] == 3) {
                            ?>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role"name="role" <?= $targetAccountInformationResult[0]['role'] == 3 ? 'checked' : '' ?> value="3">
                              <label class="form-check-label">Super Admin</label>
                            </div>
                
                            <?php
                          }
                          ?>
                          

                       
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role" <?= $targetAccountInformationResult[0]['role'] == 1 ? 'checked' : '' ?> value="1">
                              <label class="form-check-label">Admin</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role" value="2" <?= $targetAccountInformationResult[0]['role'] == 2 ? 'checked' : '' ?>>
                              <label class="form-check-label">Staff</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <!-- radio -->
                        <div>
                          <label class="col-form-label" for=""><span style="color:red">* </span>Account Status</label>
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="approval_status" <?= $targetAccountInformationResult[0]['approval_status'] == 1 ? 'checked' : '' ?> value="1">
                              <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="approval_status" value="3" <?= $targetAccountInformationResult[0]['approval_status'] != 1 ? 'checked' : '' ?>>
                              <label class="form-check-label">Inactive</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12">
                        <!-- textarea -->
                        <div class="form-group">
                          <label><span style="color:red">* </span>Name</label>
                          <input class="form-control input-name" rows="3" placeholder="ex. Juan." name="name" maxlength="50" required value="<?= $targetAccountInformationResult[0]['name'] ?>">
                        </div>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label><span style="color:red">* </span>Email </label>
                          <input type="email" class="form-control <?= $isEmailTakenResult ? 'is-invalid' : '' ?>" rows="3" placeholder="ex. juan.dela.cruz@gmail.com" required name="email" maxlength="50" value="<?= $targetAccountInformationResult[0]['email'] ?>">
                          <?php if ($isEmailTakenResult) { ?>
                            <span id="exampleInputEmail1-error" class="error invalid-feedback">Email is already taken.</span>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label><span style="color:red">* </span>Date Of Birth</label>
                          <div class="input-group date" id="birthday" data-target-input="nearest">
                            <input onkeydown="return false" type="text" class="form-control datetimepicker-input" name="birthday" data-target="#birthday" required value="<?= $targetAccountInformationResult[0]['birthday'] ?>">
                            <div class="input-group-append" data-target="#birthday" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- radio -->
                        <label class="col-form-label" for=""><span style="color:red">* </span>Gender</label>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" checked="<?= $targetAccountInformationResult[0]['gender']  == 1 ? 'checked' : '' ?>" value="1">
                            <label class="form-check-label">Male</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" checked="<?= $targetAccountInformationResult[0]['gender'] == 2 ? 'checked' : '' ?>" value="2">
                            <label class="form-check-label">Female</label>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="col-form-label" for=""><span style="color:red">* </span>Mobile Number</label>
                          <input type="text" class="form-control input-numbers" id="" placeholder="ex. 09912345678" name="mobile_number" required maxlength="11" minlength="11" value="<?= $targetAccountInformationResult[0]['contact_no'] ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary" name="updated_account">Update</button>
                  </div>
                </form>
              </div>

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
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



  <script>
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

      $("#example1").DataTable({
        "responsive": screen.width < 800 ? true : false,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [

          {
            extend: 'copy',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'csv',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excel',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
              columns: ':visible'
            }
          },

          {
            extend: 'print',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
              columns: ':visible'
            }
          },

          "colvis"
        ],
        "pageLength": 20,
        "scrollX": true,
        // columnDefs: [ {
        //     targets: -1,
        //     visible: false
        // } ]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



      //Date picker
      $('#indigent_start_date').datetimepicker({
        format: 'YYYY-MM-DD'
      });

      $('#birthday').datetimepicker({
        format: 'YYYY-MM-DD'
      });

      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      let showAlert = <?= json_encode($showAlert, true); ?>;
      let alertMessage = <?= json_encode($alertMessage, true); ?>;

      if (showAlert == 'success') {
        toastr.success(alertMessage)
      }

      if (showAlert == 'warning') {
        toastr.warning(alertMessage)
      }

      if (showAlert == 'error') {
        toastr.error(alertMessage)
      }

      if (showAlert == 'info') {
        toastr.info(alertMessage)
      }
    });
  </script>
</body>

</html>

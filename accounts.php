<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');

require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$page = 'Accounts';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = '';
$isSuperAdmin = $_SESSION['user']['role'] == 3;
if ($_SESSION['user']['role'] != 3) {
  header("location: dashboard.php");
}

$dbConn = (new SystemDatabaseConfig());

$role = null;
$name = null;
$email = null;
$birthday = null;
$gender = null;
$mobile_number = null;
$showAlert = null;

if (isset($_POST['add_account'])) {

  $role = htmlentities(trim($_POST['role']));
  $name = htmlentities(trim($_POST['name']));
  $email = htmlentities(trim($_POST['email']));
  $birthday = htmlentities(trim($_POST['birthday']));
  $gender = htmlentities(trim($_POST['gender']));
  $mobile_number = htmlentities(trim($_POST['mobile_number']));


  $query = $dbConn->getConnection()
    ->query("INSERT INTO users (
      `role`,
      `name`,
      `email`,
      `birthday`,
      `gender`,
      `contact_no`,
      `approval_status`,
      `created_by`
      )
VALUES
(
'{$role}',
'{$name}',
'{$email}',
'{$birthday}',
'{$gender}',
'{$mobile_number}',
1,
'{$user_id}')");
  $lastInsertedId = $dbConn->getConnection()->insert_id;
  $showAlert = 'success';

  // header("Location: accounts.php?id={$lastInsertedId}");
}

if (isset($_POST['delete_selected_rows'])) {
  $selected_adopted_array = explode(',', $_POST['selected_students_list']);
  if (count($selected_adopted_array) == 0) {
    return;
  }
  $idString = [];
  foreach ($selected_adopted_array as $i => $d) {
      $idString[] = "'{$d}'";
  }
  $implode = implode(',', $idString);

  $deletequery = "DELETE FROM users WHERE id IN ($implode)";
  $query = $dbConn->getConnection()
      ->query($deletequery);
  $successMessage = "Deleted";
  $showAlert = 'successDelete';
}

// if (isset($_POST['delete_selected_rows_all'])) {
// $deletequery = "DELETE FROM beneficiaries WHERE is_deleted = 1";
// $query = $dbConn->getConnection()
// ->query($deletequery);
// $successMessage = "Deleted";
// $showAlert = 'successDelete';
// }


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
$accountListQuery = $dbConn->getConnection()
  ->query("SELECT u1.id as acccount_id, u1.name, u1.role, u1.birthday, u1.email, u1.gender, u1.approval_status, u1.created_at, u2.name as created_by FROM users u1 LEFT JOIN users u2 ON u1.created_by = u2.id");
$accountListResult = $accountListQuery->fetch_all(MYSQLI_ASSOC);

$userAdmin = $dbConn->getConnection()
  ->query("SELECT * FROM users WHERE role = 1");
$userAdminResult = $userAdmin->fetch_all(MYSQLI_ASSOC);

$userSuperAdmin = $dbConn->getConnection()
  ->query("SELECT * FROM users WHERE role = 3");
$userSuperAdminResult = $userSuperAdmin->fetch_all(MYSQLI_ASSOC);

$userStaff = $dbConn->getConnection()
  ->query("SELECT * FROM users WHERE role = 2");
$userStaffResult = $userStaff->fetch_all(MYSQLI_ASSOC);

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
              <h1>Accounts</h1>
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
      <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
      <div class="row my-2">
            <div class="col-md-3 col-sm-6 col-6">
              <a type="button" class="btn btn-primary" href="add_accounts.php">
                <i class="fas fa-user-plus"></i> Add </a>
            </div>
    
            <?php if ($isSuperAdmin) {?>
              <div class="col-md-3 col-sm-6 col-6">
             
            <form method='POST'>
                  <input type='text' id='selected_students_list' name='selected_students_list' hidden>
                  <div class="btn-group">
                    <button type="button" class="btn btn-danger"><i class="nav-icon  fas fa-trash"></i> Delete</button>
                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <button name='delete_selected_rows' class='btn-delete dropdown-item' disabled>Delete Selected</button>
                      <!-- <button name='delete_selected_rows_all' class='dropdown-item'>Delete all</button> -->
                  </div>
                  </div>
                </form>
              </div>
                <?php 
              }?>
            
          </div>
        </div>
        
       
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Super Admin</span>
           
                <span class="info-box-number"><?php echo count($userSuperAdminResult) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Admin</span>
                <span class="info-box-number"><?php echo count($userAdminResult) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-gray"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-red">Staff</span>
                <span class="info-box-number"><?php echo count($userStaffResult) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <span class="info-box-number"><?php echo count($userSuperAdminResult) + count($userAdminResult) + count($userStaffResult) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- ./col -->
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
                <h3 class="card-title">Accounts</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Role</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created By</th>
                      <th>Status</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($accountListResult as $accountListKey => $accountListValue) {


                      $checkbox = ($user_id != $accountListValue['acccount_id'])
                        && ($_SESSION['user']['role'] == 3)
                        ? "<input type='checkbox' class='student_list_checkbox' value={$accountListValue['acccount_id']} data-user-id={$accountListValue['acccount_id']}/>" : '';
                      echo "
                        <tr>
                        <td>{$roleLib[$accountListValue['role']]}</td>
                        <td>
                        " . 
                        $checkbox
                         .
                        " <a href='edit_account.php?id={$accountListValue['acccount_id']}'>{$accountListValue['name']}</a></td>
                        <td>{$accountListValue['email']}</td>
                        <td>{$accountListValue['created_by']}</td>
                        <td>{$approvalStatusLib[$accountListValue['approval_status']]}</td>
                        <td>{$accountListValue['created_at']}</td>
                      </tr>
                        ";
                    }
                    ?>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Role</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created By</th>
                      <th>Status</th>
                      <th>Created At</th>
                    </tr>
                  </tfoot>
                </table>

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
      var SELECTED_STUDENTS = [];
      $("#example1").DataTable({
        initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                    refreshTable();

                    $('#example1_paginate .paginate_button').click(function() {
                        refreshTable();
                    });

                    function refreshTable() {
                        $('.student_list_checkbox').click(function() {
                            let test = $(this);
                            let newVal = SELECTED_STUDENTS;

                            let checkedEventId = $('#selected_students_list').val();
                            let id = test[0].getAttribute('data-user-id');

                            if (test[0].checked == true) {
                                newVal.push(id);
                            } else {
                                newVal = SELECTED_STUDENTS.filter((value) => value != id);
                            }
                            SELECTED_STUDENTS = newVal;
                            console.log(SELECTED_STUDENTS);
                            $('#selected_students_list').val(SELECTED_STUDENTS);


                            console.log(SELECTED_STUDENTS)
                            if ($('#selected_students_list').val() == '') {
                                $('.btn-delete').each(function() {
                                    $(this).prop('disabled', true)
                                });
                                return;
                            } else {
                                $('.btn-delete').each(function() {
                                    $(this).prop('disabled', false)
                                })
                            }

                        });
                    }


                },
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

      if (showAlert == 'success') {
        toastr.success('Successfully Created!')
      }

      if (showAlert == 'warning') {
        toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      }

      if (showAlert == 'error') {
        toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      }

      if (showAlert == 'info') {
        toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      }
    });
  </script>
</body>

</html>

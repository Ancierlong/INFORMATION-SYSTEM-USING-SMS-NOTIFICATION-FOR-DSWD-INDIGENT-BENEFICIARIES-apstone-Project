<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');
require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$dbConn = (new SystemDatabaseConfig());

if ($_SESSION['user']['role'] != 3) {
  header("location: dashboard.php");
}
$historyLogQuery = $dbConn->getConnection()
  ->query("SELECT *, h.created_at as log_created_at, h.id as id  FROM history_log h LEFT JOIN users u ON u.id = h.user_id ORDER BY h.id desc");
$historyLogResult = $historyLogQuery->fetch_all(MYSQLI_ASSOC);

// echo '<pre>';
// var_dump($historyLogResult); exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | History Log</title>

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
              <h1>History Log</h1>
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

      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">New Beneficiary</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="row">
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
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label><span style="color:red">* </span>LRIF #</label>
                      <input type="text" class="form-control input-numbers" placeholder="ex. 1001" maxlength="10" name="lrif_number" required>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label><span style="color:red">* </span>Indigent Start Date</label>
                      <div class="input-group date" id="indigent_start_date" data-target-input="nearest">
                        <input onkeydown="return false" type="text" class="form-control datetimepicker-input" name="indigent_start_date" data-target="#indigent_start_date" required>
                        <div class="input-group-append" data-target="#indigent_start_date" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label><span style="color:red">* </span>First Name</label>
                      <input class="form-control input-name" rows="3" placeholder="ex. Juan." name="first_name" maxlength="50" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label><span style="color:red"></span>Middle Name</label>
                      <input class="form-control input-name" rows="3" placeholder="ex. Gonzaga" name="middle_name" maxlength="50">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label><span style="color:red">* </span>Last Name</label>
                      <input class="form-control input-name" rows="3" placeholder="ex. Dela Cruz" name="last_name" require maxlength="50">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label><span style="color:red">* </span>Date Of Birth</label>
                      <div class="input-group date" id="birthday" data-target-input="nearest">
                        <input onkeydown="return false" type="text" class="form-control datetimepicker-input" name="birthday" data-target="#birthday" required>
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
                        <input class="form-check-input" type="radio" name="gender" checked="" value="1">
                        <label class="form-check-label">Male</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="2">
                        <label class="form-check-label">Female</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="col-form-label" for=""><span style="color:red">* </span>Mobile Number</label>
                      <input type="text" class="form-control input-numbers" id="" placeholder="ex. 09912345678" name="mobile_number" required maxlength="11" minlength="11">
                    </div>
                  </div>
                </div>

                <!-- input states -->
                <div class="form-group">
                  <label class="col-form-label" for=""><span style="color:red">* </span>Email</label>
                  <input type="email" class="form-control" id="" placeholder="ex. j.delacruz@gmail.com" name="email" required maxlength="50">
                </div>

                <div class="form-group">
                  <label class="col-form-label" for=""><span style="color:red">* </span>Address</label>
                  <input type="text" class="form-control" id="" placeholder="ex. 123 Quezon City" name="address" required maxlength="100">
                </div>
                <div class="form-group">
                  <label class="col-form-label" for=""></span>Skills</label>
                  <input type="text" class="form-control" id="" placeholder="" name="skills" maxlength="100">
                </div>
                <!--
                <div class="form-group">
                  <label class="col-form-label" for="inputSuccess"><i class="fas fa-check"></i>Address</label>
                  <input type="text" class="form-control is-valid" id="inputSuccess" placeholder="Enter ...">
                </div>
                <div class="form-group">
                  <label class="col-form-label" for="inputWarning"><i class="far fa-bell"></i> Input with
                    warning</label>
                  <input type="text" class="form-control is-warning" id="inputWarning" placeholder="Enter ...">
                </div>
                <div class="form-group">
                  <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> Input with
                    error</label>
                  <input type="text" class="form-control is-invalid" id="inputError" placeholder="Enter ...">
                </div> -->
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- radio -->
                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Category</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="category_category" checked="" value="1">
                          <label class="form-check-label">PWD</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="category_category" value="2">
                          <label class="form-check-label">Elderly</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="category_category" value="3">
                          <label class="form-check-label">Solo Parent</label>
                        </div>
                      </div>
                    </div>
                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Household Condition</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="household_category" checked="" value="1">
                          <label class="form-check-label">Makeshift Housing</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="household_category" value="2">
                          <label class="form-check-label">Informal Settlers</label>
                        </div>
                      </div>
                    </div>

                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Income and Livelihood</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="income_and_livelihood" checked="" value="1">
                          <label class="form-check-label">Households with income below poverty threshold</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="income_and_livelihood" value="2">
                          <label class="form-check-label">Households with income below food threshold</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="income_and_livelihood" value="2">
                          <label class="form-check-label">Households who experienced food shortage</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Water and Sanitation</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="water_and_sanitation" checked="" value="1">
                          <label class="form-check-label">Households without access to safe water
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="water_and_sanitation" value="2">
                          <label class="form-check-label">Households without access to sanitary toilet facility</label>
                        </div>

                      </div>
                    </div>

                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Property</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="property" checked="" value="1">
                          <label class="form-check-label">Private
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="property" value="2">
                          <label class="form-check-label">Public</label>
                        </div>

                      </div>
                    </div>

                  </div>

                </div>


              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_beneficiary">Create and Continue</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
        </div>
        <!-- Small boxes (Stat box) -->
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
                <h3 class="card-title">Logs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Date Time</th>
                      <th>Page</th>
                      <th>User</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($historyLogResult as $key => $values) {
                      $name = $values['user_id'] == 0 
                        ? 'Guest'
                        : $values['name'];

                      echo "
                        <tr>
                        <td>{$values['log_created_at']}</td>
                        <td>{$values['page_name']}</td>
                        <td>{$name}</td>
                        <td>{$values['actions']}</td>
                      </tr>
                        ";
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Date Time</th>
                      <th>Page</th>
                      <th>User</th>
                      <th>Action</th>
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
        order: [[0, 'DESC']],
        // columnDefs: [ {
        //     targets: -1,
        //     visible: false
        // } ]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });
  </script>
</body>

</html>

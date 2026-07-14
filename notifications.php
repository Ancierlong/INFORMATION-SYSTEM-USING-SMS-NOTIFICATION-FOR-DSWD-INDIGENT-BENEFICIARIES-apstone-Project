<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');

require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');
require_once(dirname(__FILE__) . '/Classes/Semaphore.php');

$page = 'Notifications';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = '';

$dbConn = (new SystemDatabaseConfig());

// for testing
// $recipientsArray = ['09957843128'];
// $message = 'hello world';
// $smsStatus = (new Semaphore)->sendMessage($recipientsArray, $message);
// var_dump($smsStatus);
// return;

$showAlert = null;
$sentId = $sent_by = $_SESSION["user"]['id'];
$categoryLib = [
  0 => 'All',
  99 => 'Not Included',
  1 => 'PWD',
  2 => 'Elderly',
  3 => 'Solo Parent'
];

$houseHoldconditionLib = [
  0 => 'All',
  99 => 'Not Included',
  1 => 'Makeshift Housing',
  2 => 'Informal Settlers'
];


$incomeAndLivelihoodLib = [
  0 => 'All',
  99 => 'Not Included',
  1 => 'Households with income below poverty threshold',
  2 => 'Households with income below food threshold',
  3 => 'Households who experienced food shortage',
];

$waterAndSanitation = [
  0 => 'All',
  99 => 'Not Included',
  1 => 'Households without access to safe water',
  2 => 'Households without access to sanitary toilet facility',
];

$propertyLib = [
  0 => 'All',
  99 => 'Not Included',
  1 => 'Private',
  2 => 'Public',
];


if (isset($_POST['send_notification'])) {

  $message = htmlentities(trim($_POST['message']));
  $remarks = "No Filter";
  $recipient_radio = htmlentities(trim($_POST['recipient_radio'])); // 1 -> category 2 - beneficiary
  $recipient_csv =  $recipient_radio == 1 ? '' : htmlentities(trim($_POST['recipient_id_csv']));
  $recipient_array = $recipient_csv == '' ? [] : explode(',', $recipient_csv);
  $whereInRecipient = count($recipient_array) > 0 ? "'" . implode("','", $recipient_array) . "'" : '';
  $hasFilter = false;

  if ($recipient_radio == 1) {
    $household_category = htmlentities(trim($_POST['household_category']));
    $category_category = htmlentities(trim($_POST['category_category']));
    $income_and_livelihood = htmlentities(trim($_POST['income_and_livelihood']));
    $water_and_sanitation = htmlentities(trim($_POST['water_and_sanitation']));
    // $property = htmlentities(trim($_POST['property']));

    $whereAndOptions = [];
    
    if ($household_category != 0 && $household_category != 99) {
      $whereAndOptions[] = "household_category = '{$household_category}'";
    } else if ($household_category == 0) {
      $whereAndOptions[] = "household_category IN (1,2)";
    } 

    if ($category_category != 0 && $category_category != 99) {
      $whereAndOptions[] = "category_category = '{$category_category}'";
    } else if ($category_category == 0) {
      $whereAndOptions[] = "category_category IN (1,2,3)";
    }

    if ($income_and_livelihood != 0 && $income_and_livelihood != 99) {
      $whereAndOptions[] = "income_and_livelihood = '{$income_and_livelihood}'";
    } else if ($income_and_livelihood == 0) {
      $whereAndOptions[] = "income_and_livelihood IN (1,2,3)";
    }

    if ($water_and_sanitation != 0 && $water_and_sanitation != 99) {
      $whereAndOptions[] = "water_and_sanitation = '{$water_and_sanitation}'";
    } else if ($water_and_sanitation == 0) {
      $whereAndOptions[] = "water_and_sanitation IN (1,2)";
    }

    // if ($property != 0 && $property != 99) {
    //   $whereAndOptions[] = "property = '{$property}'";
    // } else if ($property == 0) {
    //   $whereAndOptions[] = "property IN (1,2)";
    // }

    $whereAnd = empty($whereAndOptions)
      ? ''
      : " AND " . "(" . implode(' AND ', $whereAndOptions) . ")";
    
    $getBeneficiary = $dbConn->getConnection()
      ->query("SELECT b.id as recipient_id, b.mobile_number FROM beneficiaries b WHERE mobile_number != '' AND mobile_number IS NOT NULL AND is_deleted = 0 $whereAnd");
    $filterTemp = '';
    $filterTemp  .= "Category: {$categoryLib[$category_category]} | ";
    $filterTemp  .= "Household: {$houseHoldconditionLib[$household_category]} | ";
    $filterTemp  .= "Income and Livelihood: {$incomeAndLivelihoodLib[$income_and_livelihood]}| ";
    $filterTemp  .= "Water and Sanitation: {$waterAndSanitation[$water_and_sanitation]} | ";
    // $filterTemp  .= "Property: {$propertyLib[$property]}";
  
    $remarks =  $filterTemp;
  } else if ($recipient_radio == 2) {
    $getBeneficiary = $dbConn->getConnection()
      ->query("SELECT b.id as recipient_id, b.mobile_number FROM beneficiaries b WHERE b.id IN ($whereInRecipient)
    AND is_deleted = 0 AND mobile_number != '' AND mobile_number IS NOT NULL
   ");

    $remarks = "Selected beneficiaries.";
  }
  $getBeneficiaryResult = $getBeneficiary->fetch_all(MYSQLI_ASSOC);
  $sent_by = $user_id;
  $insertNotificationValues = $recipientsArray = [];
  foreach ($getBeneficiaryResult as $beneficiaryKey => $beneficiariesValue) {
    $insertNotificationValues[] = "( '{$beneficiariesValue['recipient_id']}', '{$message}', '{$remarks}', '{$sent_by}' )";
    $recipientsArray[] = $beneficiariesValue['mobile_number'];
  }

  $implodeInsertNotificationValues = implode(",", $insertNotificationValues);

  if (empty($implodeInsertNotificationValues) == false) {
    $insertNotifications = $dbConn->getConnection()
    ->query("INSERT INTO notifications (
      `recipient_id`,
      `message`,
      `remarks`,
      `sent_by_id`
      )
 VALUES $implodeInsertNotificationValues");

  $actions = 'New Notification';
  $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

  // send to sms
  $smsStatus = (new Semaphore)->sendMessage($recipientsArray, $message);

  $showAlert = 'success';
  } else {
    $showAlert = 'error';
  }

}

$notificationsQuery = $dbConn->getConnection()
  ->query("SELECT n.*, u.name as sent_name, b.first_name as b_first_name, b.middle_name as b_middle_name, b.last_name as b_last_name FROM notifications n
  LEFT JOIN users u ON n.sent_by_id = u.id
  LEFT JOIN beneficiaries b ON n.recipient_id = b.id
  ORDER BY created_at DESC");

$notificationsQueryyResult = $notificationsQuery->fetch_all(MYSQLI_ASSOC);

$allBeneficiaryQuery = $dbConn->getConnection()
  ->query("SELECT * FROM beneficiaries where is_deleted = 0 and status = 1  and mobile_number != '' and mobile_number IS NOT NULL order by id ASC");

$allBeneficiaryQueryyResult = $allBeneficiaryQuery->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | Notifications</title>

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
              <h1>Notifications</h1>
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
              <h4 class="modal-title">New Notification By Beneficiary</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="new_notif_form">
              <div class="modal-body">
                <input type="hidden" name="recipient_radio" value="2">
                <div class="col-12  group-by-beneficiary">
                  <table id="users_table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Name</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($allBeneficiaryQueryyResult as $allBeneficiaryQueryykey => $allBeneficiaryQueryyvalue) {
                        // <td><input class='form-check-input student_list_checkbox' data-attendance-id='{$value['attendance_id']}' data-user-id='{$value['id']}' type='checkbox' id='' value='{$value['attendance_id']}'> {$value['name']}</td>
                        echo "
                        <tr>

                        <td class='text-center'><input class='form-check-input beneficiary_checkbox'  data-user-id='{$allBeneficiaryQueryyvalue['id']}' data-mobile='{$allBeneficiaryQueryyvalue['mobile_number']}' type='checkbox'></td>

                          <td>{$allBeneficiaryQueryyvalue['first_name']} {$allBeneficiaryQueryyvalue['middle_name']} {$allBeneficiaryQueryyvalue['last_name']}</td>
                        </tr>
                      ";
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>

                      <tr>
                        <th></th>
                        <th>Name</th>

                      </tr>
                      </tr>
                    </tfoot>
                  </table>
                </div>



                <input type='hidden' id='checkbox_recipient_list' name="recipient_id_csv">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label class="col-form-label" for=""></span>Message</label>
                      <textarea type="text" class="form-control" id="" placeholder="" name="message" maxlength="200" required>Barangay Medicion I-B Announcement</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="send_notification" id="send-btn-beneficiary">Send</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-lg-category">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">New Notification By Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="new_notif_form">
              <div class="modal-body">
              <input type="hidden" name="recipient_radio" value="1">
                <div class="row  group-by-category">
                  <div class="col-sm-6">
                    <!-- radio -->
                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Category</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="category_category" checked="" value="0">
                          <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="category_category" value="1">
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
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="category_category" value="99">
                          <label class="form-check-label">Not Included</label>
                        </div>
                      </div>
                    </div>
                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Household Condition</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="household_category" checked="" value="0">
                          <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="household_category" value="1">
                          <label class="form-check-label">Makeshift Housing</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="household_category" value="2">
                          <label class="form-check-label">Informal Settlers</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="household_category" value="99">
                          <label class="form-check-label">Not Included</label>
                        </div>
                      </div>
                    </div>

                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Income and Livelihood</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="income_and_livelihood" checked="" value="0">
                          <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="income_and_livelihood" value="1">
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
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="income_and_livelihood" value="99">
                          <label class="form-check-label">Not Included</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Water and Sanitation</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="water_and_sanitation" checked="" value="0">
                          <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="water_and_sanitation" value="1">
                          <label class="form-check-label">Households without access to safe water
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="water_and_sanitation" value="2">
                          <label class="form-check-label">Households without access to sanitary toilet facility</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="water_and_sanitation" value="99">
                          <label class="form-check-label">Not Included</label>
                        </div>
                      </div>
                    </div>

                    <!-- <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Property</label>
                      <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="property" checked="" value="0">
                          <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="property" value="1">
                          <label class="form-check-label">Private
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="property" value="2">
                          <label class="form-check-label">Public</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="property" value="99">
                          <label class="form-check-label">Not Included</label>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label class="col-form-label" for=""></span>Message</label>
                      <textarea type="text" class="form-control" id="" placeholder="" name="message" maxlength="200" required>Barangay Medicion I-B Announcement</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="send_notification">Send</button>
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


            <div class="row my-2">
            <div class="col-md-3 col-sm-6 col-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                <i class="fas fa-plus"></i> New By Beneficiary
              </button>
            </div>
            <div class="col-md-3 col-sm-6 col-6">

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg-category">
                <i class="fas fa-plus"></i> New By Category
              </button>
            </div>


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
                <h3 class="card-title">Beneficiaries</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Sent by</th>
                      <th>Recipient</th>
                      <th>Message</th>
                      <th>Remarks</th>
                      <th>Sent Time</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($notificationsQueryyResult as $key => $value) {

                      echo "
                        <tr>
                          <td>{$value['id']}</td>
                          <td>{$value['sent_name']}</td>
                          <td>{$value['b_first_name']} {$value['b_middle_name']} {$value['b_last_name']}</td>
                          <td>{$value['message']}</td>
                          <td>{$value['remarks']}</td>
                          <td>{$value['created_at']}</td>
                        </tr>
                      ";
                    }
                    ?>


                  </tbody>
                  <tfoot>
                    <tr>

                      <th>ID</th>
                      <th>Sent by</th>
                      <th>Recipient</th>
                      <th>Message</th>
                      <th>Remarks</th>
                      <th>Sent Time</th>

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
      let BENEFICIARY_SELECTED = [];
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
        order: [
          [0, 'desc']
        ],
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

      var beni_table = null;
      $("#modal-lg").on('shown.bs.modal', function() {

        $(".group-by-category").show();
        $(".group-by-beneficiary").show();

        beni_table = $("#users_table").DataTable({
          "responsive": screen.width < 800 ? true : false,
          "lengthChange": false,
          "autoWidth": false,
          order: [
            [0, 'desc']
          ],
          "pageLength": 10,
          "scrollX": true,
          drawCallback: function (settings) {
            $('.beneficiary_checkbox').click(function() {
                let test = $(this);
                let newVal = BENEFICIARY_SELECTED;

                let checkedEventId = $('#checkbox_recipient_list').val();
                let id = test[0].getAttribute('data-user-id');

                if (test[0].checked == true) {
                  newVal.push(id);
                } else {
                  newVal = BENEFICIARY_SELECTED.filter((value) => value != id);
                }
                BENEFICIARY_SELECTED = [...new Set(newVal)];
                console.log(BENEFICIARY_SELECTED);
                $('#checkbox_recipient_list').val(BENEFICIARY_SELECTED);
              });
    },
          initComplete: function() {
            refreshCheckBox()

            $(".dataTables_paginate").bind("click", '.paginate_button', function(event) {
              refreshCheckBox();
            })


            function refreshCheckBox() {
              $('.beneficiary_checkbox').click(function() {
                let test = $(this);
                let newVal = BENEFICIARY_SELECTED;

                let checkedEventId = $('#checkbox_recipient_list').val();
                let id = test[0].getAttribute('data-user-id');

                if (test[0].checked == true) {
                  newVal.push(id);
                } else {
                  newVal = BENEFICIARY_SELECTED.filter((value) => value != id);
                }
                BENEFICIARY_SELECTED = [...new Set(newVal)];
                console.log(BENEFICIARY_SELECTED);
                $('#checkbox_recipient_list').val(BENEFICIARY_SELECTED);
              });
            }
          }
          // columnDefs: [ {
          //     targets: -1,
          //     visible: false
          // } ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        

        // if ($('input[name="recipient_radio"]:checked').val() == 1) {
        //   $(".group-by-beneficiary").hide();
        // } else {
        //   $(".group-by-category").hide();
        // }
        // $('.recipient-radio').click(function(){
        //   $(".group-by-category").hide();

        //   $(".group-by-beneficiary").hide();
        //     console.log('asdasd');
        //     console.log($(this).val())

        //     let beneficiary_category = $(this).val();

        //     if (beneficiary_category == 2) {
        //       $(".group-by-beneficiary").show();
        //     } else {
        //       $(".group-by-category").show();
        //     }
        // });


        // alert("I want this to appear after the modal has opened!");


      });


      $("#modal-lg").on('hidden.bs.modal', function() {
        $("#users_table").DataTable().destroy();
        $('#checkbox_recipient_list').val('');
        $('.beneficiary_checkbox').removeAttr('checked');
        BENEFICIARY_SELECTED = [];
        document.getElementById("new_notif_form").reset();
      });

      $("#send-btn-beneficiary").on('click', function(event) {
      console.log(BENEFICIARY_SELECTED);
        if (BENEFICIARY_SELECTED == '') {
          event.preventDefault();
          toastr.error('Error: Please select beneficiary.')
          return;
        }

        $(this).trigger('click');
      })

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
        toastr.success('Successfully Sent!')
      }

      if (showAlert == 'warning') {
        toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      }

      if (showAlert == 'error') {
        toastr.error('Something went wrong.')
      }

      if (showAlert == 'info') {
        toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      }
    });
  </script>
</body>

</html>

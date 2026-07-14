<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');

require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$page = 'Beneficiaries';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = '';
$isSuperAdmin = $_SESSION['user']['role'] == 3;
$dbConn = (new SystemDatabaseConfig());

$lrif_number = null;
$indigent_start_date = null;
$first_name = null;
$middle_name = null;
$last_name = null;
$birthday = null;
$gender = null;
$address = null;
$mobile_number = null;
$email = null;
$household_category = null;
$showAlert = null;

if (isset($_POST['add_beneficiary'])) {
  $lrif_number = htmlentities(trim($_POST['lrif_number']));
  $indigent_start_date = htmlentities(trim($_POST['indigent_start_date']));
  $first_name = htmlentities(trim($_POST['first_name']));
  $middle_name = htmlentities(trim($_POST['middle_name']));
  $last_name = htmlentities(trim($_POST['last_name']));
  $birthday = htmlentities(trim($_POST['birthday']));
  $gender = htmlentities(trim($_POST['gender']));
  $address = htmlentities(trim($_POST['address']));
  $mobile_number =  htmlentities(trim($_POST['mobile_number']));
  $email = null;
  $household_category = htmlentities(trim($_POST['household_category']));
  $category_category = htmlentities(trim($_POST['category_category']));
  $income_and_livelihood = htmlentities(trim($_POST['income_and_livelihood']));
  $water_and_sanitation = htmlentities(trim($_POST['water_and_sanitation']));
  $property = htmlentities(trim($_POST['property']));
  $skill = htmlentities(trim($_POST['skills']));


   // image
   if ($_FILES['image']['name'] != "") {
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $ext_array = explode('.', $file_name);
    $file_ext=strtolower(end($ext_array));

    $extensions= array("jpeg","jpg","png");

   //  if(in_array($file_ext,$extensions)=== false){
   //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
   //  }
    $new_filename = date('ymdhis') . "_" . $last_name . "_" . $first_name . "." . $file_ext;
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"upload_images/".$new_filename);
    }else{
       print_r($errors);
    }
   }

   if ($_FILES['image']['name'] != "") {
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $ext_array = explode('.', $file_name);
    $file_ext=strtolower(end($ext_array));

    $extensions= array("jpeg","jpg","png");

   //  if(in_array($file_ext,$extensions)=== false){
   //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
   //  }
    $new_filename = date('ymdhis') . "_" . $last_name . "_" . $first_name . "." . $file_ext;
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"upload_images/".$new_filename);
    }else{
       print_r($errors);
    }
   }
   if ($_FILES['file1']['name'] != "") {
    $file_name = $_FILES['file1']['name'];
    $file_size =$_FILES['file1']['size'];
    $file_tmp =$_FILES['file1']['tmp_name'];
    $file_type=$_FILES['file1']['type'];
    $ext_array = explode('.', $file_name);
    $file_ext=strtolower(end($ext_array));

    $extensions= array("jpeg","jpg","png");

   //  if(in_array($file_ext,$extensions)=== false){
   //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
   //  }
    $new_filename_file1 = date('ymdhis') . "_" . $last_name . "_" . $first_name . "_file1." . $file_ext;
    if(empty($errors)==true){
      move_uploaded_file($file_tmp,"upload_images/beneficiary_files/".$new_filename_file1);
    }else{
       print_r($errors);
    }
   }

   if ($_FILES['file2']['name'] != "") {
    $file_name = $_FILES['file2']['name'];
    $file_size =$_FILES['file2']['size'];
    $file_tmp =$_FILES['file2']['tmp_name'];
    $file_type=$_FILES['file2']['type'];
    $ext_array = explode('.', $file_name);
    $file_ext=strtolower(end($ext_array));

    $extensions= array("jpeg","jpg","png");

   //  if(in_array($file_ext,$extensions)=== false){
   //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
   //  }
    $new_filename_file2 = date('ymdhis') . "_" . $last_name . "_" . $first_name . "_file2." . $file_ext;
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"upload_images/beneficiary_files/".$new_filename_file2);
    }else{
       print_r($errors);
    }
   }

  $query = $dbConn->getConnection()
    ->query("INSERT INTO beneficiaries (
      `lrif_number`,
      `first_name`,
      `middle_name`,
      `last_name`,
      `address`,
      `gender`,
      `birthday`,
      `mobile_number`,  `email`,
      `indigent_start_date`,
      `household_category`,
      `category_category`,
      `income_and_livelihood`,
      `water_and_sanitation`,
      `property`,
      `skill`
      )
VALUES
('{$lrif_number}', '{$first_name}', '{$middle_name}',  '{$last_name}', '{$address}', '{$gender}',
 '{$birthday}', '{$mobile_number}',  '{$email}', '{$indigent_start_date}', '{$household_category}',
  '{$category_category}',
  '{$income_and_livelihood}',
  '{$water_and_sanitation}',
  '1',
  '{$skill}')");
  $lastInsertedId = $dbConn->getConnection()->insert_id;

  $actions = 'Add Beneficiary';
  $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

  if ($_FILES['image']['name'] != "") {
    $dbConn->getConnection()
    ->query("UPDATE beneficiaries SET image_file_name = '{$new_filename}' WHERE id = {$lastInsertedId}");
  }

  if ($_FILES['file1']['name'] != "") {
    $dbConn->getConnection()
    ->query("UPDATE beneficiaries SET file1 = '{$new_filename_file1}' WHERE id = {$lastInsertedId}");
  }

  if ($_FILES['file2']['name'] != "") {
    $dbConn->getConnection()
    ->query("UPDATE beneficiaries SET file2 = '{$new_filename_file2}' WHERE id = {$lastInsertedId}");
  }

  $showAlert = 'success';

  if ($_SESSION['user']['role'] == 2) {
    header("Location: beneficiaries.php");
    return; 
  }

  header("Location: beneficiary.php?id={$lastInsertedId}");
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

        $deletequery = "DELETE FROM beneficiaries WHERE id IN ($implode)";
        $query = $dbConn->getConnection()
            ->query($deletequery);
        $successMessage = "Deleted";
        $showAlert = 'successDelete';
}

if (isset($_POST['delete_selected_rows_all'])) {
  $deletequery = "DELETE FROM beneficiaries WHERE is_deleted = 0 AND status=1";
  $query = $dbConn->getConnection()
      ->query($deletequery);
  $successMessage = "Deleted";
  $showAlert = 'successDelete';
}

unset($_POST);

$beneficiariesQuery = $dbConn->getConnection()
  ->query("SELECT * FROM beneficiaries WHERE is_deleted = 0 AND status=1");
$beneficiariesResult = $beneficiariesQuery->fetch_all(MYSQLI_ASSOC);

$inactiveBeneficiariesQuery = $dbConn->getConnection()
  ->query("SELECT * FROM beneficiaries WHERE is_deleted = 1 AND status=1");
$inactiveBeneficiariesResult = $inactiveBeneficiariesQuery->fetch_all(MYSQLI_ASSOC);

$allBeneficiaryResult = $beneficiariesResult;

$beneficiaryFamilyQuery = $dbConn->getConnection()
  ->query("SELECT bf.first_name as bf_first_name, bf.middle_name as bf_middle_name, bf.last_name as bf_last_name, bf.beneficiary_id as bf_beneficiary_id
FROM beneficiaries b INNER JOIN beneficiary_family_members bf ON bf.id = b.id WHERE b.is_deleted = 0 and bf.is_deleted = 0");

$beneficiaryFamilyResult = $beneficiaryFamilyQuery->fetch_all(MYSQLI_ASSOC);
$formattedResult = [];

foreach ($beneficiaryFamilyResult as $bfkey => $bfvalue) {
  $formattedResult[$bfvalue['bf_beneficiary_id']][] = $bfvalue;
  $formattedResult[$bfvalue['bf_beneficiary_id']]['string'][] = $bfvalue['bf_last_name'] . ', ' . $bfvalue['bf_first_name'] . ' ' . $bfvalue['bf_middle_name'];
  $formattedResult[$bfvalue['bf_beneficiary_id']]['final'] = implode('<br>', $formattedResult[$bfvalue['bf_beneficiary_id']]['string']);
}

$categoryLib = [
  0 => 'N/A',
  1 => 'PWD',
  2 => 'Elderly',
  3 => 'Solo Parent'
];

$houseHoldconditionLib = [
  0 => 'N/A',
  1 => 'Makeshift Housing',
  2 => 'Informal Settlers'
];


$incomeAndLivelihoodLib = [
  0 => 'N/A',
  1 => 'Households with income below poverty threshold',
  2 => 'Households with income below food threshold',
  3 => 'Households who experienced food shortage',
];

$waterAndSanitation = [
  0 => 'N/A',
  1 => 'Households without access to safe water',
  2 => 'Households without access to sanitary toilet facility',
];

$propertyLib = [
  0 => 'N/A',
  1 => 'Private',
  2 => 'Public',
];

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
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Beneficiaries</h1>
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
                      <input type="text" class="form-control input-lrif" placeholder="ex. 1001" maxlength="10" name="lrif_number" required>
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
                      <label class="col-form-label" for="">Mobile Number</label>
                      <input type="text" class="form-control input-numbers" id="" placeholder="ex. 09912345678" name="mobile_number" maxlength="11" minlength="11" value="">
                    </div>
                  </div>
                </div>

                <!-- input states -->
                <!-- <div class="form-group">
                  <label class="col-form-label" for=""><span style="color:red">* </span>Email</label>
                  <input type="email" class="form-control" id="" placeholder="ex. j.delacruz@gmail.com" name="email" required maxlength="50">
                </div> -->

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

                    <!-- <div>
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
                    </div> -->

                  </div>

                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="exampleInputFile"><span style="color:red">* </span>File</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file1" name="file1" accept="image/png, image/jpeg, image/jpg">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <!-- <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="exampleInputFile">File</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file2" name="file2" accept="image/png, image/jpeg, image/jpg">
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <!-- <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div> -->
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
          <div class="row my-2">
            <div class="col-md-3 col-sm-6 col-6">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                <i class="fas fa-user-plus"></i> Add
              </button>
            </div>
            <?php if ($isSuperAdmin == true){?>
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
                      <button name='delete_selected_rows_all' class='dropdown-item'>Delete all</button>
                    
                    </div>
                  </div>
                </form>
              </div>
              <?php } ?>
            <div class="col-md-3 col-sm-6 col-6">
              <a type="button" target="_blank" href="generate_report.php" name="generate_report_btn" class="btn btn-success"><i class="nav-icon  fas fa-download"></i> Generate Report</a>
            </div>
          </div>
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Active</span>
                <span class="info-box-number"><?php echo count($beneficiariesResult) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-gray"><i class="fas fa-users-slash"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Inactive</span>
                <span class="info-box-number"><?php echo count($inactiveBeneficiariesResult) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <span class="info-box-number"><?php echo count($beneficiariesResult) + count($inactiveBeneficiariesResult) ?></span>
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
                <h3 class="card-title">Beneficiaries</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>LRIF #</th>
                      <th>Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Skills</th>
                      <th>Birthday</th>
                      <!-- <th>Email</th> -->
                      <th>Contact #</th>
                      <th>Indigent Start Date</th>
                      <th>Address</th>
                      <th>Household</th>
                      <th>Category</th>
                      <th>Income and Livelihood</th>
                      <th>Water and Sanitation</th>
                      <!-- <th>Property</th> -->
                      <th>Family Members</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $isDeletedLib = [
                      0 => 'Active',
                      1 => 'Inactive'
                    ];

                    $householdLib = [
                      0 => 'N/A',
                      1 => 'Makeshift Housing',
                      2 => 'Informal Settlers'
                    ];

                    $genderLib = [
                      0 => "N/A",
                      1 => "Male",
                      2 => "Female"
                    ];
                    foreach ($allBeneficiaryResult as $key => $beneficiary) {
                      $familyList = isset($formattedResult[$beneficiary['id']]) ? $formattedResult[$beneficiary['id']]['final'] : '-';
                      $date1 = new DateTime();
                      $date2 = new DateTime($beneficiary['birthday']);
                      $age = $date1->diff($date2)->y;
                      $checkbox = $isSuperAdmin ? "<input type='checkbox' class='student_list_checkbox' value={$beneficiary['id']} data-user-id={$beneficiary['id']}>" : "";
                      echo "
                        <tr>
                        <td>
                        ".
                       $checkbox
                        ."
                        
                        <a href='beneficiary.php?id={$beneficiary['id']}'> <i class='fas fa-pen'></i></a>{$beneficiary['id']}</td>
                        <td>{$beneficiary['lrif_number']}</td>
                        <td>{$beneficiary['last_name']}, {$beneficiary['first_name']} {$beneficiary['middle_name']} </td>
                        <td>{$age}</td>
                        <td>{$genderLib[$beneficiary['gender']]}</td>
                        <td>{$beneficiary['skill']}</td>
                        <td>{$beneficiary['birthday']}</td>
            
                        <td>{$beneficiary['mobile_number']}</td>
                        <td>{$beneficiary['indigent_start_date']}</td>
                        <td>{$beneficiary['address']}</td>
                        <td>{$householdLib[$beneficiary['household_category']]}</td>
                        <td>{$categoryLib[$beneficiary['category_category']]}</td>
                        <td>{$incomeAndLivelihoodLib[$beneficiary['income_and_livelihood']]}</td>
                        <td>{$waterAndSanitation[$beneficiary['water_and_sanitation']]}</td>
     
                        <td>{$familyList}</td>
                      </tr>

                        ";
                    }
                    ?>

                  </tbody>
                  <tfoot>
                    <tr>

                      <th>ID</th>
                      <th>LRIF #</th>
                      <th>Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Skills</th>
                      <th>Birthday</th>
                      <!-- <th>Email</th> -->
                      <th>Contact #</th>
                      <th>Indigent Start Date</th>
                      <th>Address</th>
                      <th>Household</th>
                      <th>Category</th>
                      <th>Income and Livelihood</th>
                      <th>Water and Sanitation</th>
                      <!-- <th>Property</th> -->
                      <th>Family Members</th>
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
      document.getElementById("file1").required = true
      var SELECTED_STUDENTS = []
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }

      $(".input-lrif").keypress(function(event) {
        return /^[\d./-]+$/.test(String.fromCharCode(event.keyCode));
      });

      $(".input-numbers").keypress(function(event) {
        return /\d/.test(String.fromCharCode(event.keyCode));
      });
      $(".input-name").keypress(function(event) {
        return /^[a-zA-Z.\s]*$/.test(String.fromCharCode(event.keyCode));
      });

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
      if (showAlert == 'successDelete') {
        toastr.success('Successfully Deleted!')
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

<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');
require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$page = 'Beneficiary';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = '';

$isStaff = false;
if ($_SESSION['user']['role'] != 1 && $_SESSION['user']['role'] != 3) {
  $isStaff = true;

}

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
$is_deleted = null;
$showAlert = null;
$alertMessage = null;
$age = 0;

if (isset($_GET['id']) == false) {
  header('Location: beneficiaries.php');
}

$id = $beneficiaryId = $_GET['id'];

if (isset($_POST['update_beneficiary'])) {


  $lrif_number = htmlentities(trim($_POST['lrif_number']));
  $indigent_start_date = htmlentities(trim($_POST['indigent_start_date']));
  $first_name = htmlentities(trim($_POST['first_name']));
  $middle_name = htmlentities(trim($_POST['middle_name']));
  $last_name = htmlentities(trim($_POST['last_name']));
  $birthday = htmlentities(trim($_POST['birthday']));
  $gender = htmlentities(trim($_POST['gender']));
  $address = htmlentities(trim($_POST['address']));
  $mobile_number =  htmlentities(trim($_POST['mobile_number']));
  $email = strtolower(preg_replace('/\s+/', '_', $first_name. '_' . $last_name ."@email.com"));
  $household_category = htmlentities(trim($_POST['household_category']));
  $is_deleted = htmlentities(trim($_POST['is_deleted']));
  $status = htmlentities(trim($_POST['status']));
  $category_category = htmlentities(trim($_POST['category_category']));
  $income_and_livelihood = htmlentities(trim($_POST['income_and_livelihood']));
  $water_and_sanitation = htmlentities(trim($_POST['water_and_sanitation']));
  $household_family_structure = htmlentities(trim($_POST['household_family_structure']));
  
  $employment = htmlentities(trim($_POST['employment']));
  $occupation = $employment == 1 ? htmlentities(trim($_POST['occupation'])) : '';
  $property = 1;
  $family_update = isset($_POST['family_update']) ? $_POST['family_update'] : [];
  $remove_image = isset($_POST['remove_image']) && $_POST['remove_image'] == 1;
  $remove_file_1 =  isset($_POST['remove_file_1']) && $_POST['remove_file_1'] == 1;
  $remove_file_2 =  isset($_POST['remove_file_2']) && $_POST['remove_file_2'] == 1;
  $reason_for_rejection = $status == 2 ? $_POST['reason_for_rejection'] : null;

  try {
    // image
    if ($_FILES['image']['name'] != "") {
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $ext_array = explode('.', $file_name);
      $file_ext = strtolower(end($ext_array));

      $extensions = array("jpeg", "jpg", "png");

      //  if(in_array($file_ext,$extensions)=== false){
      //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      //  }
      $new_filename = date('ymdhis') . "_" . $last_name . "_" . $first_name . "." . $file_ext;
      if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "upload_images/" . $new_filename);
      } else {
        print_r($errors);
      }
    }

    $beneficiary_file_names = [
      'file1', 'file2'
    ];


    if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] != "") {
      $file_name = $_FILES['file1']['name'];
      $file_size = $_FILES['file1']['size'];
      $file_tmp = $_FILES['file1']['tmp_name'];
      $file_type = $_FILES['file1']['type'];
      $ext_array = explode('.', $file_name);
      $file_ext = strtolower(end($ext_array));

      $extensions = array("jpeg", "jpg", "png");

      //  if(in_array($file_ext,$extensions)=== false){
      //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      //  }
      $new_filename_file1 = date('ymdhis') . "_" . $last_name . "_" . $first_name . "." . $file_ext;
      if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "upload_images/beneficiary_files/" . $new_filename_file1);
      } else {
        print_r($errors);
      }
    }

    if (isset($_FILES['file2']['name']) && $_FILES['file2']['name'] != "") {
      $file_name = $_FILES['file2']['name'];
      $file_size = $_FILES['file2']['size'];
      $file_tmp = $_FILES['file2']['tmp_name'];
      $file_type = $_FILES['file2']['type'];
      $ext_array = explode('.', $file_name);
      $file_ext = strtolower(end($ext_array));

      $extensions = array("jpeg", "jpg", "png");

      //  if(in_array($file_ext,$extensions)=== false){
      //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      //  }
      $new_filename_file2 = date('ymdhis') . "_" . $last_name . "_" . $first_name . "." . $file_ext;
      if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "upload_images/beneficiary_files/" . $new_filename_file2);
      } else {
        print_r($errors);
      }
    }


    // beneficiary
    $updateQuery = " UPDATE beneficiaries SET
    lrif_number = '{$lrif_number}',
    first_name = '{$first_name}',
    middle_name = '{$middle_name}',
    last_name = '{$last_name}',
    address = '{$address}',
    gender = '{$gender}',
    birthday  = '{$birthday}',
    mobile_number = '{$mobile_number}',
    email = '{$email}',
    indigent_start_date = '{$indigent_start_date}',
    household_category = '{$household_category}',
    category_category = '{$category_category}',
    income_and_livelihood = '{$income_and_livelihood}',
    water_and_sanitation = '{$water_and_sanitation}',
    household_family_structure = '{$household_family_structure}',
    occupation = '{$occupation}',
    employment = '{$employment}',
    property = '{$property}',
    is_deleted = '{$is_deleted}',
    reason_for_rejection = '{$reason_for_rejection}',
    status = '{$status}' ";

    if ($_FILES['image']['name'] != "") {
      $updateQuery .= ", image_file_name = '{$new_filename}' ";
    } else if ($remove_image == true) {
      $updateQuery .= ", image_file_name = NULL ";
    }

    if (isset($_FILES['file1']['name']) && $_FILES['file1']['name'] != "") {
      $updateQuery .= ", file1 = '{$new_filename_file1}' ";
    }
    else if ($remove_file_1 == true) {
      $updateQuery .= ", file1 = NULL ";
    }

    if (isset($_FILES['file2']['name']) && $_FILES['file2']['name'] != "") {
      $updateQuery .= ", file2 = '{$new_filename_file2}' ";
    }else if ($remove_file_2 == true) {
      $updateQuery .= ", file2 = NULL ";
    }

     if ($status == 2) {
      $updateQuery .= ", rejected_by = '{$user_id}' ";
     } else {
      $updateQuery .= ", rejected_by = null ";
     }

    $updateQuery .= "WHERE id = '$id'";

    $query = $dbConn->getConnection()
      ->query($updateQuery);

    // family details
    foreach ($family_update as $famUpdateKey => $famUpdateValue) {
      $updateQuery = " UPDATE beneficiary_family_members SET
      first_name = '{$famUpdateValue['first_name']}',
      middle_name = '{$famUpdateValue['middle_name']}',
      last_name = '{$famUpdateValue['last_name']}',
      birthday = '{$famUpdateValue['birthday']}',
      gender = '{$famUpdateValue['gender']}',
      family_role = '{$famUpdateValue['family_role']}',
      skill = '{$famUpdateValue['skill']}'
      WHERE id = '{$famUpdateValue['family_id']}'";

      $query = $dbConn->getConnection()
        ->query($updateQuery);
    }

    $actions = "Update beneficiary / Save Family member";
    $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

    $showAlert = 'success';
    $alertMessage = 'Success!';
  } catch (Exception $e) {
    $errorExceptionMessage = $alertMessage = $e->getMessage();
    $showAlert = 'error';
  }
}


if (isset($_POST['save-family-btn'])) {

  $add_family_first_name =  htmlentities(trim($_POST["add_family_first_name"]));
  $add_family_middle_name =  htmlentities(trim($_POST["add_family_middle_name"]));
  $add_family_last_name =  htmlentities(trim($_POST["add_family_last_name"]));
  $add_family_birthday =  htmlentities(trim($_POST["add_family_birthday"]));
  $add_gender =  htmlentities(trim($_POST["add_family_gender"]));
  $beneficiary_id = htmlentities(trim($_POST["beneficiary_id"]));
  $family_role_id = htmlentities(trim($_POST["add_family_role"]));
  $family_skill = htmlentities(trim($_POST["add_family_skills"]));
  $query = $dbConn->getConnection()
    ->query("INSERT INTO beneficiary_family_members (
    `beneficiary_id`,
    `first_name`,
    `middle_name`,
    `last_name`,  
    `birthday`,
    `gender`,
    `family_role`,
    `skill`
    )
VALUES
(
'{$beneficiary_id}',
'{$add_family_first_name}',
'{$add_family_middle_name}',
'{$add_family_last_name}',
'{$add_family_birthday}',
'{$add_gender}',
'{$family_role_id}',
'{$family_skill}')");
  $lastInsertedId = $dbConn->getConnection()->insert_id;
  $alertMessage = 'Family Member has been added!';
  $showAlert = 'success';
  $actions = "New Family Member";
  $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);
}
$beneficiariesQuery = $dbConn->getConnection()
  ->query("SELECT * FROM beneficiaries WHERE id = $id");
$beneficiariesResult = $beneficiariesQuery->fetch_all(MYSQLI_ASSOC);

$date1 = new DateTime();
$date2 = new DateTime($beneficiariesResult[0]['birthday']);
$age = $date1->diff($date2)->y;

if (count($beneficiariesResult) < 1) {
  header('Location: beneficiaries.php');
}

if (isset($_POST['archive-family-btn'])) {

  $familyMembersIdList = implode(",", $_POST['family_members']);


  try {
    $updateQuery = " UPDATE beneficiary_family_members SET is_deleted = 1 WHERE id IN ($familyMembersIdList)";

    $query = $dbConn->getConnection()
      ->query($updateQuery);
    $actions = "Archive Family member";
    $dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);
    $showAlert = 'success';
    $alertMessage = 'Success!';
  } catch (Exception $e) {
    $errorExceptionMessage = $alertMessage = $e->getMessage();
    $showAlert = 'error';
  }
}
unset($_POST);

$familyQuery = $dbConn->getConnection()
  ->query("SELECT * FROM beneficiary_family_members WHERE beneficiary_id = $id and is_deleted = 0");
$familyResult = $familyQuery->fetch_all(MYSQLI_ASSOC);

$familyRoleRefQuery = $dbConn->getConnection()
  ->query("SELECT * FROM family_role_ref WHERE is_deleted = 0");
$familyRoleRefResult = $familyRoleRefQuery->fetch_all(MYSQLI_ASSOC);



$lrifIdsQuery = $dbConn->getConnection()
  ->query("SELECT lrif_number from beneficiaries where id != $id ");
  $lrifIdsResult = $lrifIdsQuery->fetch_all(MYSQLI_ASSOC);

$listLrif = array_column($lrifIdsResult, 'lrif_number');

$lrifJson = json_encode($listLrif);

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
              <h1>Beneficiary Profile</h1>
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
                <div class="card-header">
                  <h3 class="card-title">Beneficiary</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <form action="" method="POST" enctype="multipart/form-data" id="
                  ">
                    <div class="modal-body">
                    <div class="row">
                      <?php if ($isStaff == false) {?> 
                        <div class="col-sm-6">
                          <!-- radio -->
                          <label class="col-form-label" for=""><span style="color:red">* </span>Status</label>
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input radio_status" type="radio" name="status" value="0" checked="<?= $beneficiariesResult['0']['status'] == 0 ? 'checked' : ''; ?>">
                              <label class="form-check-label">Pending</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input radio_status" type="radio" name="status" value="1" <?= $beneficiariesResult['0']['status'] == 1 ? 'checked' : ''; ?>>
                              <label class="form-check-label">Approved</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input radio_status" type="radio" name="status" value="2" <?= $beneficiariesResult['0']['status'] == 2 ? 'checked' : ''; ?> id="radio_rejected">
                              <label class="form-check-label">Rejected</label>
                            </div>

                            <div class="form-group rejected_input_group">
                        <label class="col-form-label" for=""></span>Reason for Rejection</label>
                        <input type="text" class="form-control" id="reason_for_rejection" placeholder="" name="reason_for_rejection" value="<?= $beneficiariesResult['0']['reason_for_rejection']; ?>" <?= $beneficiariesResult['0']['status'] == 2 ? '' : 'disabled'; ?>>
                      </div>

                          </div>
                        </div>
                        <?php } else {
                      
                          ?>
<input hidden class="form-check-input" type="radio" name="status" value="<?= $beneficiariesResult['0']['status'] ?>" checked>
                          <?php
                          
                        }?>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="card-body box-profile">
                            <div class="text-center">
                              <img class="profile-user-img img-fluid" onerror="if (this.src != 'default.jpeg') this.src = 'default.jpeg';" src="upload_images/<?= $beneficiariesResult['0']['image_file_name']; ?>" alt="User profile picture"
                               style="max-width: 300px; width: 300px">
<br>
                      <?php 
                      if (is_null($beneficiariesResult['0']['image_file_name']) == false) {
                          ?> 
                          <a target="_blank"  href="upload_images/<?= $beneficiariesResult['0']['image_file_name']; ?>" download> Download here</a>
                          <?php
                      } else {
                        ?>
                        No Photo
<?php
                      }
                      ?>
                     
                    

                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="exampleInputFile">Image</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" accept="image/png, image/jpeg, image/jpg">
                                <label class="custom-file-label" for="exampleInputFile" id="image-label">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                              </div>
                            </div>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="remove_image" value="1">
                            <label for="customCheckbox2" class="custom-control-label">Remove image</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- text input -->
                          <div class="form-group">
                            <label><span style="color:red">* </span>LRIF #</label> <span id="lrif_error" style="color:red; font-size: 10px; display: none;">LRIF # already exists.</span>
                            <input type="text" class="form-control input-lrif" id="lrif_number" placeholder="ex. 1001" maxlength="10" name="lrif_number" value="<?= $beneficiariesResult['0']['lrif_number']; ?>" required>
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
                            <input class="form-control input-name" rows="3" placeholder="ex. Juan." name="first_name" value="<?= $beneficiariesResult['0']['first_name']; ?>" maxlength="50" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label><span style="color:red"></span>Middle Name</label>
                            <input class="form-control input-name" rows="3" placeholder="ex. Gonzaga" name="middle_name" value="<?= $beneficiariesResult['0']['middle_name']; ?>" maxlength="50">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                            <label><span style="color:red">* </span>Last Name</label>
                            <input class="form-control input-name" rows="3" placeholder="ex. Dela Cruz" name="last_name" value="<?= $beneficiariesResult['0']['last_name']; ?>" required maxlength="50">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label><span style="color:red">* </span>Date Of Birth (<?= $age ?> years old)</label>
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
                              <input class="form-check-input" type="radio" name="gender" <?= $beneficiariesResult['0']['gender'] == 1 ? "checked" : ''; ?> value="1">
                              <label class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" value="2" <?= $beneficiariesResult['0']['gender'] == 2 ? "checked" : ''; ?>>
                              <label class="form-check-label">Female</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="col-form-label" for=""></span>Mobile Number</label>
                            <input type="text" class="form-control input-numbers" id="" placeholder="ex. 09912345678" name="mobile_number" value="<?= $beneficiariesResult['0']['mobile_number']; ?>" maxlength="11">
                          </div>
                        </div>
                      </div>

                      <!-- input states -->
                      <!-- <div class="form-group">
                        <label class="col-form-label" for=""><span style="color:red">* </span>Email</label>
                        <input type="email" class="form-control" id="" placeholder="ex. j.delacruz@gmail.com" name="email" value="<?= $beneficiariesResult['0']['email']; ?>" required maxlength="50">
                      </div> -->

                      <div class="form-group">
                        <label class="col-form-label" for=""><span style="color:red">* </span>Address</label>
                        <input type="text" class="form-control" id="" placeholder="ex. 123 Quezon City" name="address" value="<?= $beneficiariesResult['0']['address']; ?>" required maxlength="100">
                      </div>

                      <div class="form-group">
                        <label class="col-form-label" for=""></span>Skills</label>
                        <input type="text" class="form-control" id="" placeholder="" name="skills" maxlength="100" value="<?= $beneficiariesResult['0']['skill']; ?>">
                      </div>

                      <div class="row">
                  <div class="col-sm-6">
                    <!-- radio -->
                    <label class="col-form-label" for=""><span style="color:red">* </span>Employment Status</label>
                    <div class="form-group">
                      <div class="form-check">
                        <input class="form-check-input employment_status" type="radio" name="employment" id="unemployed" <?= $beneficiariesResult['0']['employment'] == 2 ? "checked" : ''; ?> value="2">
                        <label class="form-check-label">Unemployed</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input employment_status" type="radio" name="employment"   <?= $beneficiariesResult['0']['employment'] == 1 ? "checked" : ''; ?> id="employed" value="1">
                        <label class="form-check-label">Employed</label>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="form-group occupation-group">
                        <label class="col-form-label" for=""><span style="color:red">* </span>Occupation</label>
                        <input type="text" class="form-control" id="occupation" placeholder="" name="occupation" value="<?= $beneficiariesResult['0']['occupation'] ?>">
                  </div>

                      <?php if ($isStaff == false) {?> 
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- radio -->
                          <label class="col-form-label" for=""><span style="color:red">* </span>Active</label>
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="is_deleted" value="0" checked="<?= $beneficiariesResult['0']['is_deleted'] == 0 ? 'checked' : ''; ?>">
                              <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="is_deleted" value="1" <?= $beneficiariesResult['0']['is_deleted'] == 1 ? 'checked' : ''; ?>>
                              <label class="form-check-label">Inactive</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php }?> 

                      <hr>
                      <div class="row">
                        <div class="col-sm-6">
                          <!-- radio -->
                          <div>
                            <label class="col-form-label" for=""><span style="color:red">* </span>Category</label>
                            <div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="category_category" <?= $beneficiariesResult['0']['category_category'] == 1 ? 'checked' : ''; ?> value="1">
                                <label class="form-check-label">PWD</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="category_category" <?= $beneficiariesResult['0']['category_category'] == 2 ? 'checked' : ''; ?> value="2">
                                <label class="form-check-label">Elderly</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="category_category" <?= $beneficiariesResult['0']['category_category'] == 3 ? 'checked' : ''; ?> value="3">
                                <label class="form-check-label">Solo Parent</label>
                              </div>
                            </div>
                          </div>
                          <div>
                            <label class="col-form-label" for=""><span style="color:red">* </span>Household Condition</label>
                            <div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="household_category" <?= $beneficiariesResult['0']['household_category'] == 1 ? 'checked' : ''; ?> value="1">
                                <label class="form-check-label">Makeshift Housing</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="household_category" <?= $beneficiariesResult['0']['household_category'] == 2 ? 'checked' : ''; ?> value="2">
                                <label class="form-check-label">Informal Settlers</label>
                              </div>
                            </div>
                          </div>

                          <div>
                            <label class="col-form-label" for=""><span style="color:red">* </span>Income and Livelihood</label>
                            <div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="income_and_livelihood" <?= $beneficiariesResult['0']['income_and_livelihood'] == 1  ? 'checked' : ''; ?> value="1">
                                <label class="form-check-label">Households with income below poverty threshold</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="income_and_livelihood" <?= $beneficiariesResult['0']['income_and_livelihood'] == 2 ? 'checked' : ''; ?> value="2">
                                <label class="form-check-label">Households with income below food threshold</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="income_and_livelihood" <?= $beneficiariesResult['0']['income_and_livelihood'] == 3 ? 'checked' : ''; ?> value="3">
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
                                <input class="form-check-input" type="radio" name="water_and_sanitation" <?= $beneficiariesResult['0']['water_and_sanitation'] == 1 ? 'checked' : ''; ?> value="1">
                                <label class="form-check-label">Households without access to safe water
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="water_and_sanitation" <?= $beneficiariesResult['0']['water_and_sanitation'] == 2 ? 'checked' : ''; ?> value="2">
                                <label class="form-check-label">Households without access to sanitary toilet facility</label>
                              </div>

                            </div>
                          </div>

                          <div>
                      <label class="col-form-label" for=""><span style="color:red">* </span>Household Family Structure</label>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="household_family_structure" <?= $beneficiariesResult['0']['household_family_structure'] == 1 || $beneficiariesResult['0']['household_family_structure'] == 0 ? 'checked' : ''; ?> value="1">
                            <label class="form-check-label">Single Parent Family
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="household_family_structure" <?= $beneficiariesResult['0']['household_family_structure'] == 2 ? 'checked' : ''; ?> value="2">
                            <label class="form-check-label">Single Household</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="household_family_structure" <?= $beneficiariesResult['0']['household_family_structure'] == 3 ? 'checked' : ''; ?>  value="3">
                            <label class="form-check-label">Childless Family</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="household_family_structure" <?= $beneficiariesResult['0']['household_family_structure'] == 4 ? 'checked' : ''; ?> value="4">
                            <label class="form-check-label">Extended Family</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="household_family_structure" <?= $beneficiariesResult['0']['household_family_structure'] == 5 ? 'checked' : ''; ?> value="5">
                            <label class="form-check-label">Nuclear Family</label>
                          </div>
                        </div>
                      </div>
                      

                          <!-- <div>
                            <label class="col-form-label" for=""><span style="color:red">* </span>Property</label>
                            <div class="form-group">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="property" <?= $beneficiariesResult['0']['property'] == 1 ? 'checked' : ''; ?> value="1">
                                <label class="form-check-label">Private
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="property" <?= $beneficiariesResult['0']['property'] == 2 ? 'checked' : ''; ?> value="2">
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
                      <?php  if (is_null($beneficiariesResult['0']['file1']) == false) { ?>
                      <a target="_blank"  href="upload_images/beneficiary_files/<?= $beneficiariesResult['0']['file1']; ?>" download><i class="nav-icon  fas fa-download"></i> <?= $beneficiariesResult['0']['file1']; ?>   </a>
                      <div class="custom-control custom-checkbox ml-2">
                            <input class="custom-control-input" type="checkbox" id="remove_file_1" name="remove_file_1" value="1">
                            <label for="remove_file_1" class="custom-control-label">Remove File</label>
                          </div>

                          <div class="input-group my-1">
                     
                        <div class="custom-file">
                     
                          <input type="file" class="custom-file-input file-upload" id="file1" name="" accept="image/png, image/jpeg, image/jpg" disabled>
                          <label class="custom-file-label" for="exampleInputFile"  id="file1-label"><?= $beneficiariesResult['0']['file1']; ?></label>
                        </div>
                        <!-- <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div> -->
                      </div>

                      <?php } else { ?>
                      <div class="input-group my-1">
                     
                        <div class="custom-file">
                     
                          <input type="file" class="custom-file-input file-upload" id="file1" name="file1" accept="image/png, image/jpeg, image/jpg">
                          <label class="custom-file-label" for="exampleInputFile"  id="file1-label">Choose file</label>
                        </div>
                        <!-- <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div> -->
                      </div>
                      <?php }?>
                    </div>
                  </div>
                  <div class="col-sm-6">
              
                    <div class="form-group">
                      <label for="exampleInputFile"><span style="color:red">* </span>File</label>
                      <?php  if (is_null($beneficiariesResult['0']['file2']) == false) { ?>
                      <a target="_blank"  href="upload_images/beneficiary_files/<?= $beneficiariesResult['0']['file2']; ?>" download> <i class="nav-icon  fas fa-download"></i> <?= $beneficiariesResult['0']['file2']; ?>   </a>
                      <div class="custom-control custom-checkbox ml-2">
                            <input class="custom-control-input" type="checkbox" id="remove_file_2" name="remove_file_2" value="1">
                            <label for="remove_file_2" class="custom-control-label">Remove File</label>
                          </div>

                          <div class="input-group my-1">
                     
                        <div class="custom-file">
                     
                          <input type="file" class="custom-file-input file-upload" id="file2" accept="image/png, image/jpeg, image/jpg" disabled>
                          <label class="custom-file-label" for="exampleInputFile"  id="file2-label"><?= $beneficiariesResult['0']['file2']; ?></label>
                        </div>
                        <!-- <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div> -->
                      </div>

                        <?php } else { ?>
                      <div class="input-group my-1">
                     
                        <div class="custom-file">
                     
                          <input type="file" class="custom-file-input file-upload" id="file2" name="file2" accept="image/png, image/jpeg, image/jpg">
                          <label class="custom-file-label" for="exampleInputFile"  id="file2-label">Choose file</label>
                        </div>
                        <!-- <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div> -->
                      </div>
                      <?php }?>
                    </div>
                  </div>
                </div>

<!-- 
                      <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="exampleInputFile"><span style="color:red">* </span>File</label>
                      <div class="input-group">

                      
                
                      <?php 
                      if (is_null($beneficiariesResult['0']['file1']) == false) {
                          ?> 
                          <a target="_blank" href="upload_images/beneficiary_files/<?= $beneficiariesResult['0']['file1']; ?>"> Uploaded File 1 </a>
                          <?php
                      } else {
                        ?>
                        N/A
<?php
                      }
                      ?>
                      
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="exampleInputFile">File</label>
                      <div class="input-group"> 
                      <?php 
                      if (is_null($beneficiariesResult['0']['file2']) == false) {
                          ?> 
                          <a target="_blank"  href="upload_images/beneficiary_files/<?= $beneficiariesResult['0']['file2']; ?>"> Uploaded File 2</a>
                          <?php
                      } else {
                        ?>
                        N/A
<?php
                      }
                      ?>
                      </div>
                    </div>
                  </div>
                </div> -->
                      
                      <hr>

                      <div class="">
                        <div class="col-sm-12">
                          <h3>Family Members
                            <button type="button" class="btn btn-primary" id="add-family" data-toggle="modal" data-target="#modal-default">
                              <i class="fas fa-user-plus"></i>
                            </button>
                            <?php if (count($familyResult) > 0) { ?>
                              <button type="button" class="btn btn-danger" id="remove-family" data-toggle="modal" data-target="#modal-remove-fam">
                                <i class="fas fa-user-minus"></i>
                              </button>
                            <?php } ?>

                          </h3>
                          <?php
                          $counter = 0;
                          foreach ($familyResult as $familyKey => $familyValue) {
                            $counter++;
                          ?>
                            <div class="add_family_members">
                              <h5><span class="badge badge-pill badge-info mb-2">Member <?= $counter ?></span></h5>
                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- textarea -->
                                  <div class="form-group">
                                    <label><span style="color:red">* </span>First Name</label>
                                    <input class="form-control input-name" rows="3" placeholder="ex. Juan." name="family_update[<?= $counter ?>][first_name]" value="<?= $familyValue['first_name'] ?>" maxlength="50" required>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label><span style="color:red"></span>Middle Name</label>
                                    <input class="form-control input-name" rows="3" placeholder="ex. Gonzaga" name="family_update[<?= $counter ?>][middle_name]" value="<?= $familyValue['middle_name'] ?>" maxlength="50">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- textarea -->
                                  <div class="form-group">
                                    <label><span style="color:red">* </span>Last Name</label>
                                    <input class="form-control input-name" rows="3" placeholder="ex. Dela Cruz" name="family_update[<?= $counter ?>][last_name]" value="<?= $familyValue['last_name'] ?>" required maxlength="50">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <?php
                                    $familyMembersAge[$familyValue['id']] = $date1->diff(new DateTime($familyValue['birthday']))->y;
                                    ?>
                                    <label><span style="color:red">* </span>Date Of Birth (<?= $familyMembersAge[$familyValue['id']] ?> years old)</label>
                                    <div class="input-group date" id="birthday_fam_<?= $familyValue['id'] ?>" data-target-input="nearest">
                                      <input onkeydown="return false" type="text" class="form-control datetimepicker-input family_update_birthday" name="family_update[<?= $counter ?>][birthday]" data-target="#birthday_fam_<?= $familyValue['id'] ?>" required>
                                      <div class="input-group-append" data-target="#birthday_fam_<?= $familyValue['id'] ?>" data-toggle="datetimepicker">
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
                                      <input class="form-check-input" type="radio" name="family_update[<?= $counter ?>][gender]" <?= $familyValue['gender'] == 1 ? 'checked' : '' ?> value="1">
                                      <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="family_update[<?= $counter ?>][gender]" <?= $familyValue['gender'] == 2 ? 'checked' : '' ?> value="2">
                                      <label class="form-check-label">Female</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <!-- radio -->
                                  <label class="col-form-label" for=""><span style="color:red">* </span>Family Role</label>
                                  <div class="form-group">
                                    <?php

                                    foreach ($familyRoleRefResult as $roleRef => $role) { ?>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="family_update[<?= $counter ?>][family_role]" <?= $familyValue['family_role'] == $role['id'] ? 'checked' : '' ?> value="<?= $role['id'] ?>">
                                        <label class="form-check-label"><?= $role['name'] ?></label>
                                      </div>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <label class="col-form-label" for=""></span>Skills</label>
                                    <input type="text" class="form-control" id="" placeholder="" name="family_update[<?= $counter ?>][skill]" maxlength="100" value="<?= $familyValue['skill'] ?>">
                                  </div>

                                </div>
                              </div>
                              <input name="family_update[<?= $counter ?>][family_id]" value="<?= $familyValue['id'] ?>" hidden>
                            </div>
                            <hr>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="submit" class="btn btn-primary" name="update_beneficiary">Update</button>
                    </div>
                  </form>
                  <div class="modal fade" id="modal-default">
                    <div class="modal-dialog 
                     modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Add Family Member</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="POST" action="#">
                          <div class="modal-body">
                            <div class="add_family_members">
                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- textarea -->
                                  <div class="form-group">
                                    <label><span style="color:red">* </span>First Name</label>
                                    <input class="form-control input-name" rows="3" placeholder="ex. Juan." name="add_family_first_name" value="" maxlength="50" required>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label><span style="color:red"></span>Middle Name</label>
                                    <input class="form-control input-name" rows="3" placeholder="ex. Gonzaga" name="add_family_middle_name" value="" maxlength="50">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <!-- textarea -->
                                  <div class="form-group">
                                    <label><span style="color:red">* </span>Last Name</label>
                                    <input class="form-control input-name" rows="3" placeholder="ex. Dela Cruz" name="add_family_last_name" value="" required maxlength="50">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label><span style="color:red">* </span>Date Of Birth</label>
                                    <div class="input-group date" id="birthday_fam" data-target-input="nearest">
                                      <input onkeydown="return false" type="text" class="form-control datetimepicker-input" name="add_family_birthday" data-target="#birthday_fam" required>
                                      <div class="input-group-append" data-target="#birthday_fam" data-toggle="datetimepicker">
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
                                      <input class="form-check-input" type="radio" name="add_family_gender" checked value="1">
                                      <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="add_family_gender" value="2">
                                      <label class="form-check-label">Female</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <!-- radio -->
                                  <label class="col-form-label" for=""><span style="color:red">* </span>Family Role</label>
                                  <div class="form-group">
                                    <?php

                                    foreach ($familyRoleRefResult as $roleRef => $role) { ?>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="add_family_role" checked value="<?= $role['id'] ?>">
                                        <label class="form-check-label"><?= $role['name'] ?></label>
                                      </div>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <label class="col-form-label" for=""></span>Skills</label>
                                    <input type="text" class="form-control" id="" placeholder="" name="add_family_skills" maxlength="100">
                                  </div>

                                </div>
                              </div>

                            </div>

                          </div>
                          <input name="beneficiary_id" value="<?= $beneficiaryId ?>" hidden>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="save-family-btn">Save changes</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>


                  <div class="modal fade" id="modal-remove-fam">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Archive Family Member</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="POST" action="#">
                          <div class="modal-body">
                            <div class="remove_family_members">
                              <div class="form-group">
                                <?php foreach ($familyResult as $familyKey => $familyValue) { ?>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger" type="checkbox" id="customCheckbox_<?= $familyValue['id'] ?>" value="<?= $familyValue['id'] ?>" name="family_members[]">
                                    <label for="customCheckbox_<?= $familyValue['id'] ?>" class="custom-control-label"><?= $familyValue['first_name'] . ' ' . $familyValue['middle_name'] . ' ' .  $familyValue['last_name'] ?></label>
                                  </div>
                                <?php } ?>
                              </div>
                            </div>

                          </div>
                          <input name="beneficiary_id" value="<?= $beneficiaryId ?>" hidden>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger" name="archive-family-btn">Archive</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
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
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>


  <script>
    $(function() {
      let familyDetailsJson = '<?php echo json_encode($familyResult, true); ?>';
      let familyDetailsArray = JSON.parse(familyDetailsJson);

      const lrifJsonList = <?php echo $lrifJson ?>;


      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }

      $("#file1").change(function(e){
        $("#file1-label").text(this.files[0].name);
      });

      $("#file2").change(function(e){
        $("#file2-label").text(this.files[0].name);
      });

      $("#image").change(function(e){
        $("#image-label").text(this.files[0].name);
      });

      function employmentTick() {
        if($('#employed').is(':checked')) {
         $('#occupation').removeAttr("disabled")
         $('#occupation').prop('required', true);
         $('.occupation-group').show();
         
        } else {
         $('#occupation').prop('disabled', true)
         $('#occupation').prop('required', false);
         $('.occupation-group').hide();
        }
      }

      $('.employment_status').click(function() {
        employmentTick();
      });


      employmentTick(); 

      if (lrifJsonList.includes($('#lrif_number').val())) {
              $('#lrif_error').show(); 
               

          } else {
            $('#lrif_error').hide();
          }


        $('#lrif_number').keyup(function (e) {
          var key = e.charCode || e.keyCode || 0;
          $text = $(this);
          if (key !== 8 && key !== 9) {
            if ($text.val().length === 1) {
              $text.val($text.val() + '-');
            }
            if ($text.val().length === 4) {
              $text.val($text.val() + '-');
            }
          }

          if (lrifJsonList.includes($('#lrif_number').val())) {         
              $('#lrif_error').show();
          } else {
            $('#lrif_error').hide();
          }
        })


   $("#modal-lg").submit(function(e){
            if (lrifJsonList.includes($('#lrif_number').val())) {
              $('#lrif_number').focus()
              e.preventDefault();
              $('#lrif_error').show();
          } else {
            $('#lrif_error').hide();
          }
        });


      $(".input-lrif").keypress(function(event) {
        return /^[\d./-]+$/.test(String.fromCharCode(event.keyCode));
      });

      $(".input-numbers").keypress(function(event) {
        return /\d/.test(String.fromCharCode(event.keyCode));
      });
      $(".input-name").keypress(function(event) {
        return /^[a-zA-Z.\s]*$/.test(String.fromCharCode(event.keyCode));
      });


      //Date picker
      $('#indigent_start_date').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: new Date(<?= json_encode($beneficiariesResult[0]['indigent_start_date']); ?>),
      });

      $('#birthday').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: new Date(<?= json_encode($beneficiariesResult[0]['birthday']); ?>),
      });

      $('#birthday_fam').datetimepicker({
        format: 'YYYY-MM-DD',
        // defaultDate: new Date(<?= json_encode($beneficiariesResult[0]['birthday']); ?>),
      });


      $.each(familyDetailsArray, function(index, value) {

        $(`#birthday_fam_${value.id}`).datetimepicker({
          format: 'YYYY-MM-DD',
          defaultDate: new Date(value.birthday),
        });


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


      
      function radiotick() {
        if($('#radio_rejected').is(':checked')) {
         $('#reason_for_rejection').removeAttr("disabled")
         $('#reason_for_rejection').prop('required',true);
         $('.rejected_input_group').show();
         
        } else {
         $('#reason_for_rejection').prop('disabled', true)
         $('#reason_for_rejection').prop('required', false);
         $('.rejected_input_group').hide();
        }
      }

      radiotick();

      $('.radio_status').click(function() {
       radiotick();
      });


    });
  </script>
</body>

</html>

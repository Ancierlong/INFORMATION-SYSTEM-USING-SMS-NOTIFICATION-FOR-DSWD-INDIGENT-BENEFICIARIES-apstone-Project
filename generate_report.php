<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');

require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$page = 'Beneficiaries Report';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = 'Generate Beneficiaries Report';

$dbConn = (new SystemDatabaseConfig());
$dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);

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
  $email = htmlentities(trim($_POST['email']));
  $household_category = htmlentities(trim($_POST['household_category']));
  $category_category = htmlentities(trim($_POST['category_category']));
  $income_and_livelihood = htmlentities(trim($_POST['income_and_livelihood']));
  $water_and_sanitation = htmlentities(trim($_POST['water_and_sanitation']));
  $property = htmlentities(trim($_POST['property']));
  $skill = htmlentities(trim($_POST['skills']));

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
  '{$property}',
  '{$skill}')");
  $lastInsertedId = $dbConn->getConnection()->insert_id;

  $showAlert = 'success';
}
unset($_POST);

$beneficiariesQuery = $dbConn->getConnection()
  ->query("SELECT * FROM beneficiaries WHERE is_deleted = 0 and status = 1");
$beneficiariesResult = $beneficiariesQuery->fetch_all(MYSQLI_ASSOC);

// $inactiveBeneficiariesQuery = $dbConn->getConnection()
//   ->query("SELECT * FROM beneficiaries WHERE is_deleted = 1");
// $inactiveBeneficiariesResult = $inactiveBeneficiariesQuery->fetch_all(MYSQLI_ASSOC);

$allBeneficiaryResult = $beneficiariesQuery;

$beneficiaryFamilyQuery = $dbConn->getConnection()
  ->query("SELECT bf.first_name as bf_first_name, bf.middle_name as bf_middle_name, bf.last_name as bf_last_name, bf.beneficiary_id as bf_beneficiary_id
FROM beneficiaries b INNER JOIN beneficiary_family_members bf ON bf.id = b.id WHERE b.is_deleted = 0 and bf.is_deleted = 0");

$beneficiaryFamilyResult = $beneficiaryFamilyQuery->fetch_all(MYSQLI_ASSOC);
$formattedResult = [];

foreach ($beneficiaryFamilyResult as $bfkey => $bfvalue) {
  $formattedResult[$bfvalue['bf_beneficiary_id']][] = $bfvalue;
  // $formattedResult[$bfvalue['bf_beneficiary_id']]['string'][] = $bfvalue['bf_last_name'] . ', ' . $bfvalue['bf_first_name'] . ' ' . $bfvalue['bf_middle_name'];
  //$formattedResult[$bfvalue['bf_beneficiary_id']]['final'] = implode('<br>', $formattedResult[$bfvalue['bf_beneficiary_id']]['string']);
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

  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    th {
    white-space: nowrap;
}
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed " class="font-size: 1.2rem">
  <div class="wrapper">

    <!-- Navbar -->

    <?php //require_once('layout/_header.php')
    ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php // require_once('layout/_sidebar.php')
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="">


      <!-- /.content-header -->


      <!-- Main content -->
      <section class="content">
        <!-- <div class="container-fluid"> -->

          <!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->

            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12 connectedSortable">
              <!-- /.card -->
              <div class="card">
                <!-- /.card-header -->
                <!-- Header-----------Additional*
(nasa kaliwa)
Brgy. Hall address: 
Rufel Homes Medicion 1B 
Imus City Cavite

(nasa gitna main header)
Medicion I-B DSWD Beneficiary Masterlist

Footer------ Additional*

Signature: 
Certified by:	Ferdinand D. Condalor		Emelita M. Mercado
		Punong Barangay			Barangay S ecretary -->
    
                <div class="card-body">
                  <p><strong>PRINT DATE COVERED:</strong> <?= (new Datetime())->format('F d, Y')?>
                <br>
                <strong>Brgy. Hall address:</strong> Rufel Homes, Medicion I-B, Imus City Cavite
                <br>
               
              </p>

              <div class="mt-5">
      
        
          <p class="text-center" style="font-size: 1.5rem"><strong>Medicion I-B DSWD Beneficiary Masterlist</strong></p>
          </div>

                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th scope="col" style="border-bottom-style: solid; border-bottom: 1pt solid black;">#</th>
                        <th scope="col" style="border-bottom-style: solid; border-bottom: 1pt solid black;">LIRF #</th>
                        <th scope="col" style="border-bottom-style: solid; border-bottom: 1pt solid black;">LAST NAME</th>
                        <th scope="col" style="border-bottom-style: solid; border-bottom: 1pt solid black;">FIRST NAME</th>
                        <th scope="col" style="border-bottom-style: solid; border-bottom: 1pt solid black;">MIDDLE</th>
                        <th scope="col" style="border-bottom-style: solid; border-bottom: 1pt solid black;">ADDRESS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $counterBeneficiary = 0;
                      foreach ($allBeneficiaryResult as $key => $beneficiary) {
                        $counterBeneficiary++;

                        // var_dump($beneficiary); exit;
                      ?>
                        <tr>
                          <th style="border-bottom: 1pt solid black;" scope="row"><?= $counterBeneficiary ?></th>
                          <th style="border-bottom: 1pt solid black;text-transform: uppercase"><?= $beneficiary['lrif_number'] ?></th>
                          <th style="border-bottom: 1pt solid black;text-transform: uppercase"><?= $beneficiary['last_name'] ?></th>
                          <th style="border-bottom: 1pt solid black;text-transform: uppercase"><?= $beneficiary['first_name'] ?></th>
                          <th style="border-bottom: 1pt solid black;text-transform: uppercase"><?= $beneficiary['middle_name'] ?></th>
                          <th style="border-bottom: 1pt solid black;text-transform: uppercase"><?= $beneficiary['address'] ?></th>
                        </tr>
                        <?php
                        $counterFamily = 0;
                        if (isset($formattedResult[$beneficiary['id']]) && count($formattedResult[$beneficiary['id']]) > 0) { ?>
                          <tr class="">
                            <th scope="col" class="text-center" style="font-weight: bold"><i>FAMILY MEMBER:</i></th>
                            <th scope="col" style="border-bottom: 1.5pt dashed black;"><i>#</i></th>
                            <th scope="col" style="border-bottom: 1.5pt dashed black;"><i>LAST NAME</i></th>
                            <th scope="col" style="border-bottom: 1.5pt dashed black;"><i>FIRST NAME</i></th>
                            <th scope="col" style="border-bottom: 1.5pt dashed black;"><i>MIDDLE</i></th>
                            <th scope="col" style="border-bottom: 1.5pt dashed black;"></th>
                          </tr>
                          <?php

                          foreach ($formattedResult[$beneficiary['id']] as $famkey => $famValue) {
                            $counterFamily++;
                          ?>
                            <tr class="">
                              <td style="text-transform: uppercase"><?= $beneficiary['lrif_number'] ?></td>
                              <td style="text-transform: uppercase"><?= $counterFamily ?></td>
                              <td style="text-transform: uppercase"><?= $famValue['bf_last_name'] ?></td>
                              <td style="text-transform: uppercase"><?= $famValue['bf_first_name'] ?></td>
                              <td style="text-transform: uppercase"><?= $famValue['bf_middle_name'] ?></td>
                              <th scope="col"></th>
                            </tr>

                          <?php } ?>

                        <?php  } ?>
                      <?php  } ?>

                    </tbody>
                  </table>

            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        <!-- /</div>/.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <div class="mt-5">
          <p class="" style="font-size: 1.1rem"><strong>Prepared By:</strong> <span style=""> <?= $_SESSION['user']['name'] ?> </span></p>
          <div class="row">
            <div class="col-4">
              Signature: <br>
              <strong>Certified By:</strong>
            </div>

            <div class="col-4">
              <br>
              <strong><u>Ferdinand D. Condalor</u></strong><br>
              Punong Barangay
            </div>

            <div class="col-4">
            <br>
            <strong><u>Emelita M. Mercado</u></strong><br>
            Barangay Secretary
            </div>


          </div>
          </div>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>

  <script>
    $(function() {
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }

    window.print();
    });
  </script>
</body>

</html>

<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');
require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$dbConn = (new SystemDatabaseConfig());

$allBeneficiaryQuery = $dbConn->getConnection()
  // ->query("SELECT gender, household_category, birthday, 1 as is_beneficiary FROM beneficiaries WHERE is_deleted = 0");
  ->query("(SELECT gender, household_category, birthday,  1 as is_beneficiary, category_category, income_and_livelihood, water_and_sanitation, property, household_family_structure, employment FROM beneficiaries WHERE is_deleted = 0 and status =1 )
  UNION ALL
  (SELECT bf.gender, null, bf.birthday, 0 as is_beneficiary, null, null, null, null, null, null  FROM beneficiaries  as b
  INNER JOIN beneficiary_family_members bf ON b.id = bf.beneficiary_id
  WHERE b.is_deleted = 0 and b.status = 1 and bf.is_deleted = 0)");

$allBeneficiaryResult = $allBeneficiaryQuery->fetch_all(MYSQLI_ASSOC);
$dashboardResults = [
  'beneficiaries' => [
    'male' => 0,
    'female' => 0,
    'age' => [
      '5' => 0,
      '11' => 0,
      '15' => 0,
      '20' => 0,
      '25' => 0,
      '30' => 0,
      '35' => 0,
      '36' => 0,
    ],
    'household' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      3 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'category_category' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      3 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'income_and_livelihood' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      3 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'water_and_sanitation' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      3 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'property' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      3 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'household_family_structure' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      3 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      4 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      5 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'employment' => [
      0 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      1 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      2 => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
    ],
    'count' => 0,
  ],
  'family_members' => [
    'count' => 0
  ]
];


// `0 - 5 (${dasboardResults.beneficiaries.female})`,
// `6 - 11 (${dasboardResults.beneficiaries.male})`,
// `12 - 15 (${dasboardResults.beneficiaries.male})`,
// `16 - 20 (${dasboardResults.beneficiaries.male})`,
// `21 - 25 (${dasboardResults.beneficiaries.male})`,
// `26 - 30 (${dasboardResults.beneficiaries.male})`,
// `31 - 35 (${dasboardResults.beneficiaries.male})`,
// `36 and above (${dasboardResults.beneficiaries.male})`,

foreach ($allBeneficiaryResult as $key => $value) {
  // male
  if ($value['gender'] == 1) {
    $dashboardResults['beneficiaries']['male']++;
  }

  // female
  if ($value['gender'] == 2) {
    $dashboardResults['beneficiaries']['female']++;
  }

  // age
  $date1 = new DateTime();
  $date2 = new DateTime($value['birthday']);
  $age = $date1->diff($date2)->y;

  if ($age <= 5) {
    $dashboardResults['beneficiaries']['age']['5']++;
  } else if ($age >= 6 && $age <= 11) {
    $dashboardResults['beneficiaries']['age']['11']++;
  } else if ($age >= 12 && $age <= 15) {
    $dashboardResults['beneficiaries']['age']['15']++;
  } else if ($age >= 16 && $age <= 20) {
    $dashboardResults['beneficiaries']['age']['20']++;
  } else if ($age >= 21 && $age <= 25) {
    $dashboardResults['beneficiaries']['age']['25']++;
  } else if ($age >= 26 && $age <= 30) {
    $dashboardResults['beneficiaries']['age']['30']++;
  } else if ($age >= 31 && $age <= 35) {
    $dashboardResults['beneficiaries']['age']['35']++;
  } else {
    // 36 ++
    $dashboardResults['beneficiaries']['age']['36']++;
  }

  if ($value['is_beneficiary'] == 1) {
    // household category
    $dashboardResults['beneficiaries']['household'][$value['household_category']]['total']++;
    $dashboardResults['beneficiaries']['category_category'][$value['category_category']]['total']++;
    $dashboardResults['beneficiaries']['income_and_livelihood'][$value['income_and_livelihood']]['total']++;
    $dashboardResults['beneficiaries']['water_and_sanitation'][$value['water_and_sanitation']]['total']++;
    $dashboardResults['beneficiaries']['property'][$value['property']]['total']++;
    $dashboardResults['beneficiaries']['household_family_structure'][$value['household_family_structure']]['total']++;
    $dashboardResults['beneficiaries']['employment'][$value['employment']]['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['household'][$value['household_category']]['male']++;
      $dashboardResults['beneficiaries']['category_category'][$value['category_category']]['male']++;
      $dashboardResults['beneficiaries']['income_and_livelihood'][$value['income_and_livelihood']]['male']++;
      $dashboardResults['beneficiaries']['water_and_sanitation'][$value['water_and_sanitation']]['male']++;
      $dashboardResults['beneficiaries']['property'][$value['property']]['male']++;
      $dashboardResults['beneficiaries']['household_family_structure'][$value['household_family_structure']]['male']++;
      $dashboardResults['beneficiaries']['employment'][$value['employment']]['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['household'][$value['household_category']]['female']++;
      $dashboardResults['beneficiaries']['category_category'][$value['category_category']]['female']++;
      $dashboardResults['beneficiaries']['income_and_livelihood'][$value['income_and_livelihood']]['female']++;
      $dashboardResults['beneficiaries']['water_and_sanitation'][$value['water_and_sanitation']]['female']++;
      $dashboardResults['beneficiaries']['property'][$value['property']]['female']++;
      $dashboardResults['beneficiaries']['household_family_structure'][$value['household_family_structure']]['female']++;
      $dashboardResults['beneficiaries']['employment'][$value['employment']]['female']++;
    }

    $dashboardResults['beneficiaries']['count']++;
  } else {
    $dashboardResults['family_members']['count']++;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMIS | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
      <!-- Content Header (Page header) -->

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>

            </div>
            <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">404 Error Page</li>
            </ol>
          </div> -->
          </div>
          <div class="col-md-3 col-sm-6 col-6">
            <a type="button" target="_blank" href="generate_dashboard_report.php" name="generate_report_btn"
              class="btn btn-success"><i class="nav-icon  fas fa-download"></i> Generate Report</a>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">

            <!-- <div class="col-lg-3 col-6"> -->
            <!-- small box -->
            <!-- <div class="small-box bg-info">
                <div class="inner">
                  <h3>0</h3>
                  <p>Accounts</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> -->
            <!-- ./col -->
            <!-- <div class="col-lg-3 col-6">

              <div class="small-box bg-success">
                <div class="inner">
                  <h3>0<sup style="font-size: 20px">%</sup></h3>

                  <p>Notifications</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> -->
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?= $dashboardResults['beneficiaries']['count'] ?></h3>

                  <p>Beneficiaries</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="beneficiaries.php" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $dashboardResults['family_members']['count'] ?></h3>

                  <p>Family Members</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="beneficiaries.php" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
            <!-- <div class="col-lg-3 col-6">

              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>65</h3>

                  <p>Unique Visitors</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> -->
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
              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Beneficiaries by Gender</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesGender"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Beneficiaries by Age</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesAge"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Category - Female</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesCategory"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Category - Male</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesCategoryMale"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Household - Female</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesHousehold"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Household - Male</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesHouseholdMale"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

              </div>



              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Income and Livelihood - Female</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesIncomeAndLivelihood"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Income and Livelihood - Male</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesIncomeAndLivelihoodMale"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

              </div>

              <div class="row">

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Water and Sanitation - Female</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesWaterAndSanitation"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Water and Sanitation - Male</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesWaterAndSanitationMale"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>


              </div>


              <div class="row">

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Household Family Structure - Female</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesHouseholdFamilyStructure"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Household Family Structure Male</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesHouseholdFamilyStructureMale"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>


              <div class="row">

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Employment - Female</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesEmployment"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Employment - Male</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChartBeneficiariesEmploymentMale"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;"
                        width="1064" height="500" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>


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

  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
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
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="dist/js/pages/dashboard.js"></script> -->

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    let dasboardResults = <?= json_encode($dashboardResults, true); ?>;
    console.log(dasboardResults)


    var barOptions = {
      maintainAspectRatio: false,
      responsive: true,
      scales: {
        yAxes: [{
          grace: 5,
          ticks: {
            beginAtZero: true,
            min: 0,
          }
        }],
        // y: {
        //   beginAtZero: true,
        //   min: 2,
        //   max:100,
        //   grace: '1',
        //   ticks: {
        //     stepSize: 5,
        //     beginAtZero: true,
        //     // min: 0,
        //     // max: 500,
        //     grace: '10',
        //   },
        //   offset: true,
        //   suggestedMin: 10,
        //   suggestedMax: 100
        // },
        x: {
          beginAtZero: true,
        }
      }
    }

    $.widget.bridge('uibutton', $.ui.button)

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.

    var beneficiariesGender = {
      labels: ["Gender"],
      datasets: [{
        label: `Female (${dasboardResults.beneficiaries.female})`,
        backgroundColor: '#f4a7bb',
        data: [dasboardResults.beneficiaries.female]
      },
      {

        label: `Male (${dasboardResults.beneficiaries.male})`,
        backgroundColor: '#5579C6',
        data: [dasboardResults.beneficiaries.male]
      }],
    };

    var pieChartCanvasBeneficiariesGender = $('#pieChartBeneficiariesGender').get(0).getContext('2d')
    var pieData = beneficiariesGender;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          beginAtZero: true
        }
      }

    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    let chart = new Chart(pieChartCanvasBeneficiariesGender, {
      type: 'bar',
      data: pieData,
      options: barOptions
    });

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.


    var beneficiariesAgre = {
      labels: [
        `0 - 5 (${dasboardResults.beneficiaries.age['5']})`,
        `6 - 11 (${dasboardResults.beneficiaries.age['11']})`,
        `12 - 15 (${dasboardResults.beneficiaries.age['15']})`,
        `16 - 20 (${dasboardResults.beneficiaries.age['20']})`,
        `21 - 25 (${dasboardResults.beneficiaries.age['25']})`,
        `26 - 30 (${dasboardResults.beneficiaries.age['30']})`,
        `31 - 35 (${dasboardResults.beneficiaries.age['35']})`,
        `36 and above (${dasboardResults.beneficiaries.age['36']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.age['5'],
          dasboardResults.beneficiaries.age['11'],
          dasboardResults.beneficiaries.age['15'],
          dasboardResults.beneficiaries.age['20'],
          dasboardResults.beneficiaries.age['25'],
          dasboardResults.beneficiaries.age['30'],
          dasboardResults.beneficiaries.age['35'],
          dasboardResults.beneficiaries.age['36']
        ],
        // rainbow color hex
        backgroundColor: ['#e81416', '#ffa500', '#faeb36', '#79c314', '#487de7', '#4b369d', '#70369d', '#FBE4FF'],
      }]
    };

    var pieChartCanvasBeneficiariesAgre = $('#pieChartBeneficiariesAge').get(0).getContext('2d')
    var pieData = beneficiariesAgre;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,

    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesAgre, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });


    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.


    var beneficiariesHousehold = {
      labels: ["Household - Female"],
      datasets: [{
        label: `Makeshift housing (${dasboardResults.beneficiaries.household['1']['female']})`,
        backgroundColor: '#b30000',
        data: [dasboardResults.beneficiaries.household['1']['female']]
      },
      {

        label: `Informal settlers (${dasboardResults.beneficiaries.household['2']['female']})`,
        backgroundColor: '#e60000',
        data: [dasboardResults.beneficiaries.household['2']['female']]
      }]
    };

    var pieChartCanvasBeneficiariesHousehold = $('#pieChartBeneficiariesHousehold').get(0).getContext('2d')
    var pieData = beneficiariesHousehold;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
      label: ['Household'],
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          beginAtZero: true
        },
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesHousehold, {
      type: 'bar',
      data: pieData,
      options: barOptions
    });


    var beneficiariesHouseholdMale = {
      labels: ["Household - Male"],
      datasets: [{
        label: `Makeshift housing (${dasboardResults.beneficiaries.household['1']['male']})`,
        backgroundColor: '#6495ED',
        data: [dasboardResults.beneficiaries.household['1']['male']]
      },
      {

        label: `Informal settlers (${dasboardResults.beneficiaries.household['2']['male']})`,
        backgroundColor: '#89CFF0',
        data: [dasboardResults.beneficiaries.household['2']['male']]
      }],
    }


    var pieChartCanvasBeneficiariesHousehold = $('#pieChartBeneficiariesHouseholdMale').get(0).getContext('2d')
    var pieData = beneficiariesHouseholdMale;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
      label: ['Household'],
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesHousehold, {
      type: 'bar',
      data: pieData,
      options: barOptions
    });


    // beneficiaries category
    var beneficiariesCategory = {
      labels: [
        `PWD (${dasboardResults.beneficiaries.category_category['1']['female']})`,
        `Elderly (${dasboardResults.beneficiaries.category_category['2']['female']})`,
        `Solo Parent (${dasboardResults.beneficiaries.category_category['3']['female']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.category_category['1']['female'],
          dasboardResults.beneficiaries.category_category['2']['female'],
          dasboardResults.beneficiaries.category_category['3']['female'],
        ],
        backgroundColor: ['#b30000', '#e60000', '#ff1a1a', '#ff4d4d', '#e54545', '#b23535', '#7f2626', '#ff9494'],
      }]
    };

    var pieChartCanvasBeneficiariesCategory = $('#pieChartBeneficiariesCategory').get(0).getContext('2d')
    var pieData = beneficiariesCategory;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesCategory, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    });

    var beneficiariesCategoryMale = {
      labels: [
        `PWD (${dasboardResults.beneficiaries.category_category['1']['male']})`,
        `Elderly (${dasboardResults.beneficiaries.category_category['2']['male']})`,
        `Solo Parent (${dasboardResults.beneficiaries.category_category['3']['male']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.category_category['1']['male'],
          dasboardResults.beneficiaries.category_category['2']['male'],
          dasboardResults.beneficiaries.category_category['3']['male'],
        ],
        backgroundColor: ['#6495ED', '#89CFF0', '#088F8F', '#0096FF', '#ADD8E6'],
      }]
    };

    var pieChartCanvasBeneficiariesCategory = $('#pieChartBeneficiariesCategoryMale').get(0).getContext('2d')
    var pieData = beneficiariesCategoryMale;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,

    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesCategory, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    });


    //Water and sanitation
    // pieChartBeneficiariesWaterAndSanitation

    // beneficiaries category

    var beneficiariesWaterAndSanitation = {
      labels: ["Water and Sanitation - Female"],
      datasets: [{
        label: `Without access to safe water (${dasboardResults.beneficiaries.water_and_sanitation['1']['female']})`,
        backgroundColor: '#b30000',
        data: [dasboardResults.beneficiaries.water_and_sanitation['1']['female']]
      },
      {

        label: `Without access to sanitary toilet facility (${dasboardResults.beneficiaries.water_and_sanitation['2']['female']})`,
        backgroundColor: '#e60000',
        data: [dasboardResults.beneficiaries.water_and_sanitation['2']['female']]
      }],
    }

    var pieChartCanvasBeneficiariesWaterAndSanitation = $('#pieChartBeneficiariesWaterAndSanitation').get(0).getContext('2d')
    var pieData = beneficiariesWaterAndSanitation;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          beginAtZero: true
        }
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesWaterAndSanitation, {
      type: 'bar',
      data: pieData,
      options: barOptions,
    });


    var beneficiariesWaterAndSanitationMale = {
      labels: ["Water and Sanitation - Male"],
      datasets: [{
        label: `Without access to safe water (${dasboardResults.beneficiaries.water_and_sanitation['1']['male']})`,
        backgroundColor: '#6495ED',
        data: [dasboardResults.beneficiaries.water_and_sanitation['1']['male']]
      },
      {

        label: `Without access to sanitary toilet facility (${dasboardResults.beneficiaries.water_and_sanitation['2']['male']})`,
        backgroundColor: '#89CFF0',
        data: [dasboardResults.beneficiaries.water_and_sanitation['2']['male']]
      }],
    }


    var pieChartCanvasBeneficiariesWaterAndSanitation = $('#pieChartBeneficiariesWaterAndSanitationMale').get(0).getContext('2d')
    var pieData = beneficiariesWaterAndSanitationMale;

    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesWaterAndSanitation, {
      type: 'bar',
      data: pieData,
      options: barOptions
    });

    //Income and livelihood
    // pieChartBeneficiariesIncomeAndLivelihood

    var beneficiariesIncomeAndLivelihood = {
      labels: [
        `Income Below Poverty Threshold (${dasboardResults.beneficiaries.income_and_livelihood['1']['female']})`,
        `Income Below Food Threshold (${dasboardResults.beneficiaries.income_and_livelihood['2']['female']})`,
        `Experience food shortage (${dasboardResults.beneficiaries.income_and_livelihood['3']['female']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.income_and_livelihood['1']['female'],
          dasboardResults.beneficiaries.income_and_livelihood['2']['female'],
          dasboardResults.beneficiaries.income_and_livelihood['3']['female'],
        ],
        backgroundColor: ['#b30000', '#e60000', '#ff1a1a', '#ff4d4d', '#e54545', '#b23535', '#7f2626', '#ff9494'],
      }]
    };

    var pieChartCanvasBeneficiariesIncomeAndLivelihood = $('#pieChartBeneficiariesIncomeAndLivelihood').get(0).getContext('2d')
    var pieData = beneficiariesIncomeAndLivelihood;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,


    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesIncomeAndLivelihood, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });

    //Income and livelihood
    // pieChartBeneficiariesIncomeAndLivelihood

    var beneficiariesIncomeAndLivelihoodMale = {
      labels: [
        `Income Below Poverty Threshold (${dasboardResults.beneficiaries.income_and_livelihood['1']['male']})`,
        `Income Below Food Threshold (${dasboardResults.beneficiaries.income_and_livelihood['2']['male']})`,
        `Experience food shortage (${dasboardResults.beneficiaries.income_and_livelihood['3']['male']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.income_and_livelihood['1']['male'],
          dasboardResults.beneficiaries.income_and_livelihood['2']['male'],
          dasboardResults.beneficiaries.income_and_livelihood['3']['male'],
        ],
        backgroundColor: ['#6495ED', '#89CFF0', '#088F8F', '#0096FF', '#ADD8E6'],
      }]
    };

    var pieChartCanvasBeneficiariesIncomeAndLivelihood = $('#pieChartBeneficiariesIncomeAndLivelihoodMale').get(0).getContext('2d')
    var pieData = beneficiariesIncomeAndLivelihoodMale;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesIncomeAndLivelihood, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });


    // Property
    // pieChartBeneficiariesProperty
    // var beneficiariesProperty = {
    //   labels: [
    //     `Private (${dasboardResults.beneficiaries.property['1']['female']})`,
    //     `Public (${dasboardResults.beneficiaries.property['2']['female']})`,
    //   ],
    //   datasets: [{
    //     data: [
    //       dasboardResults.beneficiaries.property['1']['female'],
    //       dasboardResults.beneficiaries.property['2']['female'],
    //     ],
    //     backgroundColor: ['#b30000', '#e60000', '#ff1a1a', '#ff4d4d', '#e54545', '#b23535', '#7f2626', '#ff9494'],
    //   }]
    // };

    // var pieChartCanvasBeneficiariesProperty = $('#pieChartBeneficiariesProperty').get(0).getContext('2d')
    // var pieData = beneficiariesProperty;
    // var pieOptions = {
    //   maintainAspectRatio: false,
    //   responsive: true,
    // }
    // //Create pie or douhnut chart
    // // You can switch between pie and douhnut using the method below.
    // new Chart(pieChartCanvasBeneficiariesProperty, {
    //   type: 'pie',
    //   data: pieData,
    //   options: pieOptions
    // });

    // var beneficiariesPropertyMale = {
    //   labels: [
    //     `Private (${dasboardResults.beneficiaries.property['1']['male']})`,
    //     `Public (${dasboardResults.beneficiaries.property['2']['male']})`,
    //   ],
    //   datasets: [{
    //     data: [
    //       dasboardResults.beneficiaries.property['1']['male'],
    //       dasboardResults.beneficiaries.property['2']['male'],

    //     ],
    //     backgroundColor: ['#6495ED', '#89CFF0', '#088F8F', '#0096FF', '#ADD8E6'],
    //   }]
    // };

    // var pieChartCanvasBeneficiariesProperty = $('#pieChartBeneficiariesPropertyMale').get(0).getContext('2d')
    // var pieData = beneficiariesPropertyMale;
    // var pieOptions = {
    //   maintainAspectRatio: false,
    //   responsive: true,
    // }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // new Chart(pieChartCanvasBeneficiariesProperty, {
    //   type: 'pie',
    //   data: pieData,
    //   options: pieOptions
    // });

    // Household and family structure

    //     1. Single Parent Family
    // 2. Single Household
    // 3. Childless Family
    // 4. Extended Family
    // 5. Nuclear Family


    var beneficiariesCategory = {
      labels: [
        `Single Parent Family (${dasboardResults.beneficiaries.household_family_structure['1']['female']})`,
        `Single Household (${dasboardResults.beneficiaries.household_family_structure['2']['female']})`,
        `Childless Family (${dasboardResults.beneficiaries.household_family_structure['3']['female']})`,
        `Extended Family (${dasboardResults.beneficiaries.household_family_structure['4']['female']})`,
        `Nuclear Family (${dasboardResults.beneficiaries.household_family_structure['5']['female']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.household_family_structure['1']['female'],
          dasboardResults.beneficiaries.household_family_structure['2']['female'],
          dasboardResults.beneficiaries.household_family_structure['3']['female'],
          dasboardResults.beneficiaries.household_family_structure['4']['female'],
          dasboardResults.beneficiaries.household_family_structure['5']['female'],
        ],
        backgroundColor: ['#b30000', '#e60000', '#ff1a1a', '#ff4d4d', '#e54545', '#b23535', '#7f2626', '#ff9494'],
      }]
    };

    var pieChartCanvasBeneficiariesCategory = $('#pieChartBeneficiariesHouseholdFamilyStructure').get(0).getContext('2d')
    var pieData = beneficiariesCategory;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesCategory, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    });

    var beneficiariesCategoryMale = {
      labels: [
        `Single Parent Family (${dasboardResults.beneficiaries.household_family_structure['1']['male']})`,
        `Single Household (${dasboardResults.beneficiaries.household_family_structure['2']['male']})`,
        `Childless Family (${dasboardResults.beneficiaries.household_family_structure['3']['male']})`,
        `Extended Family (${dasboardResults.beneficiaries.household_family_structure['4']['male']})`,
        `Nuclear Family (${dasboardResults.beneficiaries.household_family_structure['5']['male']})`,
      ],
      datasets: [{
        data: [
          dasboardResults.beneficiaries.household_family_structure['1']['male'],
          dasboardResults.beneficiaries.household_family_structure['2']['male'],
          dasboardResults.beneficiaries.household_family_structure['3']['male'],
          dasboardResults.beneficiaries.household_family_structure['4']['male'],
          dasboardResults.beneficiaries.household_family_structure['5']['male'],
        ],
        backgroundColor: ['#6495ED', '#89CFF0', '#088F8F', '#0096FF', '#ADD8E6'],
      }]
    };

    var pieChartCanvasBeneficiariesCategory = $('#pieChartBeneficiariesHouseholdFamilyStructureMale').get(0).getContext('2d')
    var pieData = beneficiariesCategoryMale;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,

    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesCategory, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    });

    // Employment status

    var beneficiariesWaterAndSanitation = {
      labels: ["Employment - Female"],
      datasets: [{
        label: `Employed (${dasboardResults.beneficiaries.employment['1']['female']})`,
        backgroundColor: '#b30000',
        data: [dasboardResults.beneficiaries.employment['1']['female']]
      },
      {

        label: `Unemployed (${dasboardResults.beneficiaries.employment['2']['female']})`,
        backgroundColor: '#e60000',
        data: [dasboardResults.beneficiaries.employment['2']['female']]
      }],
    }

    var pieChartCanvasBeneficiariesWaterAndSanitation = $('#pieChartBeneficiariesEmployment').get(0).getContext('2d')
    var pieData = beneficiariesWaterAndSanitation;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        },
        x: {
          beginAtZero: true
        }
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesWaterAndSanitation, {
      type: 'bar',
      data: pieData,
      options: barOptions,
    });


    var beneficiariesWaterAndSanitationMale = {
      labels: ["Employment - Male"],
      datasets: [{
        label: `Employed (${dasboardResults.beneficiaries.employment['1']['male']})`,
        backgroundColor: '#6495ED',
        data: [dasboardResults.beneficiaries.employment['1']['male']]
      },
      {

        label: `Unemployed (${dasboardResults.beneficiaries.employment['2']['male']})`,
        backgroundColor: '#89CFF0',
        data: [dasboardResults.beneficiaries.employment['2']['male']]
      }],
    }


    var pieChartCanvasBeneficiariesWaterAndSanitation = $('#pieChartBeneficiariesEmploymentMale').get(0).getContext('2d')
    var pieData = beneficiariesWaterAndSanitationMale;

    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvasBeneficiariesWaterAndSanitation, {
      type: 'bar',
      data: pieData,
      options: barOptions
    });

  </script>

</body>

</html>
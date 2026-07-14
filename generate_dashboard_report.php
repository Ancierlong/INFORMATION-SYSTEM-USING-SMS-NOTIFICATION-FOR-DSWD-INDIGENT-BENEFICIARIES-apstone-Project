<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');
require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$dbConn = (new SystemDatabaseConfig());

$page = 'My Profile';
$page_url = __FILE__;
$user_id = $_SESSION['user']['id'];
$actions = 'Generate Database Report';

$dbConn->_addHistoryLog($page, $page_url, $actions, $user_id);
$allBeneficiaryQuery = $dbConn->getConnection()
  // ->query("SELECT gender, household_category, birthday, 1 as is_beneficiary FROM beneficiaries WHERE is_deleted = 0");
  ->query("(SELECT gender, household_category, birthday,  1 as is_beneficiary, category_category, income_and_livelihood, water_and_sanitation, property, household_family_structure, employment  FROM beneficiaries WHERE is_deleted = 0 and status = 1 )
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
      'under1' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      'under5' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      '0-5' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      '6-11' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      '6-12' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      '12-15' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      '13-16' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
      '10AndAbove' => [
        'total' => 0,
        'male' => 0,
        'female' => 0,
      ],
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
        ]
      ],
    'count' => 0,
    
  ],
  'family_members' => [
    'count' => 0
  ]
];

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




  // demographics
  if ($age == 0) {
    $dashboardResults['beneficiaries']['age']['under1']['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['age']['under1']['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['age']['under1']['female']++;
    }
  } else if ($age >= 1 && $age <= 5) {
    $dashboardResults['beneficiaries']['age']['under5']['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['age']['under5']['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['age']['under5']['female']++;
    }
  } else if ($age >= 6 && $age <= 11) {
    $dashboardResults['beneficiaries']['age']['6-11']['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['age']['6-11']['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['age']['6-11']['female']++;
    }
    if ($age >= 10) {
      $dashboardResults['beneficiaries']['age']['10AndAbove']['total']++;
      // male
      if ($value['gender'] == 1) {
        $dashboardResults['beneficiaries']['age']['10AndAbove']['male']++;
      }
      // female
      if ($value['gender'] == 2) {
        $dashboardResults['beneficiaries']['age']['10AndAbove']['female']++;
      }
    }
  } else if ($age >= 12  && $age <= 15) {
    $dashboardResults['beneficiaries']['age']['12-15']['total']++;

    $dashboardResults['beneficiaries']['age']['10AndAbove']['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['age']['12-15']['male']++;
      $dashboardResults['beneficiaries']['age']['10AndAbove']['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['age']['12-15']['female']++;
      $dashboardResults['beneficiaries']['age']['10AndAbove']['female']++;
    }
  } else if ($age >= 13 && $age <= 16) {
    $dashboardResults['beneficiaries']['age']['13-16']['total']++;
    $dashboardResults['beneficiaries']['age']['10AndAbove']['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['age']['13-16']['male']++;
      $dashboardResults['beneficiaries']['age']['10AndAbove']['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['age']['13-16']['female']++;
      $dashboardResults['beneficiaries']['age']['10AndAbove']['female']++;
    }
  } else {
    $dashboardResults['beneficiaries']['age']['10AndAbove']['total']++;
    // male
    if ($value['gender'] == 1) {
      $dashboardResults['beneficiaries']['age']['10AndAbove']['male']++;
    }
    // female
    if ($value['gender'] == 2) {
      $dashboardResults['beneficiaries']['age']['10AndAbove']['female']++;
    }
  }

  // pie
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
  <title>BMIS | Demographics</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
.table-sm td, .table-sm th {
    padding: .2rem;
}

  </style>
</head>

<body class="">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->

        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">
          <?php //echo '<pre>'; var_dump($dashboardResults); exit;
          ?>
   
          <div class="card-body">
                  <p><strong>PRINT DATE COVERED:</strong> <?= (new Datetime())->format('F d, Y')?>
                <br>
                <strong>Brgy. Hall address:</strong> Rufel Homes, Medicion I-B, Imus City Cavite
                <br>
               
              </p>

              <div class="mt-5">
      
        
          <p class="text-center" style="font-size: 1.5rem"><strong>BARANGAY: MEDICION I-B</strong></p>
          </div>

          <table class="table table-bordered  table-sm">
            <thead>
              <tr>
                <th scope="col" rowspan="2" class="text-center">INDICATOR</th>
                <th scope="col" colspan="3" class="text-center">Population</th>
              </tr>
              <tr>
                <th scope="col">Total</th>
                <th scope="col">Male</th>
                <th scope="col">Female</th>
              </tr>
              <tr>
                <th scope="col" colspan="5">DEMOGRAPHY</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="row">Population</td>
                <td><?= $dashboardResults['beneficiaries']['count'] + $dashboardResults['family_members']['count'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['female'] ?></td>
              </tr>
              <!-- <tr>
      <td scope="row">Average Household size</td>
      <td></td>
      <td></td>
      <td></td>
    </tr> -->
              <tr>
                <td scope="row">Children under 1 year old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['under1']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['under1']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['under1']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Children under 5 years old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['under5']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['under5']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['under5']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Children 0-5 years old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['0-5']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['0-5']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['0-5']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Children under 6-11 years old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['6-11']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['6-11']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['6-11']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Children under 6-12 years old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['6-12']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['6-12']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['6-12']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Members 12-15 years old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['12-15']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['12-15']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['12-15']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Members under 13-16 years old</td>
                <td><?= $dashboardResults['beneficiaries']['age']['13-16']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['13-16']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['13-16']['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Members 10 years old and above</td>
                <td><?= $dashboardResults['beneficiaries']['age']['10AndAbove']['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['10AndAbove']['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['age']['10AndAbove']['female'] ?></td>
              </tr>
              <!-- <tr>
      <td scope="row">Members of the labor force</td>
      <td></td>
      <td></td>
      <td></td>
    </tr> -->
              <tr>
                <th scope="row" colspan="4"></th>
              </tr>
              <tr>
                <th scope="row" colspan="4">CATEGORY</th>
              </tr>
              <tr>
                <td scope="row">PWD</td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Elderly</td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][2]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Solo Parent</td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][3]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][3]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['category_category'][3]['female'] ?></td>
              </tr>
              <tr>
                <th scope="row" colspan="4"></th>
              </tr>
              <tr>
                <th scope="row" colspan="4">HOUSING</th>
              </tr>
              <tr>
                <td scope="row">Living in make shift housing</td>
                <td><?= $dashboardResults['beneficiaries']['household'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Informal Settlers</td>
                <td><?= $dashboardResults['beneficiaries']['household'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household'][2]['female'] ?></td>
              </tr>
              <tr>
                <th scope="row" colspan="4"></th>
              </tr>
              <tr>
                <th scope="row" colspan="4">WATER AND SANITATION</th>
              </tr>
              <tr>
                <td scope="row">Without access to safe water</td>
                <td><?= $dashboardResults['beneficiaries']['water_and_sanitation'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['water_and_sanitation'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['water_and_sanitation'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Wihout access to sanitary toilet facility</td>
                <td><?= $dashboardResults['beneficiaries']['water_and_sanitation'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['water_and_sanitation'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['water_and_sanitation'][2]['female'] ?></td>
              </tr>
              <tr>
                <th scope="row" colspan="4"></th>

              </tr>
              <tr>
                <th scope="row" colspan="4">INCOME AND LIVELIHOOD</th>
              </tr>
              <tr>
                <td scope="row">Income below poverty threshold</td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Income below food threshold</td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][2]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Experienced food shortage</td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][3]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][3]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['income_and_livelihood'][3]['female'] ?></td>
              </tr>
              <tr>
                <th scope="row" colspan="4"></th>

              </tr>

              <tr>
                <th scope="row" colspan="4">Household Family Structure</th>
              </tr>
              <tr>
                <td scope="row">Single Parent Family</td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Single Household</td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][2]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Childless Family</td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][3]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][3]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][3]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Extended Family</td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][4]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][4]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][4]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Nuclear Family</td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][5]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][5]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['household_family_structure'][5]['female'] ?></td>
              </tr>

              <tr>
                <th scope="row" colspan="4"></th>
              </tr>
              <tr>
                <th scope="row" colspan="4">Employment Status</th>
              </tr>
              <tr>
                <td scope="row">Employed</td>
                <td><?= $dashboardResults['beneficiaries']['employment'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['employment'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['employment'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Unemployed</td>
                <td><?= $dashboardResults['beneficiaries']['employment'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['employment'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['employment'][2]['female'] ?></td>
              </tr>
          

              <!-- <tr>
                <th scope="row" colspan="4">PROPERTY</th>
              </tr>
              <tr>
                <td scope="row">Private</td>
                <td><?= $dashboardResults['beneficiaries']['property'][1]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['property'][1]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['property'][1]['female'] ?></td>
              </tr>
              <tr>
                <td scope="row">Public</td>
                <td><?= $dashboardResults['beneficiaries']['property'][2]['total'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['property'][2]['male'] ?></td>
                <td><?= $dashboardResults['beneficiaries']['property'][2]['female'] ?></td>
              </tr> -->
            </tbody>
          </table>

          <!-- /.card -->
        </section>
        <!-- right col -->
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
    $(document).ready(function() {

      setTimeout(function() {
        window.print();
      }, 1000)
    })
  </script>

</body>

</html>

<?php
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) . '/config/isUserGuest.php');

require_once(dirname(__FILE__) . '/Classes/SystemDatabaseConfig.php');

$dbConn = (new SystemDatabaseConfig());


if ($_SESSION['user']['role'] != 1 && $_SESSION['user']['role'] != 3) {
  header("location: dashboard.php");
}


$tableList = [
  'beneficiaries',
];

// 2 super admin, 3 admin, 5 staff

foreach ($tableList as $key) {
  $query = $dbConn->getConnection()
  ->query("TRUNCATE table {$key}");
}

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

$sampleData = [
'pending' => 20,
'approved' => 20,
'rejected' => 20
];
$counter = 0;

 for($i=0; $i <= 20; $i++) {
  $lrif_number = $i;
  $first_name = 'first name' . $i;
  $middle_name =  'middle_name';
  $last_name = 'last_name';
  $address = 'address';
  $gender = 1;
  $birthday = '2000-01-01';
  $mobile_number = '123455555555';
  $email = 'email'.$i.'@test.com';
  $indigent_start_date = '2000-01-01';
  $household_category = '1';
  $category_category = '1';
  $income_and_livelihood = '1';
  $water_and_sanitation = '1';
  $property = '1';
  $is_deleted = 0;
  $status = 0;
  
  
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
        `is_deleted`,
        `status`
        )
  VALUES
  ('{$lrif_number}', '{$first_name}', '{$middle_name}',  '{$last_name}', '{$address}', '{$gender}',
   '{$birthday}', '{$mobile_number}',  '{$email}', '{$indigent_start_date}', '{$household_category}',
    '{$category_category}',
    '{$income_and_livelihood}',
    '{$water_and_sanitation}',
    '{$property}',
    '{$is_deleted}',
    '{$status}')");
    $lastInsertedId = $dbConn->getConnection()->insert_id;
 }

    

 for($i=21; $i <= 40; $i++) {
  $lrif_number = $i;
  $first_name = 'first name' . $i;
  $middle_name =  'middle_name';
  $last_name = 'last_name';
  $address = 'address';
  $gender = 1;
  $birthday = '2000-01-01';
  $mobile_number = '123455555555';
  $email = 'email'.$i.'@test.com';
  $indigent_start_date = '2000-01-01';
  $household_category = '1';
  $category_category = '1';
  $income_and_livelihood = '1';
  $water_and_sanitation = '1';
  $property = '1';
  $is_deleted = 0;
  $status = 1;
  
  
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
        `is_deleted`,
        `status`
        )
  VALUES
  ('{$lrif_number}', '{$first_name}', '{$middle_name}',  '{$last_name}', '{$address}', '{$gender}',
   '{$birthday}', '{$mobile_number}',  '{$email}', '{$indigent_start_date}', '{$household_category}',
    '{$category_category}',
    '{$income_and_livelihood}',
    '{$water_and_sanitation}',
    '{$property}',
    '{$is_deleted}',
    '{$status}')");
    $lastInsertedId = $dbConn->getConnection()->insert_id;
 }

    
 for($i=41; $i <= 60; $i++) {
  $lrif_number = $i;
  $first_name = 'first name' . $i;
  $middle_name =  'middle_name';
  $last_name = 'last_name';
  $address = 'address';
  $gender = 1;
  $birthday = '2000-01-01';
  $mobile_number = '123455555555';
  $email = 'email'.$i.'@test.com';
  $indigent_start_date = '2000-01-01';
  $household_category = '1';
  $category_category = '1';
  $income_and_livelihood = '1';
  $water_and_sanitation = '1';
  $property = '1';
  $is_deleted = 0;
  $status = 2;
  
  
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
        `is_deleted`,
        `status`
        )
  VALUES
  ('{$lrif_number}', '{$first_name}', '{$middle_name}',  '{$last_name}', '{$address}', '{$gender}',
   '{$birthday}', '{$mobile_number}',  '{$email}', '{$indigent_start_date}', '{$household_category}',
    '{$category_category}',
    '{$income_and_livelihood}',
    '{$water_and_sanitation}',
    '{$property}',
    '{$is_deleted}',
    '{$status}')");
    $lastInsertedId = $dbConn->getConnection()->insert_id;
 }

    



 for($i=41; $i <= 60; $i++) {
  $lrif_number = $i;
  $first_name = 'first name' . $i;
  $middle_name =  'middle_name';
  $last_name = 'last_name';
  $address = 'address';
  $gender = 1;
  $birthday = '2000-01-01';
  $mobile_number = '123455555555';
  $email = 'email'.$i.'@test.com';
  $indigent_start_date = '2000-01-01';
  $household_category = '1';
  $category_category = '1';
  $income_and_livelihood = '1';
  $water_and_sanitation = '1';
  $property = '1';
  $is_deleted = 1;
  $status = 1;
  

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
        `is_deleted`,
        `status`
        )
  VALUES
  ('{$lrif_number}', '{$first_name}', '{$middle_name}',  '{$last_name}', '{$address}', '{$gender}',
   '{$birthday}', '{$mobile_number}',  '{$email}', '{$indigent_start_date}', '{$household_category}',
    '{$category_category}',
    '{$income_and_livelihood}',
    '{$water_and_sanitation}',
    '{$property}',
    '{$is_deleted}',
    '{$status}')");
    $lastInsertedId = $dbConn->getConnection()->insert_id;
 }

    





unset($_POST);

<?php 
require_once(dirname(__FILE__) . '/config/Master.php');
require_once(dirname(__FILE__) .'/Classes/Logout.php');

$logout = new Logout();
$logout->processLogout();


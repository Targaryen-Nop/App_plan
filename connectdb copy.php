<?php
$server     = "project2.ts2337.com";
$user       = "tscom_project2";
$pwd        = "pec-k-monitor";
$dbname     = "tscom_project2";
$connection = mysqli_connect($server, $user, $pwd, $dbname);
if($connection != ""){
 echo "werwe";
}
$connection->set_charset("utf8");

$server_crm     = "project2.ts2337.com";
$user_crm       = "tscom_project2";
$pwd_crm        = "pec-k-monitor";
$dbname_crm     = "tscom_project2";
$connection_crm = mysqli_connect($server_crm, $user_crm, $pwd_crm, $dbname_crm);
$connection_crm->set_charset("utf8");
?>
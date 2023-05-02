<?php
$server     = "project1.ts2337.com";
$user       = "tscom_project1";
$pwd        = "bzCUqyLI5ggZ";
$dbname     = "tscom_project1";
$connection = mysqli_connect($server, $user, $pwd, $dbname);
if($connection != ""){
 echo "werwe";
}
$connection->set_charset("utf8");

$server_crm     = "localhost";
$user_crm       = "root";
$pwd_crm        = "";
$dbname_crm     = "pec_application_plans";
$connection_crm = mysqli_connect($server_crm, $user_crm, $pwd_crm, $dbname_crm);
$connection_crm->set_charset("utf8");
?>
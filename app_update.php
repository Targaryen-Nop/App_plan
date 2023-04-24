<?php
include 'db_io.php';
$test1 = $_POST["inputComp"];
$test2 = $_POST["inputDura"];
$test3 = 1726;
$statement = $connection->prepare("UPDATE applicationplan SET
$test2    = :$test2,
$test1    = :$test1,
plan_margin = :plan_margin,
weeks = :weeks

WHERE app_id = :app_id"
);

$result = $statement->execute(
array(
  ':'.$test2                  => $_POST["Durationvalue"],
  ':'.$test1                  => $_POST["Compvalue"],
  ':plan_margin'              => $_POST["planMargin"],
  ':weeks'                    => $_POST["weeks"],
  ':app_id'                   => $_POST["id"],
)

);

$errorG = $statement->errorInfo();

if ($errorG[2] == "") {

echo 'Data Updated';

} else {

echo 'Data NOT Updated' . " " . $errorG[2];

}
echo "<meta http-equiv='refresh' content='1; url='apptableplan1.php'>";

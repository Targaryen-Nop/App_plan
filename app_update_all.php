<?php
include 'db_io.php';
$test1 = $_POST["inputComp"];
$test2 = $_POST["inputDura"];
$test3 = 1726;
$statement = $connection->prepare(
  "UPDATE applicationplan SET
      app_receive  = :recievePo,
      duraET_po   = :duraET_po,
      compET_po   = :compET_po,
      duraET_mu   = :duraET_mu,
      compET_mu   = :compET_mu,
      duraET_pa   = :duraET_pa,
      compET_pa   = :compET_pa,
      duraET_ar   = :duraET_ar,
      compET_ar   = :compET_ar,
      duraET_qcr   = :duraET_qcr,
      compET_qcr   = :compET_qcr,
      duraET_as   = :duraET_as,
      compET_as   = :compET_as,
      duraET_qca   = :duraET_qca,
      compET_qca   = :compET_qca,
      duraET_ta   = :duraET_ta,
      compET_ta   = :compET_ta

WHERE app_id = :app_id"
);

$result = $statement->execute(
  array(
    ':recievePo'        => $_POST["recievePo"],
    ':duraET_po'        => $_POST["duraPoValue"],
    ':compET_po'        => $_POST["compPoValue"],
    ':duraET_mu'        => $_POST["duraMuValue"],
    ':compET_mu'        => $_POST["compMuValue"],
    ':duraET_pa'        => $_POST["duraPaValue"],
    ':compET_pa'        => $_POST["compPaValue"],
    ':duraET_ar'        => $_POST["duraArValue"],
    ':compET_ar'        => $_POST["compArValue"],
    ':duraET_qcr'        => $_POST["duraQcrValue"],
    ':compET_qcr'        => $_POST["compQcrValue"],
    ':duraET_as'        => $_POST["duraAsValue"],
    ':compET_as'        => $_POST["compAsValue"],
    ':duraET_qca'        => $_POST["duraQcaValue"],
    ':compET_qca'        => $_POST["compQcaValue"],
    ':duraET_ta'        => $_POST["duraTaValue"],
    ':compET_ta'        => $_POST["compTaValue"],
    ':app_id'           => $_POST["id"],
  )

);

$errorG = $statement->errorInfo();

if ($errorG[2] == "") {

  echo 'Data Updated';
} else {

  echo 'Data NOT Updated' . " " . $errorG[2];
}
echo "<meta http-equiv='refresh' content='1; url='apptableplan1.php'>";

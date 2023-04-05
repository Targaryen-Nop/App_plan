<?php
include 'db_io.php';

$query   = '';
$output  = array();


$query = "SELECT holiday_date FROM holiday WHERE year = '2023'";

$statement = $connection->prepare($query);
$statement->execute();
$result        = $statement->fetchAll();


foreach ($result as $row) {
    $sub_array[] = $row['holiday_date'];
}

$output = $sub_array;

echo json_encode($output);

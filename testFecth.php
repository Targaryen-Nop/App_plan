<?php
include 'db_io.php';


$customers    = array();
$engineers   = array();
$compare    = array();
$query = "
    SELECT
      io_report.io_id AS io_id,
      io_report.io_no AS io_number,
      io_report.io_year AS io_year,
      io_report.customer AS customer_name,
      io_report.delivery AS due_date,
      io_report.io_date AS io_date,
      io_report.price AS price,
      io_report.issue_by AS APP,
      io_report.po_receive as po_receive,
      io_report.prev_delivery as po_due_date,
      io_report.io_ready as io_ready,
      logistics.region as region,
      logistics.shipped_by as shipped_by
FROM io_report 
JOIN logistics
ON logistics.io_number = io_report.io_no
JOIN applicationplan 
ON applicationplan.io_number = logistics.io_number ";
$query .= 'WHERE io_report.io_year = "2022" ';
$query .= " ORDER BY applicationplan.app_id DESC ";
$query .= "LIMIT 100";
$statement1 = $connection->prepare($query);
$statement1->execute();
$result1 = $statement1->fetchAll();

foreach ($result1 as $row) {
    $customers["io_id"]                 = $row["io_id"];
    $customers["io_number"]                 = $row["io_number"];
    $customers["io_year"]                 = $row["io_year"];
    $customers["customer_name"]                 = $row["customer_name"];
    $customers["due_date"]                 = $row["due_date"];
    $customers["io_date"]                 = $row["io_date"];
    $customers["price"]                 = $row["price"];
    $customers["APP"]                 = $row["APP"];
    $customers["po_receive"]                 = $row["po_receive"];
    $customers["po_due_date"]                 = $row["po_due_date"];
    $customers["io_ready"]                 = $row["io_ready"];
    $customers["io_ready"]                 = $row["io_ready"];
    $customers["region"]                 = $row["region"];
    $customers["shipped_by"]                 = $row["shipped_by"];
    $compare[] = $customers;
}

echo json_encode($compare);

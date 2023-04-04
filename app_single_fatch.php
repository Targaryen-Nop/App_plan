<?php
include 'db_io.php';

$customers    = array();
$compare    = array();
$query1 = "
SELECT 
    io_monitor.io_id AS io_id,
	io_monitor.io_number AS io_number,
	io_monitor.customer_name AS customer_name,
	io_monitor.customer_delivery AS due_date,
	io_monitor.io_date AS io_date,
	io_monitor.actual_delivery AS TRA,
	io_monitor.price AS price,
	io_monitor.io_by AS APP,
	io_monitor.po_receive as po_receive,
	io_report.prev_delivery as po_due_date,
	io_report.io_ready as io_ready
FROM io_monitor 
JOIN io_report
ON io_monitor.io_number = io_report.io_no
WHERE io_monitor.io_number LIKE '%".$_POST['io_number']."%'
AND io_monitor.io_year LIKE '%".$_POST['io_year']."%'";

$statement1 = $connection->prepare($query1);
$statement1->execute();
$result1 = $statement1->fetchAll();

foreach ($result1 as $row) {
    $customers["io_number"]                     = $row["io_number"];
    $customers["customer_name"]                 = $row["customer_name"];
    $customers["due_date"]                      = $row["due_date"];
    $customers["io_date"]                       = $row["io_date"];
    $customers["TRA"]                           = $row["TRA"];
    $customers["price"]                         = $row["price"];
    $customers["APP"]                           = $row["APP"];
    $customers["po_receive"]                    = $row["po_receive"];
    $customers["io_ready"]                      = $row["io_ready"];
    $compare[] = $customers;
}

echo json_encode($compare);
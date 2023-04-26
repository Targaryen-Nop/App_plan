<?php

include 'db_io.php';

$total23    = array();
$total22    = array();
$total21    = array();
$compare    = array();

$query2 = "
SELECT 
	MONTH(delivery) AS month, 
    COUNT(`io_id`) AS total2023
FROM io_report
WHERE `io_year` = YEAR(CURDATE()) AND  MONTH(delivery) <> 0
GROUP BY MONTH(delivery);";

$query3 = "
SELECT 
	MONTH(delivery) AS month, 
    COUNT(`io_id`) AS total2022
FROM io_report
WHERE `io_year` =  YEAR(CURDATE())-1 AND  MONTH(delivery) <> 0
GROUP BY MONTH(delivery);";

$query4 = "
SELECT 
	MONTH(delivery) AS month, 
    COUNT(`io_id`) AS total2021
FROM io_report
WHERE `io_year` = YEAR(CURDATE())-2 AND  MONTH(delivery) <> 0
GROUP BY MONTH(delivery);";

$statement2 = $connection->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();

$statement3 = $connection->prepare($query3);
$statement3->execute();
$result3 = $statement3->fetchAll();


$statement4 = $connection->prepare($query4);
$statement4->execute();
$result4 = $statement4->fetchAll();

foreach ($result2 as $row) {
    $total23[] = $row["total2023"];
    $compare["total2023"] = $total23;
}

foreach ($result3 as $row) {
    $total22[] = $row["total2022"];
    $compare["total2022"] = $total22;
}

foreach ($result4 as $row) {
    $total21[] = $row["total2021"];
    $compare["total2021"] = $total21;
}


echo json_encode($compare);
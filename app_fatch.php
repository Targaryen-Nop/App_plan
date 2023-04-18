<?php
include 'db_io.php';

$query   = '';
$output  = array();

$columns = array(
    'id',
    'null',
    'item',
    'product_year',
    'product_name',
);

$io_year = $_POST['io_year'];
// $holidaysPost = $_POST['date_holidays_format']; 

if ($io_year != "") {
    $query = "
    SELECT
    applicationplan.app_receive as app_receive, 
    applicationplan.duraET_po as duraET_po, 
    applicationplan.compET_po as compET_po,
    applicationplan.duraET_mu as duraET_mu,
    applicationplan.compET_mu as compET_mu,
    applicationplan.duraET_pa as duraET_pa,
    applicationplan.compET_pa as compET_pa,
    applicationplan.duraET_ar as duraET_ar,
    applicationplan.compET_ar as compET_ar,
    applicationplan.duraET_qcr as duraET_qcr,
    applicationplan.compET_qcr as compET_qcr,
    applicationplan.duraET_as as duraET_as,
    applicationplan.compET_as as compET_as,
    applicationplan.duraET_qca as duraET_qca,
    applicationplan.compET_qca as compET_qca,
    applicationplan.duraET_ta as duraET_ta,
    applicationplan.compET_ta as compET_ta,
    applicationplan.app_id as app_id,
    io_monitor.io_id AS io_id,
    io_monitor.io_number AS io_number,
    io_monitor.io_year AS io_year,
    io_monitor.customer_name AS customer_name,
    io_monitor.customer_delivery AS due_date,
    io_monitor.io_date AS io_date,
    io_monitor.actual_delivery AS TRA,
    io_monitor.price AS price,
    io_monitor.io_by AS APP,
    io_monitor.po_receive as po_receive,
    io_report.prev_delivery as po_due_date,
    io_report.io_ready as io_ready,
    logistics.region as region,
    logistics.shipped_by as shipped_by
FROM io_monitor 
JOIN io_report
ON io_monitor.io_number = io_report.io_no
JOIN applicationplan 
ON applicationplan.io_number = io_monitor.io_number
JOIN logistics
ON logistics.io_number = io_monitor.io_number
WHERE io_monitor.io_year LIKE '%" . $io_year . "%'
ORDER BY io_monitor.io_year ASC
LIMIT 100";
} else {
    $query = "
    SELECT
    applicationplan.app_receive as app_receive, 
    applicationplan.duraET_po as duraET_po, 
    applicationplan.compET_po as compET_po,
    applicationplan.duraET_mu as duraET_mu,
    applicationplan.compET_mu as compET_mu,
    applicationplan.duraET_pa as duraET_pa,
    applicationplan.compET_pa as compET_pa,
    applicationplan.duraET_ar as duraET_ar,
    applicationplan.compET_ar as compET_ar,
    applicationplan.duraET_qcr as duraET_qcr,
    applicationplan.compET_qcr as compET_qcr,
    applicationplan.duraET_as as duraET_as,
    applicationplan.compET_as as compET_as,
    applicationplan.duraET_qca as duraET_qca,
    applicationplan.compET_qca as compET_qca,
    applicationplan.duraET_ta as duraET_ta,
    applicationplan.compET_ta as compET_ta,
    applicationplan.app_id as app_id,
    io_monitor.io_id AS io_id,
    io_monitor.io_number AS io_number,
    io_monitor.io_year AS io_year,
    io_monitor.customer_name AS customer_name,
    io_monitor.customer_delivery AS due_date,
    io_monitor.io_date AS io_date,
    io_monitor.actual_delivery AS TRA,
    io_monitor.price AS price,
    io_monitor.io_by AS APP,
    io_monitor.po_receive as po_receive,
    io_report.prev_delivery as po_due_date,
    io_report.io_ready as io_ready,
    logistics.region as region,
    logistics.shipped_by as shipped_by
FROM io_monitor 
JOIN io_report
ON io_monitor.io_number = io_report.io_no
JOIN applicationplan 
ON applicationplan.io_number = io_monitor.io_number
JOIN logistics
ON logistics.io_number = io_monitor.io_number
ORDER BY io_monitor.io_year ASC
LIMIT 100";
}


$statement = $connection->prepare($query);
$statement->execute();
$result        = $statement->fetchAll();
$data          = array();
$filtered_rows = $statement->rowCount();

$sql_day = "SELECT holiday_date,year FROM holiday WHERE year = '2024'";
$result_date = $connection->query($sql_day);

$row['app_id'] = 0;


// $holidays = array();
// if ($result_date->num_rows > 0) {
//     // Fetch the result as an associative array
//     while ($row = $result_date->fetch_assoc()) {

//         // Decode the JSON string to a PHP array
//         $days = json_decode($row["holiday_date"]);
//         // Loop through the array and display the days
//         foreach ($days as $day) {
//             $explodeHolidays =  explode(",",$day);
//         }
//     }
// } else {
//     echo "No results found";
// }

// foreach ($explodeHolidays as $explodeHoliday){
//     $date = date_create($explodeHoliday);
//     $date_format = date_format($date,"Y-m-d");
//     echo $date_format. "<br>";
//     array_push($holidays,$date_format);
// }


function countBusinessDays2($start, $endDate, $holidays = array())
{
    $startDate = date($start);
    $businessDays = 0;
    $daysLate = 0;

    while ($startDate < $endDate) {
        $weekday = date('N', strtotime($startDate));

        if ($weekday < 6 && !in_array($startDate, $holidays)) { // Monday to Friday, not a holiday
            $businessDays++;
        }

        $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
    }

    if ($startDate > $endDate) { // if end date is in the past
        $weekday = date('N', strtotime($startDate));
        if ($weekday < 6 && !in_array($startDate, $holidays)) { // Monday to Friday, not a holiday
            $businessDays--;
            $daysLate = number_format((strtotime($startDate) - strtotime($endDate)) / (60 * 60 * 24)); // calculate number of days late
        }
    }

    return array("businessDays" => $businessDays, "daysLate" => $daysLate);
}

foreach ($result as $row) {
    $dw;
    $sub_array = array();
    $full_io_number = explode('-', $row['io_number']);
    $date_due = date_create($row['due_date']);
    // $date2 = date_create("25-06-2023");

    // Date counting Everydays
    // $diff = date_diff($date, $date2);
    // $duedate = $diff->format("%R%a");

    $sub_array[] = '<button type="button" name="update_' . $row['app_id'] . '" id="' . $row['app_id'] . '" class="btn btn-success btn-sm update">Edit</button>';


    if (count($full_io_number) > 3) {
        $sub_array[] = $full_io_number[4] . "-" . substr($row['io_year'], 2, 4);
    } else {
        $sub_array[] = "NOT Have DATA";
    }

    if (count($full_io_number) > 3) {
        $sub_array[] = substr($full_io_number[6], 0, 1);
    } else {
        $sub_array[] = "NOT Have DATA";
    }
    $sub_array[] = $row['customer_name'];

    $sub_array[] = date_format($date_due, "d/m/Y ");

    // ----- Date Time ------
    $dateStart = date_create($row['due_date']);
    $startDate = date_format(date_create($row['due_date']), 'Y-m-d');
    $dateEnd = date_create('25-06-2023');
    $endDate = date_format($dateEnd, 'Y-m-d');
    $businessDays = 0;
    $daysLate = 0;
    $holidays = array("2023-01-01", "2023-05-01", "2023-12-25");

    while ($startDate < $endDate) {
        $weekday = date('N', strtotime($startDate));

        if ($weekday < 6 && !in_array($startDate, $holidays)) { // Monday to Friday, not a holiday
            $businessDays++;
        }

        $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
    }

    if ($startDate > $endDate) { // if end date is in the past
        while ($endDate < $startDate) {
            $weekday = date('N', strtotime($endDate));

            if ($weekday < 6 && !in_array($endDate, $holidays)) { // Monday to Friday, not a holiday
                $daysLate++;
            }

            $endDate = date('Y-m-d', strtotime('+1 day', strtotime($endDate)));
        }

        $businessDays--;
        $daysLate--;
    }

    if ($businessDays >= 0) {
        $sub_array[] = '<button type="button" class="btn btn-success">+' .  $businessDays  . '</button>';
    } else {
        $sub_array[] = '<button type="button" class="btn btn-danger">' . $daysLate * -1 . '</button>';
    }





    // if ($date > $date2) {
    //     $sub_array[] = '<button type="button" class="btn btn-danger">' . $duedate . '</button>';
    // } else {
    //     $sub_array[] = '<button type="button" class="btn btn-success">' . $duedate . '</button>';
    // }


    // -------------------------

    $sub_array[] = substr($row['io_number'], 5, 3);
    $sub_array[] = $row['price'];
    $sub_array[] = '
    <input type="text" class="form-control bg-primary text-white text-center"  value="' . $row['APP'] . '"  />
    <input type="text" class="form-control bg-success text-white text-center"  />';

    $sub_array[] = '
    <input type="text" readonly class="form-control bg-primary text-white text-center"  value="ET"  />
    <input type="text" readonly class="form-control bg-success text-white text-center"  value="AT" />';


    if ($row['app_receive'] != NULL) {
        $sub_array[] =  '
        <input type="date" class="form-control update_all" value="' . $row['app_receive'] . '"   id="recivepo_' . $row['app_id'] . '"oninput="onplusTime(
            recivepo_' . $row['app_id'] . ',
            duraET_po_' . $row['app_id'] . ',
            compET_po_' . $row['app_id'] . ',
    
            compET_po_' . $row['app_id'] . ',
            duraET_mu_' . $row['app_id'] . ',
            compET_mu_' . $row['app_id'] . ',
    
            compET_mu_' . $row['app_id'] . ',
            duraET_pa_' . $row['app_id'] . ',
            compET_pa_' . $row['app_id'] . ',
    
            compET_pa_' . $row['app_id'] . ',
            duraET_ar_' . $row['app_id'] . ',
            compET_ar_' . $row['app_id'] . ',
    
            compET_ar_' . $row['app_id'] . ',
            duraET_qcr_' . $row['app_id'] . ',
            compET_qcr_' . $row['app_id'] . ',
    
            compET_qcr_' . $row['app_id'] . ',
            duraET_as_' . $row['app_id'] . ',
            compET_as_' . $row['app_id'] . ',
    
            compET_as_' . $row['app_id'] . ',
            duraET_qca_' . $row['app_id'] . ',
            compET_qca_' . $row['app_id'] . ',
    
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ')"/>';
    } else {
        $sub_array[] =  '
        <input type="date" class="form-control update_all"   id="recivepo_' . $row['app_id'] . '"oninput="onplusTime(
            recivepo_' . $row['app_id'] . ',
            duraET_po_' . $row['app_id'] . ',
            compET_po_' . $row['app_id'] . ',
    
            compET_po_' . $row['app_id'] . ',
            duraET_mu_' . $row['app_id'] . ',
            compET_mu_' . $row['app_id'] . ',
    
            compET_mu_' . $row['app_id'] . ',
            duraET_pa_' . $row['app_id'] . ',
            compET_pa_' . $row['app_id'] . ',
    
            compET_pa_' . $row['app_id'] . ',
            duraET_ar_' . $row['app_id'] . ',
            compET_ar_' . $row['app_id'] . ',
    
            compET_ar_' . $row['app_id'] . ',
            duraET_qcr_' . $row['app_id'] . ',
            compET_qcr_' . $row['app_id'] . ',
    
            compET_qcr_' . $row['app_id'] . ',
            duraET_as_' . $row['app_id'] . ',
            compET_as_' . $row['app_id'] . ',
    
            compET_as_' . $row['app_id'] . ',
            duraET_qca_' . $row['app_id'] . ',
            compET_qca_' . $row['app_id'] . ',
    
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ',
            planmargin_' . $row['app_id'] . ',
            week_' . $row['app_id'] . ')"/>';
    }


    if ($row['duraET_po'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_po'] . '" id="duraET_po_' . $row['app_id'] . '" />
        <input readonly type="text" class="form-control bg-success text-white text-center update" id="duraAT_po_' . $row['app_id'] . '" value="3"/>';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="3" id="duraET_po_' . $row['app_id'] . '" />
        <input readonly type="text" class="form-control bg-success text-white text-center update" id="duraAT_po_' . $row['app_id'] . '" value="3"/>';
    }


    if ($row['compET_po'] != NULL) {
        $sub_array[] = '
        <input type="text" readonly class="form-control bg-secondary text-white text-center" value="' . $row['compET_po'] . '" id="compET_po_' . $row['app_id'] . '"  />
        <input type="text" readonly class="form-control bg-secondary text-white text-center" id="compAT_po_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" readonly class="form-control bg-secondary text-white text-center" id="compET_po_' . $row['app_id'] . '"  />
        <input type="text" readonly class="form-control bg-secondary text-white text-center" id="compAT_po_' . $row['app_id'] . '"  />';
    }


    $checkManu  = substr($row['io_number'], 5, 1);

    if ($row['duraET_mu'] != NULL) {
        $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_mu'] . '"  id="duraET_mu_' . $row['app_id'] . '"  oninput="onplusTime2(compET_po_' . $row['app_id'] . ',duraET_mu_' . $row['app_id'] . ',compET_mu_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_mu_' . $row['app_id'] . '"  />';
    } else {
        if ($checkManu == 'A') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="20.5"  id="duraET_mu_' . $row['app_id'] . '"  oninput="onplusTime2(compET_po_' . $row['app_id'] . ',duraET_mu_' . $row['app_id'] . ',compET_mu_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="20.5" id="duraAT_mu_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="0"  id="duraET_mu_' . $row['app_id'] . '"  oninput="onplusTime2(compET_po_' . $row['app_id'] . ',duraET_mu_' . $row['app_id'] . ',compET_mu_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_mu_' . $row['app_id'] . '"  />';
        }
    }
    if ($row['compET_mu'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center" value="' . $row['compET_mu'] . '"  id="compET_mu_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_mu_' . $row['app_id'] . '" />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_mu_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_mu_' . $row['app_id'] . '" />';
    }


    if ($row['duraET_pa'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update"  value="' . $row['duraET_pa'] . '"  id="duraET_pa_' . $row['app_id'] . '"  oninput="onplusTime2(compET_mu_' . $row['app_id'] . ',duraET_pa_' . $row['app_id'] . ',compET_pa_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_pa_' . $row['app_id'] . '"  />';
    } else {
        if ($checkManu == 'A') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="5"  id="duraET_pa_' . $row['app_id'] . '"  oninput="onplusTime2(compET_mu_' . $row['app_id'] . ',duraET_pa_' . $row['app_id'] . ',compET_pa_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="5" id="duraAT_pa_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="0"  id="duraET_pa_' . $row['app_id'] . '"  oninput="onplusTime2(compET_mu_' . $row['app_id'] . ',duraET_pa_' . $row['app_id'] . ',compET_pa_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_pa_' . $row['app_id'] . '"  />';
        }
    }



    if ($row['compET_pa'] != NULL) {
        $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" value="' . $row['compET_pa'] . '"  id="compET_pa_' . $row['app_id'] . '" />
    <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_pa_' . $row['app_id'] . '" />';
    } else {
        $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_pa_' . $row['app_id'] . '" />
    <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_pa_' . $row['app_id'] . '" />';
    }


    $checkRegion = $row['region'];
    $checkShipped = substr($row['shipped_by'], 0, 3);

    if ($row['duraET_ar'] != NULL) {
        $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_ar'] . '"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="7" id="duraAT_ar_' . $row['app_id'] . '"  />';
    } else {

        if ($checkRegion == 'Asia' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="7"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="7" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'Asia' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="30"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="30" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'India' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="12"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="12" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'India' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="50"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="50" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'America' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="7"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="7" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'America' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="60"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="60" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'Europe' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="14"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="14" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'Europe' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="65"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="65" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkManu == 'L') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="10.5"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="10.5" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="0"  id="duraET_ar_' . $row['app_id'] . '"  oninput="onplusTime2(compET_pa_' . $row['app_id'] . ',duraET_ar_' . $row['app_id'] . ',compET_ar_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_ar_' . $row['app_id'] . '"  />';
        }
    }


    if ($row['compET_ar'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  value="' . $row['compET_ar'] . '"  id="compET_ar_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_ar_' . $row['app_id'] . '" />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_ar_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_ar_' . $row['app_id'] . '" />';
    }

    if ($row['duraET_qcr'] != NULL) {
        $sub_array[] = '
        <input type="text"  class="form-control bg-danger text-white text-center update"  value="' . $row['duraET_qcr'] . '"  id="duraET_qcr_' . $row['app_id'] . '"  oninput="onplusTime2(compET_ar_' . $row['app_id'] . ',duraET_qcr_' . $row['app_id'] . ',compET_qcr_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="2" id="duraAT_qcr_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="2"  id="duraET_qcr_' . $row['app_id'] . '"  oninput="onplusTime2(compET_ar_' . $row['app_id'] . ',duraET_qcr_' . $row['app_id'] . ',compET_qcr_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="2" id="duraAT_qcr_' . $row['app_id'] . '"  />';
    }

    if ($row['compET_qcr'] != NULL) {
        $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" value="' . $row['compET_qcr'] . '"  id="compET_qcr_' . $row['app_id'] . '" />
    <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_qcr_' . $row['app_id'] . '" />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_qcr_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_qcr_' . $row['app_id'] . '" />';
    }

    if ($row['duraET_as'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_as'] . '"  id="duraET_as_' . $row['app_id'] . '"  oninput="onplusTime2(compET_qcr_' . $row['app_id'] . ',duraET_as_' . $row['app_id'] . ',compET_as_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="2" id="duraAT_as_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="2"  id="duraET_as_' . $row['app_id'] . '"  oninput="onplusTime2(compET_qcr_' . $row['app_id'] . ',duraET_as_' . $row['app_id'] . ',compET_as_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="2" id="duraAT_as_' . $row['app_id'] . '"  />';
    }

    if ($row['compET_as'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center" value="' . $row['compET_as'] . '"  id="compET_as_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_as_' . $row['app_id'] . '" />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_as_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_as_' . $row['app_id'] . '" />';
    }

    if ($row['duraET_qca'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_qca'] . '"  id="duraET_qca_' . $row['app_id'] . '"  oninput="onplusTime2(compET_as_' . $row['app_id'] . ',duraET_qca_' . $row['app_id'] . ',compET_qca_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update"  value="2" id="duraAT_qca_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update"  value="2"  id="duraET_qca_' . $row['app_id'] . '"  oninput="onplusTime2(compET_as_' . $row['app_id'] . ',duraET_qca_' . $row['app_id'] . ',compET_qca_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update"  value="2" id="duraAT_qca_' . $row['app_id'] . '"  />';
    }

    if ($row['compET_qca'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center" value="' . $row['compET_qca'] . '"  id="compET_qca_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_qca_' . $row['app_id'] . '" />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_qca_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_qca_' . $row['app_id'] . '" />';
    }
    if ($row['duraET_ta'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_ta'] . '"  id="duraET_ta_' . $row['app_id'] . '"  oninput="onplusTime2(compET_qca_' . $row['app_id'] . ',duraET_ta_' . $row['app_id'] . ',compET_ta_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update"value="3" id="duraAT_ta_' . $row['app_id'] . '"  />';
    } else {
        if ($row['price'] > 100000) {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="3"  id="duraET_ta_' . $row['app_id'] . '"  oninput="onplusTime2(compET_qca_' . $row['app_id'] . ',duraET_ta_' . $row['app_id'] . ',compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update"value="3" id="duraAT_ta_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update"value="7"  id="duraET_ta_' . $row['app_id'] . '"  oninput="onplusTime2(compET_qca_' . $row['app_id'] . ',duraET_ta_' . $row['app_id'] . ',compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update"value="7" id="duraAT_ta_' . $row['app_id'] . '"  />';
        }
    }


    if ($row['compET_ta'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"value="' . $row['compET_ta'] . '"  id="compET_ta_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_ta_' . $row['app_id'] . '" value="25/06/2023" />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compET_ta_' . $row['app_id'] . '" />
        <input type="text" class="form-control bg-secondary text-white text-center"  id="compAT_ta_' . $row['app_id'] . '" value="25/06/2023" />';
    }

    if($row['compET_ta'] != NULL){
        $compTAday2 = DateTime::createFromFormat('d/m/Y', $row['compET_ta']);
        $formattedDate2 = $compTAday2->format('Y-m-d');
        $formatdate = $date_due->format('Y-m-d');
        $result = countBusinessDays2($formatdate,$formattedDate2,$holidays);
        // $interval2 = $compTAday2->diff($date_due);
   
        if ($result["businessDays"] >= 0) {
            $sub_array[] =  '
        <input type="text" class="form-control text-center" id="planmargin_' . $row['app_id'] . '" value="+'.$result['businessDays'].'" />';
        } else {
            $sub_array[] =  '
        <input type="text" class="form-control text-center" id="planmargin_' . $row['app_id'] . '" value="-'.$result['daysLate'].'" />';
        }
       
   
    }else{
        $sub_array[] =  '
        <input type="text" class="form-control text-center" id="planmargin_' . $row['app_id'] . '" value="0" />';
    }
 
   


    if ($row['compET_ta'] != NULL) {
        $compTAday = DateTime::createFromFormat('d/m/Y', $row['compET_ta']);
    
        $ReceivePoday = new DateTime($row['app_receive']);
        $interval = $compTAday->diff($ReceivePoday);
        $weeks = floor($interval->days / 7);
        $sub_array[] =  '
        <input type="text" class="form-control text-center" id="week_' . $row['app_id'] . '" value="'.$weeks.'" />';
  
    } else {
        $sub_array[] =  '
        <input type="text" class="form-control text-center" id="week_' . $row['app_id'] . '" value="0" />';
    }
    $data[] = $sub_array;
}

$output = array(
    "recordsFiltered" => $filtered_rows,
    "data"            => $data,
);

echo json_encode($output);

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
// $holidaysPost = array($_POST['date_holidays_format']); 
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
      applicationplan.plan_margin as plan_margin,
      applicationplan.weeks as weeks,
      applicationplan.app_id as app_id,
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

if ($io_year != "") {
    $query .= 'WHERE io_report.io_year = "' . $io_year . '" ';
} else if ($io_year == "") {
    $query .= 'WHERE io_report.io_year = "2022" ';
}
$query .= " ORDER BY applicationplan.app_id DESC ";
$query .= "LIMIT 100";

$statement = $connection->prepare($query);
$statement->execute();
$result        = $statement->fetchAll();
$data          = array();
$filtered_rows = $statement->rowCount();

$sql_day = "SELECT holiday_date,year FROM holiday WHERE year = '2024'";
$result_date = $connection->query($sql_day);




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




foreach ($result as $row) {
    $dw;
    $sub_array = array();
    $full_io_number = explode('-', $row['io_number']);
    $date_due = date_create($row['due_date']);
    // $date2 = date_create("25-06-2023");

    // Date counting Everydays
    // $diff = date_diff($date, $date2);
    // $duedate = $diff->format("%R%a");

    $sub_array[] = '<p style="font-size:10px" id="' . $row['io_number'] . '">' . $row['io_number'] . '</p>';


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
    $DueDate = date_format($date_due, "d/m/Y ");

    $sub_array[] = '<p id="due_date_' . $row['app_id'] . '">' . $DueDate . '</p>';

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
        $businessDays++;
        $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
    }

    if ($startDate > $endDate) { // if end date is in the past
        while ($endDate < $startDate) {
            $weekday = date('N', strtotime($endDate));
            $daysLate++;
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
        <input type="date" class="form-control update_all"   id="recivepo_' . $row['app_id'] . '"
        oninput="onplusTime(
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
    }


    if ($row['duraET_po'] != NULL) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_po'] . '" id="duraET_po_' . $row['app_id'] . '"
        oninput="onplusTime(
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
            compET_ta_' . $row['app_id'] . ')" />
        <input readonly type="text" class="form-control bg-success text-white text-center update" id="duraAT_po_' . $row['app_id'] . '" value="3"/>';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="3" id="duraET_po_' . $row['app_id'] . '" 
          oninput="onplusTime(
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
            compET_ta_' . $row['app_id'] . ')"/>
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
            <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_mu'] . '"  id="duraET_mu_' . $row['app_id'] . '"  
            oninput="onplusTime2(
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_mu_' . $row['app_id'] . '"  />';
    } else {
        if ($checkManu == 'A') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="20.5"  id="duraET_mu_' . $row['app_id'] . '"  
            oninput="onplusTime2(
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="20.5" id="duraAT_mu_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="0"  id="duraET_mu_' . $row['app_id'] . '"  
            oninput="onplusTime2(
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
                compET_ta_' . $row['app_id'] . '
              )"/>
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
        <input type="text" class="form-control bg-danger text-white text-center update"  value="' . $row['duraET_pa'] . '"  id="duraET_pa_' . $row['app_id'] . '"  
        oninput="onplusTime2(
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
            compET_ta_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="0" id="duraAT_pa_' . $row['app_id'] . '"  />';
    } else {
        if ($checkManu == 'A') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="5"  id="duraET_pa_' . $row['app_id'] . '"  
            oninput="onplusTime2(
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="5" id="duraAT_pa_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="0"  id="duraET_pa_' . $row['app_id'] . '"  
            oninput="onplusTime2(
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
                compET_ta_' . $row['app_id'] . ')"/>
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
            <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_ar'] . '"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="7" id="duraAT_ar_' . $row['app_id'] . '"  />';
    } else {

        if ($checkRegion == 'Asia' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="7"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="7" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'Asia' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="30"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="30" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'India' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="12"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="12" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'India' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="50"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="50" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'America' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="7"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="7" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'America' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="60"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="60" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'Europe' && $checkShipped == 'Air') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="14"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="14" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkRegion == 'Europe' && $checkShipped == 'Sea') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="65"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="65" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else if ($checkManu == 'L') {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="10.5"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update" value="10.5" id="duraAT_ar_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="0"  id="duraET_ar_' . $row['app_id'] . '"  
            oninput="onplusTime2(     
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
                compET_ta_' . $row['app_id'] . ')"/>
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
        <input type="text"  class="form-control bg-danger text-white text-center update"  value="' . $row['duraET_qcr'] . '"  id="duraET_qcr_' . $row['app_id'] . '"  
        oninput="onplusTime2(     
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
            compET_ta_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="2" id="duraAT_qcr_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="2"  id="duraET_qcr_' . $row['app_id'] . '"  
        oninput="onplusTime2(     
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
            compET_ta_' . $row['app_id'] . ')"/>
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
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_as'] . '"  id="duraET_as_' . $row['app_id'] . '"  
        oninput="onplusTime2(         
            compET_qcr_' . $row['app_id'] . ',
            duraET_as_' . $row['app_id'] . ',
            compET_as_' . $row['app_id'] . ',
    
            compET_as_' . $row['app_id'] . ',
            duraET_qca_' . $row['app_id'] . ',
            compET_qca_' . $row['app_id'] . ',
    
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update" value="2" id="duraAT_as_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update" value="2"  id="duraET_as_' . $row['app_id'] . '"  
        oninput="onplusTime2(         
            compET_qcr_' . $row['app_id'] . ',
            duraET_as_' . $row['app_id'] . ',
            compET_as_' . $row['app_id'] . ',
    
            compET_as_' . $row['app_id'] . ',
            duraET_qca_' . $row['app_id'] . ',
            compET_qca_' . $row['app_id'] . ',
    
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ')"/>
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
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_qca'] . '"  id="duraET_qca_' . $row['app_id'] . '"  
        oninput="onplusTime2(         
            compET_as_' . $row['app_id'] . ',
            duraET_qca_' . $row['app_id'] . ',
            compET_qca_' . $row['app_id'] . ',
    
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update"  value="2" id="duraAT_qca_' . $row['app_id'] . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center update"  value="2"  id="duraET_qca_' . $row['app_id'] . '"  
        oninput="onplusTime2(         
            compET_as_' . $row['app_id'] . ',
            duraET_qca_' . $row['app_id'] . ',
            compET_qca_' . $row['app_id'] . ',
    
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ')"/>
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
        <input type="text" class="form-control bg-danger text-white text-center update" value="' . $row['duraET_ta'] . '"  id="duraET_ta_' . $row['app_id'] . '"  
        oninput="onplusTime2(         
            compET_qca_' . $row['app_id'] . ',
            duraET_ta_' . $row['app_id'] . ',
            compET_ta_' . $row['app_id'] . ')"/>
        <input type="text" class="form-control bg-success text-white text-center update"value="3" id="duraAT_ta_' . $row['app_id'] . '"  />';
    } else {
        if ($row['price'] > 100000) {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update" value="3"  id="duraET_ta_' . $row['app_id'] . '"  
            oninput="onplusTime2(         
                compET_qca_' . $row['app_id'] . ',
                duraET_ta_' . $row['app_id'] . ',
                compET_ta_' . $row['app_id'] . ')"/>
            <input type="text" class="form-control bg-success text-white text-center update"value="3" id="duraAT_ta_' . $row['app_id'] . '"  />';
        } else {
            $sub_array[] = '
            <input type="text" class="form-control bg-danger text-white text-center update"value="7"  id="duraET_ta_' . $row['app_id'] . '"  
            oninput="onplusTime2(         
                compET_qca_' . $row['app_id'] . ',
                duraET_ta_' . $row['app_id'] . ',
                compET_ta_' . $row['app_id'] . ')"/>
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


    $sub_array[] =  '
        <input type="text" class="form-control text-center" id="planmargin_' . $row['app_id'] . '" value="' . $row['plan_margin'] . '" />';


    $sub_array[] =  '
        <input type="text" class="form-control text-center" id="week_' . $row['app_id'] . '" value="' . $row['weeks'] . '" />';




    $data[] = $sub_array;
}

$output = array(
    "recordsFiltered" => $filtered_rows,
    "data"            => $data,
);

echo json_encode($output);

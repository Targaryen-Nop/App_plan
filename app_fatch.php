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

if ($io_year != "") {
    $query = "
    SELECT
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
        io_report.io_ready as io_ready
    FROM io_monitor 
    JOIN io_report
    ON io_monitor.io_number = io_report.io_no
    WHERE io_monitor.io_year LIKE '%" . $io_year . "%'
    ORDER BY io_monitor.io_year DESC
    LIMIT 100";
} else {
    $query = "
    SELECT
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
        io_report.io_ready as io_ready
    FROM io_monitor 
    JOIN io_report
    ON io_monitor.io_number = io_report.io_no
    ORDER BY io_monitor.io_year DESC
    LIMIT 100";
}


$statement = $connection->prepare($query);
$statement->execute();
$result        = $statement->fetchAll();
$data          = array();
$filtered_rows = $statement->rowCount();
$n = 0;


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

    $sub_array = array();
    $n++;
    $full_io_number = explode('-', $row['io_number']);
    $date_due = date_create($row['due_date']);
    // $date2 = date_create("25-06-2023");

    // Date counting Everydays
    // $diff = date_diff($date, $date2);
    // $duedate = $diff->format("%R%a");



    $sub_array[] = '<button type="button" name="update_' . $n . '" id="' . $n . '" class="btn btn-success btn-sm update">Edit</button>';


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
    $startDate = date_format($dateStart, 'Y-m-d');
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

    $sub_array[] = "dw";
    $sub_array[] = $row['price'];
    $sub_array[] = '
    <input type="text" class="form-control bg-primary text-white text-center"  value="' . $row['APP'] . '"  />
    <input type="text" class="form-control bg-success text-white text-center"  />';

    $sub_array[] = '
    <input type="text" readonly class="form-control bg-primary text-white text-center"  value="ET"  />
    <input type="text" readonly class="form-control bg-success text-white text-center"  value="AT" />';
    $sub_array[] =  '
    <input type="date" class="form-control"  name="update" id="recivepo_' . $n . '"oninput="onplusTime(
        recivepo_' . $n . ',
        duraET_po_' . $n . ',
        compET_po_' . $n . ',

        compET_po_' . $n . ',
        duraET_mu_' . $n . ',
        compET_mu_' . $n . ',

        compET_mu_' . $n . ',
        duraET_pa_' . $n . ',
        compET_pa_' . $n . ',

        compET_pa_' . $n . ',
        duraET_ar_' . $n . ',
        compET_ar_' . $n . ',

        compET_ar_' . $n . ',
        duraET_qcr_' . $n . ',
        compET_qcr_' . $n . ',

        compET_qcr_' . $n . ',
        duraET_as_' . $n . ',
        compET_as_' . $n . ',

        compET_as_' . $n . ',
        duraET_qca_' . $n . ',
        compET_qca_' . $n . ',
        
        compET_qca_' . $n . ',
        duraET_ta_' . $n . ',
        compET_ta_' . $n . ')"/>';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center" value="3" id="duraET_po_' . $n . '" />
    <input readonly type="text" class="form-control bg-success text-white text-center" id="duraAT_po_' . $n . '" value="3"/>';


    $sub_array[] = '
    <input type="text" readonly class="form-control bg-secondary text-white text-center" id="compET_po_' . $n . '"  />
    <input type="text" readonly class="form-control bg-secondary text-white text-center" id="compAT_po_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center" value="0" name="update" id="duraET_mu_' . $n . '"  oninput="onplusTime2(compET_po_' . $n . ',duraET_mu_' . $n . ',compET_mu_' . $n . ')"/>
    <input type="text" class="form-control bg-success text-white text-center" value="0" name="update"id="duraAT_mu_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_mu_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_mu_' . $n . '" />';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center" value="5" name="update" id="duraET_pa_' . $n . '"  oninput="onplusTime2(compET_mu_' . $n . ',duraET_pa_' . $n . ',compET_pa_' . $n . ')"/>
    <input type="text" class="form-control bg-success text-white text-center" value="5" name="update"id="duraAT_pa_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_pa_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_pa_' . $n . '" />';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center" value="0" name="update" id="duraET_ar_' . $n . '"  oninput="onplusTime2(compET_pa_' . $n . ',duraET_ar_' . $n . ',compET_ar_' . $n . ')"/>
    <input type="text" class="form-control bg-success text-white text-center" value="0" name="update"id="duraAT_ar_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_ar_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_ar_' . $n . '" />';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center" value="2" name="update" id="duraET_qcr_' . $n . '"  oninput="onplusTime2(compET_ar_' . $n . ',duraET_qcr_' . $n . ',compET_qcr_' . $n . ')"/>
    <input type="text" class="form-control bg-success text-white text-center" value="2" name="update"id="duraAT_qcr_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_qcr_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_qcr_' . $n . '" />';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center" value="2" name="update" id="duraET_as_' . $n . '"  oninput="onplusTime2(compET_qcr_' . $n . ',duraET_as_' . $n . ',compET_as_' . $n . ')"/>
    <input type="text" class="form-control bg-success text-white text-center" value="2" name="update"id="duraAT_as_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_as_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_as_' . $n . '" />';

    $sub_array[] = '
    <input type="text" class="form-control bg-danger text-white text-center"  value="2" name="update" id="duraET_qca_' . $n . '"  oninput="onplusTime2(compET_as_' . $n . ',duraET_qca_' . $n . ',compET_qca_' . $n . ')"/>
    <input type="text" class="form-control bg-success text-white text-center"  value="2" name="update"id="duraAT_qca_' . $n . '"  />';

    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_qca_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_qca_' . $n . '" />';
    if ($row['price'] > 100000) {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center" value="3" name="update" id="duraET_ta_' . $n . '"  oninput="onplusTime2(compET_qca_' . $n . ',duraET_ta_' . $n . ',compET_ta_' . $n . ')"/>
        <input type="text" class="form-control bg-success text-white text-center"value="3" name="update"id="duraAT_ta_' . $n . '"  />';
    } else {
        $sub_array[] = '
        <input type="text" class="form-control bg-danger text-white text-center"value="7" name="update" id="duraET_ta_' . $n . '"  oninput="onplusTime2(compET_qca_' . $n . ',duraET_ta_' . $n . ',compET_ta_' . $n . ')"/>
        <input type="text" class="form-control bg-success text-white text-center"value="7" name="update"id="duraAT_ta_' . $n . '"  />';
    }

        
    $sub_array[] = '
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compET_ta_' . $n . '" />
    <input type="text" class="form-control bg-secondary text-white text-center" name="update" id="compAT_ta_' . $n . '" value="25/06/2023" />';



    $sub_array[] =  '
    <input type="text" class="form-control" id="planmargin_' . $n . '" value="-30" />';

    $sub_array[] =  '
    <input type="text" class="form-control" id="week_' . $n . '" value="-30" />';
    $data[] = $sub_array;
}

$output = array(
    "recordsFiltered" => $filtered_rows,
    "data"            => $data,
);

echo json_encode($output);

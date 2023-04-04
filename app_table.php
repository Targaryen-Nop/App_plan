<html>
<?php include "header.php"; ?>
<style>
    body {

        background-color: silver;
    }
    

    h1 {
        font-size: 20pt;
        margin: 0 0 20px;
        padding: 0;
        line-height: 100%;
    }

    .div_maintb {
        height: calc(100vh - 180px);
        width: 1300px;
        overflow: scroll;
        border: 1px solid #6f6f6f;
    }

    .div_maintb table {
        border-spacing: 0;
    }

    .div_maintb th {
        position: sticky;
        top: 0;
        background: #464646;
        color: #d1d1d1;
        padding: 6px;
        outline: 1px solid #7a7a7a;
        font-weight: normal;
    }

    .div_maintb td {
        padding: 6px;
        outline: 1px solid #c3c3c3;
    }

    .freeze_col_1,
    .freeze_col_td_1 {
        position: sticky;
        left: 0px;
        width: 50px;
        min-width: 50px;
    }

    .freeze_col_2,
    .freeze_col_td_2 {
        position: sticky;
        left: 50px;
        width: 75px;
        min-width: 75px;
    }

    .freeze_col_3,
    .freeze_col_td_3 {
        position: sticky;
        left: 125px;
        width: 50px;
        min-width: 50px;
    }

    .freeze_col_4,
    .freeze_col_td_4 {
        position: sticky;
        left: 175px;
        width: 250px;
        min-width: 250px;
    }

    .freeze_col_5,
    .freeze_col_td_5 {
        position: sticky;
        left: 425px;
        width: 75px;
        min-width: 75px;
    }

    .freeze_col_6,
    .freeze_col_td_6 {
        position: sticky;
        left: 500px;
        width: 75px;
        min-width: 75px;
    }

    .freeze_col_7,
    .freeze_col_td_7 {
        position: sticky;
        left: 575px;
        width: 75px;
        min-width: 75px;
    }

    .freeze_col_8,
    .freeze_col_td_8 {
        position: sticky;
        left: 650px;
        width: 75px;
        min-width: 75px;
    }

    .freeze_col_9,
    .freeze_col_td_9 {
        position: sticky;
        left: 725px;
        width: 50px;
        min-width: 50px;
    }

    .freeze_col_10,
    .freeze_col_td_10 {
        position: sticky;
        left: 775px;
        width: 50px;
        min-width: 50px;
    }


    .freeze_col_1,
    .freeze_col_2,
    .freeze_col_3,
    .freeze_col_4,
    .freeze_col_5,
    .freeze_col_6,
    .freeze_col_7,
    .freeze_col_8,
    .freeze_col_9,
    .freeze_col_10 {
        z-index: 300;
    }

    .freeze_col_td_1,
    .freeze_col_td_2,
    .freeze_col_td_3,
    .freeze_col_td_4,
    .freeze_col_td_5,
    .freeze_col_td_6,
    .freeze_col_td_7,
    .freeze_col_td_8,
    .freeze_col_td_9,
    .freeze_col_td_10 {
        z-index: 200;
    }
</style>
</head>

<body>
    <div class="container-fluid my-5">

        <form action="">
            <div class="div_maintb">
                <table class="text-center ">
                    <thead>
                        <tr>
                            <th class="freeze_col_1" rowspan="3">APP</th>
                            <th class="freeze_col_2" rowspan="3">IO No.</th>
                            <th class="freeze_col_3" rowspan="3">Types</th>
                            <th class="freeze_col_4" rowspan="3">Customer(s)</th>
                            <th class="freeze_col_5" rowspan="3">Due Date</th>
                            <th class="freeze_col_6" rowspan="3">Today DueDate</th>
                            <th class="freeze_col_7" rowspan="3">Process Margin</th>
                            <th class="freeze_col_8" rowspan="3">Net Margin</th>
                            <th class="freeze_col_9" rowspan="2">C/O</th>
                            <th class="freeze_col_10" rowspan="3">Time</th>
                            <th rowspan="3" style="min-width: 100px;">Recieve PO </th>
                            <th rowspan="2" colspan="2">ออกเอกสาร PO</th>
                            <th colspan="6">Shipping</th>
                            <th colspan="2" rowspan="2">QC assembly</th>
                            <th colspan="2" rowspan="2">Assembly</th>
                            <th colspan="2" rowspan="2">QC assembly</th>
                            <th colspan="2" rowspan="2">Transport</th>
                            <th rowspan="3">Plan Margin </th>
                            <th rowspan="3">Weeks</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="top: 33px;">Manufacture Date</th>
                            <th colspan="2" style="top: 33px;">Payment Date</th>
                            <th colspan="2" style="top: 33px;">Arrival Date</th>

                        </tr>
                        <tr>
                            <th class="freeze_col_9" style="top: 66px;">Day left</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                            <th style="top: 66px;">Duration</th>
                            <th style="top: 66px;">Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_appplan = "                        
                        SELECT 
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
                        LIMIT 100 ";
                        $query_appplan = mysqli_query($connection, $sql_appplan);


                        while ($row_app = mysqli_fetch_array($query_appplan)) {
                            $full_io_number = explode('-', $row_app['io_number']);
                            $date = date_create($row_app['due_date'])
                        ?>
                            <tr>
                                <td rowspan="2" class="freeze_col_td_1 bg-primary"><button class="btn btn-success" type="submit" name="submit">U</button></td>
                                <td rowspan="2" class="freeze_col_td_2 bg-primary"><?php echo $full_io_number[4] . "-" . substr($row_app['io_year'], 2, 4); ?></td>
                                <td rowspan="2" class="freeze_col_td_3 bg-primary"><?php echo substr($full_io_number[6], 0, 1); ?></td>
                                <td rowspan="2" class="freeze_col_td_4 bg-primary"><?php echo $row_app['customer_name'] ?></td>
                                <td rowspan="2" class="freeze_col_td_5 bg-primary"><?php echo date_format($date,"d/m/Y ") ?></td>
                                <td rowspan="2" class="freeze_col_td_6 bg-primary"> </td>
                                <td rowspan="2" class="freeze_col_td_7 bg-primary"></td>
                                <td rowspan="2" class="freeze_col_td_8 bg-primary"></td>
                                <td rowspan="2" class="freeze_col_td_9 bg-primary"></td>
                                <td class="freeze_col_td_10 bg-primary">ET</td>

                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2"><input type="text" class="form-control text-center"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2"><input type="text" class="form-control"></td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2">Row</td>
                                <td rowspan="2">Row</td>
                            </tr>
                            <tr>
                                <td class="freeze_col_td_10 bg-primary">AT</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>

</html>
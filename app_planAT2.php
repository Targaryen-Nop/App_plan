<?php
include "header.php";

if (isset($_POST['update_day'])) {
    $date = $_POST['date'];
    $year = $_POST['year'];
    $json_days = json_encode($date);
    // $sql = "INSERT INTO holiday (id,year,holiday_date) VALUES ('','$year','$json_days')";
    $sql = "UPDATE holiday SET holiday_date = '$json_days' WHERE year = '$year'";
    $dbquery = mysqli_query($connection, $sql);

    if ($dbquery) {
        echo "<div align='center'><font color=green size='10pt'><b>DATA UPDATE<b></font></div>";
    } else {

        echo "<div align='center'><font color=red size='10pt'><b>DATA NOT UPDATE<b></font></div>";
    }
    echo "<meta http-equiv='refresh' content='1; url='apptableplan1.php'>";
}
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $year = $_POST['year'];
    $json_days = json_encode($date);
    $sql = "INSERT INTO applicationplan 
    (
        app_id,
        app_io,
        app_type,
        app_customer,
        app_todayduedate,
        app_process_margin,
        app_net_margin,
        app_co_day,
        app_receive,
        app_dura_po,
        app_comp_po,
        app_dura_mu,
        app_comp_mu,
        app_dura_pay,
        app_comp_pay,
        app_dura_arr,
        app_comp_arr,
        app_dura_qc_re,
        app_comp_qc_re,
        app_dura_as,
        app_comp_as,
        app_dura_qc_as,
        app_comp_qc_as,
        app_dura_tra,
        app_comp_tra,
        plan_margin,
        weeks,
    ) 
    VALUES 
    (
        '',
        '$year',
        '$json_days'
    )";
    $dbquery = mysqli_query($connection, $sql);

    if ($dbquery) {
        echo "<div align='center'><font color=green size='10pt'><b>DATA UPDATE<b></font></div>";
    } else {

        echo "<div align='center'><font color=red size='10pt'><b>DATA NOT UPDATE<b></font></div>";
    }
    echo "<meta http-equiv='refresh' content='1; url='apptableplan1.php'>";
}
?>
<style>
    body {
        background-color: silver;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .left {
        text-align: left !important;
    }

    table td {
        height: 50px;
        text-align: center;
    }

    #mdp-demo {
        /* height: 600px;
        font-size: x-small !important; */
    }
</style>

<body>
    <div class="container-fluid my-2">
        <div class="row">
            <div class="col-4">
                <h1>Application Plan Not Accept</h1>
                <h4>(Count Weekend & Holidays)</h4>
                <button type="button" id="hideButton" class="btn btn-primary">
                    Hide Row
                </button>

            </div>
            <div class="col-3">
            <div class="form-floating">
                    <select class="form-select" name="io_year" id="io_year">
                        <option value="" selected></option>
                        <?php
                        $sql_year = "SELECT io_year FROM io_monitor GROUP BY io_year ORDER BY io_year DESC";
                        $query_year = mysqli_query($connection, $sql_year);

                        while ($result = mysqli_fetch_array($query_year)) {
                            $yearCheck = date("Y") - 3;
                            if ($result['io_year'] > $yearCheck) {
                        ?>
                                <option value="<?php echo $result['io_year']; ?>"><?php echo $result['io_year']; ?></option>
                        <?php }
                        } ?>
                    </select>
                    <label for="floatingSelect">Select Year IO</label>
                </div>
            </div>
            <div class="col-3">
               
            </div>
        </div>

        <div>
            <table class="" id="user_data">
                <thead>
                    <tr>
                        <th class="bg-primary" rowspan="3">APP</th>
                        <th class="bg-primary" style="min-width: 75px;" rowspan="3">IO No.</th>
                        <th class="bg-primary" rowspan="3">Types</th>
                        <th class="text-center bg-primary" style="min-width: 200px;" rowspan="3">Customer(s)</th>
                        <th class="bg-primary" style="min-width: 100px;" rowspan="3">Due Date</th>
                        <th class="bg-primary" rowspan="3">Today DueDate</th>
                        <th class="bg-primary" rowspan="3">Process Margin</th>
                        <th class="bg-primary" rowspan="3">Net Margin</th>
                        <th class="bg-primary" rowspan="3">C/O Day left</th>
                        <th class="bg-primary" rowspan="3">Time</th>
                        <th class="bg-success" rowspan="3" style="min-width: 100px;">Recieve PO </th>
                        <th class="bg-success" rowspan="2" colspan="2">ออกเอกสาร PO</th>
                        <th class="bg-success" colspan="6">Shipping</th>
                        <th class="bg-success" colspan="2" rowspan="2">QC Receive</th>
                        <th class="bg-success" colspan="2" rowspan="2">Assembly</th>
                        <th class="bg-success" colspan="2" rowspan="2">QC Assembly</th>
                        <th class="bg-success" colspan="2" rowspan="2">Transport</th>
                        <th class="bg-success" rowspan="3">Plan Margin </th>
                        <th class="bg-success" rowspan="3">Weeks</th>
                    </tr>
                    <tr>
                        <th class="bg-success" colspan="2">Manufacture Date</th>
                        <th class="bg-success" colspan="2">Payment Date</th>
                        <th class="bg-success" colspan="2">Arrival Date</th>

                    </tr>
                    <tr>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                        <th class="bg-success">Duration</th>
                        <th class="bg-success">Completed</th>
                    </tr>
                </thead>

            </table>
        </div>

        <!-- Modal -->
        <form action="apptableplan1.php" method="post">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Holidays</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating">
                                <input id="mdp-demo" name="date[]" class="form-control my-3">
                                <label for="floatingInput">Holidays</label>
                            </div>
                            <div class="form-floating">
                                <div class="form-floating">
                                    <select class="form-select" name="year">
                                        <option value="" selected></option>
                                        <?php
                                        $sql_year = "SELECT io_year FROM io_monitor GROUP BY io_year ORDER BY io_year DESC";
                                        $query_year = mysqli_query($connection, $sql_year);

                                        while ($result = mysqli_fetch_array($query_year)) {
                                            $yearCheck = date("Y") - 3;
                                            if ($result['io_year'] > $yearCheck) {
                                        ?>
                                                <option value="<?php echo $result['io_year']; ?>"><?php echo $result['io_year']; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <label for="floatingSelect">Year of Holidays</label>
                                </div>

                            </div>
                            <button type="submit" name="update_day" class="btn btn-success my-3">Update</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>


    <script type="text/javascript" language="javascript">
        let date_holidays = [];
        let date_holidays_format = [];





        $(document).on('input', '.update', function() {
            let selecet = $(this).attr("id");
            let idArray = selecet.split("_");
            let id = idArray[2];
            let inputComp = `compET_${idArray[1]}`;
            let inputDura = `duraET_${idArray[1]}`;
            let Durationvalue = $(`#duraET_${idArray[1]}_${idArray[2]}`).val();
            let Compvalue = $(`#compET_${idArray[1]}_${idArray[2]}`).val();
            let planMargin = $(`#planmargin_${idArray[2]}`).val();
            let weeks = $(`#week_${idArray[2]}`).val();

            console.log(inputComp);
            console.log(inputDura);
            console.log(Durationvalue);
            console.log(Compvalue);
            console.log(id);
            $.ajax({
                url: "app_update.php",
                method: "POST",
                data: {
                    id: id,
                    inputComp: inputComp,
                    inputDura: inputDura,
                    Durationvalue: Durationvalue,
                    Compvalue: Compvalue,
                    planMargin: planMargin,
                    weeks: weeks,
                },
                dataType: "json",
                success: function(data) {
                    data.id = id;
                    data.inputComp = inputComp;
                    data.inputDura = inputDura;
                    data.Durationvalue = Durationvalue;
                    data.Compvalue = Compvalue;
                    data.planMargin = planMargin;
                    data.weeks = weeks;
                }
            })
        })

        $(document).on('keyup', '.update', function() {
            let selecet = $(this).attr("id");
            let idArray = selecet.split("_");
            let recievePo = $(`#recivepo_${idArray[2]}`).val();
            let planMargin = $(`#planmargin_${idArray[2]}`);
            let weeks = $(`#week_${idArray[2]}`);
            let dueDatevalue = $(`#due_date_${idArray[2]}`).text();
            let compTaDateValue = $(`#compET_ta_${idArray[2]}`).val();
            let businessDays = 0;
            let daysLate = 0;
            const parts = dueDatevalue.split('/');
            const formattedDate = new Date(parts[2], parts[1] - 1, parts[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            const partsTa = compTaDateValue.split('/');
            const formattedTaDate = new Date(partsTa[2], partsTa[1] - 1, partsTa[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let startDate = new Date(formattedDate);
            let endDate = new Date(formattedTaDate);
            console.log(startDate);
            console.log(endDate);
            let result = countBusinessDay(startDate, endDate);
            if (result["businessDays"] > 0) {
                planMargin.val(result['businessDays']);
                weeks.val(Math.floor(result['businessDays'] / 5))
            } else {
                planMargin.val(`-${result['daysLate']}`);
                weeks.val(Math.floor(`-${result['daysLate']/5}`))
            }
        })
        $(document).on('change', '.update_all', function() {
            let selecet = $(this).attr("id");
            let idArray = selecet.split("_");
            let id = idArray[2];
            let recievePo = $(`#recivepo_${idArray[1]}`).val();
            let planMargin = $(`#planmargin_${idArray[1]}`);
            let weeks = $(`#week_${idArray[1]}`);
            let dueDatevalue = $(`#due_date_${idArray[1]}`).text();
            let businessDays = 0;
            let daysLate = 0;
            console.log(planMargin.val());
            const parts = dueDatevalue.split('/');
            const formattedDate = new Date(parts[2], parts[1] - 1, parts[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let startDate = new Date(formattedDate);
            let endDate = new Date(recievePo);
            let result = countBusinessDay(startDate, endDate);
            if (result["businessDays"] > 0) {
                planMargin.val(result['businessDays']);
                weeks.val(Math.floor(result['businessDays'] / 5))
            } else {
                planMargin.val(`-${result['daysLate']}`);
                weeks.val(Math.floor(`-${result['daysLate']/5}`))
            }
        })
        $(document).on('change', '.update_all', function() {
            let selecet = $(this).attr("id");
            let idArray = selecet.split("_");
            let id = idArray[1];
            let recievePo = $(`#recivepo_${idArray[1]}`).val();
            let duraPoValue = $(`#duraET_po_${idArray[1]}`).val();
            let compPoValue = $(`#compET_po_${idArray[1]}`).val();
            let duraMuValue = $(`#duraET_mu_${idArray[1]}`).val();
            let compMuValue = $(`#compET_mu_${idArray[1]}`).val();
            let duraPaValue = $(`#duraET_pa_${idArray[1]}`).val();
            let compPaValue = $(`#compET_pa_${idArray[1]}`).val();
            let duraArValue = $(`#duraET_ar_${idArray[1]}`).val();
            let compArValue = $(`#compET_ar_${idArray[1]}`).val();
            let duraQcrValue = $(`#duraET_qcr_${idArray[1]}`).val();
            let compQcrValue = $(`#compET_qcr_${idArray[1]}`).val();
            let duraAsValue = $(`#duraET_as_${idArray[1]}`).val();
            let compAsValue = $(`#compET_as_${idArray[1]}`).val();
            let duraQcaValue = $(`#duraET_qca_${idArray[1]}`).val();
            let compQcaValue = $(`#compET_qca_${idArray[1]}`).val();
            let duraTaValue = $(`#duraET_ta_${idArray[1]}`).val();
            let compTaValue = $(`#compET_ta_${idArray[1]}`).val();
            let planMargin = $(`#planmargin_${idArray[1]}`).val();
            let weeks = $(`#week_${idArray[1]}`).val();
            // console.log(duraPoValue);
            // console.log(compPoValue);
            // console.log(recievePo);
            // console.log(id);
            $.ajax({
                url: "app_update_all.php",
                method: "POST",
                data: {
                    id: id,
                    recievePo: recievePo,
                    duraPoValue: duraPoValue,
                    compPoValue: compPoValue,
                    duraMuValue: duraMuValue,
                    compMuValue: compMuValue,
                    duraPaValue: duraPaValue,
                    compPaValue: compPaValue,
                    duraArValue: duraArValue,
                    compArValue: compArValue,
                    duraQcrValue: duraQcrValue,
                    compQcrValue: compQcrValue,
                    duraAsValue: duraAsValue,
                    compAsValue: compAsValue,
                    duraQcaValue: duraQcaValue,
                    compQcaValue: compQcaValue,
                    duraTaValue: duraTaValue,
                    compTaValue: compTaValue,
                    planMargin: planMargin,
                    weeks: weeks,
                },
                dataType: "json",
                success: function(data) {
                    data.id = id,
                        data.recievePo = recievePo,
                        data.duraPoValue = duraPoValue,
                        data.compPoValue = compPoValue,
                        data.duraMuValue = duraMuValue,
                        data.compMuValue = compMuValue,
                        data.duraPaValue = duraPaValue,
                        data.compPaValue = compPaValue,
                        data.duraArValue = duraArValue,
                        data.compArValue = compArValue,
                        data.duraQcrValue = duraQcrValue,
                        data.compQcrValue = compQcrValue,
                        data.duraAsValue = duraAsValue,
                        data.compAsValue = compAsValue,
                        data.duraQcaValue = duraQcaValue,
                        data.compQcaValue = compQcaValue,
                        data.duraTaValue = duraTaValue,
                        data.compTaValue = compTaValue,
                        data.planMargin = planMargin,
                        data.weeks = weeks
                }
            })
        })

        $(document).ready(function() {

            $.ajax({
                url: "holiday_fatch.php",
                method: "POST",
                data: {
                    doc_number: "doc_number"
                },
                dataType: "json",
                success: function(data) {
                    let result = [];
                    let HolidaytDate = [];
                    let myArray = data[0].split(",");
                    console.log(myArray.length);
                    const today = new Date();
                    const y = today.getFullYear();
                    for (let i = 0; i < myArray.length; i++) {
                        result[i] = /[0-9]{2}[/][0-9]{2}[/][0-9]{4}/.exec(myArray[i]);
                        // console.log(result[i][0]);
                        date_holidays.push(`${result[i][0]}`);
                        // console.log(typeof date_holidays);
                        $('#mdp-demo').multiDatesPicker({
                            addDates: [date_holidays[i]],
                            numberOfMonths: [1, 4],
                            defaultDate: date_holidays[0],
                        });
                        HolidaytDate.push(new Date(result[i][0]).toLocaleDateString('en-US'));
                        date_holidays_format = HolidaytDate;
                        // const dateISO = new Date(date_holidays[i]);
                        // console.log(date_holidays_format);
                        // console.log(HolidaytDate)
                    }
                    // date_holidays_format.push(HolidaytDate);
                }
            })

            // 
            // SELECT YEAR
            // $(document).on('change', '#io_year', function() {
            //     let DataTable = $('#user_data').DataTable({
            //         scrollY: "530px",
            //         scrollX: true,
            //         scrollCollapse: true,
            //         paging: false,
            //         fixedColumns: {
            //             leftColumns: 10,

            //         },
            //         ajax: {
            //             url: "app_single_fatch.php",
            //             type: "POST",
            //             data: function(data) {
            //                 let io_year = $('#io_year').val();
            //                 data.io_year = io_year;
            //             }
            //         },
            //         "columnDefs": [{
            //                 "targets": [-1, 0, 1, 2, 3],
            //                 "orderable": false,
            //             },

            //         ],

            //     });
            // })



            // All Year
            let dataTable = $('#user_data').DataTable({
                "scrollY": "530px",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "fixedColumns": {
                    leftColumns: 10,

                },
                "ajax": {
                    url: "app_n_fatch2.php",
                    type: "POST",
                    data: function(data) {
                        //   Read values
                        let io_year = $('#io_year').val();

                        //   Append to data
                        data.io_year = io_year;
                        data.date_holidays_format = date_holidays_format;

                    }
                },
                "columnDefs": [{
                        "targets": [-1, 0, 1, 2, 3],
                        "orderable": false,
                    },

                ],

            });

            $('#io_year').change(function() {
                let io_year = $('#io_year').val();
                dataTable.draw(io_year);
                dataTable.ajax.reload();
            });
            $('#user_data tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected');
                // let d = dataTable.row(this);
                // d.remove().draw();

                $('#hideButton').click(function() {
                    // Get the selected row(s)
                    var selectedRow = dataTable.row('.selected');

                    // Remove the selected row(s)
                    selectedRow.remove().draw();
                });
            })
        });





        function onplusTime(
            datetime,
            duration,
            comp,

            datetime2 = "",
            duration2 = "",
            comp2 = "",

            datetime3 = "",
            duration3 = "",
            comp3 = "",

            datetime4 = "",
            duration4 = "",
            comp4 = "",

            datetime5 = "",
            duration5 = "",
            comp5 = "",

            datetime6 = "",
            duration6 = "",
            comp6 = "",

            datetime7 = "",
            duration7 = "",
            comp7 = "",

            datetime8 = "",
            duration8 = "",
            comp8 = "") {
            // let APP = id.value;
            let durationDay = parseInt(duration.value);
            let Recivedate = datetime.value;
            let date = new Date(Recivedate);
            console.log(date, durationDay);

            if (durationDay) {
                // let newDay = new Date(date.setDate(date.getDate() + durationDay));
                // console.log(newDay.toLocaleDateString('en-GB'));
                // comp.value = newDay.toLocaleDateString('en-GB');
                comp.value = addBusinessDays(date, durationDay);

            } else if (durationDay == 0) {
                comp.value = date.toLocaleDateString('en-GB')
            }

            let durationDay2 = parseInt(duration2.value);
            const parts2 = datetime2.value.split('/');
            const formattedDate2 = new Date(parts2[2], parts2[1] - 1, parts2[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date2 = new Date(formattedDate2);
            if (durationDay2) {
                // let newDay2 = new Date(date2.setDate(date2.getDate() + durationDay2));
                // comp2.value = newDay2.toLocaleDateString('en-GB');
                comp2.value = addBusinessDays(date2, durationDay2);
            } else if (durationDay2 == 0) {
                comp2.value = datetime2.value;
            }

            let durationDay3 = parseInt(duration3.value);
            const parts3 = datetime3.value.split('/');
            const formattedDate3 = new Date(parts3[2], parts3[1] - 1, parts3[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date3 = new Date(formattedDate3);
            if (durationDay3) {
                // let newDay3 = new Date(date3.setDate(date3.getDate() + durationDay3));
                // comp3.value = newDay3.toLocaleDateString('en-GB');
                comp3.value = addBusinessDays(date3, durationDay3);
            } else if (durationDay3 == 0) {
                comp3.value = datetime3.value;
            }

            let durationDay4 = parseInt(duration4.value);
            const parts4 = datetime4.value.split('/');
            const formattedDate4 = new Date(parts4[2], parts4[1] - 1, parts4[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date4 = new Date(formattedDate4);
            if (durationDay4) {
                // let newDay4 = new Date(date4.setDate(date4.getDate() + durationDay4));
                // comp4.value = newDay4.toLocaleDateString('en-GB');
                comp4.value = addBusinessDays(date4, durationDay4);
            } else if (durationDay4 == 0) {
                comp4.value = datetime4.value;
            }

            let durationDay5 = parseInt(duration5.value);
            const parts5 = datetime5.value.split('/');
            const formattedDate5 = new Date(parts5[2], parts5[1] - 1, parts5[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date5 = new Date(formattedDate5);
            if (durationDay5) {
                // let newDay5 = new Date(date5.setDate(date5.getDate() + durationDay5));
                // comp5.value = newDay5.toLocaleDateString('en-GB');
                comp5.value = addBusinessDays(date5, durationDay5);
            } else if (durationDay5 == 0) {
                comp5.value = datetime5.value;
            }

            let durationDay6 = parseInt(duration6.value);
            const parts6 = datetime6.value.split('/');
            const formattedDate6 = new Date(parts6[2], parts6[1] - 1, parts6[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date6 = new Date(formattedDate6);
            if (durationDay6) {
                // let newDay6 = new Date(date6.setDate(date6.getDate() + durationDay6));
                // comp6.value = newDay6.toLocaleDateString('en-GB');
                comp6.value = addBusinessDays(date6, durationDay6);
            } else if (durationDay6 == 0) {
                comp6.value = datetime6.value;
            }

            let durationDay7 = parseInt(duration7.value);
            const parts7 = datetime7.value.split('/');
            const formattedDate7 = new Date(parts7[2], parts7[1] - 1, parts7[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date7 = new Date(formattedDate7);
            if (durationDay7) {
                // let newDay7 = new Date(date7.setDate(date7.getDate() + durationDay7));
                // comp7.value = newDay7.toLocaleDateString('en-GB');
                comp7.value = addBusinessDays(date7, durationDay7);
            } else if (durationDay7 == 0) {
                comp7.value = datetime7.value;
            }

            let durationDay8 = parseInt(duration8.value);
            const parts8 = datetime8.value.split('/');
            const formattedDate8 = new Date(parts8[2], parts8[1] - 1, parts8[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date8 = new Date(formattedDate8);
            if (durationDay8) {
                // let newDay8 = new Date(date8.setDate(date8.getDate() + durationDay8));
                // comp8.value = newDay8.toLocaleDateString('en-GB');
                comp8.value = addBusinessDays(date8, durationDay8);
            } else if (durationDay8 == 0) {
                comp8.value = datetime8.value;
            }
            if (comp8.value != '') {

                console.log('wer');
            }
        }

        function onplusTime2(
            datetime = "",
            duration = "",
            comp = "",

            datetime2 = "",
            duration2 = "",
            comp2 = "",

            datetime3 = "",
            duration3 = "",
            comp3 = "",

            datetime4 = "",
            duration4 = "",
            comp4 = "",

            datetime5 = "",
            duration5 = "",
            comp5 = "",

            datetime6 = "",
            duration6 = "",
            comp6 = "",

            datetime7 = "",
            duration7 = "",
            comp7 = "") {
            // let APP = id.value;

            let durationDay = parseInt(duration.value);
            const parts = datetime.value.split('/');
            const formattedDate = new Date(parts[2], parts[1] - 1, parts[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date = new Date(formattedDate);
            if (durationDay) {
                // let newDay = new Date(date.setDate(date.getDate() + durationDay));
                // console.log(newDay.toLocaleDateString('en-GB'));
                // comp.value = newDay.toLocaleDateString('en-GB');
                comp.value = addBusinessDays(date, durationDay);
            } else if (durationDay == 0) {
                comp.value = datetime.value;
            }
            if (datetime2 != "") {
                let durationDay2 = parseInt(duration2.value);
                const parts2 = datetime2.value.split('/');
                const formattedDate2 = new Date(parts2[2], parts2[1] - 1, parts2[0]).toLocaleDateString('en-CA', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                }).replace(/\//g, '-');
                let date2 = new Date(formattedDate2);
                if (durationDay2) {
                    // let newDay2 = new Date(date2.setDate(date2.getDate() + durationDay2));
                    // comp2.value = newDay2.toLocaleDateString('en-GB');
                    comp2.value = addBusinessDays(date2, durationDay2);
                } else if (durationDay2 == 0) {
                    comp2.value = datetime2.value;
                }
                if (datetime3 != "") {
                    let durationDay3 = parseInt(duration3.value);
                    const parts3 = datetime3.value.split('/');
                    const formattedDate3 = new Date(parts3[2], parts3[1] - 1, parts3[0]).toLocaleDateString('en-CA', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit'
                    }).replace(/\//g, '-');
                    let date3 = new Date(formattedDate3);
                    if (durationDay3) {
                        // let newDay3 = new Date(date3.setDate(date3.getDate() + durationDay3));
                        // comp3.value = newDay3.toLocaleDateString('en-GB');
                        comp3.value = addBusinessDays(date3, durationDay3);
                    } else if (durationDay3 == 0) {
                        comp3.value = datetime3.value;
                    }
                    if (datetime4 != "") {
                        let durationDay4 = parseInt(duration4.value);
                        const parts4 = datetime4.value.split('/');
                        const formattedDate4 = new Date(parts4[2], parts4[1] - 1, parts4[0]).toLocaleDateString('en-CA', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit'
                        }).replace(/\//g, '-');
                        let date4 = new Date(formattedDate4);
                        if (durationDay4) {
                            // let newDay4 = new Date(date4.setDate(date4.getDate() + durationDay4));
                            // comp4.value = newDay4.toLocaleDateString('en-GB');
                            comp4.value = addBusinessDays(date4, durationDay4);
                        } else if (durationDay4 == 0) {
                            comp4.value = datetime4.value;
                        }
                        if (datetime5 != "") {
                            let durationDay5 = parseInt(duration5.value);
                            const parts5 = datetime5.value.split('/');
                            const formattedDate5 = new Date(parts5[2], parts5[1] - 1, parts5[0]).toLocaleDateString('en-CA', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit'
                            }).replace(/\//g, '-');
                            let date5 = new Date(formattedDate5);
                            if (durationDay5) {
                                // let newDay5 = new Date(date5.setDate(date5.getDate() + durationDay5));
                                // comp5.value = newDay5.toLocaleDateString('en-GB');
                                comp5.value = addBusinessDays(date5, durationDay5);
                            } else if (durationDay5 == 0) {
                                comp5.value = datetime5.value;
                            }

                            if (datetime6 != "") {
                                let durationDay6 = parseInt(duration6.value);
                                const parts6 = datetime6.value.split('/');
                                const formattedDate6 = new Date(parts6[2], parts6[1] - 1, parts6[0]).toLocaleDateString('en-CA', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                }).replace(/\//g, '-');
                                let date6 = new Date(formattedDate6);
                                if (durationDay6) {
                                    // let newDay6 = new Date(date6.setDate(date6.getDate() + durationDay6));
                                    // comp6.value = newDay6.toLocaleDateString('en-GB');
                                    comp6.value = addBusinessDays(date6, durationDay6);
                                } else if (durationDay6 == 0) {
                                    comp6.value = datetime6.value;
                                }
                                if (datetime7 != "") {
                                    let durationDay7 = parseInt(duration7.value);
                                    const parts7 = datetime7.value.split('/');
                                    const formattedDate7 = new Date(parts7[2], parts7[1] - 1, parts7[0]).toLocaleDateString('en-CA', {
                                        year: 'numeric',
                                        month: '2-digit',
                                        day: '2-digit'
                                    }).replace(/\//g, '-');
                                    let date7 = new Date(formattedDate7);
                                    if (durationDay7) {
                                        // let newDay7 = new Date(date7.setDate(date7.getDate() + durationDay7));
                                        // comp7.value = newDay7.toLocaleDateString('en-GB');
                                        comp7.value = addBusinessDays(date7, durationDay7);
                                    } else if (durationDay7 == 0) {
                                        comp7.value = datetime7.value;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        function addBusinessDays(startDate, daysToAdd) {

            // convert startDate to a date object
            startDate = new Date(startDate);

            // iterate through each day to add
            for (let i = 0; i < daysToAdd; i++) {
                // advance startDate by 1 day
                startDate.setDate(startDate.getDate() + 1);
            }

            // return the result as a formatted date string
            return formatDate(startDate);
        }

        function formatDate(date) {
            // format the date as "MM/DD/YYYY"
            let month = date.getMonth() + 1;
            let day = date.getDate();
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function countBusinessDay(startDate, endDate) {
            let businessDays = 0;
            let daysLate = 0;
            while (startDate < endDate) {
                businessDays++;
                startDate.setDate(startDate.getDate() + 1);
            }

            if (startDate > endDate) { // if end date is in the past
                while (startDate >= endDate) {
                    daysLate++;
                    startDate.setDate(startDate.getDate() - 1);
                }
            }
            return {
                "businessDays": businessDays,
                "daysLate": daysLate
            };
        }
    </script>

    </html>
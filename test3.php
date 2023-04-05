<?php include "header.php"; ?>
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
</style>

<body>
    <div class="container-fluid my-2">
        <div class="row">
            <div class="col-3">
                <select class="form-select" name="io_year" id="io_year">
                    <option value="" selected></option>
                    <?php
                    $sql_year = "SELECT io_year FROM io_monitor GROUP BY io_year";
                    $query_year = mysqli_query($connection, $sql_year);
                    while ($result = mysqli_fetch_array($query_year)) { ?>
                        <option value="<?php echo $result['io_year']; ?>"><?php echo $result['io_year']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <form action="">
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
                            <th class="bg-success" colspan="2" rowspan="2">QC assembly</th>
                            <th class="bg-success" colspan="2" rowspan="2">Assembly</th>
                            <th class="bg-success" colspan="2" rowspan="2">QC assembly</th>
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
        </form>
    </div>


    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
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
            //             url: "app_fatch.php",
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
            let DataTable = $('#user_data').DataTable({
                scrollY: "530px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedColumns: {
                    leftColumns: 10,

                },
                ajax: {
                    url: "app_fatch.php",
                    type: "POST",
                    data: function(data) {
                        let io_year = $('#io_year').val();
                        data.io_year = io_year;
                    }
                },
                "columnDefs": [{
                        "targets": [-1, 0, 1, 2, 3],
                        "orderable": false,
                    },

                ],

            });


        });

        function onplusTime(
            datetime, 
            duration, 
            comp,

            datetime2, 
            duration2, 
            comp2,

            datetime3, 
            duration3, 
            comp3,

            datetime4, 
            duration4, 
            comp4,

            datetime5, 
            duration5, 
            comp5,

            datetime6, 
            duration6, 
            comp6,

            datetime7,
            duration7, 
            comp7,

            datetime8,
            duration8, 
            comp8) {
            // let APP = id.value;
            let durationDay = parseInt(duration.value);
            let Recivedate = datetime.value;
            let date = new Date(Recivedate);
            console.log(date, durationDay);
            if (durationDay) {
                let newDay = new Date(date.setDate(date.getDate() + durationDay));
                console.log(newDay.toLocaleDateString('en-GB'));
                comp.value = newDay.toLocaleDateString('en-GB');

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
                let newDay2 = new Date(date2.setDate(date2.getDate() + durationDay2));
                comp2.value = newDay2.toLocaleDateString('en-GB');
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
                let newDay3 = new Date(date3.setDate(date3.getDate() + durationDay3));
                comp3.value = newDay3.toLocaleDateString('en-GB');
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
                let newDay4 = new Date(date4.setDate(date4.getDate() + durationDay4));
                comp4.value = newDay4.toLocaleDateString('en-GB');
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
                let newDay5 = new Date(date5.setDate(date5.getDate() + durationDay5));
                comp5.value = newDay5.toLocaleDateString('en-GB');
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
                let newDay6 = new Date(date6.setDate(date6.getDate() + durationDay6));
                comp6.value = newDay6.toLocaleDateString('en-GB');
            } else if (durationDay6 == 0) {
                comp6.value = datetime6.value;
            }

            let durationDay7 = parseInt(duration7.value);
            const parts7 = datetime7.value.split('/');
            const formattedDate7= new Date(parts7[2], parts7[1] - 1, parts7[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date7 = new Date(formattedDate7);
            if (durationDay7) {
                let newDay7 = new Date(date7.setDate(date7.getDate() + durationDay7));
                comp7.value = newDay7.toLocaleDateString('en-GB');
            } else if (durationDay7 == 0) {
                comp7.value = datetime7.value;
            }

            let durationDay8 = parseInt(duration8.value);
            const parts8 = datetime8.value.split('/');
            const formattedDate8= new Date(parts8[2], parts8[1] - 1, parts8[0]).toLocaleDateString('en-CA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).replace(/\//g, '-');
            let date8 = new Date(formattedDate8);
            if (durationDay8) {
                let newDay8 = new Date(date8.setDate(date8.getDate() + durationDay8));
                comp8.value = newDay8.toLocaleDateString('en-GB');
            } else if (durationDay8 == 0) {
                comp8.value = datetime8.value;
            }
        }

        function onplusTime2(datetime, duration, comp) {
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
                let newDay = new Date(date.setDate(date.getDate() + durationDay));
                console.log(newDay.toLocaleDateString('en-GB'));
                comp.value = newDay.toLocaleDateString('en-GB');
            } else if (durationDay == 0) {
                comp.value = datetime.value;
            }
        }
    </script>

    </html>
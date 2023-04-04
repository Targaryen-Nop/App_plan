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
        border: salmon solid;
        text-align: center;
    }

    .bg-primary {
        background-color: rgba(0, 553, 255, 0.5);
        border-color: rgba(0, 123, 255, 0.5);
        color: #333;
    }
</style>

<body>
    <div class="container-fluid my-2">
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
            var DataTable = $('#user_data').DataTable({
                scrollY: "530px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedColumns: {
                    leftColumns: 10,

                },
                "ajax": {
                    url: "app_fatch.php",
                    type: "POST",
                    data: function(data) {


                    }
                },
                "columnDefs": [{
                        "targets": [-1, 0, 1, 2, 3],
                        "orderable": false,
                    },

                ],

            });


        });

        function onplusTime(datetime, duration, comp) {
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
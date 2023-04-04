<?php include "header.php"; ?>

<body>
    <div class="container mt-2">
        <h2>Application Plan Insert</h2>
        <form action="">
            <div class="row">
                <div class="mb-3 col-2">
                    <label class="form-label">IO No.</label>
                    <input type="email" class="form-control" id="IO_no">
                </div>
                <div class="mb-3 col-1">
                    <label class="form-label">Types</label>
                    <input type="email" class="form-control bg-dark text-light" id="type_io" readonly>
                </div>
                <div class="mb-3 col-5">
                    <label class="form-label">Customer(s)</label>
                    <input type="email" class="form-control bg-dark text-light" id="customer_name" readonly>
                </div>
                <div class="mb-3 col-2">
                    <label class="form-label">Due Date</label>
                    <input type="email" class="form-control bg-dark text-light" id="due_date" readonly>
                </div>
                <div class="mb-3 col-2">
                    <label class="form-label">Today-Due Date</label>
                    <input type="email" class="form-control bg-dark text-light" id="today_due" readonly>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-3">
                    <label class="form-label">Process Margin</label>
                    <input type="email" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label class="form-label">Net Margin</label>
                    <input type="email" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>C/O</th>
                                <th>Day left</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>AP</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="row">
                    <div class="col-1">
                        <div class="mb-3">
                            <label  class="form-label">C/O</label>
                            <input type="email" class="form-control"  >
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="mb-3">
                            <label  class="form-label">Day left</label>
                            <input type="email" class="form-control"  >
                        </div>
                    </div>
                </div> -->
                <div class="mb-3 col-3">
                    <label class="form-label">Time</label>
                    <input type="email" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label class="form-label">Recieve PO </label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ออกเอกสาร PO/เบิก Stock</label>
                            <input type="email" class="form-control">
                            <label class="form-label">Completed</label>
                            <input type="email" class="form-control bg-dark text-light" readonly>
                        </div>
                    </div>
                    <div class="col-8 mt-3">
                        <div class="header_blue text-center">
                            <h2>Shipping</h2>
                        </div>
                        <div class="row mt-4">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Manufacture Date</label>
                                    <input type="email" class="form-control">
                                    <label class="form-label">Completed</label>
                                    <input type="email" class="form-control bg-dark text-light" value="adwd" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Payment Date</label>
                                    <input type="email" class="form-control">
                                    <label class="form-label">Completed</label>
                                    <input type="email" class="form-control bg-dark text-light" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label">Arrival Date</label>
                                    <input type="email" class="form-control">
                                    <label class="form-label">Completed</label>
                                    <input type="email" class="form-control bg-dark text-light" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="header_blue text-center mb-2">
                        <h2>QC Receive</h2>
                    </div>
                    <input type="email" class="form-control">
                    <label class="form-label">Completed</label>
                    <input type="email" class="form-control bg-dark text-light" readonly>
                </div>
                <div class="col-3">
                    <div class="header_blue text-center mb-2">
                        <h2>Assembly</h2>
                    </div>
                    <input type="email" class="form-control">
                    <label class="form-label">Completed</label>
                    <input type="email" class="form-control bg-dark text-light" readonly>
                </div>
                <div class="col-3">
                    <div class="header_blue text-center mb-2">
                        <h2>QC assembly</h2>
                    </div>
                    <input type="email" class="form-control">
                    <label class="form-label">Completed</label>
                    <input type="email" class="form-control bg-dark text-light" readonly>
                </div>
                <div class="col-3">
                    <div class="header_blue text-center mb-2">
                        <h2>Transport</h2>
                    </div>
                    <input type="email" class="form-control">
                    <label class="form-label">Completed</label>
                    <input readonly type="email" class="form-control bg-dark text-light" readonly>
                </div>
            </div>
            <div class="row mb-5 mt-2">
                <div class="col-4">
                    <div class="header_blue text-center">
                        <h2>Plan Margin (Days)</h2>
                    </div>
                    <label class="form-label">Remark</label>
                    <textarea class="form-control" id="floatingTextarea"></textarea>
                </div>
                <div class="col-4">
                    <div class="header_blue text-center">
                        <h2>Weeks in PO</h2>
                    </div>
                    <label class="form-label">Remark 2</label>
                    <textarea class="form-control" id="floatingTextarea"></textarea>
                </div>
                <div class="col-4">
                    <div class="header_red text-center">
                        <h2>Now Process on :</h2>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

<style>
    body {
        background-color: silver;
    }

    .header_blue {
        background-color: #0c2d5c;
        width: 100%;
        height: 50px;
        padding: 5px;
        color: white;
        border-radius: 5px;
    }

    .header_red {
        background-color: #cb3d26;
        width: 100%;
        height: 50px;
        padding: 5px;
        color: white;
        border-radius: 5px;
    }

    input:read-only {
        background-color: yellow;
    }
</style>
<script>
    $(document).ready(function() {
        $(document).on('input', '#IO_no', function() {
            let io_number = $('#IO_no').val();
            const IOArray = io_number.split("-");
            $.ajax({
                url: "app_single_fatch.php",
                method: "POST",
                data: {
                    io_number: IOArray[0],
                    io_year:IOArray[1]
                },
                dataType: "json",
                success: function(data) {
                    let data_io_number = data[0].io_number;
                    let Io_number_ar = data_io_number.split("-"); 
                    let DueDate = new Date(data[0].due_date);
                    console.log(data);
                    document.getElementById("type_io").value  =  Io_number_ar[6].charAt(0)
                    document.getElementById("customer_name").value  =  data[0].customer_name;
                    document.getElementById("due_date").value  =  `${DueDate.getDay()}/${DueDate.getMonth()}/${DueDate.getFullYear()}`;
                }
            })
        })
    })
</script>

</html>
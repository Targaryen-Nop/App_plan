<?php

session_start();
date_default_timezone_set("Asia/Bangkok");


// if (@$_SESSION['login_id'] == "") {
//     echo "<meta http-equiv='refresh' content='0; url=login.php'>";
//     exit;
// }


include "connectdb.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plant Equipment</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bungee">

    <!-- Use for 3D Button -->
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,bold" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:regular,bold" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:bold+Lobster" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">

    <!-- Use for Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src='chart-plugin/chartjs-plugin-datalabels.min.js' type='text/javascript'></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> -->

    <!-- Use for Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> -->

    <!-- Use for Datatable -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script> -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.24/api/order.neutral().js"></script>
    <script src="https:////cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" /> -->

    <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.bootstrap4.min.css" />

    <!-- <script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css" /> -->

    <!-- Use for Bootstrap Multi Select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />

    <!-- Use for Datatable Mark or Highlight -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css" />

    <!-- Use for Date -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />

    <!-- Use for Time -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.16/jquery.timepicker.min.js" integrity="sha512-huX0hcUeIkgR0QvTlhxNpIAcwiN2sABe3VwyzeZAYjMPn3OU71t9ZLlk6qs27Q049SPgeB/Az12jv/ayedXoAw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.16/jquery.timepicker.min.css" integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" />

    <!-- Use for Booststrap Select or Selectpicker -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

    <!-- Use for Chosen 1.8 -->
    <link href='chosen/chosen.min.css' rel='stylesheet' type='text/css'>
    <script src='chosen/chosen.jquery.min.js' type='text/javascript'></script>

    <!-- Use for Font Awesome -->
    <script src="https://kit.fontawesome.com/95e0a11daf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Use for Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Use for Mark JS -->
    <script scr="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.js"></script>


    <!-- Timeline -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/2643/timesheet.js" crossorigin="anonymous"></script>


    <!-- MultiDatesPicker for jQuery UI -->
    <link href="https://cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.css" rel="stylesheet" />
    <link href="https://code.jquery.com/ui/1.12.1/themes/pepper-grinder/jquery-ui.css" rel="stylesheet" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.js"></script>
    <!-- #################################################################################3######## -->

</head>


<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .navbar {
        background-color: #0c2d5c;
        width: 100%;
        height: 70px;
    }

    @media only screen and (max-width: 900px) {
        .navbar {
            background-color: #0c2d5c;
            width: 100%;
            height: 90px;
        }

        .nav-link {
            background-color: #0c2d5c;
        }

        #kmonitoring {
            display: none;
        }
    }

    .img-logo {
        width: 60px;
        height: 45px;
        background-color: white;
    }

    .moniotring h1 a {
        color: white;
    }

    .image {
        width: 45px;
        height: 45px;
        float: left;
        overflow: hidden;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;


    }

    .image {
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        border-radius: 100%;


    }

    .info-number .badge {
        font-size: 9px;
        font-weight: normal;
        line-height: 13px;
        padding: 2px 6px;
        position: relative;
        right: 4px;
        top: -8px;
    }

    .bg-greenn {
        background: #1abb9c !important;
        border: 1px solid #1abb9c !important;
        color: #fff;
    }

    .blink {
        animation: blinker 2s infinite;
    }

    @keyframes blinker {
        from {
            opacity: 1.0;
        }

        50% {
            opacity: 0;
        }

        to {
            opacity: 1.0;
        }
    }

    .card-profile {
        width: 60px;
        height: 60px;
        margin: 10px;
        border: 2px solid white;
        border-radius: 50%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        border: 2px solid #ccc;
    }
</style>

<!-- <nav class="navbar sticky-top navbar-expand-lg navbar-dark">

    <a class="navbar-brand py-0" href="<?php if ($_SESSION['auth'] == "Customer") { ?> doc_dashboard_cus.php <?php } else { ?> index.php <?php } ?>"><img src="./images/login.png" class="img-logo"></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="ul navbar-nav mr-auto">
            <span class="nav-item active" style="font-size:45px;">
                <a class="nav-link py=0" id="kmonitoring" href="<?php if ($_SESSION['auth'] == "Customer") { ?> doc_dashboard_cus.php <?php } else { ?> index.php <?php } ?>">K-Monitoring:Analysis<span class="sr-only">(current)</span></a>
            </span>
        </ul>

        <ul class="nav navbar-nav navbar-right ">
            <div class="d-flex align-items-center">
                <li class="nav-item active">
                    <img onclick="location.href='profile_cus.php'" class="card-profile" src="<?php if ($row_user['user_image'] != "") { ?>./upload/user_images/<?php echo $_SESSION['user_name'] . $row_user['user_image']; ?><?php } else { ?> <?php } ?>">
                </li>
                <li class="nav-item active">
                    <a class="nav-link py=0" href="<?php if ($_SESSION['auth'] == "Customer") { ?> doc_dashboard_cus.php <?php } else { ?> index.php <?php } ?>"><?php echo $_SESSION['user_surname'] . ' ' . $_SESSION['user_lastname']; ?><span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link py=0" href="<?php if ($_SESSION['auth'] == "Customer") { ?> doc_dashboard_cus.php <?php } else { ?> index.php <?php } ?>"><?php echo strtoupper($_SESSION['user_customer']); ?><span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link py=0" id="login" href="<?php if ($_SESSION['auth'] == "Customer") { ?> doc_dashboard_cus.php <?php } else { ?> index.php <?php } ?>"><span class="sr-only"></span></a>
                </li>
                <li class="nav-item active" id="message_alert">
                    <a href="zendesk.php?page=new" class="nav-link py=0 info-number">
                        <i class="far fa-comment"></i>
                        <span class="badge bg-greenn"></span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link py=0" href="logout.php">Log out<span class="sr-only">(current)</span></a>
                </li>
            </div>
        </ul>
    </div>
</nav> -->


<script>
    function ajaxCall() {

        $.ajax({
            url: 'refresh.php',
            method: 'POST',
            data: {

            },
            dataType: 'json',
            success: function(data) {

                $('#login').text(data.login_return);

            }
        });

    }

    $(document).ready(function() {

        ajaxCall();

    });

    setInterval(function() {

        ajaxCall();

    }, 60000);
</script>

</html>

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

// $sql_day = "SELECT holiday_date,year FROM holiday WHERE year = '2023'";
// $result = $connection->query($sql_day);

// if ($result->num_rows > 0) {
//     // Fetch the result as an associative array
//     while ($row = $result->fetch_assoc()) {

//         // Decode the JSON string to a PHP array
//         $days = json_decode($row["holiday_date"]);

//         // print_r ($days);
//         // Loop through the array and display the days
//         foreach ($days as $day) {
//             // foreach ($day as $d) {
//             //     echo $d . "<br>";
//             // }
//             // echo $day . "<br>";
//             $holidaystests =  explode(",", $day);
//             print_r(explode(",", $day)) . "<br>";
//             echo "<br>";
//             // $arry = array($day);
//             // print_r ($arry);
//         }
//     }
// } else {
//     echo "No results found";
// }
// $holidays = array();
// foreach ($holidaystests as $holidaystest) {
//     $date = date_create($holidaystest);
//     $date_format = date_format($date, "Y-m-d");
//     echo $date_format . "<br>";
//     array_push($holidays, $date_format);
// }

// // Close the MySQL connection
// print_r($holidays);
?>




    <!-- <form action="test.php" method="post">
        <input id="mdp-demo" name="date[]" class="form-control">
        <p id="par"></p>
     
        <input type="text" class="form-control" name="year" placeholder="2022" />
        <button type="submit" name="submit" onclick="Geeks()">Submit </button>
    </form> -->


<!-- <script type="text/javascript">
    let date_holidays = [];
    let date_holidays_format = [];
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
                        numberOfMonths: [3, 4],
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
    })
</script> -->


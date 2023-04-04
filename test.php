<html>
<?php include "header.php";
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $json_days = json_encode($date);
    $sql = "INSERT INTO holiday (id,year,holiday_date) VALUES ('','2022','$json_days')";
    $dbquery = mysqli_query($connection, $sql);

    if ($dbquery) {

        echo "<div align='center'><font color=green size='10pt'><b>DATA INSERTED<b></font></div>";
    } else {

        echo "<div align='center'><font color=red size='10pt'><b>DATA NOT INSERTED<b></font></div>";
    }
}

$sql_day = "SELECT holiday_date FROM holiday";
$result = $connection->query($sql_day);

if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    while ($row = $result->fetch_assoc()) {

        // Decode the JSON string to a PHP array
        $days = json_decode($row["holiday_date"]);

        // Loop through the array and display the days
        foreach ($days as $day) {
            echo $day . "<br>";
        }
    }
} else {
    echo "No results found";
}

// Close the MySQL connection

?>

<style>
    body {
        font-size: x-small !important;
        height: 600px;
    }
</style>

<body>
    <form action="test.php" method="post">
        <input id="mdp-demo" name="date[]">
        <button type="submit" name="submit" onclick="Geeks()">Submit </button>

        <p id="par"></p>
    </form>


</body>
<script>
    var today = new Date();
    var y = today.getFullYear();
    $('#mdp-demo').multiDatesPicker({
        addDates: ['10/14/' + y, '02/19/' + y, '01/14/' + y, '11/16/' + y],
        numberOfMonths: [3, 4],
        defaultDate: '1/1/' + y
    });
</script>

<script type="text/javascript">
    var k = "The respective values are :";

    function Geeks() {
        var input = document.getElementsByName('date[]');

        for (var i = 0; i < input.length; i++) {
            var a = input[i];
            k = k + "<br> array[" + i + "].value= " +
                a.value + " ";
        }

        document.getElementById("par").innerHTML = k;

    }
</script>

</html>
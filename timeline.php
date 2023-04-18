<html>

<body>
    <?php

    function countBusinessDays2($endDate, $holidays = array())
    {
        $startDate = date('Y-m-d');
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

    $holidays = array("2023-01-01", "2023-05-01", "2023-12-25"); // holidays in YYYY-MM-DD format
    $endDate = '2023-03-31'; // end date in YYYY-MM-DD format
    $result = countBusinessDays2($endDate, ($holidays)); // count number of business days between current date and end date, excluding weekends and holidays

    if ($result["businessDays"] >= 0) {
        echo "Number of business days remaining: " . $result["businessDays"];
    } else {
        echo "Number of business days late: -" . $result["daysLate"];
    }


    function getStartDate($numDays, $holidays = array())
    {
        $startDate = date('Y-m-d');
        $count = 0;

        while ($count < $numDays) {
            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
            $weekday = date('N', strtotime($startDate));

            if ($weekday < 6 && !in_array($startDate, $holidays)) { // Monday to Friday, not a holiday
                $count++;
            }
        }

        return $startDate;
    }

    $holidays = array("2023-04-01", "2023-05-01", "2023-12-25"); // holidays in YYYY-MM-DD format
    $startDate = getStartDate(10, $holidays); // get start date 10 business days ago, excluding weekends and holidays
    echo "<br>" . $startDate; // output: "2023-03-20"


    function onplusTime($datetime, $duration, $comp)
    {
        $durationDay = intval($duration);
        $Recivedate = $datetime;
        $date = new DateTime($Recivedate);
        if ($durationDay) {
            $newDay = $date->modify("+{$durationDay} day");
            $comp = $newDay->format('d/m/Y');
        } else if ($durationDay == 0) {
            $comp = $date->format('d/m/Y');
        }
        return $comp;
    }
    echo "<br>" . onplusTime("2023-04-04", 3, "dw") . "<br>";

    function countBusinessDays($endDate, $holidays = array())
    {
        $startDate = date('Y-m-d');
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

        return array("businessDays" => $businessDays, "daysLate" => $daysLate);
    }

    $holidays = array("2023-04-01", "2023-05-01", "2023-12-25"); // holidays in YYYY-MM-DD format
    $endDate = '2023-03-31'; // end date in YYYY-MM-DD format
    $result = countBusinessDays($endDate, $holidays); // count number of business days between current date and end date, excluding weekends and holidays

    if ($result["businessDays"] >= 0) {
        echo "Number of business days remaining: " . $result["businessDays"];
    } else {
        echo "Number of business days latea: " . $result["daysLate"];
    }



    function countBusinessDays3($endDate, $holidays = array())
    {
        $startDate = date('Y-m-d');
        $businessDays = 0;

        while ($startDate < $endDate) {
            $weekday = date('N', strtotime($startDate));

            if ($weekday < 6 && !in_array($startDate, $holidays)) { // Monday to Friday, not a holiday
                $businessDays++;
            }

            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        }

        return $businessDays;
    }

    $holidays = array("2023-04-01", "2023-05-01", "2023-12-25"); // holidays in YYYY-MM-DD format
    $endDate = '2023-04-20'; // end date in YYYY-MM-DD format
    $businessDays3 = countBusinessDays3($endDate, $holidays); // count number of business days between current date and end date, excluding weekends and holidays
    echo "<br>";
    echo $businessDays3; // output: number of business days


    $date1 = new DateTime('2022-02-28');
$date2 = new DateTime('2022-01-01');
$interval = $date1->diff($date2);
$weeks = floor($interval->days / 7);
echo "The two dates are {$weeks} weeks apart";

    ?>


</body>

<script>
    function addBusinessDays(startDate, daysToAdd) {
        // define a list of holiday dates (in MM/DD/YYYY format)
        let holidays = ["04/05/2023", "4/12/2023"];

        // convert startDate to a date object
        startDate = new Date(startDate);

        // iterate through each day to add
        for (let i = 0; i < daysToAdd; i++) {
            // advance startDate by 1 day
            startDate.setDate(startDate.getDate() + 1);
            console.log(startDate.toLocaleDateString('en-US'))
            // console.log(holidays.includes(formatDate(startDate)))
            // check if the day is a weekend or holiday
            if (startDate.getDay() === 0 || startDate.getDay() === 6 || holidays.includes(formatDate(startDate))) {
                // subtract 1 from daysToAdd and iterate again
                daysToAdd++;
            }
        }

        // return the result as a formatted date string
        return formatDate(startDate);
    }

    function formatDate(date) {
        // format the date as "MM/DD/YYYY"
        let month = date.getMonth() + 1;
        let day = date.getDate();
        let year = date.getFullYear();
        return `${month}/${day}/${year}`;
    }

    let startDate = '2023-04-07'; // format: "YYYY-MM-DD"
    let daysToAdd = 3;

    let result = addBusinessDays(startDate, daysToAdd);
    console.log(result); // output: "04/17/2023"

    // function addBusinessDays2(startDate, numDays, holidays) {
    //     // Convert startDate string to Date object
    //     startDate = new Date(startDate);

    //     // Loop through each day to add, skipping weekends and holidays
    //     for (let i = 0; i < numDays; i++) {
    //         // Add one day to the date
    //         startDate.setDate(startDate.getDate() + 1);

    //         // Check if it's a weekend day
    //         if (startDate.getDay() === 0 || startDate.getDay() === 6) {
    //             // Subtract one day to account for the weekend day
    //             startDate.setDate(startDate.getDate() - 1);

    //             // Add one day to skip to the next business day
    //             startDate.setDate(startDate.getDate() + 1);
    //         }

    //         // Check if it's a holiday
    //         if (holidays && holidays.indexOf(startDate.toISOString().slice(0, 10)) !== -1) {
    //             // Subtract one day to account for the holiday
    //             startDate.setDate(startDate.getDate() - 1);

    //             // Add one day to skip to the next business day
    //             startDate.setDate(startDate.getDate() + 1);
    //         }
    //     }

    //     // Return formatted date string (e.g. "2023-04-10")
    //     return startDate.toISOString().slice(0, 10);
    // }

    // // Example usage
    // const startDate2 = "2023-04-03";
    // const numDays2 = 5;
    // const holidays2 = ["2023-04-05", "2023-04-07"];
    // const endDate2 = addBusinessDays2(startDate2, numDays2, holidays2);

    // console.log(endDate2); // Output: "2023-04-10"

</script>

</html>
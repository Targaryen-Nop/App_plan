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
    echo "<br>" . onplusTime("2023-04-04", 3, "dw")."<br>";

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

            $businessDays --;
            $daysLate --;
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


    ?>


</body>

</html>
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
    <div id="mdp-demo"></div>
</body>
<script type="text/javascript" language="javascript">
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
                let date_holidays = [];
                let myArray = data[0].split(",");
                console.log(myArray.length)

                const today = new Date();
                const y = today.getFullYear();
                for (let i = 0; i < myArray.length; i++) {
                    result[i] = /[0-9]{2}[/][0-9]{2}[/][0-9]{4}/.exec(myArray[i]);
                    // console.log(result[i][0]);
                    date_holidays.push(`${result[i][0]}`);
                    $('#mdp-demo').multiDatesPicker({
                        addDates: [date_holidays[i]],
                        numberOfMonths: [3, 4],
                        defaultDate: date_holidays[0]
                    });
                    const dateISO = new Date(date_holidays[i]);
                    console.log(dateISO);
                }
            }
        })
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
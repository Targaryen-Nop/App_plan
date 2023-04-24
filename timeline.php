<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
    <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
    <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline-api.js"></script>
    <script src="https://cdn.knightlab.com/libs/timeline3/latest/js/locale/th.js"></script>
</head>
<style>

</style>



<body>
    <div style="margin-top: 200px;" id="timeline"></div>

</body>
<script>
    const timelineData = {
        "events": [{
                "start_date": {
                    "year": "2010",
                    "month": "01",
                    "day": "01"
                },
                "text": {
                    "headline": "Event 1",
                    "text": "Description of event 1"
                },
                "media": {
                    "url": "Cat03.jpg",

                }

            },
            {
                "start_date": {
                    "year": "2010",
                    "month": "03",
                    "day": "01"
                },
                "text": {
                    "headline": "Eventqwd",
                    "text": "Description of event "
                },
                "media": {
                    "url": "dog.jpg",
                    "width":"700",
                    "height ":"400"

                }
            },
            {
                "start_date": {
                    "year": "2010",
                    "month": "05",
                    "day": "01"
                },
                "text": {
                    "headline": "Eventqwd2",
                    "text": "Description of event "
                },
                
            },
            // {
            //     "start_date": {
            //         "year": "2015",
            //         "month": "01",
            //         "day": "01"
            //     },
            //     "text": {
            //         "headline": "Event 2",
            //         "text": "Description of event 2"
            //     }
            // },
            // {
            //     "start_date": {
            //         "year": "2020",
            //         "month": "01",
            //         "day": "01"
            //     },
            //     "text": {
            //         "headline": "Event 3",
            //         "text": "Description of event 3"
            //     }
            // }
        ],
    };
    var timeline = new TL.Timeline('timeline', timelineData, {
        language: 'th',
        hight: 500
    });
</script>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- <link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" />
  <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script> -->

  <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
</head>

<body>
  <div id="gantt-chart" style="width: 100%; height: 500px;"></div>
</body>
<script>
  // Initialize Gantt chart
  gantt.init("gantt-chart");
  // Modify options using gantt.config
  gantt.config.date_format = '%d-%m-%Y';
  gantt.config.scale_unit = 'week';
  gantt.config.scale_step = 2;
  gantt.config.show_grid = true;

  // Alternatively, you can use gantt.config to set options individually


  //   var tasks = [
  //   {
  //     id: 1,
  //     text: 'Task 1',
  //     start_date: '2023-05-01',
  //     duration: 5
  //   },
  //   {
  //     id: 2,
  //     text: 'Task 2',
  //     start_date: '2023-05-06',
  //     duration: 5,
  //     links: [
  //       { id: 1, source: 1, target: 2, type: '0' }
  //     ]
  //   }
  // ];


  // Load tasks into the Gantt chart
  gantt.parse({
    data: [{
        id: 1,
        text: "Project #1",
        start_date: null,
        duration: null,
        parent: 0,
        progress: 0,
        open: true
      },
      {
        id: 2,
        text: "Task #1",
        start_date: "2019-08-01 00:00",
        duration: 5,
        parent: 1,
        progress: 1
      },
      {
        id: 3,
        text: "Task #2",
        start_date: "2019-08-06 00:00",
        duration: 2,
        parent: 1,
        progress: 0.5
      },
      {
        id: 4,
        text: "Task #3",
        start_date: null,
        duration: null,
        parent: 1,
        progress: 0.8,
        open: true
      },
      {
        id: 5,
        text: "Task #3.1",
        start_date: "2019-08-09 00:00",
        duration: 2,
        parent: 4,
        progress: 0.2
      },
      {
        id: 6,
        text: "Task #3.2",
        start_date: "2019-08-11 00:00",
        duration: 1,
        parent: 4,
        progress: 0
      }
    ],
    links: [{
        id: 1,
        source: 2,
        target: 3,
        type: "0"
      },
      {
        id: 2,
        source: 3,
        target: 4,
        type: "0"
      },
      {
        id: 3,
        source: 5,
        target: 6,
        type: "0"
      }
    ]
  });
</script>

</html>
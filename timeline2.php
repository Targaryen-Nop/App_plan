<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css" />
  <script src="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.js"></script>
</head>

<body>
  <div id="gantt-chart"></div>
</body>
<script>
  let options = {
    header_height: 50,
    column_width: 30,
    step: 'day',
    view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week',  'Quarter Month', 'Month', 'Year'],
    bar_height: 20,
    bar_corner_radius: 3,
    arrow_curve: 5,
    padding: 18,
    view_mode: 'Month',
    date_format: 'YYYY-MM-DD',
    custom_popup_html: function(task) {
      // Custom popup HTML function
      return '<div class="task-popup">' +
        '<h3>' + task.name + '</h3>' +
        '<p>Start: ' + task.start + '</p>' +
        '<p>End: ' + task.end + '</p>' +
        '</div>';
    }
  };
  // Initialize Gantt chart
  let tasks = [{
      id: 'Task 1',
      name: 'Task 1',
      start: '2023-05-01',
      end: '2023-06-05',
      progress: 20
    },
    {
      id: 'Task 2',
      name: 'Task 2',
      start: '2023-06-06',
      end: '2023-07-10',
      progress: 100,
      dependencies: []
    },
    // Add more tasks as needed
  ];

  const gantt = new Gantt('#gantt-chart', tasks,options);
</script>
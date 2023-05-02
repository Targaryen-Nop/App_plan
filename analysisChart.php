<head>
  <!-- Load plotly.js into the DOM -->
  <script src='https://cdn.plot.ly/plotly-2.20.0.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/d3-array@3"></script>
  <script src="https://cdn.jsdelivr.net/npm/d3-time@3"></script>
  <script src="https://cdn.jsdelivr.net/npm/d3-time-format@4"></script>
</head>

<body>
  <div id='myDiv'><!-- Plotly chart will be drawn inside this DIV --></div>
</body>
<script>

var quarterFormat = d3.timeFormat("%Y Q%q");
// Sample data
var data = [{
  x: ['2020-01-01', '2020-04-01', '2020-07-01', '2020-10-01'],
  y: [0, 0, 0, 0],
  mode: 'lines+markers',
  marker: {
    color: 'blue'
  },
  line: {
    width: 1,
    color: 'blue'
  },
  showlegend: false,
  hoverinfo: 'none'
}, {
  x: ['2020-01-15', '2020-04-01', '2020-07-15', '2020-10-01'],
  y: [0, 1, 2, 3],
  mode: 'markers',
  marker: {
    size: 10,
    color: 'red'
  },
  name: 'Events'
}];

// Set x-axis tick format
var layout = {
  xaxis: {
    tickformat: quarterFormat,
    type: 'date'
  },
  yaxis: {
    title: ''
  }
};

// Create chart
Plotly.newPlot('myDiv', data, layout);
</script>
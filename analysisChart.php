<?php
include 'header.php';
?>

<body>
  <div class="row">
    <div class="col-6"></div>
    <div class="col-6"></div>
    <div class="col-6"></div>
    <div class="col-6"></div>
  </div>
  <div class="row">
    <div class="col-6"><canvas id="myChart"></canvas></div>
    <div class="col-6"></div>
  </div>

  <div>

  </div>
</body>
<script>
  $(document).ready(function() {
    $.ajax({
      url: "app_fetchALL.php",
      method: "POST",
      dataType: "json",
      success: function(data) {
        console.log(data.total2023)
        let year = []
        year = data.total2023
        console.log(year)
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augest', 'Septemper', 'Octorber', 'November', 'December'],
            datasets: [{
                label: '2023',
                data: data.total2023,
                borderWidth: 1
              },
              {
                label: '2022',
                data: data.total2022,
                borderWidth: 1
              },
              {
                label: '2021',
                data: data.total2021,
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });


      }
    })
  })
</script>
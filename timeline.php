<?php
include 'header.php';
?>

<style></style>

<body>
  <div id="timeline-embed" style="width: 100%; height: 600px"></div>
</body>
<script async src="//www.instagram.com/embed.js"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: "app_fetchALL.php",
      method: "POST",
      dataType: "json",
      success: function(data) {
        let array = [];

        // for (let i = 0; i < 100; i++) {
        //   array[i] = {
        //     start_date: {
        //       year: data.io[i].delivery.substr(0, 4),
        //       month: data.io[i].delivery.substr(5, 2),
        //       day: data.io[i].delivery.substr(8, 2),
        //     },
        //     text: {
        //       headline: data[i].customer_name,
        //       text: "Description of event 1",
        //     },
        //     media: {
        //       url: '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3877.019116861581!2d100.46567847429823!3d13.656600999492067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2a3ad81fc27cb%3A0x438ff7357b09b43d!2sPlant%20Equipment%20Co.%2C%20Ltd.!5e0!3m2!1sen!2sth!4v1682323277702!5m2!1sen!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        //     },
        //     background: {
        //       url: "dog.jpg",
        //     },
        //   }
        // }
        console.log(data);
        console.log(array);

        // const timelineData = {
        //   events:array
        // };
        // var timeline = new TL.Timeline("timeline-embed", timelineData, {
        //   language: "th",
        //   duration: 1000,
        //   default_bg_color: {
        //     r: 0,
        //     g: 0,
        //     b: 0,
        //   },
        //   // timenav_height: "250",
        //   is_embed: true,
        //   timenav_position: "top",
        //   initial_zoom: 10,
        //   hash_bookmark: false,
        // });
      },
    });
  });
</script>
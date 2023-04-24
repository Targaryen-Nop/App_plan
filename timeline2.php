
<!DOCTYPE html>
<html lang="en"><!--
  	 
  	88888888888 d8b                        888 d8b                888888   d8888b  
  	    888     Y8P                        888 Y8P                   88b d88P  Y88b 
  	    888                                888                       888 Y88b
  	    888     888 88888b d88b     d88b   888 888 88888b     d88b   888   Y888b
  	    888     888 888  888  88b d8P  Y8b 888 888 888  88b d8P  Y8b 888      Y88b
  	    888     888 888  888  888 88888888 888 888 888  888 88888888 888        888 
  	    888     888 888  888  888 Y8b      888 888 888  888 Y8b      88P Y88b  d88P 
  	    888     888 888  888  888   Y8888  888 888 888  888   Y8888  888   Y8888P
  	                                                                d88P            
  	                                                              d88P             
  	                                                            888P              
  	 -->
  <head>
    <title>Revolutionary User Interfaces</title>
    <meta name="description" content="The human computer interface helps to define computing at any one time.">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <!-- Style-->
    <style>
      html, body {
      height:100%;
      padding: 0px;
      margin: 0px;
      }
    </style>
	<link rel="shortcut icon" href="https://cdn.knightlab.com/libs/blueline/latest/assets/logos/favicon.ico"> 

  </head>
  <body>
       <!-- Demo -->
<div id="timeline-embed">
    <div id="timeline"></div>
</div>
<link rel="stylesheet" href="//cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
<link rel="stylesheet" href="//cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
<script type="text/javascript" src="//cdn.knightlab.com/libs/timeline3/latest/js/timeline-min.js"></script>
<script>
    $(document).ready(function() {
        var embed = document.getElementById('timeline-embed');
        embed.style.height = getComputedStyle(document.body).height;
        window.timeline = new TL.Timeline('timeline-embed', 'timeline3.json', {
            hash_bookmark: false
        });
        window.addEventListener('resize', function() {
            var embed = document.getElementById('timeline-embed');
            embed.style.height = getComputedStyle(document.body).height;
            timeline.updateDisplay();
        })
    });
</script>
          <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- This fragment is only used on some of the examples pages -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-537357-20"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-537357-20', { 'anonymize_ip': true });
    </script>
  </body>
</html>
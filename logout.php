<?php
  session_start();
  include "connectdb.php";
  

  session_destroy();
  echo "<meta http-equiv='refresh' content='2;url=login.php'>";
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<?php
echo "<br><br><center><font size='5' color='blue' face='MS Sans Serif'><b>Logout Please Wait</b></font></center>";
?>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");

include "connectdb.php";

if (isset($_POST['employee_login']) && isset($_POST['pwd_login'])) {

    $sql_aes    = "SELECT AES_ENCRYPT('" . $_POST['pwd_login'] . "','ACL4064') AS PASS";
    $query_aes  = mysqli_query($connection, $sql_aes);
    $result_aes = mysqli_fetch_array($query_aes);

    $sql   = "select * from users where user_name='" . mysqli_real_escape_string($connection, $_POST["employee_login"]) . "' and user_password='" . $result_aes['PASS'] . "'";
    $query = mysqli_query($connection, $sql);
    $num   = mysqli_num_rows($query);
?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
    if ($num <= 0) {
        echo "<br><br><center><font size='5' color='red' face='MS Sans Serif'><b>Username or Password Invalid</b></font></center>";
        echo "<meta http-equiv=refresh content=2;URL=login.php>";
        exit();
    } else {
        $result                     = mysqli_fetch_array($query);
        $_SESSION['login_id']       = $result['user_id'];
        $_SESSION['user_surname']      = $result['surname'];
        $_SESSION['user_lastname']  = $result['lastname'];
        $_SESSION['user_name']           = $result['user_name'];
        $_SESSION['user_customer']  = $result['user_customer'];
        $_SESSION['user_phone']     = $result['user_phone'];
        $_SESSION['user_address']   = $result['user_address'];
        $_SESSION['auth']           = $result['user_auth'];
        $_SESSION['email']          = $result['user_email'];


        echo "<br><br><center><font size='5' color='green' face='MS Sans Serif'><b>Login Please Wait</b></font></center>";
       if($_SESSION['auth'] == 'Customer'){
        echo "<meta http-equiv='refresh' content='1 ;url=application_insert.php'>";
       } else if($_SESSION['auth'] == 'Master' || $_SESSION['auth'] == 'Engineer'){
        echo "<meta http-equiv='refresh' content='1 ;url=index.php'>";
       }
        exit();
    }
} ?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Form Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;1,700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="center">
        <!--- leftbar ------------->
        <div class="left_bar">

            <div class="logo">
                <img src="./images/login.png" alt="">
            </div>

        </div>

        <!--- end leftbar ------------->

        <!--- rigth_bar ------------->

        <div class="right_bar">
            <form method="post" action="">
                <div class="h1">
                    <h1>
                        Login
                    </h1>
                    <p>
                        กรุณาลงชื่อเข้าใช้เพื่อเข้าสู่ระบบ Monitoring
                    </p>
                </div>
                <div class="txt_field">
                    <input type="text" placeholder="Username" required name='employee_login'>

                </div>
                <div class="txt_field">
                    <input type="password" placeholder="Password" required name='pwd_login'>

                </div>
                <div class="submit">
                    <input class="btn" type="submit" value="Submit" style=" text-align: center;">

                </div>
            </form>
        </div>

        <!--- rigth_bar ------------->

    </div>

</body>

<style>
    * {
  margin: 0%;
  padding: 0%;
  box-sizing: border-box;
  color: #666666;
  font-family: "PT Sans", sans-serif;
}
.logo {
  max-width: 30%;
  max-height: 30%;
  margin: 200px auto;
}
img {
  max-width: 100%;
  height: 100%;
}
.center {
  box-shadow: 0px 2px 20px 18px rgba(102, 102, 102, 0.37);
  border-radius: 10px;
  width: 60%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: none;
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.center h1 {
  padding: 20px;
  text-align: center;
  font-size: 60px;
  font-weight: bolder;
}
.btn {
  width: 80%;
  height: 40px;
  margin-left: 20px;
  margin-bottom: 40px;
  border-radius: 10px;
  background-color: #666666;
  color: white;
}
input {
  text-align: left;
  margin: 0px 20px;
  width: 80%;
  padding: 0 5px;
  height: 40px;
  font-size: 16px;
  border: none;
  border-bottom: 1px solid #666666;
  outline: none;
}
.header {
  background-color: #666666;
  border-radius: 10px 10px 0 0;
}
label {
  margin: 30px;
  color: #666666;
}
span {
  background-color: #666666;
}
.left_bar {
  background-color: #ccd1d1;
  border-radius: 10px 0 0 10px;
}
.right_bar {
  background-color: none;
}
p {
  margin: 30px;
}
.txt_field {
  margin-bottom: 30px;
}

</style>
</html>
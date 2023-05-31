<?php
$server     = "35.240.133.163";
$user       = "pec-admin";
$pwd        = "PEC131213";
$dbname     = "pec-database";
$connection = mysqli_connect($server, $user, $pwd, $dbname);
$connection->set_charset("utf8");


$sql = "SELECT * FROM quotation_report LIMIT 10 ";
$query = mysqli_query($connection, $sql);


while ($result = mysqli_fetch_array($query)) {

    echo $result['quotation_no'] . " " . $result['product_detail_code'] . "<br>";
}

$server_crm     = "localhost";
$user_crm       = "root";
$pwd_crm        = "";
$dbname_crm     = "pec_application_plans";
$connection_crm = mysqli_connect($server_crm, $user_crm, $pwd_crm, $dbname_crm);
$connection_crm->set_charset("utf8");
?>
<?php
if (isset($_POST['update'])) {
    $product_detail_code = $_POST['product_detail_code'];
    $sql_update = "UPDATE quotation_report SET product_detail_code ='" . $product_detail_code . "' WHERE quotation_no = 'P-KS-0-001-0119'";
    $updatequery = mysqli_query($connection, $sql_update);

    if ($updatequery) {
        echo "<div align='center'><font color=green size='10pt'><b>DATA UPDATED<b></font></div>";
    } else {

        echo "<div align='center'><font color=red size='10pt'><b>DATA NOT UPDATED<b></font></div>";
    }

    echo "<meta http-equiv='refresh' content='1; url=connectdbcopy2.php";
}
?>

<form method="post">
    <input type="text" name="product_detail_code" value="MAIN">
    <button type="submit" name="update">update</button>
</form>
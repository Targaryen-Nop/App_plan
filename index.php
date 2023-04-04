<?php
$path = 'data/Application Plan 2022 - App Data.csv';
$handle = fopen($path, "r"); // open in readonly mode
while (($row = fgetcsv($handle)) !== false) {
    // var_dump($row);
    // echo $row[0];
}
fclose($handle);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="container">
<table class="table my-3">
  <tbody>
  <?php  
$path = 'data/Application Plan 2022 - App Data.csv';
$handle = fopen($path, "r"); // open in readonly mode
while (($row = fgetcsv($handle)) !== false) { 
?>
    <tr>
      <th><?php echo $row[0]; ?></th>
      <td><?php echo $row[1]; ?></td>
      <td><?php echo $row[2]; ?></td>
      <td><?php echo $row[3]; ?></td>
      <td><?php echo $row[4]; ?></td>
      <td><?php echo $row[5]; ?></td>
      <td><?php echo $row[6]; ?></td>
      <td><?php echo $row[7]; ?></td>
      <td><?php echo $row[8]; ?></td>
      <td><?php echo $row[9]; ?></td>
      <td><?php echo $row[10]; ?></td>
      <td><?php echo $row[11]; ?></td>
      <td><?php echo $row[12]; ?></td>
      <td><?php echo $row[13]; ?></td>
      <td><?php echo $row[14]; ?></td>
      <td><?php echo $row[15]; ?></td>
      <td><?php echo $row[16]; ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
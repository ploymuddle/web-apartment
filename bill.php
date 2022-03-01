<?php
$conn = mysqli_connect('localhost','root','','myapartment');

$strSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id ";
if ($_GET["room"] != 'all' && $_GET["room"] != '') {
  $room = $_GET["room"];
  $strSQL =  $strSQL . " AND i.room_id = '" . $_GET["room"] . "' ";
}
if ($_GET["cust"] != '') {
  $cust = $_GET["cust"];
  $strSQL =  $strSQL . " AND i.cust_id = '" . $_GET["cust"] . "' ";
}
if ($_GET["month"] != 0) {
  $month = $_GET["month"];
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%-" . $month . "-%' ";
}
if ($_GET["year"] != 0) {
  $year = $_GET["year"];
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%" . $year . "%' ";
}

$strSQL = $strSQL . " ORDER BY i.inv_date DESC ";

$objQuery = mysqli_query($conn, $strSQL);

?>

<!DOCTYPE html>
<html>
<head>
<style>
table {text-align: center;border-collapse: collapse;width: 100%;}
td {border-bottom: 1px solid #ddd;padding: 8px;}
th {border-bottom: 3px solid #ddd;padding: 8px;}
</style>
</head>
<body>

<h2>HTML Table</h2>

<table>
  <tr>
    <th>วันที่</th><th>ห้อง</th><th>รหัสมาชิก</th><th>ชื่อลูกค้า</th><th>รายการชำระ</th><th>สถานะการชำระ</th>
  </tr>
  <?php while($row = mysqli_fetch_array($objQuery)) { ?>
  <tr>
    <td><?php echo $row['inv_date']; ?></td>
    <td><?php echo $row['room_id']; ?></td>
    <td><?php echo $row['cust_id']; ?></td>
    <td><?php echo $row['cust_name'].' '.$row['cust_surname']; ?></td>
    <td><?php echo $row['pay_amount']; ?></td>
    <td><?php echo $row['pay_status']; ?></td>
  </tr>
  <?php } ?>
</table>

</body>
</html>


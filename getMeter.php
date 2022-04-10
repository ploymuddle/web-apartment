<?php
$room = $_GET['room'];
$cust = $_GET['cust'];
 
//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

$sql = " SELECT inv_fire_meter AS FM, inv_fire_unit AS FU, inv_water_meter AS WM, inv_water_unit AS WU FROM invoice  WHERE cust_id = '$cust' AND room_id = '$room' ORDER BY inv_date DESC LIMIT 1 ";
$query = mysqli_query($conn,$sql);
$json = array();
// echo $sql;
while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($conn);
?>

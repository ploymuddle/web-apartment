<?php
//แสดงข้อมูลทั้งหมดของลูกค้านั้น
$q = $_GET['q'];
require_once "connection/connection.php";
$sql="SELECT * FROM contract co, customer cu ,  room r , room_type rt 
 WHERE  cu.cust_id = co.cust_id 
 AND r.room_id = co.room_id 
 AND r.type_room = rt.type_room 
 AND cu.cust_id = '".$q."'";

$query = mysqli_query($conn,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($conn);
?>

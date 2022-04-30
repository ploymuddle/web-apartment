<?php
//แสดงข้อมูลชนิดห้องพัก ตามประเภทนั้นๆ
$q = $_GET['q'];

require_once "connection/connection.php";
$sql=" SELECT * FROM room_type WHERE type_room = '". $q ."' ";
$query = mysqli_query($conn, $sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
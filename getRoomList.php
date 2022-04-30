<?php
//รายชื่อห้องพักที่ว่าง ตามชนิด
$q = $_GET['q'];

require_once "connection/connection.php";
$sql = "SELECT * FROM room WHERE room_status = 'N' AND type_room = '". $q ."' ";
$query = mysqli_query($conn, $sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
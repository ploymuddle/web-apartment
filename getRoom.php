<?php
$q = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection/connection.php";

$sql=" SELECT * FROM room r,room_type rt WHERE r.type_room =  rt.type_room AND  r.room_id = '". $q ."' ";
$query = mysqli_query($conn, $sql);
$json = array();
// echo $sql;

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
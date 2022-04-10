<?php
$q = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$sql = "SELECT * FROM room WHERE room_status = 'N' AND type_room = '". $q ."' ";
$query = mysqli_query($conn, $sql);
$json = array();
// echo $sql;

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
<?php
$q = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$sql=" SELECT * FROM room_type WHERE type_room = '". $q ."' ";
$query = mysqli_query($conn, $sql);
$json = array();
// echo $sql;

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
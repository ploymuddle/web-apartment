<?php
//ค่าที่ส่งมาจาก javascript
$q = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$sql=" SELECT * FROM room r,room_type rt WHERE r.type_room =  rt.type_room AND  r.type_room = '". $q ."' ";
$result = mysqli_query($conn,$sql);
$data = array();

while($row = mysqli_fetch_array($result)) {

    $hint = array(
            "room_id"=> $row['room_id'],
            "room_status"=> $row['room_status'],
            "type_room"=> $row['type_room'],
            "type_data"=> $row['type_data'],
            "type_rental"=> $row['type_rental']
    );
    array_push($data, $hint);
  }

echo json_encode($data);

mysqli_close($conn);

?>

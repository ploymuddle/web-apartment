<?php
//แสดงรายชื่อห้องพักทั้งหมด ตามชนิด
$q = $_GET['q'];

require_once "connection/connection.php";
$sql=" SELECT * FROM room r,room_type rt WHERE r.type_room =  rt.type_room AND  r.type_room = '". $q ."' ORDER BY r.room_id ASC";
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

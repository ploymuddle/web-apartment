<?php 
session_start();
$conn = mysqli_connect('localhost','root','','myapartment');

$id = $_POST['roomId'];
$type = $_POST['roomType'];
$status = 'N';

//add contract
$sql = " INSERT INTO room (room_id, room_status, type_room) VALUE ('$id', '$status', '$type') ";
$result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success'] = "ห้อง ".$id."  ประเภท ".$type;
                header("Location: admin_addroom.php");
            } else {
                $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
                header("Location: admin_addroom.php");
            }

exit();

?>
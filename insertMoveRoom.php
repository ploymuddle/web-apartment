<?php 
session_start();
require_once "connection/connection.php";

if($_POST['move'] == 'room') {
    $detail = $_POST['detail'];
    $con = $_POST['con'];
    $room = $_POST['room'];
    $status = 'ขอย้ายห้อง';
    $date = $_POST['date'];;
} else if($_POST['move'] == 'out') {
    $detail = $_POST['detail'];
    $con = $_POST['con'];
    $room = $_POST['room'];
    $status = 'ขอย้ายออก';
    $date = $_POST['date'];
} else {
    header("Location: user_to_move.php");
    exit();
}

//add contract
$sql = " INSERT INTO petition (petition_detail, petition_date , petition_status, room_id, con_id) VALUE ('$detail','$date', '$status', '$room','$con') ";
$result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success'] = "ส่งคำขอย้ายห้องสำเร็จ";
                header("Location: user_to_move.php");
            } else {
                $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
                header("Location: user_to_move.php");
            }

exit();

?>
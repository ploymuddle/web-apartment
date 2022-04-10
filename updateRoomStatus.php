<?php
$id = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

//query room status
$sql = "SELECT room_status FROM room WHERE room_id = '" . $id . "' ";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
$json = json_encode($result);
$status = json_decode($json);

if ($status->room_status == 'C') {
    $sqlUpdate = " UPDATE room SET room_status = 'N' WHERE room_id = '" . $id . "' ";
    $queryUpdate = mysqli_query($conn, $sqlUpdate);
} else {
    $sqlUpdate = " UPDATE room SET room_status = 'C' WHERE room_id = '" . $id . "' ";
    $queryUpdate = mysqli_query($conn, $sqlUpdate);
}

echo 'succeed';

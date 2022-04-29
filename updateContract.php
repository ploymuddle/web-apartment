<?php
session_start();
//อัปเดตเพื่อยกเลิกสัญญา
//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$id = $_POST['con'];


if ($_GET['move'] == 'room') {
    $id = $_GET['id'];
    $move = $_GET['move'];
} else if ($_GET['move'] == 'out') {
    $id = $_GET['id'];
    $move = $_GET['move'];
}

//query cust_id
$sql = "SELECT cust_id, room_id FROM contract WHERE con_id = '$id' ";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($query);
$json = json_encode($result);
$data = json_decode($json);

//update customer
$sqlCust = "UPDATE customer SET cust_status = 'leave' WHERE cust_id = '$data->cust_id'  ";
$result = mysqli_query($conn, $sqlCust);

//update room
$sqlRoom = "UPDATE room SET room_status = 'N' WHERE room_id = '$data->room_id'  ";
$result = mysqli_query($conn, $sqlRoom);

//delete message
$sqlMessage = "DELETE FROM messages WHERE from_user = '$data->room_id' OR to_user = '$data->room_id'  ";
$result = mysqli_query($conn, $sqlMessage);

//update contract
$sqlUpdate = "UPDATE contract SET con_status = 'V' WHERE con_id = '$id'  ";
$result = mysqli_query($conn, $sqlUpdate);

if ($result) {

    if ($_GET['move'] == 'room') {
        $sqlCust = "UPDATE petition SET petition_status = 'ตอบรับ' WHERE room_id = '$data->room_id'  ";
        $result = mysqli_query($conn, $sqlCust);
        header("Location: admin_contract.php");
        exit();
    } else if ($_GET['move'] == 'out') {
        $sqlCust = "UPDATE petition SET petition_status = 'ตอบรับ' WHERE room_id = '$data->room_id'  ";
        $result = mysqli_query($conn, $sqlCust);
        header("Location: approved_to_move.php");
        exit();
    }

    $_SESSION['success'] = "Insert user successfully";
    header("Location: admin_customer.php");
} else {
    $_SESSION['error'] = "Something went wrong";
    header("Location: admin_customer.php");
}

exit();

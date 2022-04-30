<?php

session_start();
require_once "connection/connection.php";

$id = $_POST['billId'];
$amount = $_POST['payment'];

if ($amount > 0) {

    $sql = "SELECT pay_id FROM payment WHERE inv_id = '" . $id . "' ";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    $json = json_encode($result);
    $payId = json_decode($json);

    $sqlUpdate = " UPDATE payment SET pay_status = 'ชำระแล้ว', pay_amount = '$amount' WHERE pay_id = '" . $payId->pay_id . "' ";
    $queryUpdate = mysqli_query($conn, $sqlUpdate);

    if ($result) {
        $_SESSION['success'] = "";
        header("Location: admin_update_bill.php");
    } else {
        $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล ก่อนบันทึก";
        header("Location: admin_update_bill.php");
    }
} else {
    $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล ก่อนบันทึก";
    header("Location: admin_update_bill.php");
}

exit();

<?php
session_start();
require_once "connection/connection.php";

$id = $_POST['billID'];
$pic = 'images/' . $_FILES['img']['name'];
move_uploaded_file($_FILES['img']['tmp_name'], $pic);

if ($pic != 'images/') {
    // update data
    $sqlUpdate = "UPDATE payment SET pay_status = 'รอดำเนินการ' ";
    if ($_FILES['img']['name'] != '') {
        $sqlUpdate = $sqlUpdate . " , pay_slip = '$pic' ";
    }
    $sqlUpdate = $sqlUpdate . " WHERE pay_id = '$id' ";

    $result = mysqli_query($conn, $sqlUpdate);

    if ($result) {
        $_SESSION['success'] = "";
        header("Location: user_bill.php");
    } else {
        $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
        header("Location: user_bill.php");
    }
} else {
    $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
    header("Location: user_bill.php");
}
exit();

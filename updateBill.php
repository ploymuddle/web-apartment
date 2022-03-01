<?php

$con = mysqli_connect('localhost','root','','myapartment');

$id = $_POST['billId'];
$amount = $_POST['payment'];

$sql = "SELECT pay_id FROM payment WHERE inv_id = '" . $id . "' ";
$query = mysqli_query($con, $sql);
$result = mysqli_fetch_assoc($query);
$json = json_encode($result);
$payId = json_decode($json);

$sqlUpdate = " UPDATE payment SET pay_status = 'ตรวจสอบแล้ว', pay_amount = '$amount' WHERE pay_id = '" . $payId->pay_id . "' ";
$queryUpdate = mysqli_query($con, $sqlUpdate);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_update_bill.php");
            } else {
                // $_SESSION['error'] = "Something went wrong";
                // header("Location: admin_update_bill.php");
                echo $sqlUpdate;
            }

exit();

?>

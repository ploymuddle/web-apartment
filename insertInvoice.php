<?php 
session_start();
require_once "connection/connection.php";

$roomId = $_POST['roomId'];
$custId = $_POST['cust_id'];
$name = $_POST['name'];
$suername = $_POST['surname'];
$date = $_POST['date'];
$deadtime = $_POST['deadtime'];
$rental = $_POST['roomRent'];
$penalty = $_POST['penalty'];
$FU = $_POST['FU'];
$FM = $_POST['FM'];
$WU = $_POST['WU'];
$WM = $_POST['WM'];
$total = $_POST['total'];

//add invoice
$sqlInvoice = " INSERT INTO invoice (cust_id, room_id, inv_fire_meter, inv_fire_unit, inv_water_meter, inv_water_unit,inv_rental,inv_penalty,inv_total,inv_date,inv_deadtime) 
                        VALUE ('$custId', '$roomId', '$FM', '$FU', '$WM', '$WU', '$rental', '$penalty', '$total','$date','$deadtime') ";
$resultInvoice = mysqli_query($conn, $sqlInvoice);

//query cust_id
$resultId = mysqli_insert_id($conn);

//add payment in status ค้างชำระ
$sql = " INSERT INTO payment (inv_id,cust_id,pay_status,pay_amount	) 
                        VALUE ('$resultId','$custId', 'ค้างชำระ',0) ";

$result = mysqli_query($conn, $sql);

            if ($result && $resultInvoice) {
                $_SESSION['success'] = "";
                header("Location: admin_create_bill.php");
            } else {
                $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
                header("Location: admin_create_bill.php");
            }

exit();

?>
<?php 
//อัปเดตเพื่อยกเลิกสัญญา
//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$id = $_POST['con'];

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

//update contract
$sqlUpdate = "UPDATE contract SET con_status = 'V' WHERE con_id = '$id'  ";

$result = mysqli_query($conn, $sqlUpdate);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_customer.php");
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: admin_customer.php");
            }

exit();

?>
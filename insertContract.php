<?php 
session_start();
require_once "connection/connection.php";

$file='file/'.$_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'],$file)) 
{
    
}
else {
    echo 'not';
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$number = $_POST['tel'];
$username = $_POST['roomId'];
$password = $_POST['roomId'];

$date = $_POST['contractDate'];
$roomId = $_POST['roomId'];
$deposit = $_POST['contract'];
$img_document = $_POST['file'];

//add customer
$queryInsertCust = "INSERT INTO customer (cust_name, cust_surname, cust_tel, cust_email, cust_username, cust_status, cust_password)
                        VALUE ('$name', '$surname', '$number', '$email', '$username' , 'live', '$password')";
$resultInsertCust = mysqli_query($conn, $queryInsertCust);

//query cust_id
$resultId = mysqli_insert_id($conn);

//update room
$sqlUpdateRoom = "UPDATE room SET room_status = 'O' WHERE room_id = '$roomId'";
$result = mysqli_query($conn, $sqlUpdateRoom);

//add contract
$sql = "INSERT INTO contract (con_checkin, room_id, con_deposit, cust_id, img_document, img_contract, con_status)
                        VALUE ('$date', '$roomId', '$deposit', '$resultId' , '$file' , 'www', 'O')";
$result = mysqli_query($conn, $sql);

$resultCon = mysqli_insert_id($conn);

            if ($result) {
                header('Location: uploadContract.php?id='.$resultCon);
            } else {
                $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
                header("Location: admin_contract.php");
            }

exit();

?>
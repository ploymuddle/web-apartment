<?php

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

$id = $_POST['billID'];
$pic ='images/'.$_FILES['img']['name'];
move_uploaded_file($_FILES['img']['tmp_name'],$pic);

// update data
$sqlUpdate = "UPDATE payment SET pay_status = 'รอดำเนินการ' ";
if($_FILES['img']['name']!=''){
$sqlUpdate = $sqlUpdate . " , pay_slip = '$pic' ";
}
$sqlUpdate = $sqlUpdate . " WHERE pay_id = '$id' ";

echo $sqlUpdate;
$result = mysqli_query($conn, $sqlUpdate);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: user_bill.php");
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: user_bill.php");
            }

exit();
?>
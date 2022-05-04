<?php 
session_start();
require_once "connection/connection.php";
unset($_SESSION["error"]);
$file='file/'.$_FILES['file']['name'];
$id = $_POST['id'];

if(move_uploaded_file($_FILES['file']['tmp_name'],$file)) 
{
    
}
else {
}

//update
$sql = " UPDATE contract SET img_contract = '$file' WHERE con_id = '$id' ";        

$result = mysqli_query($conn, $sql);

            if ($result && $_FILES['file']['name'] != '') {
                header('Location: admin_customer.php');
            } else {
                $_SESSION['error'] = "กรุณาตรวจสอบข้อมูล";
                header("Location: uploadContract.php?id=".$resultCon);
            }
            
exit();

?>
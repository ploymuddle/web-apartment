<?php 
session_start();
//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$id = $_POST['cust_id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$number = $_POST['tel'];

$password = is_null($_POST['roomId']) ? $_POST['password'] : $_POST['roomId'];

//update customer
$sqlUpdate = "UPDATE customer SET cust_name = '$name' , cust_surname = '$surname' , cust_email = '$email' , cust_tel = '$number' , cust_password = '$password' WHERE cust_id = '$id'  ";

$result = mysqli_query($conn, $sqlUpdate);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                if ($_SESSION['status'] == "user") {
                    header("Location: user_profile.php");
                } else {
                    header("Location: admin_customer.php");
                }
            } else {
                $_SESSION['error'] = "Something went wrong";
                if ($_SESSION['status'] == "user") {
                    header("Location: user_profile.php");
                } else {
                    header("Location: admin_customer.php");
                }
            }

exit();

?>
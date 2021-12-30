<?php 
session_start();
require_once "connection.php";

$name = $_POST['txtName'];
$surname = $_POST['txtSurname'];
$email = $_POST['txtEmail'];
$number = $_POST['txtNumber'];
$password = $_POST['txtPassword'];
$passwordConfirm = $_POST['txtPassConfirm'];
$status = "user";
echo "<script>console.log( 'status: " . $status . "')</script>";
echo "<script>console.log( 'name: " . $name . " , surname: " . $surname . " , email: " . $email . "')</script>";
echo "<script>console.log( 'password: " . $password . " , passwordConfirm: " . $passwordConfirm . "')</script>";

if ($password != $passwordConfirm) {
    header("location:register.php");
}

$query = "INSERT INTO customer (cust_name, cust_surname, cust_tel, cust_email, cust_status, cust_password)
                        VALUE ('$name', '$surname', '$number', '$email', 'U', '$password')";
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: index.php");
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: index.php");
            }

// echo $name;
exit();

?>
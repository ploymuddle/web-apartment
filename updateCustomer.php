<?php 
$conn = mysqli_connect('localhost','root','','myapartment');

$id = $_POST['cust_id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$number = $_POST['tel'];

$username = is_null($_POST['roomId']) ? null: $_POST['roomId'];
$password = is_null($_POST['roomId']) ? null: $_POST['roomId'];

//update customer
$sqlUpdate = "UPDATE customer SET cust_name = '$name' , cust_surname = '$surname' , cust_email = '$email' , cust_tel = '$number' WHERE cust_id = '$id'  ";

if($username != null) {
    $sqlUpdate = $sqlUpdate . " AND cust_password = '$password' ";
}

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
<?php
session_start();
require_once "connection/connection.php";
$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];
$status = $_POST['txtStatus'];

if ($username == 'admin' && $password == '1234' ) {
    $objResult = 'true';
} else {
    $strSQL = "SELECT * FROM customer WHERE cust_status = 'live' AND (cust_username = '" . $username . "' and cust_password = '" . $password . "');";
    $objQuery = mysqli_query($conn, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
}


if (!$objResult) {

    echo "Username and Password ไม่ถูกต้อง!";

} else {

    if ($status == "admin") {
        $_SESSION["id"] = 0;
        $_SESSION["status"] = $status;
        header("location:admin_home.php");
    } else {
        $_SESSION["id"] = $objResult["cust_id"];
        $_SESSION["status"] = $status;
        header("location:user_profile.php");
    }
}
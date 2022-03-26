<?php
session_start();
require_once "connection.php";
$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];
$status = $_POST['txtStatus'];
$mysql = mysqli_connect("localhost","root","123456","myapartment");

if ($status == "admin" && $username == 'admin' && $password == '1234' ) {
    $objResult = 'true';
} else {
    $strSQL = "SELECT * FROM customer WHERE cust_username = '" . $username . "' and cust_password = '" . $password . "';";
    $objQuery = mysqli_query($conn, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
}


if (!$objResult) {
    echo "Username and Password ไม่ถูกต้อง!";
} else {

    if ($status == "admin") {
        $_SESSION["id"] = 0;
        $_SESSION["status"] = $status;
        session_write_close();
        header("location:admin_home.php");
    } else {
        $_SESSION["id"] = $objResult["cust_id"];
        $_SESSION["status"] = $status;
        session_write_close();
        header("location:user_messages.php");
        // header("location:test/user_page.php");
    }
}
	// mysqli_close($mysql);

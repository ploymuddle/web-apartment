<?php
session_start();
require_once "connection.php";
$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];
$status = $_POST['txtStatus'];
$mysql = mysqli_connect("localhost","root","","myapartment");
echo "<script>console.log( '" . $status . "')</script>";

if ($status === "admin") {
    $strSQL = "SELECT * FROM employee WHERE emp_username = '" . $username . "' and emp_password = '" . $password . "';";
} else {
    $strSQL = "SELECT * FROM customer WHERE cust_username = '" . $username . "' and cust_password = '" . $password . "';";
}

echo "<script>console.log( '" . $strSQL . "')</script>";
$objQuery = mysqli_query($conn, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

if (!$objResult) {
    echo "Username and Password ไม่ถูกต้อง!";
} else {

    if ($status == "admin") {
        $_SESSION["id"] = $objResult["emp_id"];
        $_SESSION["status"] = $status;
        session_write_close();
        header("location:admin_home.php");
    } else {
        $_SESSION["id"] = $objResult["cust_id"];
        $_SESSION["status"] = $status;
        session_write_close();
        header("location:user_profile.php");
        // header("location:test/user_page.php");
    }
}
	// mysqli_close($mysql);

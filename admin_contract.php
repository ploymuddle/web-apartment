<?php
session_start();
require_once "../connection.php";
if ($_SESSION['id'] == "") {
	echo "Please Login!";
	exit();
}

if ($_SESSION['status'] != "admin") {
	echo "This page for Admin only!";
	exit();
}

$strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
$objQuery = mysqli_query($conn, $strSQL);
$objResult = mysqli_fetch_array($objQuery);
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<meta http-equiv="X-Compatible" content="ie=edge">
	<title>Contract Manage</title>

	<link rel="stylesheet" href="css/style-admin-home.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <?php include('layout.php'); ?>
</body>
</html>
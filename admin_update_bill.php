<?php
session_start();

//set menu admin page
$page = 'ระบบรับชำระ';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
// require_once "../connection.php";
require_once "connection.php";

//ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
if ($_SESSION['id'] == "") {
    header("location:login.php");
}

//ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
if ($_SESSION['status'] != "admin") {
    echo "This page for Admin only!";
    exit();
}

//คำสั่ง sql ในการดึงข้อมูล
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
    <title><?php echo $page; ?></title>

    <link rel="stylesheet" href="css/style-admin-home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <!-- import menu page -->
    <?php include('admin_menu.php'); ?>

    <div class="job"></div>

    <script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>
</body>

</html>
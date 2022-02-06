<?php
session_start();

//set menu admin page
$page = 'คำขอย้าย';
$_GET['menu'] = $page;
// ----
// //เชื่อมต่อฐานข้อมูล
// // require_once "../connection.php";
// require_once "connection.php";

// //ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
// if ($_SESSION['id'] == "") {
//     header("location:login.php");
// }

// //ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
// if ($_SESSION['status'] != "admin") {
//     echo "This page for Admin only!";
//     exit();
// }

// //คำสั่ง sql ในการดึงข้อมูล
// $strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
// $objQuery = mysqli_query($conn, $strSQL);
// $objResult = mysqli_fetch_array($objQuery);

?>

<!doctype html>
<html>
  <!-- import menu page -->
  <?php include('admin_menu.php'); ?>
  
<body>

    <div class="job"></div>

    <script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>
</body>

</html>
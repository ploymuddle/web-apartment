<?php
session_start();

//set menu admin page
$page = 'หน้าแรก';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
// require_once "../connection.php";
// require_once "connection.php";

//ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
// if ($_SESSION['id'] == "") {
//     header("location:login.php");
// }

//ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
// if ($_SESSION['status'] != "admin") {
// 	echo "This page for Admin only!";
// 	exit();
// }

//คำสั่ง sql ในการดึงข้อมูล
// $strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
// $objQuery = mysqli_query($conn, $strSQL);
// $objResult = mysqli_fetch_array($objQuery);

?>

<!doctype html>
<html>

<!-- <link rel="stylesheet" href="css/style-admin-home.css"> -->
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

	<div class="job">
		<h1 class="title">หน้าแรก</h1>
		<h1>Hello Admin</h1>

		<div class="box">

			<!-- <div class="card-box"> -->
				<div class="show-box grid-4">
					<i class="far fa-address-book"></i>
					<p class="text1">สัญญาใหม่รอการอนุมัติ</p>
					<p class="text2">
						<y1>จำนวน</y1>&nbsp; &nbsp; <a>4</a>&nbsp; &nbsp;<y2>รายการ</y2>
					</p>
					<button><a href="#">ตรวจสอบ</a></button>
				</div>
				<div class="show-box grid-4">
					<i class="far fa-comment-dots"></i>
					<p class="text1">คำร้องแจ้งปัญหาห้องพัก</p>
					<p class="text2">
						<y1>จำนวน</y1><a>&nbsp; &nbsp; <a>1</a>&nbsp; &nbsp;</a>
						<y2>รายการ</y2>
					</p>
					<button><a href="#">ตรวจสอบ</a></button>
				</div>
			<!-- </div> -->

			<div class="grid">
				<div class="show-box grid-4">
					<i class="fas fa-search-dollar"></i>
					<p class="text3">รายการค้างชำระ</p>
					<p class="text4"><a>2</a></p>
				</div>
				<div class="show-box grid-4">
					<i class="fas fa-hotel"></i>
					<p class="text3">จำนวนห้องว่าง</p>
					<p class="text4"><a>10</a>&nbsp;<y>/</y>&nbsp;<a>30</a></p>
				</div>
			</div>

		</div>
	</div>

	<script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>

</body>

</html>
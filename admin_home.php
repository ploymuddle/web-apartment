<?php
session_start();

//set menu admin page
$page = 'หน้าแรก';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
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

//นับจำนวนคำร้องแจ้งปัญหาห้องพัก
$sqlCountMessages = "SELECT COUNT(DISTINCT from_user) AS count FROM messages WHERE isFlagRead = 'N' ;";
$query = mysqli_query($conn, $sqlCountMessages);
$countMessages = mysqli_fetch_assoc($query);

//นับจำนวนรายการค้างชำระ
$sqlCountPayment = "SELECT COUNT(*) AS count FROM payment WHERE pay_status = 'ค้างชำระ' ;";
$query = mysqli_query($conn, $sqlCountPayment);
$countPayment = mysqli_fetch_assoc($query);

//นับจำนวนห้องพัก
$sqlCountRoom = "SELECT (SELECT COUNT(room_status) FROM room ) AS total , (SELECT COUNT(room_status) FROM room WHERE room_status = 'N') AS N ;";
$query = mysqli_query($conn, $sqlCountRoom);
$countRoom = mysqli_fetch_assoc($query);

//นับจำนวนแจ้งขอย้าย
$sqlMove = "SELECT COUNT(*) AS count FROM petition WHERE petition_status = 'ขอย้ายออก' OR petition_status = 'ขอย้ายห้อง';";
$query = mysqli_query($conn, $sqlMove);
$countMove = mysqli_fetch_assoc($query);
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
				<!-- <div class="show-box grid-4">
					<i class="far fa-address-book"></i>
					<p class="text1">สัญญาใหม่รอการอนุมัติ</p>
					<p class="text2">
						<y1>จำนวน</y1>&nbsp; &nbsp; <a>4</a>&nbsp; &nbsp;<y2>รายการ</y2>
					</p>
					<button class="btn"><a href="#">ตรวจสอบ</a></button>
				</div> -->
				<div class="show-box grid-4">
					<i class="far fa-comment-dots"></i>
					<p class="text1">คำร้องแจ้งปัญหาห้องพัก</p>
					<p class="text2">
						<y1>จำนวน</y1><a>&nbsp; &nbsp; <a><?php echo $countMessages['count']; ?></a>&nbsp; &nbsp;</a>
						<y2>รายการ</y2>
					</p>
					<button class="btn"><a href="admin_messages.php" class="text-white">ตรวจสอบ</a></button>
				</div>
				<div class="show-box grid-4">
					<i class="far fa-address-book"></i>
					<p class="text1">คำขอย้าย</p>
					<p class="text2">
						<y1>จำนวน</y1>&nbsp; &nbsp; <a><?php echo $countMove['count']; ?></a>&nbsp; &nbsp;
						<y2>รายการ</y2>
					</p>
					<button class="btn"><a href="approved_to_move.php" class="text-white">ตรวจสอบ</a></button>
				</div>
			<!-- </div> -->

			<div class="grid">
				<div class="show-box grid-4">
					<i class="fas fa-search-dollar"></i>
					<p class="text3">รายการค้างชำระ</p>
					<p class="text4"><a><?php echo $countPayment['count']; ?></a></p>
				</div>
				<div class="show-box grid-4">
					<i class="fas fa-hotel"></i>
					<p class="text3">จำนวนห้องว่าง</p>
					<p class="text4"><a><?php echo $countRoom['N']; ?></a>&nbsp;<y>/</y>&nbsp;<a><?php echo $countRoom['total']; ?></a></p>
				</div>
			</div>

		</div>
	</div>

	<script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>

</body>

</html>
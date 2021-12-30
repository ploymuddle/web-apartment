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
	<title>AP Management....</title>

	<link rel="stylesheet" href="css/style-admin-home.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

	<?php include('layout.php'); ?>

	<div class="job">
		<div class="box">

			<a1>หน้าแรก</a1>
			<a2>Hello Admin</a2>


			<div class="groub">
				<div class="show-box1">
					<i class="far fa-address-book"></i>
					<p class="text1">สัญญาใหม่รอการอนุมัติ</p>
					<p class="text2">
						<y1>จำนวน</y1>&nbsp; &nbsp; <a>4</a>&nbsp; &nbsp;<y2>รายการ</y2>
					</p>
					<li><a href="#">ตรวจสอบ</a></li>
				</div>
				<div class="show-box2">
					<i class="far fa-comment-dots"></i>
					<p class="text1">คำร้องแจ้งปัญหาห้องพัก</p>
					<p class="text2">
						<y1>จำนวน</y1><a>&nbsp; &nbsp; <a>1</a>&nbsp; &nbsp;</a>
						<y2>รายการ</y2>
					</p>
					<li><a href="#">ตรวจสอบ</a></li>
				</div>
			</div>

			<div class="grid-card">
				<div class="show-box3">
					<i class="fas fa-search-dollar"></i>
					<p class="text3">รายการค้างชำระ</p>
					<p class="text4"><a>2</a></p>
				</div>
				<div class="show-box4">
					<i class="fas fa-hotel"></i>
					<p class="text3">จำนวนห้องว่าง</p>
					<p class="text4"><a>10</a>&nbsp;<y>/</y>&nbsp;<a>30</a></p>
				</div>
			</div>

		</div>


	</div>





	<script>
		// คำสั่งสำหลับ show เมนูในปุ่มสามเหลี่ยม
		$('.serv-btn').click(function() {
			$('nav ul .serv-show').toggleClass('show')
			$('nav ul .second').toggleClass('rotate')
		})

		// คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่
		$('nav ul li').click(function() {
			$(this).addClass('active').siblings().removeClass('active')
		})
	</script>
</body>

</html>
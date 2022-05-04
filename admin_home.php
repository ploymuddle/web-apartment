<?php
session_start();

//set menu admin page
$page = 'หน้าแรก';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
require_once "connection/connection.php";

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

<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

	<div class="job">
		<h1 class="title">หน้าแรก</h1>
		<h1>Hello Admin</h1>
		
		<!-- Alert -->
		<?php if(isset($_SESSION['error'])) {?>
        <div class="alert error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>บันทึกข้อมูลไม่สำเร็จ! </strong> <?php echo $_SESSION['error'] ?>
        </div>
       <?php  unset($_SESSION['error']); } ?>

       <?php if(isset($_SESSION['success'])) {?>
        <div class="alert success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>บันทึกข้อมูลสำเร็จ! </strong> <?php echo $_SESSION['success'] ?>
        </div>
       <?php  unset($_SESSION['success']); } ?>
       <!-- Alert -->

		<div class="box home">

			<div class="show-box home-box-100">
				<i class="far fa-comment-dots"></i>
				<p class="text-main">คำร้องแจ้งปัญหาห้องพัก</p>
				<p class="text">
					<y1>จำนวน</y1><a>&nbsp; &nbsp; <a><?php echo $countMessages['count']; ?></a>&nbsp; &nbsp;</a>
					<y2>รายการ</y2>
				</p>
				<button class="btn"><a href="admin_messages.php">ตรวจสอบ</a></button>
			</div>
			<div class="show-box home-box-100">
				<i class="far fa-address-book"></i>
				<p class="text-main">คำขอย้าย</p>
				<p class="text">
					<y1>จำนวน</y1>&nbsp; &nbsp; <a><?php echo $countMove['count']; ?></a>&nbsp; &nbsp;
					<y2>รายการ</y2>
				</p>
				<button class="btn"><a href="approved_to_move.php">ตรวจสอบ</a></button>
			</div>

			<div class="home-row">
				<div class="show-box home-box-50">
					<i class="fas fa-search-dollar"></i>
					<p class="text-main">รายการค้างชำระ</p>
					<p class="text"><a><?php echo $countPayment['count']; ?></a></p>
				</div>
				<div class="show-box home-box-50">
					<i class="fas fa-hotel"></i>
					<p class="text-main">จำนวนห้องว่าง</p>
					<p class="text"><a><?php echo $countRoom['N']; ?></a>&nbsp;<y>/</y>&nbsp;<a><?php echo $countRoom['total']; ?></a></p>
				</div>
			</div>

		</div>
	</div>

	<script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>

</body>

</html>
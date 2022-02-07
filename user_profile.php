<?php
session_start();

//set menu user_profile page
$page = 'ข้อมูลส่วนตัว';
$_GET['menu'] = $page;

// //connect database
// require_once "connection.php";

// //check id ว่ามีการ Login
// if ($_SESSION['id'] == "") {
// 	echo "Please Login!";
// 	exit();
// }

// //check status user
// if ($_SESSION['status'] != "user") {
// 	echo "This page for User only!";
// 	exit();
// }

// //get data in database
// $strSQL = "SELECT * FROM customer WHERE cust_id = '" . $_SESSION['id'] . "' ";
// echo "<script>console.log( '" . $strSQL . "')</script>";

// $objQuery = mysqli_query($conn, $strSQL);
// $objResult = mysqli_fetch_array($objQuery);

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('user_menu.php'); ?>

<body>

	<div class="job">
		<h1 class="title">Profile...</h1>
		<h1>สวัสดีท่านสมาชิก</h1>

		<div class="box">

			<div class="show-box">
				<div class="grid-col">

					<div class="grid-row">
						<div class="grid col-20">
							<label for="roomId"></label>
							<input type="text" id="txtRoomId" name="txtRoomId" placeholder="รหัสสมาชิก" disabled>
						</div>
						<div class="grid col-20">
							<label for="roomId">ชื่อ:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" placeholder="ชื่อ">
						</div>
						<div class="grid col-20">
							<label for="roomId">นามสกุล:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" placeholder="นามสกุล">
						</div>
						<div class="grid col-20">
							<label for="roomId">Email:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" placeholder="Email">
						</div>
						<div class="grid col-20">
							<label for="roomId">เบอร์โทร:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" placeholder="เบอร์โทร">
						</div>
					</div>


					<!-- <div class="d-flex content-right"> -->
						<div class="grid-row grid-start">
							<div class="grid col-end-30">
								<label for="roomId">ชื่อผู้ใช้:</label>
								<input type="text" id="txtRoomId" name="txtRoomId" value="AAA" disabled>
							</div>
							<div class="grid col-end-30">
								<label for="roomId">รหัสผ่าน:</label>
								<input type="text" id="txtRoomId" name="txtRoomId" placeholder="รหัสผ่าน">
							</div>
							<div class="grid col-end-30 ">
								<label for="roomId">กำหนดชำระ:</label>
								<input type="text" id="txtRoomId" name="txtRoomId" value="วันที่ 1" disabled>
							</div>
							<div class="grid col-end-30 ">
								<label for="roomId"></label>
								<button type="submit">แก้ไขข้อมูล</button>
							</div>
						</div>
					<!-- </div> -->

				</div>
			</div>

		</div>
	</div>

	<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
	<script src="js/script.js"></script>
	<!-- <script>
		//  คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่
		$('nav ul li').click(function() {
			$(this).addClass('active').siblings().removeClass('active')
		})
	</script> -->

</body>

</html>
<?php
session_start();

//set menu user_profile page
$page = 'สัญญาเช่า';
$_GET['menu'] = $page;

//connect database
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

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<meta http-equiv="X-Compatible" content="ie=edge">
	<title> <?php echo $page; ?> </title>

	<link rel="stylesheet" href="css/style-customer.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

	<!-- import menu page -->
	<?php include('user_menu.php'); ?>

	<div class="job">
		<h1 class="title">ข้อมูลสัญญาเช่า</h1>
		<div class="box bg-white">

		<div class="grid-col-3">

					<div class="grid-row">
						<div class="full">
							<input type="text" id="txtRoomId" name="txtRoomId" value="AAA" disabled>
						</div>
						<div class="full">
							<input type="text" id="txtRoomId" name="txtRoomId" value="AAA" disabled>
						</div>
						<div class="full">
							<input type="text" id="txtRoomId" name="txtRoomId" value="XXXXXXXX" disabled>
						</div>
						<div class="grid col-30">
							<label for="roomId">วันที่ทำสัญญา:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" value="22/01/2020" disabled>
						</div>
						<div class="grid col-30">
							<label for="roomId">กำหนดชำระ:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" value="วันที่ 1" disabled>
						</div>
					</div>

					<div class="grid-row grid-end">
						<div class="full">

						</div>
						<div class="full">
							<input type="text" id="txtRoomId" name="txtRoomId" value="สกุล" disabled>
						</div>
						<div class="full">
							<input type="text" id="txtRoomId" name="txtRoomId" value="XXXXXXXX" disabled>
						</div>
						<div class="grid col-30">
							<label for="roomId">ประเภทห้อง:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" value="22/01/2020" disabled>
						</div>
						<div class="grid col-30">
							<label for="roomId">ราคาเช่า:</label>
							<input type="text" id="txtRoomId" name="txtRoomId" value="วันที่ 1" disabled>
						</div>
					</div>

					<div class="grid-row">
						<div class="full">
							<textarea id="w3review" name="w3review" placeholder="ข้อมูลห้องพัก"></textarea>
						</div>
					</div>

				</div>
	</div>

		<div class="box">

			<div class="m-0">
			<iframe src="http://thaifranchisedownload.com/dl/group2720110902165538.pdf" width="100%" height="600px">
			</div>


		</div>
	</div>

	<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
	<script src="js/script.js"></script>

</body>

</html>
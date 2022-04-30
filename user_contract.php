<?php
session_start();
require_once "connection/connection.php";

$page = 'สัญญาเช่า';
$_GET['menu'] = $page;

//get customer data in database
$strSQL = "SELECT * FROM customer cu, contract co , room r , room_type rt WHERE cu.cust_id = co.cust_id AND co.room_id = r.room_id  AND r.type_room = rt.type_room   AND cu.cust_id = '" . $_SESSION['id'] . "' ";

$objQuery = mysqli_query($conn, $strSQL);
$objCust = mysqli_fetch_array($objQuery);

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
		<div class="box bg-white m-0">

			<div class="ifm-text-box">

				<div class="ifm-text-col">
					<label>รหัสสมาชิก : </label> <?php echo $objCust['cust_id'] ?>
					<label>ชื่อ-นามสกุล : </label><?php echo $objCust['cust_name'] . " " . $objCust['cust_surname'] ?>
					<label>เบอร์โทร : </label><?php echo $objCust['cust_tel'] ?>
					<label>Email : </label><?php echo $objCust['cust_email'] ?>
					<label>วันที่ทำสัญญา : </label><?php echo $objCust['con_checkin'] ?>
				</div>

				<div class="ifm-text-col">
					<label> ห้อง : </label><?php echo $objCust['room_id'] ?>
					<label> ประเภท : </label><?php echo $objCust['type_room'] ?>
					<label> ค่ามัดจำ : </label><?php echo $objCust['con_deposit'] ?>
					<label> ค่าเช่า : </label><?php echo $objCust['type_rental'] ?>
				</div>

				<div class="ifm-text-row">
					<label>รายละเอียดห้อง : </label><textarea rows="4" cols="20" disabled><?php echo $objCust['type_data'] ?></textarea>
				</div>

			</div>

			<div class="show-pdf m-0">
				<iframe class="pdf-contract" src="file/เอกสารสัญญา_1.pdf" width="100%" height="400vh">
			</div>
		</div>
	</div>

	<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
	<script src="js/script.js"></script>

</body>

</html>
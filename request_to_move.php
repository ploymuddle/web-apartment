<?php
session_start();

//set menu user_profile page
$page = 'แจ้งขอย้าย';
$_GET['menu'] = $page;

//connect database
require_once "connection.php";

//check id ว่ามีการ Login
if ($_SESSION['id'] == "") {
	echo "Please Login!";
	exit();
}

//check status user
if ($_SESSION['status'] != "user") {
	echo "This page for User only!";
	exit();
}

//get customer data in database
$strSQL = "SELECT * FROM customer cu, contract co , room r , room_type rt WHERE cu.cust_id = co.cust_id AND co.room_id = r.room_id  AND r.type_room = rt.type_room   AND cu.cust_id = '" . $_SESSION['id'] . "' ";

$objQuery = mysqli_query($conn, $strSQL);
$objCust = mysqli_fetch_array($objQuery);

//get moveout data in database
$moveSQL = "SELECT * FROM petition WHERE room_id = '" . $objCust['room_id'] . "' ";

$moveQuery = mysqli_query($conn, $moveSQL);
$objMove = mysqli_fetch_array($moveQuery);

//get payment data in database
$paySQL = "SELECT count(*) AS count FROM payment WHERE cust_id = '" . $_SESSION['id'] . "' AND pay_status <> 'ชำระแล้ว' ";

$payQuery = mysqli_query($conn, $paySQL);
$objPay = mysqli_fetch_array($payQuery);

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
		<h1 class="title">ระบบขอย้ายห้อง/ย้ายออก</h1>


		<div class="rtm-box">
			<div class="rtm-text-box">
				<div class="rtm-text-col show-box">
					<label>รหัสสมาชิก : </label> <?php echo $objCust['cust_id'] ?>
					<label>ชื่อ-นามสกุล : </label><?php echo $objCust['cust_name'] . " " . $objCust['cust_surname'] ?>
					<label>เบอร์โทร : </label><?php echo $objCust['cust_tel'] ?>
					<label>Email : </label><?php echo $objCust['cust_email'] ?>
					<label>วันที่ทำสัญญา : </label><?php echo $objCust['con_checkin'] ?>
				</div>

				<div class="rtm-box show-box">
					<div class="rtm-text-col">
						<label> ห้อง : </label><?php echo $objCust['room_id'] ?>
						<label> ประเภท : </label><?php echo $objCust['type_room'] ?>
						<label> ค่ามัดจำ : </label><?php echo $objCust['con_deposit'] ?>
						<label> ค่าเช่า : </label><?php echo $objCust['type_rental'] ?>
					</div>

					<div class="rtm-text-row">
						<label>รายละเอียดห้อง : </label><textarea rows="4" cols="20" disabled><?php echo $objCust['type_data'] ?></textarea>
					</div>
				</div>
			</div>

			<?php if ($objMove['petition_status'] == 'ขอย้ายออก' || $objMove['petition_status'] == 'ขอย้ายห้อง') { ?>
				<div class="show-box box-text bg-move">
					<h1>คุณได้แจ้งขอย้ายแล้ว</h1>
					<h3>รอการตรวจสอบ</h3>
				</div>
			<?php } else if ($objPay['count'] > 0) { ?>
				<div class="show-box box-text bg-alert">
					<h1>คุณมียอดค้างชำระ</h1>
					<a href="user_bill.php">
						<h3>>>กดเพื่อชำระ<< </h3>
					</a>
				</div>
			<?php } else { ?>
				<div class="show-box">
					<form action="insertMoveRoom.php" method="POST">
						<input type="text" id="room" name="room" value="<?php echo $objCust['room_id'] ?>" hidden>
						<input type="text" id="con" name="con" value="<?php echo $objCust['con_id'] ?>" hidden>
						<div class="rtm-text-move">
							<input type="radio" id="moveroom" name="move" value="room">
							<label for="moveroom">ขอย้ายห้อง</label>
						</div>
						<div class="rtm-text-move">
							<input type="radio" id="moveout" name="move" value="out">
							<label for="moveout">ขอย้ายออก</label>
						</div>
						<br>
						<div class="rtm-input-move">
							<label>ระบุสาเหตุการย้าย:</label>
							<textarea type="text" id="detail" name="detail" rows="4" cols="20"></textarea>
						</div>
						<div class="rtm-input-move">
							<label>ระบุวันย้าย:</label>
							<input type="date" id="date" name="date" value="">
						</div>
						<br>
						<div class="btn-save rtm-btn-move">
							<button type="button" class="btn" onclick="window.location='request_to_move.php';">ยกเลิก</button>
							<button type="submit" class="btn">ส่งคำขอ</button>
						</div>
					</form>
				</div>
			<?php } ?>
		</div>

		<script>
			function selectType() {
				var type = document.getElementById("roomType").value;
				console.log(type);
				document.getElementById("roomId").disabled = false;
				ddRoomList(type);
			}

			function ddRoomList(id) {

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {

					if (this.readyState == 4 && this.status == 200) {
						var response = this.response;
						var data = JSON.parse(response);
						console.log(data);

						var option = '<option value="">เลือกรายการ</option>';
						for (var i = 0; i < data.length; i++) {
							option += '<option value="' + data[i].room_id + '">' + data[i].room_id + '</option>';
						}
					}
					$('#roomId').html(option);

				}
				xmlhttp.open("GET", "getRoomList.php?q=" + id, true);
				xmlhttp.send();

			}

			function showDataType(id) {

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {

					if (this.readyState == 4 && this.status == 200) {
						var response = this.response;
						var data = JSON.parse(response);
						console.log(data);
						document.getElementById("roomData").value = data[0].type_data;
						document.getElementById("roomRental").value = data[0].type_rental;
					}
				}
				xmlhttp.open("GET", "getDataType.php?q=" + id, true);
				xmlhttp.send();

			}

			function sendData(id) {

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {

					if (this.readyState == 4 && this.status == 200) {
						var response = this.responseText;
						console.log(response);
					}
				}
				xmlhttp.open("GET", "insertMoveout.php?id=" + id, true);
				xmlhttp.send();
			}
		</script>

		<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
		<script src="js/script.js"></script>

</body>

</html>
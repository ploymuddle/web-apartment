<?php
session_start();

//set menu user_profile page
$page = 'ชำระค่าเช่า';
$_GET['menu'] = $page;

// //connect database
require_once "connection.php";

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

//get customer data in database
$strSQL = "SELECT * FROM customer WHERE cust_id = '" . $_SESSION['id'] . "' ";

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
		<h1 class="title">ระบบชำระค่าเช่า</h1>

		<div class="box-bill">
			<h3>รายการบิลค่าเช่า</h3>
			<div class="grid-bill">
				<?php
				$strSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id AND i.cust_id = '" . $_SESSION['id'] . "' ORDER BY i.inv_date DESC";
				$objQuery = mysqli_query($conn, $strSQL);

				while ($bill = mysqli_fetch_array($objQuery)) {
				?>

					<div class="card-box">
						<p class="">รหัสใบแจ้งหนี้ <?php echo $bill['inv_id']; ?></p>
						<p class="">รหัสใบเสร็จ <?php echo $bill['pay_id']; ?></p>
						<p class="">วันที่ <?php echo $bill['inv_date']; ?></p>
						<img src="https://img.icons8.com/external-smashingstocks-circular-smashing-stocks/100/000000/external-bill-power-and-energy-smashingstocks-circular-smashing-stocks.png" />

						<div class="ifm-text-bill">
							<p class=""><span>ค่าไฟ : </span><?php echo $bill['inv_fire_meter']; ?></p>
							<p class=""><span>ค่าน้ำ : </span><?php echo $bill['inv_water_meter']; ?></p>
							<p class=""><span>ค่าเช่า : </span><?php echo $bill['inv_rental']; ?></p>
							<p class=""><span>รวมเป็นเงิน </span><?php echo $bill['pay_amount']; ?></p>
						</div>
						<a class="button" onclick="showBill(<?php echo $bill['cust_id']; ?>)">ชำระเงิน</a>
					</div>

				<?php } ?>

			</div>
		</div>
	</div>

	<!-- The Modal Bill -->
	<div id="modalBill" class="modal">

		<div class="modal-content show-box">

			<h3>ข้อมูลการชำระ</h3>

			<hr>

			<div class="d-flex content-space-around">
				<p>รหัสลูกค้า : <a id="id"> - </a></p>
				<p>ชื่อลูกค้า : </p>
				<p>ห้องพัก : </p>
			</div>

			<hr>

			<form method="POST">

				<div class="grid-col">
					<div class="">
						<div class="grid form-label">
							<label>ชื่อลูกค้า : </label>
							<input type="text" id="name" name="name" placeholder="ชื่อลูกค้า" value="">
						</div>
						<div class="grid form-label">
							<label>นามสกุล : </label>
							<input type="text" id="surname" name="surname" placeholder="นามสกุล" value="">
						</div>
						<div class="grid form-label">
							<label>เบอร์โทร : </label>
							<input type="text" id="tel" name="tel" placeholder="เบอร์โทร" value="">
						</div>
						<div class="grid form-label">
							<label>Email : </label>
							<input type="text" id="email" name="email" placeholder="Email" value="">
						</div>
					</div>

					<div class="">
						<div class="grid form-label">
							<label>เลขที่ห้องพัก : </label>
							<input type="text" id="roomId" name="roomId" placeholder="เลขที่ห้องพัก" value="" disabled>
						</div>
						<div class="grid form-label">
							<label>ประเภทห้องพัก : </label>
							<input type="text" id="roomType" name="roomType" placeholder="ประเภทห้องพัก" value="" disabled>
						</div>
						<div class="grid form-label">
							<label>ข้อมูลห้องพัก : </label>
							<textarea type="text" id="roomDetail" name="roomDetail" placeholder="ข้อมูลห้องพัก" disabled></textarea>
						</div>
						<div class="grid form-label">
							<label>ราคาค่าเช่า : </label>
							<input type="text" id="roomRent" name="roomRent" placeholder="0.00" disabled>
						</div>
					</div>
				</div>

				<hr>

				<div class="d-flex content-center">
					<button type="button" id="close" class="btn" onclick="window.location='user_bill.php';">ยกเลิก</button>
				</div>

			</form>
		</div>

	</div>
	<!-- End The Modal Bill  -->

	<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
	<script src="js/script.js"></script>
	<script>
		var data;
		var modalBill = document.getElementById("modalBill");
		modalBill.style.display = "none";

		function showBill(id) {

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					var response = this.response;
					var dataBill = JSON.parse(response);
					console.log(dataBill);
					document.getElementById("id").value = dataBill.cust_id;
					document.getElementById("name").value = dataBill.cust_name;
					document.getElementById("surname").value = dataBill.cust_surname;
					document.getElementById("tel").value = dataBill.cust_tel;
					document.getElementById("email").value = dataBill.cust_email;
					modalBill.style.display = "block";
				}
			}
			xmlhttp.open("GET", "getBill.php?q=" + id, true);
			xmlhttp.send();
		}
	</script>

</body>

</html>
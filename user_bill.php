<?php
session_start();

//set menu user_profile page
$page = 'ชำระค่าเช่า';
$_GET['menu'] = $page;

// //connect database
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
				$strSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id AND c.cust_status = 'live'  AND i.cust_id = '" . $_SESSION['id'] . "' ORDER BY i.inv_date DESC";
				$objQuery = mysqli_query($conn, $strSQL);

				while ($bill = mysqli_fetch_array($objQuery)) {
				?>

					<div class="card-box">
						<!-- <p class="">รหัสใบแจ้งหนี้ <?php //echo $bill['inv_id']; 
														?></p> -->
						<p class="">รหัสบิล <?php echo $bill['pay_id']; ?></p>
						<p class="">วันที่ <?php echo $bill['inv_date']; ?></p>
						<img src="https://img.icons8.com/external-smashingstocks-circular-smashing-stocks/100/000000/external-bill-power-and-energy-smashingstocks-circular-smashing-stocks.png" />

						<div class="ifm-text-bill">
							<!-- <p class=""><span>ค่าไฟ : </span><?php //echo $bill['inv_fire_meter']; 
																	?></p> -->
							<!-- <p class=""><span>ค่าน้ำ : </span><?php //echo $bill['inv_water_meter']; 
																	?></p> -->
							<!-- <p class=""><span>ค่าเช่า : </span><?php //echo $bill['inv_rental']; 
																	?></p> -->
							<p class=""><span>ยอดเงิน : </span><?php echo $bill['inv_total']; ?></p>
							<p class=""><span>หมายเลขห้องพัก : </span><?php echo $bill['room_id']; ?></p>
							<p class=""><span>รหัสลูกค้า : </span><?php echo $bill['cust_id']; ?></p>
							<p class=""><span>ชื่อลูกค้า : </span><?php echo $bill['cust_name'] . " " . $bill['cust_surname']; ?></p>
						</div>
						<?php if ($bill['pay_status'] == "ค้างชำระ") { ?>
							<a class="button status-red" onclick="showBill(<?php echo $bill['inv_id']; ?>)"><?php echo $bill['pay_status']; ?></a>
						<?php } else if ($bill['pay_status'] == "ชำระแล้ว") { ?>
							<a class="button status-green" onclick="showBill(<?php echo $bill['inv_id']; ?>)"><?php echo $bill['pay_status']; ?></a>
						<?php } else { ?>
							<a class="button status-gray" onclick="showBill(<?php echo $bill['inv_id']; ?>)"><?php echo $bill['pay_status']; ?></a>
						<?php } ?>
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

			<div class="modal-bill-header">
				<p>รหัสบิลค่าเช่า : <a id="id"> - </a></p>
				<p>วันที่ : <a id="date"> - </a></p>
			</div>

			<hr>

			<form id="form-slip"  method="POST" action="updateSlip.php" enctype="multipart/form-data">

				<div class="modal-bill-content">
					<div class="img-bill-slip">
						<img id="picSilp" style="width:200px;height:100%;">
							<input type="file" id="img" name="img" accept="image/*">
							<label for="img" id="textImg">กรุณาแนบหลักฐานการชำระเงิน</label>
					</div>

					<div class="">
						<img id="picPayment" style="width:300px;height:100%;" src="https://www.scb.co.th/content/dam/scb/personal-banking/digital-banking/scb-easy/how-to/qr-code/qr-code-generated-7.jpg">
					</div>

					<div class="">

						<div class="" id="statusBill"></div>

						<div class="grid form-label">
							<label>รหัสบิล : </label>
							<input type="text" id="billID" name="billID" placeholder="เลขที่ห้องพัก" value="" readonly>
						</div>
						<div class="grid form-label">
							<label>ยอดเงิน : </label>
							<input type="text" id="payment" name="payment" placeholder="ประเภทห้องพัก" value="" disabled>
						</div>
						<div class="grid form-label">
							<label>หมายเลขห้องพัก : </label>
							<input type="text" id="roomID" name="roomID" placeholder="ข้อมูลห้องพัก" disabled>
						</div>
						<div class="grid form-label">
							<label>รหัสลูกค้า : </label>
							<input type="text" id="custID" name="custID" placeholder="ชื่อลูกค้า" value="" disabled>
						</div>
						<div class="grid form-label">
							<label>ชื่อลูกค้า : </label>
							<input type="text" id="name" name="name" placeholder="ชื่อลูกค้า" value="" disabled>
						</div>
						<div class="grid form-label">
							<label>หมายเลขสัญญาเช่า : </label>
							<input type="text" id="conID" name="conID" placeholder="เบอร์โทร" value="" disabled>
						</div>
						<div class="d-flex content-center">
							<button type="submit" id="submit" class="btn" value="Submit">ยืนยันการชำระเงิน</button>
							<button type="button" class="btn btn-download" id="bill"></button>
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
					var data = JSON.parse(response);
					var dataBill = data[0];
					console.log(dataBill);
					document.getElementById("id").innerHTML = dataBill.pay_id;
					document.getElementById("date").innerHTML = dataBill.inv_date;
					document.getElementById("billID").value = dataBill.pay_id;
					document.getElementById("payment").value = dataBill.inv_total;
					document.getElementById("roomID").value = dataBill.room_id;
					document.getElementById("custID").value = dataBill.cust_id;
					document.getElementById("name").value = dataBill.cust_name + ' ' + dataBill.cust_surname;
					document.getElementById("conID").value = dataBill.con_id;

					document.getElementById("picSilp").src = 'https://img.icons8.com/external-vitaliy-gorbachev-blue-vitaly-gorbachev/100/000000/external-invoice-home-office-vitaliy-gorbachev-blue-vitaly-gorbachev.png';
					document.getElementById("picSilp").style.width = "90px";

					if (dataBill.pay_slip == '' || dataBill.pay_slip == null) {
						document.getElementById("picSilp").src = 'https://img.icons8.com/external-vitaliy-gorbachev-blue-vitaly-gorbachev/100/000000/external-invoice-home-office-vitaliy-gorbachev-blue-vitaly-gorbachev.png';
						document.getElementById("picSilp").style.width = "90px";
					} else {
						document.getElementById("picSilp").src = dataBill.pay_slip;
						document.getElementById("picSilp").style.width = "300px"
						document.getElementById("img").style.display = "none";
						document.getElementById("img").disabled = true;
						document.getElementById("textImg").innerHTML = "หลักฐานการชำระเงิน";
					}

					if (dataBill.pay_status == 'รอดำเนินการ') {
						document.getElementById("statusBill").innerHTML = dataBill.pay_status;
						document.getElementById("statusBill").className = 'status-gray';

						document.getElementById("submit").hidden = true;
						document.getElementById("submit").disabled = true;
						document.getElementById("bill").hidden = false;
						document.getElementById("bill").disabled = true;

						var btnDB = document.getElementById('bill');
						var aDB = document.createElement('a');
						aDB.innerHTML = ' ใบเสร็จ';
						aDB.setAttribute('class', 'text-white');
						btnDB.appendChild(aDB);

					} else if (dataBill.pay_status == 'ค้างชำระ') {
						document.getElementById("statusBill").innerHTML = dataBill.pay_status;
						document.getElementById("statusBill").className = 'status-red';

						document.getElementById("bill").style.display = "none";

					} else {
						document.getElementById("statusBill").innerHTML = dataBill.pay_status;
						document.getElementById("statusBill").className = 'status-green';

						document.getElementById("submit").hidden = true;
						document.getElementById("submit").disabled = true;
						document.getElementById("bill").hidden = false;

						var btnDB = document.getElementById('bill');
						var aDB = document.createElement('a');
						aDB.innerHTML = ' ใบเสร็จ';
						aDB.setAttribute('href', 'billFile.php?id=' + dataBill.pay_id);
						aDB.setAttribute('class', 'text-white');
						aDB.setAttribute('target', '_blank');
						btnDB.appendChild(aDB);
					}

					modalBill.style.display = "block";
				}
			}
			xmlhttp.open("GET", "getBillDetail.php?q=" + id, true);
			xmlhttp.send();
		}
	</script>

</body>

</html>
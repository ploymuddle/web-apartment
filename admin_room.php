<?php
session_start();

//set menu admin page
$page = 'จัดการห้องพัก';
$_GET['menu'] = $page;
// ----
// //เชื่อมต่อฐานข้อมูล
// // require_once "../connection.php";
require_once "connection.php";

// //ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
// if ($_SESSION['id'] == "") {
//     header("location:login.php");
// }

// //ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
// if ($_SESSION['status'] != "admin") {
// 	echo "This page for Admin only!";
// 	exit();
// }

// //คำสั่ง sql ในการดึงข้อมูล
// $strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
// $objQuery = mysqli_query($conn, $strSQL);
// $objResult = mysqli_fetch_array($objQuery);


$roomTypeSQL = "SELECT * FROM room_type ";
$roomTypeQuery = mysqli_query($conn, $roomTypeSQL);



?>


<!doctype html>
<html>
<!-- <link rel="stylesheet" href="css/style-admin-room.css"> -->
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

	<div class="job">
		<h1 class="title">จัดการห้องพัก</h1>
		<div class="box">
			<div class="d-flex content-right">
				<button class="btn-add" type="submit" onclick="document.location.href='admin_addroom.php'"> เพิ่มห้องพัก</button>
			</div>

			<!-- <div class="groub"> -->
			<?php while ($roomType = mysqli_fetch_array($roomTypeQuery)) {
				$countSQL = "SELECT ";
				$countSQL = $countSQL . "(SELECT COUNT(*) FROM room WHERE type_room = '" . $roomType['type_room'] . "') AS countTotal ";
				$countSQL = $countSQL . ", (SELECT COUNT(*) FROM room WHERE type_room = '" . $roomType['type_room'] . "' AND room_status = 'N') AS countN";
				$countQuery = mysqli_query($conn, $countSQL);
				$count = mysqli_fetch_array($countQuery);
			?>

				<div class="show-box grid-6">
					<img src="<?php echo $roomType["type_picture"]; ?>" alt="room">
					<p class="text1"><?php echo $roomType["type_room"]; ?></p>
					<p class="text2">รายการห้องว่าง</p>
					<p class="text3"><a><?php echo $count["countN"]; ?></a>&nbsp;<y>/</y>&nbsp;<a><?php echo $count["countTotal"]; ?></a></p>

					<button href="#" class="btn-show" onclick="showData('<?php echo $roomType['type_room']; ?>')">แสดง</button>
					<button href="#" class="btn-update" onclick="editData('<?php echo $roomType['type_room']; ?>')">แก้ไขข้อมูล</button>

				</div>

			<?php } ?>
			<!-- </div> -->
		</div>
	</div>


	<!-- The Modal Data -->
	<div id="modalData" class="modal">

		<!-- Modal content -->
		<div class="modal-content show-box">

			<h3>แสดงข้อมูลห้องพัก</h3>

			<hr>

			<div class="d-flex content-space-around">
				<p>ประเภท : <a id="type"> - </a></p>
				<p>ราคา : <a id="rental"> - </a></p>
			</div>

			<div class="d-flex content-space-around">
				<p class="text-detail">รายละเอียด : <a id="data"> - </a></p>
			</div>

			<hr>

			<table class="table" id="table">
				<thead>
					<tr>
						<th>ลำดับ</th>
						<th>เลขที่ห้อง</th>
						<th>สถานะ</th>
						<th>ปรับปรุง</th>
					</tr>
				</thead>
				<tbody id="divResult">
				</tbody>
			</table>
			<div class="d-flex content-center">
				<button type="submit" onclick="document.location.href='admin_room.php'">ปิด</button>
			</div>

		</div>

	</div>
	<!-- End The Modal Data  -->


	<!-- The Modal Edit -->
	<div id="modalEdit" class="modal">

		<!-- Modal content -->
		<div class="modal-content show-box">

			<h3>แก้ไขข้อมูลประเภทห้องพัก</h3>
			<br>
			<form method="POST" action="updateDataType.php" enctype="multipart/form-data">
			<div class="grid-col">
				
				<div class="">
					<div class="grid col-30">
						<label for="roomType">ประเภทห้องพัก :</label>
						<input id="roomType" name="roomType" placeholder="ประเภทห้องพัก" readonly="readonly">
					</div>
					<div class="grid col-30">
						<label for="roomData"></label>
						<textarea id="roomData" name="roomData" rows="4" cols="50" placeholder="ข้อมูลห้องพัก" ></textarea>
					</div>
					<div class="grid col-30">
						<label for="roomRental">ราคาค่าเช่า :</label>
						<input type="text" id="roomRental" name="roomRental" placeholder="0.00" >
					</div>
				</div>
				<div class="d-flex content-center f-column">
					<div class="grid">
					<img id="pic" alt="room">
					</div>
					<div class="grid col-20">
						<label for="pic">รูปภาพ :</label>
						<input type="file" id="pic" name="pic" class="bg-white">
					</div>
				</div>
			</div>

			<div class="d-flex content-center my-20">
				<button type="button" onclick="document.location.href='admin_room.php'">ยกเลิก</button>
				<button type="submit" onclick="document.location.href='admin_room.php'">บันทึก</button>
			</div>

			</form>
		</div>

	</div>
	<!-- End The Modal Edit  -->

	<script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>
	<script>
		let data;
		var modalData = document.getElementById("modalData");
		modalData.style.display = "none";
		var modalEdit = document.getElementById("modalEdit");
		modalEdit.style.display = "none";

		function showData(type) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					var response = this.response;
					var data = JSON.parse(response);
					console.log(data);

					document.getElementById("type").innerText = data[0].type_room;
					document.getElementById("rental").innerText = data[0].type_rental;
					document.getElementById("data").innerText = data[0].type_data;


					modalData.style.display = "block";

					var table = '';
					for (var i = 0; i < data.length; i++) {
						table += '<tr><td>' + (i + 1) + '</td>';
						table += '<td type="text" id="roomId" name="roomId">' + data[i].room_id + '</td>';
						table += '<td style=' + (data[i].room_status == 'C' ? '"color:red;" > ปิดปรับปรุง' : (data[i].room_status == 'N' ? '"color:green;" > ว่าง' : '"color:#888888;"> ไม่ว่าง')); + '</td></tr>';
						table += '<td><a href="#" class="button" onclick="editRoom(\'' + data[i].room_id + '\',\'' + data[i].type_room + '\')"><i class="fas fa-power-off"  id="icon" style="font-size:20px;"></i></a>&nbsp;<a id="btnSave"></a></td>';
					}

				}
				$('#divResult').html(table);
			}
			xmlhttp.open("GET", "getRoomType.php?q=" + type, true);
			xmlhttp.send();

		}

		function editRoom(id, type) {
			updateStatus(id, type)
		}

		function updateStatus(id, type) {

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					var response = this.responseText;
					console.log(response);
					showData(type);
				}
			}
			xmlhttp.open("GET", "updateRoomStatus.php?q=" + id, true);
			xmlhttp.send();


		}

		function editData(type) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					var response = this.response;
					var data = JSON.parse(response);
					console.log(data);

					document.getElementById("roomType").value = data[0].type_room;
					document.getElementById("roomRental").value = data[0].type_rental;
					document.getElementById("roomData").value = data[0].type_data;
					document.getElementById("pic").src = data[0].type_picture;

					modalEdit.style.display = "block";

				}
			}
			xmlhttp.open("GET", "getDataType.php?q=" + type, true);
			xmlhttp.send();

		}
	</script>
</body>

</html>
<?php
session_start();
require_once "connection/connection.php";

$page = 'จัดการห้องพัก';
$_GET['menu'] = $page;

$roomTypeSQL = "SELECT * FROM room_type ";
$roomTypeQuery = mysqli_query($conn, $roomTypeSQL);

?>


<!doctype html>
<html>

<?php include('admin_menu.php'); ?>

<body>

	<div class="job">
		<h1 class="title">จัดการห้องพัก</h1>
		<div class="box">
			<div class="box-btn-add">
				<button class="btn btn-add" type="submit" onclick="document.location.href='admin_addroom.php'"> เพิ่มห้องพัก</button>
			</div>

			<?php while ($roomType = mysqli_fetch_array($roomTypeQuery)) {
				$countSQL = "SELECT ";
				$countSQL = $countSQL . "(SELECT COUNT(*) FROM room WHERE type_room = '" . $roomType['type_room'] . "') AS countTotal ";
				$countSQL = $countSQL . ", (SELECT COUNT(*) FROM room WHERE type_room = '" . $roomType['type_room'] . "' AND room_status = 'N') AS countN";
				$countQuery = mysqli_query($conn, $countSQL);
				$count = mysqli_fetch_array($countQuery);
			?>

				<div class="show-box grid-6">
					<img id="room" src="<?php echo $roomType["type_picture"]; ?>" alt="room">
					<p class="text-main"><?php echo $roomType["type_room"]; ?></p>
					<p class="text">รายการห้องว่าง</p>
					<p class="text"><a><?php echo $count["countN"]; ?></a>&nbsp;<y>/</y>&nbsp;<a><?php echo $count["countTotal"]; ?></a></p>

					<button href="#" class="btn btn-show" onclick="showData('<?php echo $roomType['type_room']; ?>')">แสดง</button>
					<button href="#" class="btn btn-update" onclick="editData('<?php echo $roomType['type_room']; ?>')">แก้ไขข้อมูล</button>

				</div>

			<?php } ?>
		</div>
	</div>


	<!-- The Modal Data -->
	<div id="modalData" class="modal">

		<!-- Modal content -->
		<div class="modal-content show-box">

			<h3>แสดงข้อมูลห้องพัก</h3>

			<hr>

			<div class="room-text-row">
				<p>ประเภท : <a id="type"> - </a></p>
				<p>ราคา : <a id="rental"> - </a></p>
			</div>

			<div class="room-text-row">
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
			<div class="box-btn-center">
				<button class="btn" type="submit" onclick="document.location.href='admin_room.php'">ปิด</button>
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
			<div class="room-box">
				
				<div class="">
					<div class="room-box-text">
						<label for="roomType">ประเภทห้องพัก :</label>
						<input id="roomType" name="roomType" placeholder="ประเภทห้องพัก" readonly="readonly" required>
					</div>
					<div class="room-box-text">
						<label for="roomData"></label>
						<textarea id="roomData" name="roomData" rows="4" cols="50" placeholder="ข้อมูลห้องพัก" required></textarea>
					</div>
					<div class="room-box-text">
						<label for="roomRental">ราคาค่าเช่า :</label>
						<input type="text" id="roomRental" name="roomRental" placeholder="0.00" required>
					</div>
				</div>
				<div class="room-box-img">
					<div>
						<img id="pic" alt="room">
					</div>
					<div class="room-input-img">
						<label for="pic">รูปภาพ :</label>
						<input type="file" id="pic" name="pic" class="bg-white" accept="image/png, image/jpeg">
					</div>
				</div>
			</div>

			<div class="box-btn-center my-20">
				<button class="btn" type="button" onclick="document.location.href='admin_room.php'">ยกเลิก</button>
				<button class="btn" type="submit" onclick="document.location.href='admin_room.php'">บันทึก</button>
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
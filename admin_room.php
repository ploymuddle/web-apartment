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
					<button href="#" class="btn-update">แก้ไขข้อมูลห้องพัก</button>

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

			<div class="content-space-around">
				<p>ประเภท : <a id="type"> - </a></p>
				<p>ราคา : <a id="rental"> - </a></p>
			</div>

			<hr>

			<table class="table" id="table">
				<thead>
					<tr>
						<th>ลำดับ</th>
						<th>เลขที่ห้อง</th>
						<th>รายละเอียด</th>
						<th>สถานะ</th>
						<th>แก้ไข</th>
					</tr>
				</thead>
				<tbody id="divResult">
				</tbody>
			</table>
			<div class="content-center">
				<button type="submit" onclick="document.location.href='admin_addroom.php'">เพิ่มห้องพัก</button>
			</div>

		</div>

	</div>
	<!-- End The Modal Data  -->

	<script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>
	<script>
		let data;
		var modalData = document.getElementById("modalData");
		modalData.style.display = "none";

		function showData(type) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					var response = this.response;
					var data = JSON.parse(response);
					console.log(data);

					document.getElementById("type").innerText = data[0].type_room;
					document.getElementById("rental").innerText = data[0].type_rental;

					modalData.style.display = "block";

					var table = '';
					for (var i = 0; i < data.length; i++) {
						table += '<tr><td>' + (i + 1) + '</td>';
						table += '<td>' + data[i].room_id + '</td>';
						table += '<td><textarea type="text" id="roomDetail" name="roomDetail" disabled>' + data[i].room_data + '</textarea></td>';
						table += '<td style=' + (data[i].room_status == 'N' ? '"color:green;"> ว่าง' : '"color:#888888;"> ไม่ว่าง'); + '</td></tr>';
						table += '<td><a href="#" class="button" onclick="edit(this)"> <i class="fas fa-edit"  id="icon" style="font-size:20px;"></i></a>&nbsp;<a id="btnSave"></a></td>';
					}

				}
				$('#divResult').html(table);
			}
			xmlhttp.open("GET", "getRoomType.php?q=" + type, true);
			xmlhttp.send();

		}

		function edit(x) {
			var data = document.getElementById("roomDetail").innerHTML;
			if (document.getElementById("roomDetail").disabled == true) {
				document.getElementById("roomDetail").disabled = false;
				var btn = document.getElementById('btnSave');
				var a = document.createElement('a');
				a.innerHTML = '<i class="fas fa-save" style="font-size:20px;"></i>';
  				a.href = "#";
				a.onclick = 'save('+document.getElementById("roomDetail").value+')';
				btn.appendChild(a);
				
				document.getElementById("roomDetail").disabled = false;
				x.querySelector('i').classList.remove('fa-edit');
				x.querySelector('i').classList.add('fa-window-close');
			} else {
				document.getElementById("roomDetail").value = data;
				document.getElementById("roomDetail").disabled = true;
				x.querySelector('i').classList.remove('fa-window-close');
				x.querySelector('i').classList.add('fa-edit');
				x.querySelector('i').classList.remove('fa-save');
			}

		}
	</script>
</body>

</html>
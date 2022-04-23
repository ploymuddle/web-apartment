<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<meta http-equiv="X-Compatible" content="ie=edge">
	<title>AP Management</title>

	<link rel="stylesheet" href="css/style-index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

	<header>
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<a href="index.php">AP Management.</a>
				</div>
				<a href="#" class="bar">
					<i class="fas fa-bars"></i>
				</a>
				<nav>
					<ul>
						<li><a href="index.php" class="btn-home active">HOME</a></li>
						<!-- <li><a href="register.php" class="btn-signup">Sign..UP</a></li> -->
						<li><a href="login.php" class="btn-login">LOG IN</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>

	<div class="content">
		<div class="header">
			<h3><i class="fas fa-laptop-house"></i>&nbsp;</h3>
			<h3>&nbsp;</h3>
			<h3>Welcome</h3>
			<h1>To</h1>
			<h1>Website...</h1>

			<p>ลูกค้าใหม่กรุณาสมัครสมาชิก สำหลับเข้าใช้งาน </p>
			<p>ขอให้ทุกท่าน มีความสุขตลอดการใช้บริการของเรา </p>
		</div>

		<div class="grid-card">
			<?php
			require_once "connection.php";
			$roomTypeSQL = "SELECT * FROM room_type ";
			$roomTypeQuery = mysqli_query($conn, $roomTypeSQL);
			while ($roomType = mysqli_fetch_array($roomTypeQuery)) {
			?>
				<div class="box " style="background-image: url('<?php echo $roomType["type_picture"]; ?>');" onclick="showData('<?php echo $roomType['type_room']; ?>')">
					<a>
						<h2>Room <?php echo $roomType["type_room"]; ?></h2>
						<h5><?php echo $roomType["type_rental"]; ?> / month</h5>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>

	<!-- The Modal Data -->
	<div id="modalData" class="modal">

		<!-- Modal content -->
		<div class="modal-content show-box">

			<div class="modal-header">
				<h2 id="type"></h2>
			</div>


			<div class="modal-text">
				<hr>
				<p id="data"></p>
				<p id="rental"></p>
				<hr>

				<div id="divResult" class="modal-result"></div>
			</div>

			<div class="modal-footer">
				<a onclick="window.location='index.php';" class="link-2"></a>
			</div>
		</div>

	</div>
	<!-- End The Modal Data  -->

	<footer>
		<p>Copyright &copy; 2021 ! AP Management.</p>
	</footer>

	<script src="js/script.js"></script>
	<script>
		var data;
		var modalData = document.getElementById("modalData");
		modalData.style.display = "none";

		function showData(id) {

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {

				if (this.readyState == 4 && this.status == 200) {
					var response = this.response;
					data = JSON.parse(response);
					console.log(data);

					document.getElementById("type").innerText = 'Room ' + data[0].type_room;
					document.getElementById("data").innerText = 'ข้อมูลห้องพัก: ' + data[0].type_data;
					document.getElementById("rental").innerText = 'ราคา: ' + data[0].type_rental;
					modalData.style.display = "block";

					for (var i = 0; i < data.length; i++) {
						var img = document.createElement('img');
						img.width = 50;
						if (data[i].room_status == 'N'){
							img.src = 'https://img.icons8.com/material-rounded/64/76D7C4/door.png';
						} else {
							img.src = 'https://img.icons8.com/material-rounded/64/C0392B/door.png';
						}

						let textSpan = document.createElement("span");
						textSpan.innerHTML = data[i].room_id;

						var div = document.createElement('div');

						div.append(img)
						div.append(textSpan)
						document.getElementById('divResult').appendChild(div);

					}

				}
			}
			xmlhttp.open("GET", "getRoomType.php?q=" + id, true);
			xmlhttp.send();
		}
	</script>
</body>

</html>
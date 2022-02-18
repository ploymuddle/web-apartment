<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<meta http-equiv="X-Compatible" content="ie=edge">
	<title>AP Management....</title>

	<link rel="stylesheet" href="css/style1.css">
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
						<li><a href="index.php" class="btn-home active" >HOME</a></li>
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
				<div class="box " style="background-image: url('<?php echo $roomType["type_picture"]; ?>');">
					<a href="#">
						<h2>Room <?php echo $roomType["type_room"]; ?></h2>
						<h5><?php echo $roomType["type_rental"]; ?> / month</h5>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>

	<footer>
		<p>Copyright &copy; 2021 ! AP Management.</p>
	</footer>



	<script src="js/script.js"></script>

</body>

</html>
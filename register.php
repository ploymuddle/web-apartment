<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<meta http-equiv="X-Compatible" content="ie=edge">
	<title>AP Management....</title>

	<link rel="stylesheet" href="css/stylesignup.css">


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

	<header>
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<g>AP Management.</g>
				</div>
				<a href="#" class="bar">
					<i class="fas fa-bars"></i>
				</a>
				<nav>
					<ul>
						<li><a href="index.php" class="btn-home">Home</a></li>
						<li><a href="register.php" class="btn-signup">Sign..UP</a></li>
						<li><a href="login.php" class="btn-login">Log..IN</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>

	<body2>
		<div class="con">
			<div class="title">Sign UP</div>

			<div class="content">
				<form action="check_register.php" method="Post">
					<div class="user-details">
						<div class="input-box">
							<span class="details">ชื่อ</span>
							<input type="text" name="txtName" id="txtName" placeholder="Enter your name" required />
						</div>
						<div class="input-box">
							<span class="details">นามสกุล</span>
							<input type="text" name="txtSurname" id="txtSurname" placeholder="Enter your surname" required />
						</div>
						<div class="input-box">
							<span class="details">Email</span>
							<input type="email" name="txtEmail" id="txtEmail" placeholder="Enter your email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
						</div>
						<div class="input-box">
							<span class="details">เบอร์มือถือ</span>
							<input type="tel" name="txtNumber" id="txtNumber" placeholder="Enter your number" required pattern="[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$"/>
						</div>
						<div class="input-box">
							<span class="details">รหัสผ่าน</span>
							<input type="password" name="txtPassword" id="txtPassword" placeholder="Enter your password" oninput='check();' required />
						</div>
						<div class="input-box">
							<span class="details">ยืนยันรหัสผ่าน</span>
							<input type="password" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirm your password" oninput='check();' required />
							<span class='message' id='message'></span>
						</div>
					</div>

					<div class="button">
						<input type="submit" value="ยืนยันการลงทะเบียน">
					</div>
				</form>
			</div>
		</div>
	</body2>

	<footer>
		<p>Copyright &copy; 2021 ! AP Management.</p>
	</footer>

	<script src="js/script.js"></script>
	<script>
		var check = function() {
			if (document.getElementById('txtPassword').value == '' || document.getElementById('txtPassConfirm').value == '') {
				document.getElementById('message').innerHTML = '';
			} else if (document.getElementById('txtPassword').value == document.getElementById('txtPassConfirm').value) {
				document.getElementById('message').style.color = 'green';
				document.getElementById('message').innerHTML = 'รหัสผ่านตรงกัน';
			} else {
				document.getElementById('message').style.color = 'red';
				document.getElementById('message').innerHTML = 'กรุณากรอกรหัสผ่านให้ตรงกัน';
			}
		}
	</script>

</body>

</html>
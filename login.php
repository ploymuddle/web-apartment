<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<meta http-equiv="X-Compatible" content="ie=edge">
<title>AP Management....</title>


<link rel="stylesheet" href="css/stylelogin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
</head>

<body>
	
	<header>
		<div class="container">
			<div class="navbar">
				<div class="logo">
					<g >AP Management.</g>
				</div>
					<a href="#" class="bar">
						<i class="fas fa-bars"></i>
					</a>
				<nav>
					<ul>
						<li><a href="index.php" class="btn-home">HOME</a></li>
						<li><a href="login.php" class="btn-login active">LOG IN</a></li>			
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
			
	<form action="check_login.php" method="Post" class="card">
		<div class="log-in">Log IN</div>
		<i id="logo" class="fas fa-user-circle"></i> <!-- Logo -->
			
			<!-- username -->
			<div class="login-form">
				<i class="fas fa-house-user" id="logo-user"></i>  
				<input type="text" class="input" id="txtUsername" name="txtUsername"> 
			</div>
			
			<!-- password -->
			<div class="login-form">
				<i class="fas fa-unlock-alt" id="logo-password"></i>
				<input type="password" class="input" id="txtPassword" name="txtPassword"> 			
			</div>
		
		
			<div class="select">
				<select name="txtStatus" id="txtStatus">
					<option selected disabled>กรุณาเลือกสถานะ</option>
					<option value="user">User</option>
					<option value="admin">Admin</option>
				</select>
			</div>
		
				<!-- <y>Don 't have account ?&nbsp; &nbsp;  <a href="register.php" >Sign UP</a></y> -->
				<input type="submit" class="btn-submit" value="เข้าสู่ระบบ">
		
	</form>
	</div>
	
<footer>
	<p>Copyright &copy; 2021 ! AP Management.</p>
</footer>
	

	
	<script src="js/script.js"></script>

</body>
</html>

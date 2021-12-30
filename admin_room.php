<?php
session_start();

//set menu admin page
$page = 'จัดการห้องพัก';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
// require_once "../connection.php";
require_once "connection.php";

//ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
if ($_SESSION['id'] == "") {
    header("location:login.php");
}

//ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
if ($_SESSION['status'] != "admin") {
	echo "This page for Admin only!";
	exit();
}

//คำสั่ง sql ในการดึงข้อมูล
$strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
$objQuery = mysqli_query($conn, $strSQL);
$objResult = mysqli_fetch_array($objQuery);
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<meta http-equiv="X-Compatible" content="ie=edge">
<title><?php echo $page; ?></title>

<link rel="stylesheet" href="css/style-admin-room.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
<!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	
</head>

<body>

	<!-- import menu page -->
	<?php include('admin_menu.php'); ?>
	
	<div class="job">
		<div class="box">
		
			<a1>จัดการห้องพัก</a1>
			
				<div class="groub">
          				<div class="box-room1">
							<div class="room1-icon"></div>
							<p class="text1">Room1</p> 
							<p class="text2">รายการห้องว่าง</p> 
							<p class="text3"><a>3</a>&nbsp;<y>/</y>&nbsp;<a>10</a></p>
							
							<ul>
								<li><a href="#" class="btn-show">แสดง</a></li>
								<li><a href="#" class="btn-update">แก้ไขข้อมูลห้องพัก</a></li>
							</ul>  	
          				</div>
					    <div class="box-room2">
							<div class="room2-icon"></div>
							<p class="text1">Room2</p> 
							<p class="text2">รายการห้องว่าง</p> 
							<p class="text3"><a>6</a>&nbsp;<y>/</y>&nbsp;<a>10</a></p>
							
							<ul>
								<li><a href="#" class="btn-show">แสดง</a></li>
								<li><a href="#" class="btn-update">แก้ไขข้อมูลห้องพัก</a></li>
							</ul> 	
          				</div>
						<div class="box-room3">
							<div class="room3-icon"></div>
							<p class="text1">Room3</p> 
							<p class="text2">รายการห้องว่าง</p> 
							<p class="text3"><a>2</a>&nbsp;<y>/</y>&nbsp;<a>5</a></p>
							
							<ul>
								<li><a href="#" class="btn-show">แสดง</a></li>
								<li><a href="#" class="btn-update">แก้ไขข้อมูลห้องพัก</a></li>
							</ul>  	
          				</div>
						<div class="box-room4">
							<div class="room4-icon"></div>
							<p class="text1">Room4</p> 
							<p class="text2">รายการห้องว่าง</p> 
							<p class="text3"><a>5</a>&nbsp;<y>/</y>&nbsp;<a>5</a></p>
							
							<ul>
								<li><a href="#" class="btn-show">แสดง</a></li>
								<li><a href="#" class="btn-update">แก้ไขข้อมูลห้องพัก</a></li>
							</ul>  	
          				</div>
					
        		</div>
		
		</div>
	</div>
	
	<script src="js/script-dropdown.js"></script>
	<script src="js/script.js"></script>
</body>
	
</html>	
	
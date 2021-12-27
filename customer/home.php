<?php
	session_start();
    require_once "../connection.php";
	if($_SESSION['id'] == "")
	{
		echo "Please Login!";
		exit();
	}

	if($_SESSION['status'] != "user")
	{
		echo "This page for User only!";
		exit();
	}	

	$strSQL = "SELECT * FROM customer WHERE cust_id = '".$_SESSION['id']."' ";
    echo "<script>console.log( '" . $strSQL . "')</script>";

	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<meta http-equiv="X-Compatible" content="ie=edge">
<title>AP Management....</title>

<link rel="stylesheet" href="css/style-customer-home.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
<!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	
</head>
 
<body>
	
	<div class="out">
		
		<i href="#" class="fas fa-sign-out-alt"></i>
		<!--< <span class="fas fa-bars"></span> >-->    
    </div>
	
	<nav class="menubar">
        <div class="header">
			
			<i id="logo" class="fas fa-users"></i> <!-- --> <!-- Logo -->
        <!--    <div class="header-img">
                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=80&q=80" alt="">
            </div> -->
			
            <div class="header-name">
            <?php echo $objResult["cust_username"];?> 
                <h2><?php echo $objResult["cust_name"];?> <?php echo $objResult["cust_surname"];?></h2> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
				<h3>Room</h3> <h5>A009</h5> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
            </div>
        </div>

        <ul>
            <li><a href="admin - home.html">ข้อมูลส่วนตัว</a></li>
			
			<li><a href="admin - home.html">สัญญาเช่า</a></li>
            
            <li><a href="admin - home.html">ชำระค่าเช่า </a></li>
            
			<li><a href="admin - home.html">Messages</a></li>
			
			<li><a href="admin - home.html">แจ้งขอย้ายห้อง/ย้ายออก</a></li>
        </ul>
    </nav>
	
	<div class="job">
	
	
	
	</div>
	
	
	
	
    
	<script>
	    //  คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่
        $('nav ul li').click(function() {
            $(this).addClass('active').siblings().removeClass('active')
        })
		
    </script>		
</body>
	
</html>	
	
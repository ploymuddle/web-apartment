<?php
session_start();

//set menu user_profile page
$page = 'ข้อมูลส่วนตัว';
$_GET['menu'] = $page;

//connect database
require_once "connection.php";

// //check id ว่ามีการ Login
// if ($_SESSION['id'] == "") {
// 	echo "Please Login!";
// 	exit();
// }

// //check status user
// if ($_SESSION['status'] != "user") {
// 	echo "This page for User only!";
// 	exit();
// }

//get customer data in database
$strSQL = "SELECT * FROM customer WHERE cust_id = '" . $_SESSION['id'] . "' ";

$objQuery = mysqli_query($conn, $strSQL);
$objCust = mysqli_fetch_array($objQuery);

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('user_menu.php'); ?>

<body>

	<div class="job">
		<h1>สวัสดีท่านสมาชิก</h1>

			<div class="show-box">

			<form action="updateCustomer.php" method="POST">

				<div class="grid-col">

					<div class="grid-row">
						<div class="grid col-20">
							<label for="cust_id">รหัสสมาชิก:</label>
							<input type="text" id="cust_id" name="cust_id" placeholder="รหัสสมาชิก" value="<?php echo $objCust['cust_id'] ?>" readonly>
						</div>
						<div class="grid col-20">
							<label for="custName">ชื่อ:</label>
							<input type="text" id="name" name="name" placeholder="ชื่อ" value="<?php echo $objCust['cust_name'] ?>">
						</div>
						<div class="grid col-20">
							<label for="surname">นามสกุล:</label>
							<input type="text" id="surname" name="surname" placeholder="นามสกุล" value="<?php echo $objCust['cust_surname'] ?>">
						</div>
						<div class="grid col-20">
							<label for="email">Email:</label>
							<input type="text" id="email" name="email" placeholder="Email" value="<?php echo $objCust['cust_email'] ?>">
						</div>
						<div class="grid col-20">
							<label for="tel">เบอร์โทร:</label>
							<input type="text" id="tel" name="tel" placeholder="เบอร์โทร" value="<?php echo $objCust['cust_tel'] ?>">
						</div>
					</div>
				


					<!-- <div class="d-flex content-right"> -->
						<div class="grid-row grid-start">
							<div class="grid col-20">
								<label for="username">ชื่อผู้ใช้:</label>
								<input type="text" id="username" name="username" placeholder="username" disabled value="<?php echo $objCust['cust_username'] ?>">
							</div>
							<div class="grid col-20">
								<label for="password">รหัสผ่าน:</label>
								<input type="text" id="password" name="password" placeholder="password" value="<?php echo $objCust['cust_password'] ?>">
							</div>
							<div class="grid col-20 my-20">
								<div></div>
								<button class="btn" type="submit">แก้ไขข้อมูล</button>
							</div>
						</div>
					<!-- </div> -->
					
				</div>
			</form>
			</div>

	</div>

	<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
	<script src="js/script.js"></script>

</body>

</html>
<?php
session_start();
require_once "connection/connection.php";

$page = 'ข้อมูลส่วนตัว';
$_GET['menu'] = $page;

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
		<!-- Alert -->
		<?php if (isset($_SESSION['error'])) { ?>
			<div class="alert error">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				<strong>บันทึกข้อมูลไม่สำเร็จ! </strong> <?php echo $_SESSION['error'] ?>
			</div>
		<?php unset($_SESSION['error']);
		} ?>

		<?php if (isset($_SESSION['success'])) { ?>
			<div class="alert success">
				<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
				<strong>บันทึกข้อมูลสำเร็จ! </strong> <?php echo $_SESSION['success'] ?>
			</div>
		<?php unset($_SESSION['success']);
		} ?>
		<!-- Alert -->

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
							<input type="text" id="name" name="name" placeholder="ชื่อ" value="<?php echo $objCust['cust_name'] ?>" required>
						</div>
						<div class="grid col-20">
							<label for="surname">นามสกุล:</label>
							<input type="text" id="surname" name="surname" placeholder="นามสกุล" value="<?php echo $objCust['cust_surname'] ?>" required>
						</div>
						<div class="grid col-20">
							<label for="email">Email:</label>
							<input type="text" id="email" name="email" placeholder="Email" value="<?php echo $objCust['cust_email'] ?>" required>
						</div>
						<div class="grid col-20">
							<label for="tel">เบอร์โทร:</label>
							<input type="text" id="tel" name="tel" placeholder="เบอร์โทร" value="<?php echo $objCust['cust_tel'] ?>" required>
						</div>
					</div>

					<div class="grid-row grid-start">
						<div class="grid col-20">
							<label for="username">ชื่อผู้ใช้:</label>
							<input type="text" id="username" name="username" placeholder="username" disabled value="<?php echo $objCust['cust_username'] ?>" required>
						</div>
						<div class="grid col-20">
							<label for="password">รหัสผ่าน:</label>
							<input type="text" id="password" name="password" placeholder="password" value="<?php echo $objCust['cust_password'] ?>" required>
						</div>
						<div class="grid col-20 my-20">
							<div></div>
							<button class="btn" type="submit">แก้ไขข้อมูล</button>
						</div>
					</div>

				</div>
			</form>
		</div>

	</div>

	<!-- คำสั่งสำหลับแสดงสถานะ ในแถบเมนูที่ใช้งานอยู่ -->
	<script src="js/script.js"></script>

</body>

</html>
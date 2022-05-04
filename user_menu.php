<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
	<meta http-equiv="X-Compatible" content="ie=edge">
	<title> <?php //echo $page; ?> </title>

	<link rel="stylesheet" href="css/style-body.css">
    <link rel="stylesheet" href="css/style-customer-menu.css">
	<link rel="stylesheet" href="css/style-customer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/1c68c00305.js" crossorigin="anonymous"></script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">

	<!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<nav class="menu">
    <div class="header">

        <i id="logo" class="fas fa-users"></i>

        <div class="header-name">
            <h3>Room</h3>
            <h5 class=""><?php echo $objCust['cust_username'] ?></h5> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
        </div>
    </div>

    <ul>
        <li <?php if ($_GET['menu'] == "ข้อมูลส่วนตัว") {
                echo "class=\"active\"";
            } ?>><a href="user_profile.php" class="user_profile"></a></li>

        <li <?php if ($_GET['menu'] == "สัญญาเช่า") {
                echo "class=\"active\"";
            } ?>><a href="user_contract.php" class="user_contract"></a></li>

        <li <?php if ($_GET['menu'] == "ชำระค่าเช่า") {
                echo "class=\"active\"";
            } ?>><a href="user_bill.php" class="user_bill"></a></li>

        <li <?php if ($_GET['menu'] == "User messages") {
                echo "class=\"active\"";
            } ?>><a href="user_messages.php" class="user_messages"></a></li>

        <li <?php if ($_GET['menu'] == "แจ้งขอย้าย") {
                echo "class=\"active\"";
            } ?>><a href="user_to_move.php" class="user_to_move"></a></li>
    </ul>

    <div class="out">
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</nav>
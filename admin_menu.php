<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <meta http-equiv="X-Compatible" content="ie=edge">
    <title><?php echo $page; ?></title>

    <link rel="stylesheet" href="css/style-body.css">
    <link rel="stylesheet" href="css/style-admin-menu.css">
    <link rel="stylesheet" href="css/style-admin.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/1c68c00305.js" crossorigin="anonymous"></script>
    <!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<nav class="menu">
    <div class="header">

        <i id="logo" class="fas fa-id-badge"></i>

    </div>

    <ul>
        <!-- menu admin_home active -->
        <li <?php if ($_GET['menu'] == "หน้าแรก") {
                echo "class=\"active\"";
            } ?>><a href="admin_home.php" class="admin_home"></a></li>
            
        <li <?php if ($_GET['menu'] == "จัดการห้องพัก") {
                echo "class=\"active\"";
            } ?>><a href="admin_room.php" class="admin_room"></a></li>
        
        <li <?php if (($_GET['menu'] == "เพิ่มสัญญาลูกค้า") || ($_GET['menu'] == "แก้ไขข้อมูลลูกค้า")) {
                echo "class=\"active\"";
            }?>><a href="admin_customer.php" class="admin_customer"></a></li>

        <li <?php if ($_GET['menu'] == "จดมิเตอร์") {
                echo "class=\"active\"";
            } ?>><a href="admin_create_bill.php" class="admin_create_bill"></a></li>

        <li <?php if ($_GET['menu'] == "ระบบรับชำระ") {
                echo "class=\"active\"";
            } ?>><a href="admin_update_bill.php" class="admin_update_bill"></a></li>

        <li <?php if ($_GET['menu'] == "รายงานการชำระ") {
                echo "class=\"active\"";
            } ?>><a href="admin_bill.php" class="admin_bill"></a></li>

        <li <?php if ($_GET['menu'] == "Admin messages") {
                echo "class=\"active\"";
            } ?>><a href="admin_messages.php" class="admin_messages"></a></li>

        <li <?php if ($_GET['menu'] == "คำขอย้าย") {
                echo "class=\"active\"";
            } ?>><a href="approved_to_move.php" class="approved_to_move"></a></li>
    </ul>
    
    <div class="out">
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</nav>
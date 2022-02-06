<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <meta http-equiv="X-Compatible" content="ie=edge">
    <title><?php echo $page; ?></title>

    <link rel="stylesheet" href="css/style-admin-menu.css">
    <!-- <link rel="stylesheet" href="css/style-admin.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sriracha&display=swap" rel="stylesheet">

    <!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<div class="out">
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
</div>

<nav class="menu">
    <div class="header">

        <i id="logo" class="fas fa-id-badge"></i>

        <div class="header-name">
            <h2><?php //echo $objResult["emp_name"]; 
                ?></h2> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
        </div>

    </div>

    <ul>
        <!-- menu admin_home active -->
        <li <?php if ($_GET['menu'] == "หน้าแรก") {
                echo "class=\"active\"";
            } ?>><a href="admin_home.php">หน้าแรก - Home</a></li>

        <li <?php if ($_GET['menu'] == "จัดการห้องพัก") {
                echo "class=\"active\"";
            } ?>><a href="admin_room.php">จัดการห้องพัก</a></li>

        <li><a class="serv-btn">จัดการลูกค้า<span class="fas fa-caret-down second"></span></a>
            <ul class="serv-show <?php if ($_GET['menu'] == "เพิ่มสัญญาลูกค้า" || $_GET['menu'] == "แก้ไขข้อมูลลูกค้า") {
                                        echo "show";
                                    } ?>">
                <li <?php if ($_GET['menu'] == "เพิ่มสัญญาลูกค้า") {
                        echo "class=\"active\"";
                    } ?>><a href="admin_contract.php">เพิ่มสัญญาลูกค้า</a></li>
                <li <?php if ($_GET['menu'] == "แก้ไขข้อมูลลูกค้า") {
                        echo "class=\"active\"";
                    } ?>><a href="admin_customer.php">แก้ไขข้อมูลลูกค้า</a></li>
            </ul>
        </li>

        <li <?php if ($_GET['menu'] == "จดมิเตอร์") {
                echo "class=\"active\"";
            } ?>><a href="admin_create_bill.php">จดมิเตอร์</a></li>

        <li <?php if ($_GET['menu'] == "ระบบรับชำระ") {
                echo "class=\"active\"";
            } ?>><a href="admin_update_bill.php">ระบบรับชำระ</a></li>

        <li <?php if ($_GET['menu'] == "รายงานการชำระ") {
                echo "class=\"active\"";
            } ?>><a href="admin_bill.php">รายงานการชำระ</a></li>

        <li <?php if ($_GET['menu'] == "Admin messages") {
                echo "class=\"active\"";
            } ?>><a href="admin_messages.php">Messages</a></li>

        <li <?php if ($_GET['menu'] == "คำขอย้าย") {
                echo "class=\"active\"";
            } ?>><a href="approved_to_move.php">คำขอย้ายห้อง/ย้ายออก</a></li>
    </ul>
</nav>
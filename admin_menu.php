
    <div class="out">
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
    </div>

    <nav class="menubar">
        <div class="header">

            <i id="logo" class="fas fa-id-badge"></i> 

            <div class="header-name">
                <h2><?php echo $objResult["emp_name"]; ?></h2> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
            </div>

        </div>

        <ul>
            <!-- menu admin_home active -->
            <li <?php if ($_GET['menu'] == "หน้าแรก") { echo "class=\"active\""; } ?> ><a href="admin_home.php">หน้าแรก - Home</a></li>
            
            <li <?php if ($_GET['menu'] == "จัดการห้องพัก") { echo "class=\"active\""; } ?>><a href="admin_room.php">จัดการห้องพัก</a></li>

            <li><a class="serv-btn">จัดการลูกค้า<span class="fas fa-caret-down second"></span></a>
                <ul class="serv-show <?php if ($_GET['menu'] == "เพิ่มสัญญาลูกค้า" || $_GET['menu'] == "แก้ไขข้อมูลลูกค้า") { echo "show"; } ?>" >
                    <li <?php if ($_GET['menu'] == "เพิ่มสัญญาลูกค้า") { echo "class=\"active\""; } ?> ><a href="admin_contract.php">เพิ่มสัญญาลูกค้า</a></li>
                    <li <?php if ($_GET['menu'] == "แก้ไขข้อมูลลูกค้า") { echo "class=\"active\""; } ?> ><a href="admin_customer.php">แก้ไขข้อมูลลูกค้า</a></li>
                </ul>
            </li>

            <li <?php if ($_GET['menu'] == "จดมิเตอร์") { echo "class=\"active\""; } ?> ><a href="admin_create_bill.php">จดมิเตอร์</a></li>

            <li <?php if ($_GET['menu'] == "ระบบรับชำระ") { echo "class=\"active\""; } ?> ><a href="admin_update_bill.php">ระบบรับชำระ</a></li>

            <li <?php if ($_GET['menu'] == "รายงานการชำระ") { echo "class=\"active\""; } ?> ><a href="admin_bill.php">รายงานการชำระ</a></li>

            <li <?php if ($_GET['menu'] == "Admin messages") { echo "class=\"active\""; } ?> ><a href="admin_messages.php">Messages</a></li>

            <li <?php if ($_GET['menu'] == "คำขอย้าย") { echo "class=\"active\""; } ?> ><a href="approved_to_move.php">คำขอย้ายห้อง/ย้ายออก</a></li>
        </ul>
    </nav>

 
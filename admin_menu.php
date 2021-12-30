
    <div class="out">

        <i href="#" class="fas fa-sign-out-alt"></i>
        <!--< <span class="fas fa-bars"></span> >-->
    </div>

    <nav class="menubar">
        <div class="header">

            <i id="logo" class="fas fa-id-badge"></i> <!-- -->
            <!-- Logo -->
            <!--    <div class="header-img">
                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=80&q=80" alt="">
            </div> -->

            <div class="header-name">
                <h2><?php echo $objResult["emp_username"]; ?></h2> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
            </div>
        </div>

        <ul>
            <li><a href="home.php">หน้าแรก - Home</a></li>

            <li><a href="room_manage.php">จัดการห้องพัก</a></li>

            <li><a class="serv-btn" href="contract_manage.php">จัดการลูกค้า<span class="fas fa-caret-down second"></span></a>
                <!-- <ul class="serv-show">
                    <li><a href="customer_add.php">เพิ่มสัญญาลูกค้า</a></li>
                    <li><a href="customer_edit.php">แก้ไขข้อมูลลูกค้า</a></li>
                </ul> -->
            </li>

            <li><a href="customer_home.html">จดมิเตอร์</a></li>

            <li><a href="customer_home.html">ระบบรับชำระ</a></li>

            <li><a href="admin_home.html">รายงานการชำระ</a></li>

            <li><a href="admin_home.html">Messages</a></li>

            <li><a href="admin_home.html">คำขอย้ายห้อง/ย้ายออก</a></li>
        </ul>
    </nav>

 
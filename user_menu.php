<div class="out">

<a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>

</div>

<nav class="menubar">
    <div class="header">

        <i id="logo" class="fas fa-users"></i> <!-- -->
        <!-- Logo -->
        <!--    <div class="header-img">
                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=80&q=80" alt="">
            </div> -->

        <div class="header-name">
            <?php echo $objResult["cust_username"]; ?>
            <h2><?php echo $objResult["cust_name"]; ?> <?php echo $objResult["cust_surname"]; ?></h2> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
            <h3>Room</h3>
            <h5>A009</h5> <!-- ต้องดึงมาจาก ฐานข้อมูล -->
        </div>
    </div>

    <ul>
        <li <?php if ($_GET['menu'] == "ข้อมูลส่วนตัว") { echo "class=\"active\""; } ?> ><a href="user_profile.php">ข้อมูลส่วนตัว</a></li>

        <li <?php if ($_GET['menu'] == "สัญญาเช่า") { echo "class=\"active\""; } ?> ><a href="user_contract.php">สัญญาเช่า</a></li>

        <li <?php if ($_GET['menu'] == "ชำระค่าเช่า") { echo "class=\"active\""; } ?> ><a href="user_bill.php">ชำระค่าเช่า </a></li>

        <li <?php if ($_GET['menu'] == "User messages") { echo "class=\"active\""; } ?> ><a href="user_messages.php">Messages</a></li>

        <li <?php if ($_GET['menu'] == "แจ้งขอย้าย") { echo "class=\"active\""; } ?>><a href="request_to_move.php">แจ้งขอย้ายห้อง/ย้ายออก</a></li>
    </ul>
</nav>
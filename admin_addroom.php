<?php
session_start();

//set menu admin page
$page = 'เพิ่มห้องพัก';
$_GET['menu'] = 'จัดการห้องพัก';

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

//ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
if ($_SESSION['id'] == "") {
    header("location:login.php");
}

// //ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
if ($_SESSION['status'] != "admin") {
  
    $_SESSION['page_error'] = 'หน้านี้เฉพาะแอดมินเท่านั้น';
    header("location:only_admin.php");
}

?>

<!doctype html>
<html>
<!-- <link rel="stylesheet" href="css/style-admin-contract.css"> -->

<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

    <div class="job">
        <h1 class="title  d-flex content-center"><?php echo $page; ?></h1>

       <?php if(isset($_SESSION['error'])) {?>
        <div class="alert error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>บันทึกข้อมูลไม่สำเร็จ! </strong> <?php echo $_SESSION['error'] ?>
        </div>
       <?php  unset($_SESSION['error']); } ?>

       <?php if(isset($_SESSION['success'])) {?>
        <div class="alert success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>บันทึกข้อมูลสำเร็จ! </strong> <?php echo $_SESSION['success'] ?>
        </div>
       <?php  unset($_SESSION['success']); } ?>

        <div class="box bg-white">
            <form method="POST" class="" action="insertRoom.php">
                <hr>
                <div class="grid-row">
                    <div class="grid col-20">
                        <label for="roomId">เลขที่ห้องพัก:</label>
                        <input type="text" id="roomId" name="roomId" placeholder="X000">
                    </div>
                    <div class="grid col-20">
                        <label for="roomType">ประเภทห้องพัก:</label>
                        <select id="roomType" name="roomType" onchange="selectType()">
                            <option value="">เลือกรายการ</option>
                            <?php
                            $typeSQL = "SELECT * FROM room_type ";
                            $typeQuery = mysqli_query($conn, $typeSQL);
                            while ($type = mysqli_fetch_array($typeQuery)) {
                            ?>
                                <option value="<?php echo $type['type_room']; ?>"><?php echo $type['type_room']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="grid col-20">
                        <label for="roomData"></label>
                        <textarea id="roomData" name="roomData" rows="4" cols="50" placeholder="ข้อมูลห้องพัก" disabled></textarea>
                    </div>
                    <div class="grid col-20">
                        <label for="roomRental">ราคาค่าเช่า:</label>
                        <input type="text" id="roomRental" name="roomRental" placeholder="0.00" disabled>
                    </div>
                </div>

                <hr>

                <div class="d-flex content-center">
                    <button class="btn" type="button" id="close" onclick="window.location='admin_room.php';">กลับหน้าจัดการห้องพัก</button>
                    <button class="btn" type="submit">บันทึกรายการ</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function selectType() {
            var type = document.getElementById("roomType").value;
            console.log(type);
            showDataType(type);
        }

        function showDataType(id) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var response = this.response;
                    var data = JSON.parse(response);
                    console.log(data);
                    document.getElementById("roomData").value = data[0].type_data;
                    document.getElementById("roomRental").value = data[0].type_rental;
                }
            }
            xmlhttp.open("GET", "getDataType.php?q=" + id, true);
            xmlhttp.send();
        }
    </script>

    <script src="js/script-dropdown.js"></script>
    <script src="js/script.js"></script>

</body>

</html>
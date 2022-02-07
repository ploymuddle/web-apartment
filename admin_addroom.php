<?php
session_start();

//set menu admin page
$page = 'เพิ่มห้องพัก';
$_GET['menu'] = 'จัดการห้องพัก';

// ----
// //เชื่อมต่อฐานข้อมูล
// // require_once "../connection.php";
require_once "connection.php";

// //ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
// if ($_SESSION['id'] == "") {
//     header("location:login.php");
// }

// //ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
// if ($_SESSION['status'] != "admin") {
//     echo "This page for Admin only!";
//     exit();
// }

// //คำสั่ง sql ในการดึงข้อมูล
// $strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
// $objQuery = mysqli_query($conn, $strSQL);
// $objResult = mysqli_fetch_array($objQuery);

?>

<!doctype html>
<html>
<!-- <link rel="stylesheet" href="css/style-admin-contract.css"> -->

<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

    <div class="job">
        <h1 class="title"><?php echo $page;?></h1>

        <div class="box bg-white">

            <form method="POST" class="" action="insertC.php" enctype="multipart/form-data">

                <div class="grid-col">
                    <div class="grid-row">
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
                            <label for="roomId">เลือกห้องพัก:</label>
                            <select id="roomId" name="roomId" disabled onchange="showDataRoom(this.value)">
                            </select>
                        </div>
                        <div class="grid col-20">
                            <label for=""></label>
                            <textarea id="roomData" name="roomData" rows="4" cols="50" placeholder="ข้อมูลห้องพัก" disabled></textarea>
                        </div>
                        <div class="grid col-20">
                            <label for="roomRental">ราคาค่าเช่า:</label>
                            <input type="text" id="roomRental" name="roomRental" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="grid-row">
                        <div class="grid col-30">
                            <label for="file">เอกสารยืนยัน:</label>
                            <input type="file" id="file" name="file">
                        </div>
                        <div class=""></div>
                    </div>
                </div>

                <hr>

                <div class="d-flex content-center">
                    <button type="button" id="close" onclick="window.location='admin_room.php';">กลับหน้าจัดการห้องพัก</button>
                    <button type="submit">บันทึกรายการ</button>
                </div>

            </form>
        </div>
    </div>




    <script>
        function ddRoomList(id) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var response = this.response;
                    var data = JSON.parse(response);
                    console.log(data);

                    var option = '<option value="">เลือกรายการ</option>';
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value="' + data[i].room_id + '">' + data[i].room_id + '</option>';
                    }
                }
                $('#roomId').html(option);

            }
            xmlhttp.open("GET", "getRoomList.php?q=" + id, true);
            xmlhttp.send();

        }

        function selectType() {
            var type = document.getElementById("roomType").value;
            console.log(type);
            document.getElementById("roomId").disabled = false;
            ddRoomList(type);
        }

        function showDataRoom(id) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var response = this.response;
                    var data = JSON.parse(response);
                    console.log(data);
                    document.getElementById("roomData").value = data[0].room_data;
                    document.getElementById("roomRental").value = data[0].type_rental;
                }
            }
            xmlhttp.open("GET", "getRoom.php?q=" + id, true);
            xmlhttp.send();

        }
    </script>

    <script src="js/script-dropdown.js"></script>
    <script src="js/script.js"></script>

</body>

</html>
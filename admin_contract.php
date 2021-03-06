<?php
session_start();
require_once "connection/connection.php";

$page = 'เพิ่มสัญญาลูกค้า';
$_GET['menu'] = $page;

?>

<!doctype html>
<html>

<?php include('admin_menu.php'); ?>

<body>

    <div class="job">
        <h1 class="title text-center">เพิ่มสัญญาใหม่</h1>
        <!-- Alert -->
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
       <!-- Alert -->

        <div class="box bg-white">
        <form method="POST" action="insertContract.php" enctype="multipart/form-data">

                <div class="contract-input-4">
                    <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า" required>
                    <input type="text" id="surname" name="surname" placeholder="นามสกุล" required>
                    <input type="text" id="tel" name="tel" placeholder="เบอร์โทร" pattern="[0-9]{10,11}" required >
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <hr>

                <div class="contract-row">
                    <div class="">
                        <div class="contract-input">
                            <label for="roomType">ประเภทห้องพัก:</label>
                            <select id="roomType" name="roomType" onchange="selectType()" required>
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
                        <div class="contract-input">
                            <label for="roomId">เลือกห้องพัก:</label>
                            <select id="roomId" name="roomId" disabled required>
                            </select>
                        </div>
                        <div class="contract-input">
                            <label for=""></label>
                            <textarea id="roomData" name="roomData" rows="4" cols="50" placeholder="ข้อมูลห้องพัก" disabled></textarea>
                        </div>
                        <div class="contract-input">
                            <label for="roomRental">ราคาค่าเช่า:</label>
                            <input type="text" id="roomRental" name="roomRental" placeholder="0.00" disabled>
                        </div>
                    </div>

                    <div class="">
                        <div class="contract-input">
                            <label for="contractDate">วันที่ทำสัญญา:</label>
                            <input type="date" id="contractDate" name="contractDate" required>
                        </div>

                        <div class="contract-input">
                            <label for="contract">ค่ามัดจำ:</label>
                            <input type="number" id="contract" name="contract" required>
                        </div>

                        <div class="contract-input">
                            <label for="file">เอกสารยืนยัน:</label>
                            <input type="file" id="file" name="file" required>
                        </div>
                  
                    </div>
                </div>
                <hr>

                <div class="box-btn-center">
                    <button type="button" class="btn btn-back" onclick="window.location='admin_customer.php';">กลับหน้าจัดการข้อมูล</button>
                    <button type="submit" class="btn">บันทึกรายการ</button>
                </div>
            </form>
        </div>
    </div>




    <script>
        function selectType() {
            var type = document.getElementById("roomType").value;
            console.log(type);
            document.getElementById("roomId").disabled = false;
            ddRoomList(type);
            showDataType(type);
        }

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
<?php
session_start();

//set menu admin page
$page = 'เพิ่มสัญญาลูกค้า';
$_GET['menu'] = $page;
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

$strSQL = "SELECT * FROM customer WHERE cust_status =  'wait' ";
$custListQuery = mysqli_query($conn, $strSQL);
?>

<!doctype html>
<html>
<!-- <link rel="stylesheet" href="css/style-admin-contract.css"> -->

<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

    <div class="job">
        <h1 class="title">สัญญาใหม่ รอการอนุมัติ</h1>

        <div class="box">
            <div class="grid-header mx-20 ">
                <h3>รอการอนุมัติ</h3>
                <label>รายการรออนุมัติ : </label>
                <input type="text" value="110" disabled />
                <label>รายการ</label>
            </div>

            <?php while ($custList = mysqli_fetch_array($custListQuery)) { ?>
                <div class="show-box grid-3">
                    <div class="grid">
                        <input type="text" id="txtName" name="txtName" placeholder="ชื่อลูกค้า" disabled value="<?php echo $custList["cust_name"]; ?>">
                        <input type="text" id="txtSurname" name="txtSurname" placeholder="นามสกุล" disabled value="<?php echo $custList["cust_surname"]; ?>">
                        <input type="text" id="txtId" name="q" value="<?php echo $custList["cust_id"]; ?>">
                    </div>
                    <p class="mx-20 content-center">รอดำเนินการ</p>

                    <button type="submit" id="myBtn" onclick="showCust(<?php echo $custList['cust_id']; ?>)">ดำเนินการ <i class="fas fa-arrow-alt-circle-right" style="font-size:12px;"></i></button>
                </div>
            <?php } ?>

        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content show-box">

            <h3>สร้างรายการบิล</h3>

            <?php
            if ($custID != '') {
                $strSQL = "SELECT * FROM customer WHERE cust_id = '" . $custID . "' ";
                $custQuery = mysqli_query($conn, $strSQL);
                $cust = mysqli_fetch_array($custQuery);
                echo "<script>console.log('Debug Objects: " . $custID . "' );</script>";
                echo "<script>console.log('Debug Objects: " . $cust["cust_name"] . "' );</script>";
            }
            ?>

            <form method="POST">

                <div class="grid-col">
                    <div class="grid-4">
                        <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า">
                        <input type="text" id="surname" name="surname" placeholder="นามสกุล">
                        <input type="text" id="tel" name="tel" placeholder="เบอร์โทร" >
                        <input type="text" id="email" name="email" placeholder="Email">
                    </div>
                </div>

                <hr>

                <div class="grid-col">
                    <div class="grid-row">
                        <div class="grid col-20">
                            <label for="roomId">เลือกห้องพัก:</label>
                            <select id="roomId" name="roomId">
                                <option value="">เลือกรายการ</option>
                                <option value="101">101</option>
                            </select>
                        </div>
                        <div class="grid col-20">
                            <label for=""></label>
                            <textarea id="w3review" name="w3review" rows="4" cols="50" placeholder="ข้อมูลห้องพัก"></textarea>
                        </div>
                        <div class="grid col-20">
                            <label for="roomId">ประเภทห้องพัก:</label>
                            <input type="text" id="txtRoomId" name="txtRoomId" placeholder="ประเภทห้องพัก">
                        </div>
                        <div class="grid col-20">
                            <label for="roomId">ราคาค่าเช่า:</label>
                            <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
                        </div>
                    </div>
                    <div class="grid-row">
                        <div class="grid col-20-30">
                            <label for="roomId">วันที่ทำสัญญา:</label>
                            <input type="date" id="txtRoomId" name="txtRoomId">
                            <input type="text" id="txtRoomId" name="txtRoomId" placeholder="หมายเลขสัญญา">
                        </div>
                        <div class="grid col-20-30">
                            <label for="roomId">วันที่ทำสัญญา:</label>
                            <select id="roomId" name="roomId">
                                <option value="1">วันที่ 1</option>
                            </select>
                            <input type="text" id="txtRoomId" name="txtRoomId" placeholder="รหัสสมาชิก">
                        </div>
                        <div class="content-center">
                            <button type="button">เพิ่มไฟล์เอกสาร</button>
                        </div>
                        <div class=""></div>
                    </div>
                </div>

                <hr>

                <div class="content-center">
                    <button type="button" id="close" onclick="window.location='admin_contract.php';" >ยกเลิก</button>
                    <button type="submit">บันทึกรายการ</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        modal.style.display = "none";

        function showCust(id) {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
        
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.response;
                    var data = JSON.parse(response);
                    console.log(data);

                    document.getElementById("name").value = data.cust_name;
                    document.getElementById("surname").value = data.cust_surname;
                    document.getElementById("tel").value = data.cust_tel;
                    document.getElementById("email").value = data.cust_email;
                    modal.style.display = "block";
                }
            }
            xmlhttp.open("GET", "getuser.php?q=" + id, true);
            xmlhttp.send();

        }
    </script>

    <script src="js/script-dropdown.js"></script>
    <script src="js/script.js"></script>

</body>

</html>
<?php
session_start();

//set menu admin page
$page = 'จดมิเตอร์';
$_GET['menu'] = $page;
// ----
// //เชื่อมต่อฐานข้อมูล
// // require_once "../connection.php";
// require_once "connection.php";

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
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

  <div class="job">
    <h1 class="title">จดมิเตอร์</h1>
    <div class="box">
      <div class="show-box">
        <h3>สร้างรายการบิล</h3>

        <form>

          <div class="grid-col">
            <div class="grid col-40">
              <label for="roomId">หมายเลขห้องพัก:</label>
              <!-- <input type="text" id="txtRoomId" name="txtRoomId" placeholder="เลือกรายการ"> -->
              <select id="roomId" name="roomId">
                <option value="">เลือกรายการ</option>
                <option value="101">101</option>
              </select>
            </div>
            <div class="grid col-3-20">
              <input type="text" id="txtId" name="txtId" placeholder="รหัสสมาชิก">
              <input type="text" id="txtName" name="txtName" placeholder="ชื่อลูกค้า">
              <input type="text" id="txtSurname" name="txtSurname" placeholder="นามสกุล">
            </div>
          </div>

          <hr>

          <div class="grid-col">
            <div class="grid col-20">
              <label for="roomId">วันที่:</label>
              <input type="date" id="txtRoomId" name="txtRoomId" placeholder="22/2/2021">
            </div>
            <div class="grid col-20">
              <label for=""></label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="รหัสใบเสร็จ">
            </div>
            <div class="grid col-20">
              <label for="roomId">ค่าเช่าห้อง:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
            </div>
            <div class="grid col-3-20">
              <label for="roomId">ค่าปรับ:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="จำนวนหน่วย">
            </div>
            <div class="grid col-20">
              <label for="roomId">ค่าไฟฟ้า:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
            </div>
            <div class="grid col-3-20">
              <label for="roomId">ค่าน้ำประปา:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="จำนวนหน่วย">
            </div>
            <div class="grid"></div>
            <div class="grid col-20">
              <label for="roomId">ยอดชำระเงิน:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
            </div>
          </div>

          <hr>

          <div class="d-flex content-center">
            <button type="cancel">ยกเลิก</button>
            <button type="submit">บันทึกรายการ</button>
          </div>

        </form>


      </div>
    </div>
  </div>

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
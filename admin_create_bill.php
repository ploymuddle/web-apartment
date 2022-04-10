<?php
session_start();

//set menu admin page
$page = 'จดมิเตอร์';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

//ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
if ($_SESSION['id'] == "") {
    header("location:login.php");
}

//ตรวจสอบสถานะว่าเป็น admin เข้าใช้งานในหน้านี้เท่านั้น
if ($_SESSION['status'] != "admin") {
    echo "This page for Admin only!";
    exit();
}

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

        <form method="POST" action="insertInvoice.php">

          <div class="grid-col">
            <div class="grid col-40">
              <label for="roomId">หมายเลขห้องพัก:</label>
              <!-- <input type="text" id="txtRoomId" name="txtRoomId" placeholder="เลือกรายการ"> -->
              <select id="roomId" name="roomId" onchange="selectRoom()">
                <option value="">เลือกรายการ</option>
                <?php
                $roomSQL = "SELECT * FROM room WHERE room_status = 'O' ";
                $roomQuery = mysqli_query($conn, $roomSQL);
                while ($room = mysqli_fetch_array($roomQuery)) {
                ?>
                  <option value="<?php echo $room['room_id']; ?>"><?php echo $room['room_id']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="grid col-3-20">
              <input type="text" id="cust_id" name="cust_id" placeholder="รหัสสมาชิก">
              <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า">
              <input type="text" id="surname" name="surname" placeholder="นามสกุล">
            </div>
          </div>

          <hr>

          <div class="grid-col col-40">
            <div class="grid col-20">
              <label for="date">วันที่ทำรายการ:</label>
              <input type="date" id="date" name="date" placeholder="22/2/2021">
            </div>
            <div class="grid col-20">
              <label for="deadtime">วันที่กำหนดจ่าย:</label>
              <input type="date" id="deadtime" name="deadtime" placeholder="22/2/2021">
            </div>
            <!-- <div class="grid col-20"> -->
            <!-- <label for=""></label>
              <input type="text" id="" name="" placeholder="รหัสใบเสร็จ"> -->
            <!-- </div> -->
            <div class="grid col-20">
              <label for="roomRent">ค่าเช่าห้อง:</label>
              <input type="text" id="roomRent" name="roomRent" placeholder="0.00">
            </div>
            <div class="grid col-4-20">
              <label for="electronic">มิเตอร์ไฟฟ้า:</label>
              <input type="text" id="FM" name="FM" placeholder="000">
              <input type="text" id="FM_before"  name="FM_before" readonly="readonly" >
              <input type="text" id="FU" name="FU" placeholder="ต่อหน่วย" value="7">
            </div>
            <div class="grid col-20">
              <label for="penalty">ค่าปรับ:</label>
              <input type="text" id="penalty" name="penalty" placeholder="0.00" value="0">
            </div>
            <div class="grid col-4-20">
              <label for="water">มิเตอร์น้ำ:</label>
              <input type="text" id="WM" name="WM" placeholder="000">
              <input type="text" id="WM_before" name="WM_before" readonly="readonly" >
              <input type="text" id="WU" name="WU" placeholder="ต่อหน่วย" value="10">
            </div>
            <div class="grid"></div>
            <div class="grid col-3-20">
              <label for="total">ยอดชำระเงิน:</label>
              <input type="text" id="total" name="total" placeholder="0.00">
              <button class="btn" type="button" onclick="sumTotal()">คำนวณ</button>
            </div>
          </div>

          <hr>

          <div class="d-flex content-center">
            <button class="btn" type="cancel">ยกเลิก</button>
            <button class="btn" type="submit">บันทึกรายการ</button>
          </div>

        </form>


      </div>
    </div>
  </div>

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
  <script>
    function selectRoom() {
      var room = document.getElementById("roomId").value;
      console.log(room);
      showDataRoom(room);
    }

    function showDataRoom(id) {

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          // console.log(response);
          data = JSON.parse(response);
          console.log(data[0]);

          document.getElementById("cust_id").value = data[0].cust_id;
          document.getElementById("name").value = data[0].cust_name;
          document.getElementById("surname").value = data[0].cust_surname;

          document.getElementById("roomRent").value = data[0].type_rental;

          showDataMeter(id,data[0].cust_id);
        }
      }
      xmlhttp.open("GET", "getRoomDetail.php?q=" + id, true);
      xmlhttp.send();
    }

    function showDataMeter(room,cust) {
      console.log(room+cust);
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          // console.log(response);
          data = JSON.parse(response);
          console.log(data[0]);

          document.getElementById("FM_before").value = data[0].FM;
          document.getElementById("WM_before").value = data[0].WM;
        }
      }
      xmlhttp.open("GET", "getMeter.php?room=" + room + "&cust=" + cust, true);
      xmlhttp.send();
    }

    function sumTotal() {
      var rental = parseInt(document.getElementById("roomRent").value) ? parseInt(document.getElementById("roomRent").value) : 0;
      var penalty = parseInt(document.getElementById("penalty").value) ? parseInt(document.getElementById("penalty").value) : 0;
      var fire = (document.getElementById("FM").value - document.getElementById("FM_before").value) * document.getElementById("FU").value;
      var water = (document.getElementById("WM").value - document.getElementById("WM_before").value) * document.getElementById("WU").value ;
      var total =  rental + penalty + fire + water;
      document.getElementById("total").value = total;
    }
  </script>
</body>

</html>
<?php
session_start();

//set menu admin page
$page = 'รายงานการชำระ';
$_GET['menu'] = $page;
// -----
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

<!doctype html>
<html>
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

  <div class="job">
    <h1 class="title">รายงานการชำระ</h1>

    <div class="box">

      <div class="show-box">
        <div class="grid-search">
          <div class="grid form-search">
            <label for="roomId">หมายเลขห้องพัก:</label>
            <select id="roomId" name="roomId">
              <option value="">เลือกรายการ</option>
              <option value="101">101</option>
            </select>
          </div>
          <div class="grid form-search">
            <label for="roomId">สถานะ :</label>
            <select id="roomId" name="roomId">
              <option value="">เลือกรายการ</option>
              <option value="101">101</option>
            </select>
          </div>
          <div class="grid form-search">
            <label>วันที่ : </label>
            <input type="date" id="txtName" name="txtName" />
          </div>
          <div class="grid form-search">
            <label>รหัสสมาชิก : </label>
            <input type="text" id="txtName" name="txtName" />
          </div>
          <div class="grid form-search">
            <label>ชื่อลูกค้า : </label>
            <input type="text" id="txtName" name="txtName" />
          </div>
          <div></div>
        </div>
        <div class="content-center">
           <button type="submit" class="px-20">ค้นหา</button>
        </div>
      </div>

      <div class="show-box">

        <table class="table">
          <thead>
            <tr>
              <th>หมายเลขห้อง</th>
              <th>รหัสสมาชิก</th>
              <th>ชื่อลูกค้า</th>
              <th>นามสกุล</th>
              <th>รายการชำระ</th>
              <th>สถานะชำระ</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>A105</td>
              <td>AAA</td>
              <td>AAA</td>
              <td>AAA</td>
              <td>2000</td>
              <td>
                <div class="status-bill">ค้างชำระ</div>
              </td>
              <td><button class="button" id="myBtn">ดำเนินการ</button></td>
            </tr>
          </tbody>
        </table>

        <div class="pagination">
          <ol id="numbers"></ol>
        </div>

      </div>

    </div>
  </div>

  <!-- The Modal -->
  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content show-box">

      <h3>รายการรับชำระ</h3>

      <form method="POST">

        <div class="grid-col">
          <div class="grid col-40">
            <label for="roomId">หมายเลขห้องพัก:</label>
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

          <div class="grid-row">
            <img src="https://www.kasikornbank.com/SiteCollectionDocuments/personal/digital-banking/kplus/functions/verified-slip/img/img-03.png" style="width:300px;height:100%;">
            <p class="content-center">หลักฐานการชำระเงิน</p>
          </div>

          <div class="grid-row">
            <div class="">
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="รหัสใบเสร็จ">
            </div>
            <div class="grid col-3-20">
              <label for="roomId">วันที่:</label>
              <input type="date" id="txtRoomId" name="txtRoomId" placeholder="22/2/2021" disabled>
            </div>
            <div class="grid col-3-20">
              <label for="roomId">จำนวนเงิน:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00" disabled>
            </div>
            <div class="grid col-3-20">
              <label for="roomId">ค้างชำระ:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00" disabled>
            </div>
            <div class="grid col-3-20">
              <label for="roomId">รับชำระ:</label>
              <input type="text" id="txtRoomId" name="txtRoomId" placeholder="0.00">
            </div>
          </div>
        </div>

        <hr>

        <div class="content-center">
          <button type="cancel" id="close">ยกเลิก</button>
          <button type="submit">บันทึกรายการ</button>
        </div>

      </form>
    </div>


  </div>

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
  <script src="js/script-pagination.js"></script>
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>

</html>
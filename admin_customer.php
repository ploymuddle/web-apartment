<?php
session_start();

//set menu admin page
$page = 'แก้ไขข้อมูลลูกค้า';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
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
// $admin = mysqli_fetch_array($objQuery);


//ลำดับของ query
$i = 0;


//sql query customer data
$keyName = null;
$keyRoom = null;
$keyStatus = null;

if (isset($_POST["txtName"])) {
  $keyName = $_POST["txtName"];
}
if (isset($_POST["txtRoomId"])) {
  $keyRoom = $_POST["txtRoomId"];
}
if (isset($_POST["status"])) {
  $keyStatus = $_POST["status"];
}

if (isset($_POST["clear"])) {
  $keyRoom = "";
  $keyName = "";
  $keyStatus = 'live';
}

$strSQL = "SELECT * FROM customer";
if ($keyStatus == 'live') {
  $strSQL = $strSQL . " WHERE cust_status = 'live' ";
  if ($keyName != "") {
    $strSQL = $strSQL . "AND ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
  } else if ($keyRoom != "") {
    $strSQL = $strSQL . "AND cust_username = '" . $keyRoom . "' ";
  } else if ($keyName != "" && $keyRoom != "") {
    $strSQL = $strSQL . "AND ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
    $strSQL = $strSQL . "AND cust_username = '" . $keyRoom . "' ";
  }
} else if ($keyStatus == 'leave') {
  $strSQL = $strSQL . " WHERE cust_status = 'leave' ";
  if ($keyName != "") {
    $strSQL = $strSQL . "AND ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
  } else if ($keyRoom != "") {
    $strSQL = $strSQL . "AND cust_username = '" . $keyRoom . "' ";
  } else if ($keyName != "" && $keyRoom != "") {
    $strSQL = $strSQL . "AND ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
    $strSQL = $strSQL . "AND cust_username = '" . $keyRoom . "' ";
  }
} else {
  if ($keyName != "") {
    $strSQL = $strSQL . " WHERE ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
  } else if ($keyRoom != "") {
    $strSQL = $strSQL . " WHERE cust_username = '" . $keyRoom . "' ";
  } else if ($keyName != "" && $keyRoom != "") {
    $strSQL = $strSQL . " WHERE ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
    $strSQL = $strSQL . "AND cust_username = '" . $keyRoom . "' ";
  }
}
// echo '' . $strSQL . '';
// echo '' . $keyStatus . '';

$custQuery = mysqli_query($conn, $strSQL);

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

  <div class="job">
    <h1 class="title">จัดการข้อมูลลูกค้า</h1>

    <div class="box">

      <div class="content-right">
    <button class="btn-add" type="submit" onclick="document.location.href='admin_contract.php'">เพิ่มสัญญาลูกค้า</button>
      </div>

      <div class="show-box">
        <form name="frmSearch" method="POST" action="admin_customer.php">
          <div class="grid-search col-3-20">
            <div class="grid form-search">
              <label for="roomId">หมายเลขห้องพัก :</label>
              <input type="text" id="txtRoomId" name="txtRoomId" value="<?php echo $keyRoom; ?>" />

            </div>
            <div class="grid form-search">
              <label>ชื่อลูกค้า : </label>
              <input type="text" id="txtName" name="txtName" value="<?php echo $keyName; ?>" />
            </div>
            <div class="grid form-search">
              <label for="status">สถานะ :</label>
              <select id="status" name="status">
                <option value="live" <?php if ($keyStatus == "live") {
                                        echo "selected";
                                      } ?>>อาศัยอยู่</option>
                <option value="leave" <?php if ($keyStatus == "leave") {
                                        echo "selected";
                                      } ?>>ย้ายออก</option>
                <option value="all" <?php if ($keyStatus == "all") {
                                      echo "selected";
                                    } ?>>ทั้งหมด</option>
              </select>
            </div>
          </div>
          <div class="content-center">
            <button type="submit" class="btn-search">ค้นหา</button>
            <button type="submit" class="btn-clear" name="clear" value="clear">ล้างค่า</button>
          </div>
        </form>
      </div>

      <div class="show-box">

        <table class="table" id="table">
          <thead>
            <tr>
              <th>ลำดับ</th>
              <th>ชื่อลูกค้า</th>
              <th>นามสกุล</th>
              <th>เบอร์โทร</th>
              <th>อีเมล</th>
              <th>ห้องพัก</th>
              <th>ข้อมูล</th>
              <th>การชำระ</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($custList = mysqli_fetch_array($custQuery)) { ?>
              <tr>
                <td><?php $i++;
                    echo $i; ?></td>
                <td><?php echo $custList["cust_name"]; ?></td>
                <td><?php echo $custList["cust_surname"]; ?></td>
                <td><?php echo $custList["cust_tel"]; ?></td>
                <td><?php echo $custList["cust_email"]; ?></td>
                <td><?php echo $custList["cust_username"]; ?></td>
                <td><a href="#" class="button" onclick="showData(<?php echo $custList['cust_id']; ?>)"><i class="fas fa-edit" style="font-size:20px;"></i></a></td>
                <td><a href="#" class="button" onclick="showBill(<?php echo $custList['cust_id']; ?>)"><i class="fas fa-file-invoice" style="font-size:22px;"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <div class="pagination">
          <ol id="numbers"></ol>
        </div>


      </div>

    </div>
  </div>

  <!-- The Modal Data -->
  <div id="modalData" class="modal">

    <!-- Modal content -->
    <div class="modal-content show-box">

      <h3>แก้ไขข้อมูลลูกค้า</h3>

      <hr>

      <div class="content-space-around">
        <p>รหัสลูกค้า : <a id="id"> - </a></p>
        <p>วันที่ทำสัญญา : </p>
      </div>

      <hr>

      <form method="POST">

        <div class="grid-col">
          <div class="">
            <div class="grid form-label">
              <label>ชื่อลูกค้า : </label>
              <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า">
            </div>
            <div class="grid form-label">
              <label>นามสกุล : </label>
              <input type="text" id="surname" name="surname" placeholder="นามสกุล">
            </div>
            <div class="grid form-label">
              <label>เบอร์โทร : </label>
              <input type="text" id="tel" name="tel" placeholder="เบอร์โทร">
            </div>
            <div class="grid form-label">
              <label>Email : </label>
              <input type="text" id="email" name="email" placeholder="Email">
            </div>
          </div>

          <div class="">
            <div class="grid form-label">
              <label>เลขที่ห้องพัก : </label>
              <input type="text" id="roomId" name="roomId" placeholder="เลขที่ห้องพัก">
            </div>
            <div class="grid form-label">
              <label>ประเภทห้องพัก : </label>
              <input type="text" id="roomType" name="roomType" placeholder="ประเภทห้องพัก" disabled>
            </div>
            <div class="grid form-label">
              <label>ข้อมูลห้องพัก : </label>
              <textarea type="text" id="roomDetail" name="roomDetail" placeholder="ข้อมูลห้องพัก" disabled></textarea>
            </div>
            <div class="grid form-label">
              <label>ราคาค่าเช่า : </label>
              <input type="text" id="roomRent" name="roomRent" placeholder="0.00" disabled>
            </div>
          </div>
        </div>

        <hr>

        <div class="content-center">
          <button type="button" id="close" onclick="window.location='admin_customer.php';">ยกเลิก</button>
          <button type="submit">บันทึกรายการ</button>
        </div>

      </form>
    </div>

  </div>
  <!-- End The Modal Data  -->

  <!-- The Modal Bill -->
  <div id="modalBill" class="modal">

    <div class="modal-content show-box">

      <h3>ข้อมูลการชำระ</h3>

      <hr>

      <div class="content-space-around">
        <p>รหัสลูกค้า : <a id="id"> - </a></p>
        <p>ชื่อลูกค้า : </p>
        <p>ห้องพัก : </p>
      </div>

      <hr>

      <form method="POST">

        <div class="grid-col">
          <div class="">
            <div class="grid form-label">
              <label>ชื่อลูกค้า : </label>
              <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า" value="">
            </div>
            <div class="grid form-label">
              <label>นามสกุล : </label>
              <input type="text" id="surname" name="surname" placeholder="นามสกุล" value="">
            </div>
            <div class="grid form-label">
              <label>เบอร์โทร : </label>
              <input type="text" id="tel" name="tel" placeholder="เบอร์โทร" value="">
            </div>
            <div class="grid form-label">
              <label>Email : </label>
              <input type="text" id="email" name="email" placeholder="Email" value="">
            </div>
          </div>

          <div class="">
            <div class="grid form-label">
              <label>เลขที่ห้องพัก : </label>
              <input type="text" id="roomId" name="roomId" placeholder="เลขที่ห้องพัก" value="">
            </div>
            <div class="grid form-label">
              <label>ประเภทห้องพัก : </label>
              <input type="text" id="roomType" name="roomType" placeholder="ประเภทห้องพัก" value="" disabled>
            </div>
            <div class="grid form-label">
              <label>ข้อมูลห้องพัก : </label>
              <textarea type="text" id="roomDetail" name="roomDetail" placeholder="ข้อมูลห้องพัก" disabled></textarea>
            </div>
            <div class="grid form-label">
              <label>ราคาค่าเช่า : </label>
              <input type="text" id="roomRent" name="roomRent" placeholder="0.00" disabled>
            </div>
          </div>
        </div>

        <hr>

        <div class="content-center">
          <button type="button" id="close" onclick="window.location='admin_customer.php';">ยกเลิก</button>
          <button type="submit">บันทึกรายการ</button>
        </div>

      </form>
    </div>

  </div>
  <!-- End The Modal Bill  -->

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
  <script src="js/script-pagination.js"></script>
  <script>
    var modalData = document.getElementById("modalData");
    modalData.style.display = "none";
    var modalBill = document.getElementById("modalBill");
    modalBill.style.display = "none";

    function showData(id) {

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          var data = JSON.parse(response);
          console.log(data);
          document.getElementById("id").innerText = data.cust_id;
          document.getElementById("name").value = data.cust_name;
          document.getElementById("surname").value = data.cust_surname;
          document.getElementById("tel").value = data.cust_tel;
          document.getElementById("email").value = data.cust_email;
          modalData.style.display = "block";
        }
      }
      xmlhttp.open("GET", "getCustomer.php?q=" + id, true);
      xmlhttp.send();

    }

    function showBill(id) {

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          var data = JSON.parse(response);
          console.log(data);
          document.getElementById("id").value = data.cust_id;
          document.getElementById("name").value = data.cust_name;
          document.getElementById("surname").value = data.cust_surname;
          document.getElementById("tel").value = data.cust_tel;
          document.getElementById("email").value = data.cust_email;
          modalBill.style.display = "block";
        }
      }
      xmlhttp.open("GET", "getBill.php?q=" + id, true);
      xmlhttp.send();

    }

  </script>

</body>

</html>
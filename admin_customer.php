<?php
session_start();

//set menu admin page
$page = 'แก้ไขข้อมูลลูกค้า';
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

//ลำดับของ query
$i = 0;


//sql query customer data
$keyName = null;
$keyRoom = null;
$keyStatus = 'live';

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
  $strSQL = $strSQL . " ORDER BY cust_id DESC";
} else {
  if ($keyName != "") {
    $strSQL = $strSQL . " WHERE ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
  } else if ($keyRoom != "") {
    $strSQL = $strSQL . " WHERE cust_username = '" . $keyRoom . "' ";
  } else if ($keyName != "" && $keyRoom != "") {
    $strSQL = $strSQL . " WHERE ( cust_name LIKE '%" . $keyName . "%' OR cust_surname LIKE '%" . $keyName . "%' ) ";
    $strSQL = $strSQL . "AND cust_username = '" . $keyRoom . "' ";
  }
  $strSQL = $strSQL . " ORDER BY cust_id DESC";
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

      <div class="d-flex content-right">
        <button class="btn btn-add" type="submit" onclick="document.location.href='admin_contract.php'"> เพิ่มสัญญาลูกค้า</button>
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
          <div class="d-flex content-center">
            <button type="submit" class="btn btn-search">ค้นหา</button>
            <button type="submit" class="btn btn-clear" name="clear" value="clear">ล้างค่า</button>
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
            <?php
            if (mysqli_num_rows($custQuery) == 0) { ?>
              <tr>
                <td colspan="8">ไม่มีข้อมูล</td>
              </tr>
              <?php
            } else {
              while ($custList = mysqli_fetch_array($custQuery)) { ?>
                <tr>
                  <td><?php $i++;
                      echo $i; ?></td>
                  <td><?php echo $custList["cust_name"]; ?></td>
                  <td><?php echo $custList["cust_surname"]; ?></td>
                  <td><?php echo $custList["cust_tel"]; ?></td>
                  <td><?php echo $custList["cust_email"]; ?></td>
                  <td><?php echo $custList["cust_username"]; ?></td>
                  <td><a class="button" onclick="showData(<?php echo $custList['cust_id']; ?>)"><i class="fas fa-eye" style="font-size:20px;"></i></a></td>
                  <td><a class="button" onclick="showBill(<?php echo $custList['cust_id']; ?>)"><i class="fas fa-file-invoice" style="font-size:22px;"></i></a></td>
                </tr>
            <?php }
            } ?>
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

      <div class="d-flex content-space-around">
        <p>รหัสลูกค้า : <a id="id"> - </a></p>
        <p>วันที่ทำสัญญา : <a id="date"> - </a></p>
        <p>สถานะ : <a id="cust_status"> - </a></p>
      </div>

      <hr>

      <div class="grid-col">
        <form method="POST" action="updateCustomer.php">
          <div class="">
            <div class="d-flex content-center">
              <button type="submit" class="btn btn-save my-20" id="btnSave"> บันทึก</button>
            </div>
            <input type="text" id="cust_id" name="cust_id" hidden>
            <div class="grid form-label">
              <label>ชื่อลูกค้า : </label>
              <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า" disabled>
            </div>
            <div class="grid form-label">
              <label>นามสกุล : </label>
              <input type="text" id="surname" name="surname" placeholder="นามสกุล" disabled>
            </div>
            <div class="grid form-label">
              <label>เบอร์โทร : </label>
              <input type="text" id="tel" name="tel" placeholder="เบอร์โทร" disabled>
            </div>
            <div class="grid form-label">
              <label>Email : </label>
              <input type="text" id="email" name="email" placeholder="Email" disabled>
            </div>
            <div class="d-flex content-space-around content-align-center text-detail my-20 ">
              <p>Username : <a id="username"> - </a></p>
              <p>Password : <a id="password"> - </a></p>
              <button type="button" id="btn" class="btn btn-edit" onclick="edit()"><a class="text-white" id="textEdit"></a></button>
            </div>
          </div>
        </form>

        <div class="">
          <div class="grid">
            <div class="form-label">
              <label>เลขที่ห้องพัก : </label>
              <input type="text" id="roomId" name="roomId" placeholder="เลขที่ห้องพัก" disabled>
            </div>
            <div class="form-label">
              <label>ประเภทห้องพัก : </label>
              <input type="text" id="roomType" name="roomType" placeholder="ประเภทห้องพัก" disabled>
            </div>
          </div>
          <div class="grid form-label">
            <label>ข้อมูลห้องพัก : </label>
            <textarea type="text" id="roomDetail" name="roomDetail" placeholder="ข้อมูลห้องพัก" disabled></textarea>
          </div>
          <div class="grid">
            <div class="form-label">
              <label>ราคาค่าเช่า : </label>
              <input type="text" id="roomRent" name="roomRent" placeholder="0.00" disabled>
            </div>
            <div class="form-label">
              <label>ราคาค่ามัดจำ : </label>
              <input type="text" id="roomDeposit" name="roomDeposit" placeholder="0.00" disabled>
            </div>
          </div>

          <div class="d-flex content-center my-20">
            <button type="button" class="btn btn-download" id="dd"></button>
            <button type="button" class="btn btn-download" id="dc"></button>
            <form method="POST" action="updateContract.php" id="cancelCon">
              <input type="text" id="con" name="con" hidden>
            </form>
            <button type="submit" class="btn btn-delete" form="cancelCon" value="submit">ยกเลิกสัญญา</button>
          </div>

        </div>
      </div>

      <hr>

      <div class="d-flex content-center">
        <button type="button" id="close" class="btn" onclick="window.location='admin_customer.php';">ยกเลิก</button>
      </div>
    </div>

  </div>
  <!-- End The Modal Data  -->

  <!-- The Modal Bill -->
  <div id="modalBill" class="modal ">

    <div class="modal-content show-box">

      <h3>ข้อมูลการชำระ</h3>

      <hr>

      <div class="d-flex content-space-around">
        <p>รหัสลูกค้า : <a id="id_showbill"> - </a></p>
        <p>ชื่อลูกค้า : <a id="name_showbill"> - </a></p>
        <p>ห้องพัก : <a id="room_showbill"> - </a></p>
      </div>

      <hr>

      <div class="box-bill">
        <div class="grid-bill" id="showbill"></div>
      </div>

      <div class="d-flex content-center">
        <button type="button" id="close" class="btn" onclick="window.location='admin_customer.php';">ยกเลิก</button>
      </div>
    </div>

  </div>
  <!-- End The Modal Bill  -->

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
  <script src="js/script-pagination.js"></script>
  <script>
    var data;
    var modalData = document.getElementById("modalData");
    modalData.style.display = "none";
    var modalBill = document.getElementById("modalBill");
    modalBill.style.display = "none";

    var btn = document.getElementById('btn');
    var btnSave = document.getElementById('btnSave');
    var textEdit = document.getElementById("textEdit");
    textEdit.innerText = "แก้ไขข้อมูลลูกค้า";
    document.getElementById("btnSave").style.display = 'none';

    function showData(id) {

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          data = JSON.parse(response);
          console.log(data[0]);
          document.getElementById("id").innerText = data[0].cust_id;
          document.getElementById("date").innerText = data[0].con_checkin;
          document.getElementById("cust_status").innerText = (data[0].cust_status === 'live') ? 'อาศัยอยู่' : 'ย้ายออก';

          document.getElementById("cust_id").value = data[0].cust_id;
          document.getElementById("name").value = data[0].cust_name;
          document.getElementById("surname").value = data[0].cust_surname;
          document.getElementById("tel").value = data[0].cust_tel;
          document.getElementById("email").value = data[0].cust_email;

          document.getElementById("con").value = data[0].con_id;
          document.getElementById("roomId").value = data[0].room_id;
          document.getElementById("roomType").value = data[0].type_room;
          document.getElementById("roomDetail").value = data[0].type_data;
          document.getElementById("roomRent").value = data[0].type_rental;
          document.getElementById("roomDeposit").value = data[0].con_deposit;

          document.getElementById("username").innerText = data[0].cust_username;
          document.getElementById("password").innerText = data[0].cust_password;

          modalData.style.display = "block";

          var btnDD = document.getElementById('dd');
          var aDD = document.createElement('a');
          aDD.innerHTML = 'ไฟล์เอกสาร';
          aDD.setAttribute('href', data[0].img_document);
          aDD.setAttribute('class', 'text-white');
          aDD.setAttribute('download', 'เอกสารยืนยัน_' + data[0].con_id + '.pdf');
          btnDD.appendChild(aDD);

          var btnDC = document.getElementById('dc');
          var aDC = document.createElement('a');
          aDC.innerHTML = 'ไฟล์สัญญา';
          aDC.setAttribute('href', data[0].img_contract);
          aDC.setAttribute('class', 'text-white');
          aDC.setAttribute('download', 'เอกสารสัญญา_' + data[0].con_id + '.pdf');
          btnDC.appendChild(aDC);

        }
      }
      xmlhttp.open("GET", "getCustomerDetail.php?q=" + id, true);
      xmlhttp.send();
    }

    function showBill(id) {
      console.log(id);

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          var dataBill = JSON.parse(response);
          console.log(dataBill);

          document.getElementById("id_showbill").innerText = dataBill[0].cust_id;
          document.getElementById("name_showbill").innerText = dataBill[0].cust_name + ' ' + dataBill[0].cust_surname;
          document.getElementById("room_showbill").innerText = dataBill[0].room_id;

          for (var i = 0; i < dataBill.length; i++) {

            let txtBill = document.createElement("p");
            txtBill.innerHTML = "รหัสบิล " + dataBill[i].pay_id;
            let txtDate = document.createElement("p");
            txtDate.innerHTML = "วันที่ " + dataBill[i].inv_date;
            let txtPay = document.createElement("p");
            txtPay.innerHTML = "ยอดเงิน : " + dataBill[i].inv_total;

            let txtStatus = document.createElement("p");
            if (dataBill[i].pay_status == "ค้างชำระ") {
              txtStatus.innerHTML = dataBill[i].pay_status;
              txtStatus.className = "status-red";
            } else if (dataBill[i].pay_status == "ชำระแล้ว") {
              txtStatus.innerHTML = dataBill[i].pay_status;
              txtStatus.className = "status-green";
            } else {
              txtStatus.innerHTML = dataBill[i].pay_status;
              txtStatus.className = "status-gray";
            }

            let img = document.createElement("img");
            img.className = "card-box-img";
            img.src = "https://img.icons8.com/external-smashingstocks-circular-smashing-stocks/100/000000/external-bill-power-and-energy-smashingstocks-circular-smashing-stocks.png";

            var box = document.createElement('div');
            box.className = "card-box";

            box.append(txtBill)
            box.append(txtDate)
            box.append(img)
            box.append(txtPay)
            box.append(txtStatus)
            document.getElementById('showbill').appendChild(box);

          }

          modalBill.style.display = "block";
        }
      }
      xmlhttp.open("GET", "getBill.php?q=" + id, true);
      xmlhttp.send();

    }

    function edit() {

      if (textEdit.innerText === "แก้ไขข้อมูลลูกค้า") {

        document.getElementById("name").disabled = false;
        document.getElementById("surname").disabled = false;
        document.getElementById("tel").disabled = false;
        document.getElementById("email").disabled = false;

        document.getElementById("btnSave").style.display = 'flex';

        textEdit.innerText = "ยกเลิก";
        btn.classList.remove('btn-edit');
        btn.classList.add('btn-cancel');

      } else {

        document.getElementById("name").disabled = true;
        document.getElementById("surname").disabled = true;
        document.getElementById("tel").disabled = true;
        document.getElementById("email").disabled = true;

        document.getElementById("name").value = data[0].cust_name;
        document.getElementById("surname").value = data[0].cust_surname;
        document.getElementById("tel").value = data[0].cust_tel;
        document.getElementById("email").value = data[0].cust_email;

        document.getElementById("btnSave").style.display = 'none';

        textEdit.innerText = "แก้ไขข้อมูลลูกค้า";
        btn.classList.remove('btn-cancel');
        btn.classList.add('btn-edit');
      }
    }

    function save() {}
  </script>

</body>

</html>
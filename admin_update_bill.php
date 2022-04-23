<?php
session_start();

//set menu admin page
$page = 'ระบบรับชำระ';
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

$year = date("Y");
$month = date("m");
if (isset($_POST['month'])) {
  $month = $_POST['month'];
}
if (isset($_POST['year'])) {
  $year = $_POST['year'];
}
if (isset($_POST['status'])) {
  $status = $_POST['status'];
}

//คำสั่ง sql ในการดึงข้อมูล
$billSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id AND i.inv_date LIKE '%-" . $month . "-%' AND i.inv_date LIKE '%" . $year . "%' ";
if ($status != 'all') {
  $billSQL =  $billSQL . " AND p.pay_status = '" . $status . "' ";
}
$billSQL = $billSQL . " ORDER BY i.inv_date DESC ";
?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

  <div class="job">
    <h1 class="title">รายการรับชำระ</h1>

    <div class="box">
      <div class="grid-table">
        <form method="POST" class="none">
        <div class="grid ">
          <label>เดือน : </label>
          <select id='month' name="month" onchange="this.form.submit()">
            <option <?php if ($month == "01") {
                      echo "selected";
                    } ?> value='01'>มกราคม</option>
            <option <?php if ($month == "02") {
                      echo "selected";
                    } ?> value='02'>กุมภาพันธ์</option>
            <option <?php if ($month == "03") {
                      echo "selected";
                    } ?> value='03'>มีนาคม</option>
            <option <?php if ($month == "04") {
                      echo "selected";
                    } ?> value='04'>เมษายน</option>
            <option <?php if ($month == "05") {
                      echo "selected";
                    } ?> value='05'>พฤษภาคม</option>
            <option <?php if ($month == "06") {
                      echo "selected";
                    } ?> value='06'>มิถุนายน</option>
            <option <?php if ($month == "07") {
                      echo "selected";
                    } ?> value='07'>กรกฎาคม</option>
            <option <?php if ($month == "08") {
                      echo "selected";
                    } ?> value='08'>สิงหาคม</option>
            <option <?php if ($month == "09") {
                      echo "selected";
                    } ?> value='09'>กันยายน</option>
            <option <?php if ($month == "10") {
                      echo "selected";
                    } ?> value='10'>ตุลาคม</option>
            <option <?php if ($month == "11") {
                      echo "selected";
                    } ?> value='11'>พฤศจิกายน</option>
            <option <?php if ($month == "12") {
                      echo "selected";
                    } ?> value='12'>ธันวาคม</option>
          </select>
        </div>
        <div class="grid ">
          <label>ปี : </label>
          <select id='year' name="year" onchange="this.form.submit()">
            <option <?php if ($year == "2020") {
                      echo "selected";
                    } ?> value='2020'>2020</option>
            <option <?php if ($year == "2021") {
                      echo "selected";
                    } ?> value='2021'>2021</option>
            <option <?php if ($year == "2022") {
                      echo "selected";
                    } ?> value='2022'>2022</option>
          </select>
        </div>
        <div class="grid ">
          <label>สถานะ : </label>
          <select id='status' name="status" onchange="this.form.submit()">
            <option <?php if ($status == "all") {
                          echo "selected";
                        } ?> value='all'>ทั้งหมด</option>
            <option <?php if ($status == "ค้างชำระ") {
                      echo "selected";
                    } ?> value='ค้างชำระ'>ค้างชำระ</option>
            <option <?php if ($status == "ชำระแล้ว") {
                      echo "selected";
                    } ?> value='ชำระแล้ว'>ชำระแล้ว</option>
            <option <?php if ($status == "รอดำเนินการ") {
                      echo "selected";
                    } ?> value='รอดำเนินการ'>รอดำเนินการ</option>
          </select>
        </div>
        </form>
      </div>

      <div class="show-box">

        <table class="table" id="table">
          <thead>
            <tr>
              <th>วันที่</th>
              <th>หมายเลขห้อง</th>
              <th>ชื่อลูกค้า</th>
              <th>นามสกุล</th>
              <th>รายการชำระ</th>
              <th>สถานะชำระ</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $billQuery = mysqli_query($conn, $billSQL);
            while ($bill = mysqli_fetch_array($billQuery)) {
            ?>
              <tr>
                <td><?php echo $bill['inv_date']; ?></td>
                <td><?php echo $bill['room_id']; ?></td>
                <td><?php echo $bill['cust_name']; ?></td>
                <td><?php echo $bill['cust_surname']; ?></td>
                <td><?php echo $bill['inv_total']; ?></td>
                <td>
                  <div <?php $bill['pay_status'] == 'ค้างชำระ' ? print ' class="bill-r "' : ($bill['pay_status'] == 'ชำระแล้ว' ? print ' class="bill-g "' : print ' class="bill-y "') ?>><?php echo $bill['pay_status']; ?>
                  </div>
                </td>
                <?php if ($bill['pay_status'] == 'ค้างชำระ') { ?>
                  <td><button class="button btn" id="myBtn" onclick="showData('<?php echo $bill['inv_id']; ?>')">ตรวจสอบ</button></td>
                <?php } else { ?>
                  <td><button class="button btn" id="myBtn" onclick="showData('<?php echo $bill['inv_id']; ?>')">ตรวจสอบ</i></button></td>
                <?php } ?>
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

  <!-- The Modal -->
  <div id="modalData" class="modal">

    <!-- Modal content -->
    <div class="modal-content show-box">

      <h3>รายการรับชำระ</h3>

      <form method="POST" action="updateBill.php">

        <div class="grid-col">
          <div class="grid col-40">
            <label for="">ห้องพัก:</label>
            <input type="text" id="roomId" name="roomId" readonly>
          </div>
          <div class="grid col-3-20">
            <input type="text" id="id" name="id" placeholder="รหัสสมาชิก" readonly>
            <input type="text" id="name" name="name" placeholder="ชื่อลูกค้า" readonly>
            <input type="text" id="surname" name="surname" placeholder="นามสกุล" readonly>
          </div>
        </div>

        <hr>

        <div class="grid-col">

          <div class="grid-row">
            <img id="pic" style="width:200px;height:100%;">
            <p class="d-flex content-center">หลักฐานการชำระเงิน(<a id="statusBill"></a>)</p>
          </div>

          <div class="grid-row">

            <div class="form-label">
              <label for="">รหัสใบแจ้งหนี้:</label>
              <input type="text" id="billId" name="billId" placeholder="รหัสใบเสร็จ" readonly>
            </div>

            <div class="grid col-3-20">
              <label for="">วันที่สร้าง:</label>
              <input type="date" id="billCreateDate" name="billCreateDate" placeholder="22/2/2021" disabled>
            </div>
            <div class="grid col-3-20" id="billDateShow">
              <label for="">วันที่ชำระ:</label>
              <input type="date" id="billDate" name="billDate" placeholder="22/2/2021" disabled>
            </div>
            <div class="grid col-3-20">
              <label for="">จำนวนเงิน:</label>
              <input type="text" id="amount" name="amount" placeholder="0.00" readonly>
            </div>
            <!-- <div class="grid col-3-20">
              <label for="">ค้างชำระ:</label>
              <input type="text" id="overdue" name="overdue" placeholder="0.00" value="0">
            </div> -->
            <div class="grid col-3-20" id="paymentShow">
              <label for="">รับชำระ:</label>
              <input type="text" id="payment" name="payment" placeholder="0.00" disabled>
            </div>

            <div class="grid">
              <button type="button" class=" btn btn-download" id="invoice"></button>
              <button type="button" class=" btn btn-download" id="bill"></button>
            </div>
          </div>
        </div>

        <hr>

        <div class="d-flex content-center">
          <button class="btn" type="cancel" id="close">ยกเลิก</button>
          <button class="btn" type="submit" id="btnUpdate" hidden>บันทึกรายการ</button>
        </div>

      </form>
    </div>


  </div>

  <script src="js/script-dropdown.js"></script>
  <script src="js/script-pagination.js"></script>
  <script src="js/script.js"></script>
  <script>
    let data;
    var modalData = document.getElementById("modalData");
    modalData.style.display = "none";

    function showData(id) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          var data = JSON.parse(response);
          console.log(data);

          document.getElementById("roomId").value = data[0].room_id;

          document.getElementById("id").value = data[0].cust_id;
          document.getElementById("name").value = data[0].cust_name;
          document.getElementById("surname").value = data[0].cust_surname;

          document.getElementById("billId").value = data[0].inv_id;
          document.getElementById("billCreateDate").value = data[0].inv_date;
          document.getElementById("amount").value = data[0].inv_total;

          if (data[0].pay_slip == '' || data[0].pay_slip == null) {
            document.getElementById("pic").src = 'https://img.icons8.com/external-vitaliy-gorbachev-blue-vitaly-gorbachev/100/000000/external-invoice-home-office-vitaliy-gorbachev-blue-vitaly-gorbachev.png';
            document.getElementById("pic").style.width = "90px"
          } else {
            document.getElementById("pic").src = data[0].pay_slip;
          }

          document.getElementById("billDate").value = data[0].pay_date;
          document.getElementById("payment").value = data[0].pay_amount;

          if (data[0].pay_status == 'ชำระแล้ว') {
            document.getElementById("payment").disabled = false;
            document.getElementById("btnUpdate").hidden = false;
            document.getElementById("statusBill").innerHTML = data[0].pay_status;
            document.getElementById("statusBill").style.color = 'LimeGreen';
            document.getElementById("bill").disabled = true;
          } else if (data[0].pay_status == 'ค้างชำระ') {
            document.getElementById("statusBill").innerHTML = data[0].pay_status;
            document.getElementById("statusBill").style.color = 'red';
            document.getElementById("billDateShow").style.display = 'none';
            document.getElementById("paymentShow").style.display = 'none';
            document.getElementById("bill").disabled = true;
          } else {
            document.getElementById("statusBill").innerHTML = data[0].pay_status;
            document.getElementById("statusBill").style.color = 'SlateGray';
          }

          modalData.style.display = "block";

          var btnDI = document.getElementById('invoice');
          var aDI = document.createElement('a');
          aDI.innerHTML = ' ใบแจ้งหนี้';
          aDI.setAttribute('href', 'invoiceFile.php?id=' + data[0].pay_id);
          aDI.setAttribute('class', 'text-white');
          aDI.setAttribute('target', '_blank');
          btnDI.appendChild(aDI);

          var btnDB = document.getElementById('bill');
          var aDB = document.createElement('a');
          aDB.innerHTML = ' ใบเสร็จ';
          aDB.setAttribute('href', 'billFile.php?id=' + data[0].pay_id);
          aDB.setAttribute('class', 'text-white');
          aDB.setAttribute('target', '_blank');
          btnDB.appendChild(aDB);

        }
      }
      xmlhttp.open("GET", "getBillDetail.php?q=" + id, true);
      xmlhttp.send();

    }

    function invoiceFile(id) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = this.response;
          // var data = JSON.parse(response);
          console.log(response);
        }
      }
      xmlhttp.open("GET", "invoiceFile.php?q=" + id, true);
      xmlhttp.send();

    }
  </script>
</body>

</html>
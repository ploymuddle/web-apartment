<?php
session_start();

//set menu admin page
$page = 'ระบบรับชำระ';
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
// $objResult = mysqli_fetch_array($objQuery);

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

  <div class="job">
    <h1 class="title">รายการรับชำระ</h1>

    <div class="box">
      <div class="grid-table mx-20 ">
        <h3></h3>
        <label>วันที่ : </label>
        <input type="date" id="txtName" name="txtName" />
      </div>

      <div class="show-box">

        <table class="table">
          <thead>
            <tr>
            <th>วันที่</th>
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
          <?php
                $billSQL = "SELECT * FROM invoice i,customer c WHERE  i.cust_id = c.cust_id ORDER BY inv_date DESC ";
                $billQuery = mysqli_query($conn, $billSQL);
                while ($bill = mysqli_fetch_array($billQuery)) {
                ?>
            <tr>
            <td><?php echo $bill['inv_date']; ?></td>
              <td><?php echo $bill['room_id']; ?></td>
              <td><?php echo $bill['cust_id']; ?></td>
              <td><?php echo $bill['cust_name']; ?></td>
              <td><?php echo $bill['cust_surname']; ?></td>
              <td><?php echo $bill['inv_total']; ?></td>
              <td>
                <div 
                <?php  $bill['inv_status'] == 'ยังไม่ได้จ่าย' ? print ' class="bill-r "' :  ( $bill['inv_status'] == 'จ่ายแล้ว' ? print ' class="bill-g "' : print ' class="bill-y "' ) ?> ><?php echo $bill['inv_status']; ?>
                </div>
              </td>
              <td><button class="button" id="myBtn" onclick="showData('<?php echo $bill['inv_id']; ?>')">ดำเนินการ</button></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>

    </div>
  </div>

  <!-- The Modal -->
  <div id="modalData" class="modal">

    <!-- Modal content -->
    <div class="modal-content show-box">

      <h3>รายการรับชำระ</h3>

      <form method="POST">

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
            <img src="https://www.kasikornbank.com/SiteCollectionDocuments/personal/digital-banking/kplus/functions/verified-slip/img/img-03.png" style="width:300px;height:100%;">
            <p class="d-flex content-center">หลักฐานการชำระเงิน</p>
          </div>

          <div class="grid-row">
            <div class="">
              <input type="text" id="billId" name="billId" placeholder="รหัสใบเสร็จ" readonly>
            </div>
            <div class="grid col-3-20">
              <label for="">วันที่สร้าง:</label>
              <input type="date" id="billCreateDate" name="billCreateDate" placeholder="22/2/2021" readonly>
            </div>
            <div class="grid col-3-20">
              <label for="">วันที่ชำระ:</label>
              <input type="date" id="billDate" name="billDate" placeholder="22/2/2021" >
            </div>
            <div class="grid col-3-20">
              <label for="">จำนวนเงิน:</label>
              <input type="text" id="amount" name="amount" placeholder="0.00" readonly>
            </div>
            <div class="grid col-3-20">
              <label for="">ค้างชำระ:</label>
              <input type="text" id="overdue" name="overdue" placeholder="0.00">
            </div>
            <div class="grid col-3-20">
              <label for="">รับชำระ:</label>
              <input type="text" id="payment" name="payment" placeholder="0.00" >
            </div>
          </div>
        </div>

        <hr>

        <div class="d-flex content-center">
          <button type="cancel" id="close">ยกเลิก</button>
          <button type="submit">บันทึกรายการ</button>
        </div>

      </form>
    </div>


  </div>

  <script src="js/script-dropdown.js"></script>
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

					modalData.style.display = "block";

				}
			}
			xmlhttp.open("GET", "getBillDetail.php?q=" + id, true);
			xmlhttp.send();

		}
  </script>
</body>

</html>
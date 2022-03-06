<?php
session_start();

//set menu admin page
$page = 'รายงานการชำระ';
$_GET['menu'] = $page;
// -----
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


// if (isset($_POST['download'])) {
//   header('Window-target: _blank');
//    header('Location: bill.php');
// } 

if (isset($_POST["clear"])) {
  $room = 'all';
  $cust = '';
  $month = '0';
  $year = '0';
} else {

  $room = 'all';
  $cust = '';
  $month = '0';
  $year = '0';

  if ($_POST["room"] != 'all' && $_POST["room"] != '') {
    $room = $_POST["room"];
  }
  if ($_POST["cust"] != '') {
    $cust = $_POST["cust"];
  }
  if ($_POST["month"] != 0) {
    $month = $_POST["month"];
  }
  if ($_POST["year"] != 0) {
    $year = $_POST["year"];
  }
}


// //คำสั่ง sql ในการดึงข้อมูล
$strSQL = "SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id ";
if ($room != 'all') {
  $strSQL =  $strSQL . " AND i.room_id = '" . $room . "' ";
}
if ($cust != '') {
  $strSQL =  $strSQL . " AND i.cust_id = '" . $cust . "' ";
}
if ($month  != 0) {
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%-" . $month . "-%' ";
}
if ($year != 0) {
  $strSQL =  $strSQL . " AND i.inv_date LIKE '%" . $year . "%' ";
}

$strSQL = $strSQL . " ORDER BY i.inv_date DESC ";

$objQuery = mysqli_query($conn, $strSQL);
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

        <form name="frmSearch" method="POST" action="admin_bill.php">
          <div class="grid-search-4">
            <div class="grid form-search">
              <label for="room">หมายเลขห้องพัก:</label>
              <select id="room" name="room">
                <option <?php if ($room == "all") {
                          echo "selected";
                        } ?> value="all">ทั้งหมด</option>
                <?php
                $roomSQL = "SELECT * FROM room ";
                $roomQuery = mysqli_query($conn, $roomSQL);
                while ($roomlist = mysqli_fetch_array($roomQuery)) {
                ?>
                  <option <?php if ($room == $roomlist['room_id']) {
                            echo "selected";
                          } ?> value="<?php echo $roomlist['room_id']; ?>"><?php echo $roomlist['room_id']; ?></option>
                <?php } ?>
              </select>
            </div>
            <!-- <div class="grid form-search">
            <label for="roomId">สถานะ :</label>
            <select id="roomId" name="roomId">
              <option value="">เลือกรายการ</option>
              <option value="101">101</option>
            </select>
          </div> -->
            <div class="grid form-search">
              <label>เดือน : </label>
              <select id='month' name="month">
                <option <?php if ($month == "0") {
                          echo "selected";
                        } ?> value='0'>ทั้งหมด</option>
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
            <div class="grid form-search">
              <label>ปี : </label>
              <select id='year' name="year">
                <option <?php if ($year == "0") {
                          echo "selected";
                        } ?> value='0'>ทั้งหมด</option>
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
            <div class="grid form-search">
              <label>รหัสสมาชิก : </label>
              <input type="text" id="cust" name="cust" value="<?php echo $cust; ?>" />
            </div>
            <!-- <div class="grid form-search">
            <label>ชื่อลูกค้า : </label>
            <input type="text" id="txtName" name="txtName" />
          </div> -->
            <div></div>
          </div>
          <div class="d-flex content-center">
            <button type="submit" class="btn btn-search">ค้นหา</button>
            <button type="button" class="btn btn-search"><a class="text-white" href="reportFile.php?room=<?php echo $room; ?>&cust=<?php echo $cust; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>" target="_blank">Link</a></button>
            <button type="submit" class="btn btn-clear" name="clear" value="clear">ล้างค่า</button>
          </div>
        </form>
      </div>

      <div class="show-box">

        <table class="table" id="table">
          <thead>
            <tr>
              <th>วันที่</th>
              <th>หมายเลขห้อง</th>
              <th>รหัสสมาชิก</th>
              <th>ชื่อลูกค้า</th>
              <th>นามสกุล</th>
              <th>รายการชำระ</th>
              <th>สถานะชำระ</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($objQuery) == 0) { ?>
              <tr>
                <td colspan="7">ไม่มีข้อมูล</td>
              </tr>
            <?php
            } else {
              while ($bill = mysqli_fetch_array($objQuery)) {
            ?>
              <tr>
                <td><?php echo $bill['inv_date']; ?></td>
                <td><?php echo $bill['room_id']; ?></td>
                <td><?php echo $bill['cust_id']; ?></td>
                <td><?php echo $bill['cust_name']; ?></td>
                <td><?php echo $bill['cust_surname']; ?></td>
                <td><?php echo $bill['inv_total']; ?></td>
                <td>
                  <div <?php $bill['pay_status'] == 'ค้างชำระ' ? print ' class="bill-r "' : ($bill['pay_status'] == 'จ่ายแล้ว' ? print ' class="bill-g "' : print ' class="bill-y "') ?>><?php echo $bill['pay_status']; ?>
                  </div>
                </td>
              </tr>
            <?php } }?>
          </tbody>
        </table>
       
        <div class="pagination">
          <ol id="numbers"></ol>
        </div>

      </div>

    </div>
  </div>

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
  <script src="js/script-pagination.js"></script>
  
</body>

</html>
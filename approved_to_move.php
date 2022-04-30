<?php
session_start();
require_once "connection/connection.php";

$page = 'คำขอย้าย';
$_GET['menu'] = $page;

//คำสั่ง sql ในการดึงข้อมูล
$strSQL = "SELECT * FROM petition p LEFT JOIN contract con ON p.con_id = con.con_id LEFT JOIN customer c ON con.cust_id = c.cust_id WHERE p.petition_status = 'ขอย้ายออก' OR p.petition_status = 'ขอย้ายห้อง' ";

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('admin_menu.php'); ?>

<body>

  <div class="job">
    <div class="show-box">

      <table class="table" id="table">
        <thead>
          <tr>
            <th>หมายเลขห้อง</th>
            <th>ชื่อลูกค้า</th>
            <th>นามสกุล</th>
            <th>สาเหตุการย้าย</th>
            <th>แจ้งเรื่อง</th>
            <th>วันที่ขอย้ายออก</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($conn, $strSQL);
          while ($move = mysqli_fetch_array($query)) {
          ?>
            <tr>
              <td><?php echo $move['room_id']; ?></td>
              <td><?php echo $move['cust_name']; ?></td>
              <td><?php echo $move['cust_surname']; ?></td>
              <td><?php echo $move['petition_detail']; ?></td>
              <td><?php echo $move['petition_status']; ?></td>
              <td><?php echo $move['petition_date']; ?></td>
            
              <?php if ($move['petition_status'] == 'ขอย้ายห้อง') { ?>
                <td><button class="button btn" id="myBtn" onclick="window.location='updateContract.php?id='+<?php echo $move['con_id'];?>+'&move=room';">ทำสัญญาใหม่</button></td>
              <?php } else { ?>
                <td><button class="button btn" id="myBtn" onclick="window.location='updateContract.php?id='+<?php echo $move['con_id'];?>+'&move=out';">ยกเลิกสัญญา</i></button></td>
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

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
<?php
session_start();

//set menu admin page
$page = 'Admin messages';
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

$_SESSION["cust_id"] = $_SESSION["id"];

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('admin_menu.php'); ?>
<link rel="stylesheet" href="css/style-chat.css">

<body>
  <div class="job p-0">
    <div class="modal-chat">
      <div class="modal-dialog">
        <div class="chat">

          <div class="modal-sidebar">

            <!-- search by name  -->
            <div class="chat-search search">
              <p class="text-center text-grey">รายชื่อลูกค้าที่แจ้ง</p>
            </div>

            <!-- list customer chat -->
            <div class="chat-users">
              <ul class="users">

                <?php
                $msgs = mysqli_query($conn, "SELECT  DISTINCT m.from_user , c.*  FROM messages m , customer c WHERE to_user ='0' AND m.from_user = c.cust_id ");
            
                while ($msg = mysqli_fetch_assoc($msgs)) {
              
                ?>

                  <li class="users-item users-item_group">
                    <?php                 
                    $roomSql = mysqli_query($conn, "SELECT cust_username  FROM customer WHERE  cust_id = ".$msg['cust_id']." ");
                    $room = mysqli_fetch_assoc($roomSql);
                    $countSQL = mysqli_query($conn,"SELECT COUNT(*)  FROM messages m , customer c WHERE to_user ='0' AND m.from_user = c.cust_id AND isFlagRead = 'N' AND from_user =  ".$msg['cust_id']." ");
                    $count = mysqli_fetch_assoc($countSQL);
                    ?>
                    <div class="">ห้อง : </div>
                    <span class="users-note"> <a href="?toUser=<?php echo $msg["cust_id"]; ?>"><?php echo $room['cust_username'] ?> </a></span>
                    <?php if ($count['COUNT(*)'] != 0) { ?>
                    <div class="users-counter">
                      <span class="counter"><?php echo $count['COUNT(*)']?></span>
                    </div>
                    <?php } ?>
                  </li>

                <?php
                }
                ?>
              </ul>
            </div>
          </div>

          <div class="modal-main">
            
            <div class="chatbox">
              <form action="sentMessage.php" method="POST">
                <div class="chatbox-row">
                  <div class="head">
 
                    <?php
                    if (isset($_GET["toUser"])) {
                      $userName = mysqli_query($conn, "SELECT * FROM customer WHERE cust_id = '" . $_GET["toUser"] . "' ");
                      $uName = mysqli_fetch_assoc($userName);

                      $sqlUpdate = "UPDATE messages SET isFlagRead = 'Y' WHERE  from_user =  ".$_GET["toUser"]." ";
                      $result = mysqli_query($conn, $sqlUpdate);
                    ?>
                      <input type="text" value='<?php echo $_GET["toUser"] ?> ' id="toUser" name="toUser" hidden/>
                      <div class="head-title">
                        <?php echo '  หมายเลขห้องพัก : ' . $uName['cust_username'] ?>
                      </div>
                      <div class="head-title">
                        <?php echo $uName['cust_name'] . ' ' . $uName['cust_surname'] ?>
                      </div>
                      <?php
                    } else {
                      $userName = mysqli_query($conn, "SELECT  DISTINCT m.from_user , c.*  FROM messages m , customer c WHERE to_user ='0' AND m.from_user = c.cust_id ");
                      $uName = mysqli_fetch_assoc($userName);
                      $_SESSION['toUser'] = $uName['cust_id'];

                      if( $_SESSION['toUser'] != '') {
                      ?>
                       <input type="text" value='<?php echo $_GET["toUser"] ?> ' id="toUser" name="toUser" hidden/>
                      <div class="head-title">
                        <?php echo '  หมายเลขห้องพัก : ' . $uName['cust_username'] ?>
                      </div>
                      <div class="head-title">
                        <?php echo $uName['cust_name'] . ' ' . $uName['cust_surname'] ?>
                      </div>
                      <?php
                    } else {
                      echo '<h1>ไม่มีคำร้องแจ้งปัญหาห้องพัก</h1>'; 
                    }
                  }
                    ?>

                  </div>
                </div>

                <?php 
            if($_SESSION["toUser"] == '') ;
            else {
            ?>
                <div class="chatbox-row chatbox-row_fullheight">
                  <div class="chatbox-content" id="msgBody">

                    <?php
                    if (isset($_GET["toUser"])) {
                      $sqlChat = "SELECT * FROM messages WHERE (from_user = '" . $_SESSION["cust_id"] . "' AND
                                                to_user = '" . $_GET["toUser"] . "') OR (from_user = '" . $_GET["toUser"] . "' AND to_user = '" . $_SESSION["cust_id"] . "'  )";
                      $chats = mysqli_query($conn, $sqlChat);
                    } else {
                      $sqlChat = "SELECT * FROM messages WHERE (from_user = '" . $_SESSION["cust_id"] . "' AND
                                                to_user = '" . $_SESSION["toUser"] . "') OR (from_user = '" . $_SESSION["toUser"] . "' AND to_user = '" . $_SESSION["cust_id"] . "' ) ";
                      $chats = mysqli_query($conn, $sqlChat);
                    }

                    while ($chat = mysqli_fetch_assoc($chats)) {
                      if ($chat["from_user"] == $_SESSION["cust_id"]) {
                    ?>
                        <div class="message">
                          <!-- <div class="message-head">
                                        <span class="message-note"><?php //echo $uName['cust_name'] . ' ' . $uName['cust_surname']; 
                                                                    ?></span>
                                    </div> -->

                          <div class="message-base me">
                            <div class="message-head me">
                              <span class="message-note"><?php echo  $chat["date"]; ?></span>
                            </div>
                            <div class="message-textbox">
                              <span class="message-text"><?php echo  $chat["message"]; ?></span>
                            </div>
                          </div>
                        </div>

                      <?php
                      } else {
                      ?>
                        <div class="message">
                          <div class="message-base you">
                            <div class="message-textbox">
                              <span class="message-text"><?php echo  $chat["message"]; ?></span>
                            </div>
                            <div class="message-head">
                              <span class="message-note"><?php echo  $chat["date"]; ?></span>
                            </div>
                          </div>
                        </div>
                    <?php
                      }
                    }

                    ?>

                  </div>
                </div>

              


                <div class="chatbox-row">
                  <div class="enter">

                    <div class="enter-submit">
                      <button class="button button_id_submit" type="submit" <?php if($_SESSION["toUser"] == '') echo 'disabled' ?>>
                        <i class="fa fa-paper-plane"></i>
                      </button>
                    </div>
                    <div class="enter-textarea">
                      <textarea name="enterMessage" id="enterMessage" cols="30" rows="2" placeholder="ข้อความ..." <?php if($_SESSION["toUser"] == '') echo 'disabled' ?>></textarea>
                    </div>

                  </div>
                </div>
                <?php } ?>
              </form>
            </div>
        
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- <script>
        var input = document.getElementById("enterMessage");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("myBtn").click();
            }
        });
    </script> -->


  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
  <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> -->
    <script type="text/javascript">
        $(function() {
            setInterval(function() { // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
                // 1 วินาที่ เท่า 1000
                // คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
                $.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
                    url: "realtime.php",
                    method:"POST",
                    data: {
                      fromUser:'<?php echo $_SESSION['cust_id']?>',
                      toUser:"<?php if (isset($_GET["toUser"])) echo $_GET['toUser']; else echo $_SESSION['toUser'];?>"
                    },
                    dataType:"text",
                    success:function(data){
                    $("#msgBody").html(data); // ส่วนที่ 3 นำข้อมูลมาแสดง
                }
                });
                // location.reload(true);
            }, 3000);
        });
    </script>
</body>

</html>
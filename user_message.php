<?php
session_start();

//set menu admin page
$page = 'User messages';
$_GET['menu'] = $page;
// ----
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

// //คำสั่ง sql ในการดึงข้อมูล
// $strSQL = "SELECT * FROM employee WHERE emp_id = '" . $_SESSION['id'] . "' ";
// $objQuery = mysqli_query($conn, $strSQL);
// $objResult = mysqli_fetch_array($objQuery);

$_SESSION["cust_id"] = $_SESSION["id"];

$users = mysqli_query($conn, "SELECT * FROM customer WHERE cust_id = '" . $_SESSION["cust_id"] . "'");
$user = mysqli_fetch_assoc(($users));

?>

<!doctype html>
<html>
<!-- import menu page -->
<?php include('user_menu.php'); ?>
<link rel="stylesheet" href="css/style-chat.css">

<body>
  <div class="job p-0">
    <div class="modal-chat">
      <div class="modal-dialog">
        <div class="chat">

          <!-- <div class="modal-sidebar"> -->
            <!-- search by name  -->
            <!-- <div class="chat-search search">
              <div class="search">
                <div class="search-icon">
                  <i class="fa fa-search"></i>
                </div>
                <input type="search" class="search-input" placeholder="ค้นหา" value="">
              </div>
            </div> -->

            <!-- list customer chat -->
            <!-- <div class="chat-users">
              <ul class="users">
                  <li class="users-item users-item_group">
                    <div class="users-avatar avatar">
                      <a href="?toUser=0" class="avatar-wrap">
                        A
                      </a>
                    </div>
                    <span class="users-note">Admin</span>
                  </li>
              </ul>
            </div> -->
          <!-- </div> -->

          <div class="modal-main">
            <div class="chatbox">
              <form action="sentMessage.php" method="POST">
                <div class="chatbox-row">
                  <div class="head">
                    <div class="head-avatar avatar avatar_larger">
                      <a href="#" class="avatar-wrap">
                        A
                      </a>
                    </div>

                    <!-- <div class="head-title">MaximModus</div> -->

                
                      <input type="text" value='0' id="toUser" name="toUser" hidden/>
                      <div class="head-title">Admin</div>
                    

                  </div>
                </div>

                <div class="chatbox-row chatbox-row_fullheight">
                  <div class="chatbox-content" id="msgBody">

                    <?php
                    
                      $sqlChat = "SELECT * FROM messages WHERE (from_user = '" . $_SESSION["cust_id"] . "' AND
                                                to_user = '0') OR (from_user = '0' AND to_user = '" . $_SESSION["cust_id"] . "' ) ";
                      $chats = mysqli_query($conn, $sqlChat);
                    

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
                      <button class="button button_id_submit" type="submit">
                        <i class="fa fa-paper-plane"></i>
                      </button>
                    </div>
                    <div class="enter-textarea">
                      <textarea name="enterMessage" id="enterMessage" cols="30" rows="2" placeholder="ข้อความ..."></textarea>
                    </div>

                  </div>
                </div>
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
                      toUser:"0"
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
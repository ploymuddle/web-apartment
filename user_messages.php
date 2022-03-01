<?php
session_start();

//set menu admin page
$page = 'User messages';
$_GET['menu'] = $page;

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

// //ตรวจสอบการเข้าใช้งาน ถ้าไม่มีให้กลับไป login.php
if ($_SESSION['id'] == "") {
    header("location:login.php");
}

//กำหนด $_SESSION["cust_id"]
$_SESSION["cust_id"] = $_SESSION["id"];

//คำสั่ง sql ในการดึงข้อมูลลูกค้า search by cust_id
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

                <!-- หัวการแชท แสดงชื่อผู้ที่กำลังสนทนาด้วย -->
                  <div class="head">
                    <div class="head-avatar avatar avatar_larger">
                      <a href="#" class="avatar-wrap">
                        A
                      </a>
                    </div>
                
                      <input type="text" value='0' id="toUser" name="toUser" hidden/>
                      <div class="head-title">Admin</div>
                    
                  </div>
                  
                </div>

                <div class="chatbox-row chatbox-row_fullheight">
                  <div class="chatbox-content" id="msgBody">

                    <?php
                    // ค้นหาข้อมูลการแชท 
                    // เมื่อ from_user = cust_id และ to_user = admin_id(ที่มีค่า id = 0)
                    // หรือ from_user = admin_id และ to_user = cust_id
                      $sqlChat = "SELECT * FROM messages WHERE (from_user = '" . $_SESSION["cust_id"] . "' AND
                                                to_user = '0') OR (from_user = '0' AND to_user = '" . $_SESSION["cust_id"] . "' ) ";
                      $chats = mysqli_query($conn, $sqlChat);
                    
                    while ($chat = mysqli_fetch_assoc($chats)) {

                    // ถ้าลูกค้าเป็นคนส่ง จะแสดงข้อความทางด้านขวา
                      if ($chat["from_user"] == $_SESSION["cust_id"]) {
                    ?>
                        <div class="message">
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
                      } 
                      // ถ้าแอดมินเป็นคนส่ง จะแสดงข้อความทางด้านซ้าย
                      else {
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

  <script src="js/script-dropdown.js"></script>
  <script src="js/script.js"></script>
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
    <!-- ref:https://www.ninenik.com/%E0%B9%81%E0%B8%99%E0%B8%A7%E0%B8%97%E0%B8%B2%E0%B8%87_%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%94%E0%B8%B6%E0%B8%87%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5_%E0%B9%81%E0%B8%9A%E0%B8%9A_real_time_%E0%B8%94%E0%B9%89%E0%B8%A7%E0%B8%A2_ajax_%E0%B9%83%E0%B8%99_jQuery_-284.html -->
</body>

</html>
<?php
session_start();
require_once "connection.php";

$users = mysqli_query($conn, "SELECT * FROM customer WHERE cust_id = '" . $_SESSION["id"] . "'");
$user = mysqli_fetch_assoc(($users));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style-chat.css">
    <?php  include('admin_menu.php'); ?>
</head>

<body>

    <div class="modal-chat">
        <div class="modal-dialog">
            <div class="chat">

                <div class="modal-sidebar">

                    <!-- search by name  -->
                    <div class="chat-search search">
                        <div class="search">
                            <div class="search-icon">
                                <i class="fa fa-search"></i>
                            </div>
                            <input type="search" class="search-input" placeholder="ค้นหา" value="">
                        </div>
                    </div>

                    <!-- list customer chat -->
                    <div class="chat-users">
                        <ul class="users">

                            <?php
                            $msgs = mysqli_query($conn, "SELECT * FROM customer");
                            while ($msg = mysqli_fetch_assoc($msgs)) {
                            ?>

                                <li class="users-item users-item_group">
                                    <div class="users-avatar avatar">
                                        <a href="?toUser=<?php echo $msg["cust_id"]; ?>" class="avatar-wrap">
                                            M
                                        </a>
                                    </div>
                                    <span class="users-note"><?php echo $msg['cust_name'] . ' ' . $msg['cust_surname']; ?> </span>
                                    <div class="users-counter">
                                        <span class="counter">99+</span>
                                    </div>
                                </li>

                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="modal-main">
                    <div class="chatbox">

                        <div class="chatbox-row">
                            <div class="head">
                                <div class="head-avatar avatar avatar_larger">
                                    <a href="#" class="avatar-wrap">
                                        M
                                    </a>
                                </div>

                                <!-- <div class="head-title">MaximModus</div> -->

                                <?php
                                if (isset($_GET["toUser"])) {
                                    $userName = mysqli_query($conn, "SELECT * FROM customer WHERE cust_id = '" . $_GET["toUser"] . "' ");
                                    $uName = mysqli_fetch_assoc($userName);
                                    echo '<input type="text" value=' . $_GET["toUser"] . ' id="toUser" hidden/>';
                                    echo '<div class="head-title">' . $uName['cust_name'] . ' ' . $uName['cust_surname'] . '</div>';
                                } else {
                                    $userName = mysqli_query($conn, "SELECT * FROM customer ");
                                    $uName = mysqli_fetch_assoc($userName);
                                    $_SESSION['toUser'] = $uName['cust_id'];
                                    echo '<input type="text" value=' . $_SESSION["toUser"] . ' id="toUser" hidden/>';
                                    echo '<div class="head-title">' . $uName['cust_name'] . ' ' . $uName['cust_surname'] . '</div>';
                                }
                                ?>

                            </div>
                        </div>

                        <div class="chatbox-row chatbox-row_fullheight">
                            <div class="chatbox-content">

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
                                    } else {
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
                                }

                                ?>

                            </div>
                        </div>

                        <div class="chatbox-row">
                            <div class="enter">
                                <div class="enter-submit">
                                    <button class="button button_id_submit" type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                                <div class="enter-textarea">
                                    <textarea name="enterMessage" id="enterMessage" cols="30" rows="2" placeholder="ข้อความ..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var input = document.getElementById("enterMessage");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("myBtn").click();
            }
        });
    </script>

</body>


</html>
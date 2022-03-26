<?php   
session_start();
$conn = mysqli_connect('localhost','root','123456','myapartment');

$fromUser = $_SESSION["cust_id"];
$toUser = $_POST["toUser"];
$output = "";

$sqlChat = "SELECT * FROM messages WHERE (from_user = '" . $fromUser . "' AND
                            to_user = '" . $toUser . "') OR (from_user = '" . $toUser . "' AND to_user = '" . $fromUser . "'  )";
$chats = mysqli_query($conn, $sqlChat);
while ($chat = mysqli_fetch_assoc($chats)) {
    if ($chat["from_user"] == $fromUser) {
        $output.=
        '<div class="message">
        <div class="message-base me">
        <div class="message-head me">
        <span class="message-note">'.$chat["date"].'</span>
        </div>
        <div class="message-textbox">
        <span class="message-text">'.$chat["message"].'</span>
        </div>
        </div>
        </div>';
    } else {
        $output.=
        '<div class="message">
        <div class="message-base you">
        <div class="message-textbox">
        <span class="message-text">'.$chat["message"].'</span>
        </div>
        <div class="message-head">
        <span class="message-note">'.$chat["date"].'</span>
        </div>
        </div>
        </div>';
    }
}

echo $output;

?>
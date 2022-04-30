<?php 
session_start();

//เชื่อมต่อฐานข้อมูล
require_once "connection/connection.php";

if(isset($_POST['enterMessage']) && !(strlen($_POST['enterMessage']) == 0) ) {
    $msg = $_POST['enterMessage'];
    if(isset($_POST['toUser'])) {
        $to = $_POST['toUser'];
    }
    
    $from = $_SESSION["cust_id"];
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y-m-d H:i:s");
    
    //add chat
    $sql = " INSERT INTO messages (from_user, to_user, message, date, isFlagRead) 
                            VALUE ('$from', '$to', '$msg', '$date','N') ";
    $result = mysqli_query($conn, $sql);
    
                if ($result) {
                    $_SESSION['success'] = "Insert user successfully";
                    if($from == '0') {
                        header("Location: admin_messages.php?toUser=".$to);
                    } else {
                        header("Location: user_messages.php?toUser=".$to);
                    }
                } else {
                    // $_SESSION['error'] = "Something went wrong";
                    // header("Location: admin_messages.php");
                    echo $sql;
                }
} else  if(isset($_POST['toUser'])) {
    header("Location: admin_messages.php?toUser=".$_POST['toUser']);
} else {
    header("Location: admin_messages.php");
}

exit();

?>
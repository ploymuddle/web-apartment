<?php 
$conn = mysqli_connect('localhost','root','','myapartment');

$id = $_POST['roomId'];
$type = $_POST['roomType'];
$status = 'N';

//add contract
$sql = " INSERT INTO room (room_id, room_status, type_room) VALUE ('$id', '$status', '$type') ";
$result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_room.php");
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: admin_addroom.php");
            }

exit();

?>
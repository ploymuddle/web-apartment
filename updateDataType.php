<?php 
$conn = mysqli_connect('localhost','root','','myapartment');

$type = $_POST['roomType'];
$data = $_POST['roomData'];
$rental = $_POST['roomRental'];

$pic ='images/'.$_FILES['pic']['name'];
move_uploaded_file($_FILES['pic']['tmp_name'],$pic);

// update data
$sqlUpdate = "UPDATE room_type SET type_data = '$data' , type_rental = '$rental'  ";
if($_FILES['pic']['name']!=''){
$sqlUpdate = $sqlUpdate . " , type_picture = '$pic' ";
}
$sqlUpdate = $sqlUpdate . " WHERE type_room = '$type' ";

$result = mysqli_query($conn, $sqlUpdate);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_room.php");
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: admin_room.php");
            }

exit();

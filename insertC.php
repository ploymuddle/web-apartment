<?php 
$conn = mysqli_connect('localhost','root','','myapartment');

$file='file/'.$_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'],$file)) 
{
    
}
else {
    echo 'not';
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$number = $_POST['tel'];
$username = $_POST['roomId'];
$password = $_POST['roomId'];

$date = $_POST['contractDate'];
$roomId = $_POST['roomId'];
$deposit = $_POST['contract'];
$img_document = $_POST['file'];

//add customer
$queryInsertCust = "INSERT INTO customer (cust_name, cust_surname, cust_tel, cust_email, cust_username, cust_status, cust_password)
                        VALUE ('$name', '$surname', '$number', '$email', '$username' , 'live', '$password')";
$resultInsertCust = mysqli_query($conn, $queryInsertCust);

//query cust_id
$resultId = mysqli_insert_id($conn);
echo "<script>console.log( 'status: " . $resultId . "')</script>";

//update room
$sqlUpdateRoom = "UPDATE room SET room_status = 'O' WHERE room_id = '$roomId'";
$result = mysqli_query($conn, $sqlUpdateRoom);

//add contract
$sql = "INSERT INTO contract (con_checkin, room_id, con_deposit, cust_id, img_document, img_contract, con_status)
                        VALUE ('$date', '$roomId', '$deposit', '$resultId' , '$img_document' , 'www', 'O')";

$result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_contract.php");
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: admin_contract.php");
            }



exit();

?>
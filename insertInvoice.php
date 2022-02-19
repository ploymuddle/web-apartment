<?php 
$conn = mysqli_connect('localhost','root','','myapartment');

$roomId = $_POST['roomId'];
$custId = $_POST['cust_id'];
$name = $_POST['name'];
$suername = $_POST['surname'];
$date = $_POST['date'];
$rental = $_POST['roomRent'];
$FM = $_POST['FM'];
$FU = $_POST['FM'] - $_POST['FM_before'];
$penalty = $_POST['penalty'];
$WM = $_POST['WM'];
$WU = $_POST['WM'] - $_POST['WM_before'];
echo $_POST['WM_before'];
$total = $_POST['total'];
$status = 'ยังไม่ได้จ่าย';

//add bill
$sql = " INSERT INTO invoice (cust_id, room_id, inv_fire_meter, inv_fire_unit, inv_water_meter, inv_water_unit,inv_rental,inv_penalty,inv_total,inv_status,inv_date) 
                        VALUE ('$custId', '$roomId', '$FM', '$FU', '$WM', '$WU', '$rental', '$penalty', '$total', '$status','$date') ";
$result = mysqli_query($conn, $sql);


            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_create_bill.php");
            } else {
                // $_SESSION['error'] = "Something went wrong";
                // header("Location: insertInvoice.php");
                echo $sql;
            }

exit();

?>
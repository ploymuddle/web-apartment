<?php 
$conn = mysqli_connect('localhost','root','123456','myapartment');

if(isset($_POST['FM_before'])) {
    $FU = 0;
} else {
    $FU = $_POST['FM'] - $_POST['FM_before'];
}

if(isset($_POST['WM_before'])) {
    $WU = 0;
} else {
    $WU = $_POST['WM'] - $_POST['WM_before'];
}


$roomId = $_POST['roomId'];
$custId = $_POST['cust_id'];
$name = $_POST['name'];
$suername = $_POST['surname'];
$date = $_POST['date'];
$deadtime = $_POST['deadtime'];
$rental = $_POST['roomRent'];
$FM = $_POST['FM'];
$penalty = $_POST['penalty'];
$WM = $_POST['WM'];
$total = $_POST['total'];

//add invoice
$sqlInvoice = " INSERT INTO invoice (cust_id, room_id, inv_fire_meter, inv_fire_unit, inv_water_meter, inv_water_unit,inv_rental,inv_penalty,inv_total,inv_date,inv_deadtime) 
                        VALUE ('$custId', '$roomId', '$FM', '$FU', '$WM', '$WU', '$rental', '$penalty', '$total','$date','$deadtime') ";
$resultInvoice = mysqli_query($conn, $sqlInvoice);

//query cust_id
$resultId = mysqli_insert_id($conn);
// echo "<script>console.log( 'resultId: " . $resultId . "')</script>";

//add payment in status ค้างชำระ
$sql = " INSERT INTO payment (inv_id,cust_id,pay_status,pay_amount	) 
                        VALUE ('$resultId','$custId', 'ค้างชำระ',0) ";

$result = mysqli_query($conn, $sql);


            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header("Location: admin_update_bill.php");
            } else {
                // $_SESSION['error'] = "Something went wrong";
                // header("Location: insertInvoice.php");
                echo $sqlInvoice;
            }

exit();

?>
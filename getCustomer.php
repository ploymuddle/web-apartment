<?php
$q = intval($_GET['q']);

//เชื่อมต่อฐานข้อมูล
require_once "connection/connection.php";

$sql="SELECT * FROM customer WHERE cust_id = '".$q."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {

    $hint = array(
        "cust_name"=> $row['cust_name'],
        "cust_surname"=> $row['cust_surname'],
        "cust_tel"=> $row['cust_tel'],
        "cust_email"=> $row['cust_email'],
        "cust_username"=> $row['cust_username'],
        "cust_id"=> $row['cust_id']
    );

  }

//   echo $hint === "" ? "no suggestion" : $hint;

echo json_encode($hint);


mysqli_close($conn);
?>

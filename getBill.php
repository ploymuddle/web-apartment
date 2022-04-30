<?php
$q = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection/connection.php";
$sql="SELECT * FROM invoice i,customer c,payment p WHERE  i.cust_id = c.cust_id AND i.inv_id = p.inv_id AND i.cust_id = '" .$q. "' ORDER BY i.inv_date DESC";
// echo $sql;
$query = mysqli_query($conn,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($conn);
?>

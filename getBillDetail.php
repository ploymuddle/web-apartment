<?php
$q = $_GET['q'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";
$sql="SELECT * 
FROM payment p 
INNER JOIN invoice i ON p.inv_id = i.inv_id 
INNER JOIN customer c ON i.cust_id = c.cust_id 
INNER JOIN contract co ON co.cust_id = c.cust_id 
WHERE i.inv_id = '".$q."' " ;
// echo $sql;
$query = mysqli_query($conn,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($conn);
?>

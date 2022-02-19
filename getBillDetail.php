<?php
$q = $_GET['q'];

$con = mysqli_connect('localhost','root','','myapartment');
$sql="SELECT * FROM customer cu ,  room r , room_type rt , invoice i
 WHERE  cu.cust_id = i.cust_id 
 AND r.room_id = i.room_id 
 AND r.type_room = rt.type_room 
 AND i.inv_id = '".$q."' " ;
// echo $sql;
$query = mysqli_query($con,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($con);
?>

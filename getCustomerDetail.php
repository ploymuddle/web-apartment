<?php
$q = $_GET['q'];

$con = mysqli_connect('localhost','root','','myapartment');
$sql="SELECT * FROM contract co, customer cu ,  room r , room_type rt 
 WHERE  cu.cust_id = co.cust_id 
 AND r.room_id = co.room_id 
 AND r.type_room = rt.type_room 
 AND cu.cust_id = '".$q."'";

$query = mysqli_query($con,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($con);
?>

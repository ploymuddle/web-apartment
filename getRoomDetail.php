<?php
$q = $_GET['q'];

$con = mysqli_connect('localhost','root','123456','myapartment');
$sql="SELECT * FROM contract co, customer cu ,  room r , room_type rt 
 WHERE  cu.cust_id = co.cust_id 
 AND r.room_id = co.room_id 
 AND r.type_room = rt.type_room 
 AND co.con_status = 'O'
 AND co.room_id = '".$q."' " ;
// echo $sql;
$query = mysqli_query($con,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($con);
?>

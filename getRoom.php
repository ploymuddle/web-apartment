<?php
$q = $_GET['q'];

$con = mysqli_connect('localhost','root','','myapartment');
$sql=" SELECT * FROM room r,room_type rt WHERE r.type_room =  rt.type_room AND  r.room_id = '". $q ."' ";
$query = mysqli_query($con, $sql);
$json = array();
// echo $sql;

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
<?php
$q = $_GET['q'];

$con = mysqli_connect('localhost','root','','myapartment');
$sql=" SELECT * FROM room_type WHERE type_room = '". $q ."' ";
$query = mysqli_query($con, $sql);
$json = array();
// echo $sql;

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);
?>
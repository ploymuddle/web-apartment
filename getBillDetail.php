<?php
$q = $_GET['q'];

$con = mysqli_connect('localhost','root','123456','myapartment');
$sql="SELECT * 
FROM payment p 
INNER JOIN invoice i ON p.inv_id = i.inv_id 
INNER JOIN customer c ON i.cust_id = c.cust_id 
WHERE i.inv_id = '".$q."' " ;
// echo $sql;
$query = mysqli_query($con,$sql);
$json = array();

while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);

mysqli_close($con);
?>

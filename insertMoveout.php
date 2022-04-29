<?php

$id = $_GET['id'];

//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

//query room status
$sqlInsert = "INSERT INTO moveout (cust_id, status) VALUE ('$id', 'ขอย้ายออก')";
$queryInsert = mysqli_query($conn, $sqlInsert);

echo $sqlInsert;

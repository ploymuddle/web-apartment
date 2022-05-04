<?php 
    $conn = mysqli_connect("localhost", "root", "123456", "myapartment");


    if(!$conn) {
        die("Failed to connec to database");
    }

    $conn->set_charset("utf8");
?>
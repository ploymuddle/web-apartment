<?php 
    $conn = mysqli_connect("localhost", "root", "123456", "myapartment");

    if(!$conn) {
        die("Failed to connec to database");
    }
?>
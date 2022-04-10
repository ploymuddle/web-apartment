<?php 
    $conn = mysqli_connect("localhost", "root", "", "myapartment");

    if(!$conn) {
        die("Failed to connec to database");
    }
?>
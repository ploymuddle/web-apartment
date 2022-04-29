<?php 
session_start();
require_once "connection.php";

$id = $_GET['id'];
$move = $_GET['move'];

if ($move == 'room') {
    header("Location: updateContract.php?id=".$id.'&');

} else if ($move == 'out'){
    header("Location: updateContract.php?id=".$id);
}
exit();
?>
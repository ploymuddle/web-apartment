<?php
	session_start();
	require_once "connection.php";
	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];
	// $mysql = mysqli_connect("localhost","root","","myapartment");
	$strSQL = "SELECT * FROM user WHERE username = '".$username."' and password = '".$password."';";
	// echo "<script>console.log( '" . $strSQL . "')</script>";
	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);

	if(!$objResult)
	{
			echo "Username and Password Incorrect!";
	}
	else
	{
			$_SESSION["username"] = $objResult["username"];
			$_SESSION["role"] = $objResult["userlevel"];

			session_write_close();
			
			if($objResult["userlevel"] == "A")
			{
				header("location:admin_page.php");
			}
			else
			{
				header("location:user_page.php");
			}
	}
	// mysqli_close($mysql);
?>
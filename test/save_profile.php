<?php
	session_start();
    require_once "connection.php";
	if($_SESSION['username'] == "")
	{
		echo "Please Login!";
		exit();
	}

	
	if($_POST["txtPassword"] != $_POST["txtConPassword"])
	{
		echo "Password not Match!";
		exit();
	}
	$strSQL = "UPDATE user SET password = '".trim($_POST['txtPassword'])."' 
	,firstname = '".trim($_POST['txtName'])."' WHERE username = '".$_SESSION["username"]."' ";
	$objQuery = mysqli_query($conn,$strSQL);
	
	echo "Save Completed!<br>";		
	
	if($_SESSION["role"] == "A")
	{
		echo "<br> Go to <a href='admin_page.php'>Admin page</a>";
	}
	else
	{
		echo "<br> Go to <a href='user_page.php'>User page</a>";
	}
	
	// mysqli_close();
?>
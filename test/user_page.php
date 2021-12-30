<?php
	session_start();
    require_once "connection.php";
	if($_SESSION['username'] == "")
	{
		echo "Please Login!";
		exit();
	}

	if($_SESSION['role'] != "U")
	{
		echo "This page for User only!";
		exit();
	}	

	$strSQL = "SELECT * FROM user WHERE username = '".$_SESSION['username']."' ";
	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);
?>
<html>
<head>
<title>ThaiCreate.Com Tutorials</title>
</head>
<body>
  Welcome to User Page! <br>
  <table border="1" style="width: 300px">
    <tbody>
      <tr>
        <td width="87"> &nbsp;Username</td>
        <td width="197"><?php echo $objResult["username"];?>
        </td>
      </tr>
      <tr>
        <td> &nbsp;Name</td>
        <td><?php echo $objResult["firstname"];?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <a href="edit_profile.php">Edit</a><br>
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>
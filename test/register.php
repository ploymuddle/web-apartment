<?php 
    session_start();
    require_once "connection.php";
    if (isset($_POST['submit'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $user_check = "SELECT * FROM user WHERE username = \"".$username."\" ";
        echo "<script>console.log('SQL: " . $user_check . "' );</script>";
        $result = mysqli_query($conn, $user_check);
        echo "<script>console.log('result: " . $result . "' );</script>";
        // $user = mysqli_fetch_assoc($result);
        // echo "<script>console.log('result: " . $user . "' );</script>";

        // if ($user['username'] === $username) {
        //     echo "<script>alert('Username already exists');</script>";
        // } else { 
        //     $passwordenc = md5($password);
        //     $query = "INSERT INTO user (username, password, firstname, lastname, userlevel)
        //                 VALUE ('$username', '$passwordenc', '$fname', '$name', 'a')";
        //     $result = mysqli_query($conn, $query);
            
        //     if ($result) {
        //         $_SESSION['success'] = "Insert user successfully";
        //         header("Location: index.php");
        //     } else {
        //         $_SESSION['error'] = "Something went wrong";
        //         header("Location: index.php");
        //     }
        // }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <!-- <link rel="stylesheet" href="style.css"> -->

</head>
<body>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="username">Username:</label><br>
        <input type="text" name="username" require><br>
        <label for="password">Password:</label><br>
        <input type="text" name="password" require><br><br>
        <label for="fname">First name:</label><br>
        <input type="text" name="fname" require><br>
        <label for="lname">Last name:</label><br>
        <input type="text" name="lname" require><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Go back to index</a>
    
</body>
</html>
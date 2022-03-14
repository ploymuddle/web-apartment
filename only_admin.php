<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style-page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <div>
    <h1><?php echo $_SESSION['page_error'] ?> !</h1>

    <?php if ($_SESSION['status']  == "admin") { ?>
        <a type="submit" href="admin_home.php">กลับไปหน้าแรก</a>
    <?php  } else { ?>
        <a type="submit" href="user_profile.php">กลับไปหน้าแรก</a>
    <?php } ?>

    </div>
</body>

</html>
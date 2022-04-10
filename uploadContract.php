<?php
session_start();
//เชื่อมต่อฐานข้อมูล
require_once "connection.php";

?>

<!doctype html>
<html>

<!-- import menu page -->
<?php //include('admin_menu.php'); 
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <meta http-equiv="X-Compatible" content="ie=edge">
    <title><?php echo $page; ?></title>

    <link rel="stylesheet" href="css/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/1c68c00305.js" crossorigin="anonymous"></script>
    <!--< คำสั่งชื่อมต่อ สำหลับใช้งานการปิด/เปิด ต่างๆ ในแถบเมนู >-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <div class="my-20">
        <h1 class="title d-flex content-center">Upload สัญญาใหม่</h1>

        <div class="box bg-white">

            <form method="POST" action="contractFile.php" enctype="multipart/form-data" target="_blank">

                <input type="text" id="id" name="id" value="<?php echo $_GET['id'] ?>" hidden>

                <div class="d-flex content-center">
                    <label>หมายเลขสัญญา <?php echo $_GET['id'] ?></label>
                </div>

                <div class="d-flex content-center my-20">

                    <button type="submit" class="btnbtn-add">สร้างสัญญาใหม่ แล้วทำการบันทึกสัญญา</button>
                </div>

            </form>

            <form method="POST" action="insertContractFile.php" enctype="multipart/form-data">
                <div class="grid-upload col-30 box">
                    <label for="file">เอกสารสัญญา:</label>
                    <input type="file" id="file" name="file">
                    <input type="text" id="id" name="id" value="<?php echo $_GET['id'] ?>" hidden>
                </div>
                <hr>

                <div class="d-flex content-center">
                    <button class="btn" type="submit">บันทึกรายการ</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>

</body>

</html>
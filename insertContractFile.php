<?php 
$conn = mysqli_connect('localhost','root','','myapartment');

$file='file/'.$_FILES['file']['name'];
$id = $_POST['id'];

if(move_uploaded_file($_FILES['file']['tmp_name'],$file)) 
{
    
}
else {
    echo 'not';
}

//update
$sql = " UPDATE contract SET img_contract = '$file' WHERE con_id = '$id' ";        

$result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success'] = "Insert user successfully";
                header('Location: admin_customer.php');
            } else {
                $_SESSION['error'] = "Something went wrong";
                header("Location: uploadContract.php?id=".$resultCon);
            }
            
exit();

?>
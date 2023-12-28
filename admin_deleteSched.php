<?php
$schedId = $_GET['id'];
$con = mysqli_connect("localhost","root","","kinder_class");
$sql = "DELETE FROM class_schedule WHERE id ='$schedId'";
$result = mysqli_query($con, $sql);
if($result)
{
    header("location: admin_home.php");
}

?>
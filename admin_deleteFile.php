<?php
$id = $_GET['id'];
$con = mysqli_connect("localhost","root","","kinder_class");
$sql = "DELETE FROM files WHERE id ='$id'";
$result = mysqli_query($con, $sql);
if($result)
{
    header("location: admin_academicResources.php");
}

?>
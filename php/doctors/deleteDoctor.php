<?php
require_once "../connect.php";
require_once "../authorization.php";

$DoctorIdDelete = $_POST["DoctorIdDelete"];

$sql  = "DELETE FROM doctor WHERE DoctorId='".$DoctorIdDelete."'";

$result = mysqli_query($link,$sql);
if($result)
{
    $msg = "The doctor successfully deleted.";
}
else
{
    $msg = mysqli_error($link);
}
echo $msg;
?>
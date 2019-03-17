<?php
require_once "../connect.php";
require_once "../authorization.php";

if(isset($_POST["Mashinid"]))
{
    $machineId = $_POST["Mashinid"];
}
else
{
    echo "Mashinid отсутствует.";
    return;
}
$sql = "SELECT COUNT(*) AS machineIdCount FROM reagent WHERE Mashinid='".$machineId."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $machineIdCount = $row["machineIdCount"];
    if($machineIdCount > 0)
    {
        echo true;
    }
    else
    {
        echo false;
    }
}
?>
<?php
require_once "../connect.php";
require_once "../authorization.php";

if(isset($_POST["ReagentId"]))
{
    $reagentId = $_POST["ReagentId"];
}
else
{
    echo "reagentId отсутствует.";
    return;
}
$sql = "SELECT Mashinid FROM reagent WHERE ReagentId='".$reagentId."'";
$result = mysqli_query($link,$sql);
$rowsCount=mysqli_num_rows($result);
if($rowsCount > 0)
{
    $row = mysqli_fetch_array($result);
    $machineId = $row["Mashinid"];
    echo $machineId;
}
else
{
    echo -1;
}
?>
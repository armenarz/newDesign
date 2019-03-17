<?php
require_once "../connect.php";
require_once "../authorization.php";

$ReagentIdDelete = $_POST["ReagentIdDelete"];

$sql  = "DELETE FROM reagent WHERE ReagentId='".$ReagentIdDelete."'";

$result = mysqli_query($link,$sql);
if($result)
{
    $msg = "Reagent successfully deleted.";
}
else
{
    $msg = mysqli_error($link);
}
echo $msg;
?>
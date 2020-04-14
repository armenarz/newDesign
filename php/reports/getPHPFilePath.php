<?php
require_once "../connect.php";
require_once "../authorization.php";

$userId = $_POST["user_id"];

$sql = "SELECT phpFilePath FROM user_menus WHERE userId='$userId' AND menuId=2";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    echo $row["phpFilePath"];
    return;
}
?>
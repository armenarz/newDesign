<?php
require_once "../connect.php";
require_once "../authorization.php";

$userId = $_POST["user_id"];

if($userId == 800) {
	$sql = "SELECT phpFilePath FROM user_menus WHERE userId='$userId' AND menuId=3";
	$result = mysqli_query($link,$sql);
	if($result)
	{
		$row = mysqli_fetch_array($result);
		echo $row["phpFilePath"];
		return;
	}
}

elseif($userId == 202) {
	echo '../orders_frm.php';
	return;
}

else {
	$sql = "SELECT phpFilePath FROM user_menus WHERE userId='$userId' AND menuId=2";
	$result = mysqli_query($link,$sql);
	if(mysqli_num_rows($result) == 0) {
		echo '';
		return;
	}
	if($result)
	{
		$row = mysqli_fetch_array($result);
		echo $row["phpFilePath"];
		return;
	}
}
?>
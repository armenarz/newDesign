<?php
if(!$_POST["uu"])
{
	header("Location: ../../index.php");
	return;
}
$uu=$_POST["uu"];
$userId = $uu;

$num_pac=$_POST["num_pac"];
if(!isset($_POST["num"]))
{
	$sql="select OrderId from orders WHERE user_id='".$uu."' order by OrderId desc limit 0,1";
	$result = mysqli_query($link,$sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$num=$row["OrderId"];
	}
}
else
{
	$num=$_POST["num"];
}
?>
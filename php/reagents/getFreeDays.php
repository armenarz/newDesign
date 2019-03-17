<?php
require_once "../connect.php";
require_once "../authorization.php";

//$sql = "SELECT id, weekend FROM weekends WHERE MONTH(weekend)='".$currentMonth."' ORDER BY id";
$sql = "SELECT id, weekend FROM weekends ORDER BY id";
$result = mysqli_query($link, $sql);
if($result)
{
	$freeDays = array();
	while ($row = mysqli_fetch_array($result)) 
	{
		array_push($freeDays, $row["weekend"]);
	}
	echo json_encode($freeDays);
	return;
}
echo "[]";
?>
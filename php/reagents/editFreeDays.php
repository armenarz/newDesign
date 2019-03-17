<?php
require_once "../connect.php";
require_once "../authorization.php";

if(isset($_POST["selectedDate"]))
{
    $selectedDate = $_POST["selectedDate"];

    $sql = "SELECT COUNT(*) AS cnt FROM weekends WHERE weekend='".$selectedDate."'";
	$result = mysqli_query($link, $sql);
    if($result)
    {
		$row = mysqli_fetch_array($result);
		$cnt = $row["cnt"];
	}

    if($cnt == 1)
    {
		$sql = "DELETE FROM weekends WHERE weekend = '".$selectedDate."' ";
		$res = mysqli_query($link, $sql);
	}
    else 
    {
		$sql = "INSERT INTO weekends (weekend) VALUES ('".$selectedDate."') ";
		$res = mysqli_query($link, $sql);
	}
}
echo "selectedDate=".$selectedDate;
?>
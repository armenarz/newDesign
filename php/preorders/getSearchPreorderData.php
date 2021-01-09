<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../shorten.php";

$arr = array();

$sql = "SELECT preorderId, customerLastName, customerFirstName, customerMidName FROM preorders ORDER BY preorderId";

$result = mysqli_query($link, $sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $label = FillNonBreak($row["preorderId"],4).' '.$row["customerLastName"].' '.$row["customerFirstName"].' '.$row["customerMidName"];
        array_push($arr, $label);
    }
}

$msg = json_encode($arr);

echo $msg;
return;
?>
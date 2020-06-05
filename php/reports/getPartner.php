<?php
require_once "../connect.php";
require_once "../authorization.php";

$sql = "SELECT 
            id, 
            partner 
        FROM partners 
        ORDER BY sorting
        ";
$partner = array();
$result = mysqli_query($link, $sql);
if($result)
{
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            array_push($partner,$row["partner"]);
        }
    }
}
$partner = json_encode($partner);
echo $partner;
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/p108/files/php/connect.php";

function rawPreordersCount($link)
{
    $sql = "SELECT 
                count(preorderId) AS rawPreordersCount 
            FROM preorders 
            WHERE preorderStatus='1'";

    $result = mysqli_query($link,$sql);
    $rawPreordersCount = 0;
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            $rawPreordersCount = $row["rawPreordersCount"];
        }
    }
    if($rawPreordersCount == 0) $rawPreordersCount = null;
    return $rawPreordersCount;
}
?>
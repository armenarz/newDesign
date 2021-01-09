<?php
require_once "../connect.php";
require_once "../authorization.php";

$msg = '<option value="0" selected></option>';

$sql = "SELECT 
            DATE(preorderDate) AS preorder_date
        FROM preorders 
        GROUP BY preorder_date
        ORDER BY preorder_date DESC";

$result = mysqli_query($link,$sql);
if($result)
{
    $preorderEndDateIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
/*         if($preorderEndtDateIndex == 0)
        {
            $msg .=  '<option value="'.$row["preorder_date"].'" selected>'.$row["preorder_date"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["preorder_date"].'">'.$row["preorder_date"].'</option>';
        }
        $preorderStartDateIndex++; */
        $msg .=  '<option value="'.$row["preorder_date"].'">'.$row["preorder_date"].'</option>';
    }
}

echo $msg;
return;
?>

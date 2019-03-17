<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

$arr = array();

$sql  = "SELECT GroupId, GroupDesc, GroupDescRus, sorting FROM reagentgroup";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $category = ConcatWithBrackets($row["GroupDesc"],$row["GroupDescRus"]);

        $sql_reagent = "SELECT ReagentId, ReagentDesc, ReagentDescRus FROM reagent WHERE GroupId='".$row['GroupId']."' ORDER BY ReagentId";
        $result_reagent = mysqli_query($link,$sql_reagent);
        if($result_reagent)
        {
            while($row_reagent = mysqli_fetch_array($result_reagent))
            {
                $arrIn = array();
                $label = FillNonBreak($row_reagent["ReagentId"],4).'&nbsp;'.ConcatWithBrackets($row_reagent["ReagentDesc"],$row_reagent["ReagentDescRus"]);      
                array_push($arrIn,$label);
                array_push($arrIn,$category);
                array_push($arr,$arrIn);
            }
        }
    }
}
$msg = json_encode($arr);

echo $msg;
return;
?>
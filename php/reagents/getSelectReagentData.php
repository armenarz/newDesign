<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

$msg = '<option value="0"></option>';

$sql  = "SELECT GroupId, GroupDesc, GroupDescRus, sorting FROM reagentgroup";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .= '<optgroup label="'.ConcatWithBrackets($row["GroupDesc"],$row["GroupDescRus"]).'">';

        $sql_reagent = "SELECT ReagentId, ReagentDesc, ReagentDescRus FROM reagent WHERE GroupId='".$row['GroupId']."' ORDER BY ReagentId";
        $result_reagent = mysqli_query($link,$sql_reagent);
        if($result_reagent)
        {
            while($row_reagent = mysqli_fetch_array($result_reagent))
            {
                $msg .= '<option value="'.$row_reagent["ReagentId"].'">';
                $msg .= FillNonBreak($row_reagent["ReagentId"],4).'&nbsp;'.ConcatWithBrackets($row_reagent["ReagentDesc"],$row_reagent["ReagentDescRus"]);
                $msg .= '</option>';
            }
        }

        $msg .= '</optgroup>';
    }
}
echo $msg;
return;
?>
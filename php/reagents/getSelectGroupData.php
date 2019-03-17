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
        $msg .=  '<option value="'.$row["GroupId"].'"';
        // if($GroupId == $row["GroupId"]) $msg .= ' selected';
        $msg .='>'.FillNonBreak($row["GroupId"],2).'&nbsp;'.ConcatWithBrackets($row["GroupDesc"],$row["GroupDescRus"]).'</option>';
    }
}
echo $msg;
return;
?>
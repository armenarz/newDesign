<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

$msg = '<option value="0"></option>';

$sql  = "SELECT salesId, salesName FROM sales WHERE salesId<>'1' ORDER BY salesName";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["salesId"].'"';
        $msg .='>'.FillNonBreak($row["salesId"],2).'&nbsp;'.$row["salesName"].'</option>';
    }
}
echo $msg;
return;
?>
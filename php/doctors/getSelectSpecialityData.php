<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../shorten.php";

$msg = '<option value="0"></option>';

$sql  = "SELECT MethodId, Method FROM profession ORDER BY Method";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["MethodId"].'"';
        $msg .='>'.FillNonBreak($row["MethodId"],2).'&nbsp;'.Shorten($row["Method"],20).'</option>';
    }
}
echo $msg;
return;
?>
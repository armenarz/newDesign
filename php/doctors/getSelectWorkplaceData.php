<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../shorten.php";

$msg = '<option value="0"></option>';

$sql  = "SELECT WorkPlaceId, WorkPlaceDesc FROM cworkplace";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["WorkPlaceId"].'"';
        $msg .='>'.FillNonBreak($row["WorkPlaceId"],3).'&nbsp;'.Shorten($row["WorkPlaceDesc"]).'</option>';
    }
}
echo $msg;
return;
?>
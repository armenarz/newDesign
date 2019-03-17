<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";

$msg = '<option value="0"></option>';

$sql = "SELECT MethodId, Method FROM method";

$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .= '<option value="'.$row["MethodId"].'">';
        $tempMethodId  = FillNonBreak($row["MethodId"],2).'&nbsp;';
        $tempMethod = $row["Method"];
		if(mb_strlen($tempMethod,'UTF-8')>23)$tempMethod = mb_substr($row["Method"],0,20,'UTF-8')."&hellip;";
        $msg .=     $tempMethodId.$tempMethod;
        $msg .= '</option>';
    }
}
echo $msg;
return;
?>
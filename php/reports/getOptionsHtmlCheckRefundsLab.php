<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../user_to_name.php";

if(!isset($_POST["reportDate"]))
{
    $msg .= "The report date is not defined.";
    echo $msg;
    return;
}
$reportDate = $_POST["reportDate"];

$sql = "SELECT 
            check_vozvrat.orderid, 
            check_vozvrat.summa, 
            check_vozvrat.lab, 
            TIME(check_vozvrat.check_date) AS check_date1, 
            us22.id 
        FROM check_vozvrat 
        INNER JOIN us22 ON check_vozvrat.usrid=us22.id
        WHERE DATE(check_vozvrat.check_date)='$reportDate' AND check_vozvrat.checked=0 AND 
            (check_vozvrat.usrid='2' OR check_vozvrat.usrid='137' OR check_vozvrat.usrid='68' OR 
            check_vozvrat.usrid='143' OR check_vozvrat.usrid='202' OR check_vozvrat.usrid='256'	OR 
            check_vozvrat.usrid='10' OR check_vozvrat.usrid='66' OR check_vozvrat.usrid='258' OR 
            check_vozvrat.usrid='198' OR check_vozvrat.usrid='200' OR check_vozvrat.usrid='392' OR 
            check_vozvrat.usrid='394' OR check_vozvrat.usrid='396' OR check_vozvrat.usrid='398'	OR 
            check_vozvrat.usrid='564' OR check_vozvrat.usrid='566' OR check_vozvrat.usrid='568')
        ORDER BY check_vozvrat.check_date ";
$result = mysqli_query($link, $sql);
$html = '';
if($result)
{
    $html = '<option></option>';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' '.(-$row["summa"]).' '.usr_to_name($link, $row["id"], $reportDate).' '.$row["lab"].' '.$row["check_date1"].'</option>';
        }
    }
}

echo $html;
?>
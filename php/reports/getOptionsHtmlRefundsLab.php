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
            vozvrat.orderid,
            vozvrat.vozvrat_sum,
            us22.id, 
            TIME(vozvrat.vozvrat_date) AS vozvrat_date 
        FROM vozvrat
        INNER JOIN us22 ON vozvrat.uu=us22.id 
        WHERE 
        DATE(vozvrat.vozvrat_date)='$reportDate'";
        $result = mysqli_query($link,$sql);
        $html = '';
        if($result)
        {
            $html = '<option></option>';
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_array($result)) 
                {
                    $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["vozvrat_sum"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["vozvrat_date"].'</option>';
                }
            }
        }

echo $html;
?>
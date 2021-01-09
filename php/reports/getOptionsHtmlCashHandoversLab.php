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
            prochee_all.sdano,
            us22.id, 
            prochee_all.strip_time, 
            labs.lab 
        FROM prochee_all 
        INNER JOIN us22 ON prochee_all.uu=us22.id
        INNER JOIN labs ON prochee_all.lab_id=labs.id
        WHERE 
            prochee_all.strip_date='$reportDate'
		ORDER BY prochee_all.strip_time";
$result = mysqli_query($link, $sql);
$html = '';
if($result)
{
    $html = '<option></option>';
    if(mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result)) 
        {
            if($row['sdano']!=0)
            {
                $html.= '<option>'.$row["sdano"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["strip_time"].' | '.$row["lab"].'</option>';
            }
        }
    }
}

echo $html;
?>
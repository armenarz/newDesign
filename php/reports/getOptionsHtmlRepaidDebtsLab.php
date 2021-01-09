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
            vernuli_dolg.orderid,
            vernuli_dolg.dolg,
            us22.id, 
            TIME(vernuli_dolg.vernuli_date) AS vernuli_date 
        FROM vernuli_dolg
        INNER JOIN us22 ON vernuli_dolg.uu=us22.id 
        WHERE 
            DATE(vernuli_dolg.vernuli_date)='$reportDate'
		ORDER BY vernuli_dolg.vernuli_date";
$result = mysqli_query($link,$sql);
$html = 0;
if($result)
{
    $html = '<option></option>';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result)) 
        {
            $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["dolg"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["vernuli_date"].'</option>';
        }
    }
}
echo $html;
?>
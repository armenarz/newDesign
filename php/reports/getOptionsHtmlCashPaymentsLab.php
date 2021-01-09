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
            zaplatili.orderid,
            zaplatili.zapl,
            us22.id, 
            TIME(zaplatili.den) AS den_zaplatili 
        FROM zaplatili 
        INNER JOIN us22 ON zaplatili.uu=us22.id
        WHERE 
        DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0
		ORDER BY zaplatili.den";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        $html = '<option></option>';
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["den_zaplatili"].'</option>';
            }
        }
    }

echo $html;
?>
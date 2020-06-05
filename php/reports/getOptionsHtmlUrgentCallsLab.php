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
            orders.OrderId,
            orders.cena_analizov 
        FROM orders 
        INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
        WHERE 
            orderresult.ReagentId=1014 AND orders.OrderDate='$reportDate'
        ";
$result = mysqli_query($link, $sql);
$html = '';
if($result)
{
    $html = '<option></option>';
    if(mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_array($result)) 
        {
            $html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["cena_analizov"].'</option>';
        }
    }
}

echo $html;
?>
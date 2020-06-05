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

$sql_partner_users = "	SELECT 
                            us22.log 
                        FROM partner_users
                        LEFT JOIN us22 ON partner_users.user_id=us22.id
                        ";
$result_partner_users = mysqli_query($link, $sql_partner_users);
$partner_users_array = array();
if($result_partner_users)
{
    if(mysqli_num_rows($result_partner_users) > 0)
    {
        while($row_partner_users = mysqli_fetch_array($result_partner_users))
        {
            array_push($partner_users_array,$row_partner_users["log"]);
        }
    }
}
$partner_users = implode("','",$partner_users_array);
$partner_users = "'".$partner_users."'";

$sql = "SELECT 
            OrderId,
            cena_analizov,
            dolg 
        FROM orders 
        WHERE 
            dolg!=0 AND OrderDate='$reportDate' AND usr NOT IN ( $partner_users )
            ";

$result = mysqli_query($link, $sql);
$html = '';
if($result)
{
    $html = '<option></option>';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result)) 
        {
            $html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["dolg"].'</option>';
        }
    }
}

echo $html;
?>
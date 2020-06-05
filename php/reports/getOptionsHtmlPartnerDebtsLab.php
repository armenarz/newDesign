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

if(!isset($_POST["partner"]))
{
    $msg .= "The partner is not defined.";
    echo $msg;
    return;
}
$partner = $_POST["partner"];

$html = '';
if( $partner == "Maple_ Leafs" || $partner == "Garant_Assinstance" ||
$partner == "Gyumri" || $partner == "Jermuk" ||
$partner == "On-Clinic" || $partner == "Maletti" ||
$partner == "Nairi" || $partner == "Ingo0" ||
$partner == "Profimed" || $partner == "MIM" || $partner == "Cosmolab" ||
$partner == "Manasyan")
{
    $sql = "SELECT 
                OrderId,
                cena_analizov
            FROM orders 
            INNER JOIN us22 ON orders.usr=us22.log
            INNER JOIN partner_users ON us22.id=partner_users.user_id
            INNER JOIN partners ON partner_users.partner_id=partners.id
            WHERE 
                orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
            ";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $html = '<option></option>';
        while($row = mysqli_fetch_array($result)) 
        {
            $html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["cena_analizov"].'</option>';
        }
    }
}
elseif($partner == "Davinci")
{
    $sql = "SELECT 
                OrderId,
                (cena_analizov / 2) AS cen_an
            FROM orders 
            INNER JOIN us22 ON orders.usr=us22.log
            INNER JOIN partner_users ON us22.id=partner_users.user_id
            INNER JOIN partners ON partner_users.partner_id=partners.id
            WHERE 
                orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
            ";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $html = '<option></option>';
        while($row = mysqli_fetch_array($result)) 
        {
            $html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.intval($row["cen_an"]).'</option>';
        }
    }
}
elseif($partner == "ARMMED" || $partner == "Tonoyan")
{
    $sql = "SELECT 
                OrderId,
                (cena_analizov * 0.7) AS cen_an
            FROM orders 
            INNER JOIN us22 ON orders.usr=us22.log
            INNER JOIN partner_users ON us22.id=partner_users.user_id
            INNER JOIN partners ON partner_users.partner_id=partners.id
            WHERE 
                orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
            ";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $html = '<option></option>';
        while($row = mysqli_fetch_array($result)) 
        {
            $html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.intval($row["cen_an"]).'</option>';
        }
    }                    
} 

echo $html;
?>
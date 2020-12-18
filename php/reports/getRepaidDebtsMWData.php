<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";
require_once "../constants.php";

$msg = "";

//<!-- BEGIN Tabs HTML Markup -->
$msg = '
<div class="row">
    <div class="col">
        <label for="StartDateRepaidDebts">Начальная дата</label>
        <select id="StartDateRepaidDebts" class="form-control" name="StartDateRepaidDebts">
            <option value="0"></option>
            ';
$sql=  "SELECT 
            OrderDate 
        FROM orders 
        where OrderDate >= ".START_DATE_REPORT." 
        GROUP BY OrderDate 
        ORDER BY OrderDate DESC";
$result = mysqli_query($link,$sql);
if($result)
{
    $startDateRepaidDebtsIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateRepaidDebtsIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateRepaidDebtsIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateRepaidDebts">Конечная дата</label>
        <select id="EndDateRepaidDebts" class="form-control" name="EndDateRepaidDebts">
            <option value="0"></option>
            ';
$sql=  "SELECT 
            OrderDate 
        FROM orders 
        where OrderDate >= ".START_DATE_REPORT." 
        GROUP BY OrderDate 
        ORDER BY OrderDate DESC";
$result = mysqli_query($link,$sql);
if($result)
{
    $endDateRepaidDebtsIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateRepaidDebtsIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateRepaidDebtsIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>

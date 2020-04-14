<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

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
        where OrderDate >= '2017-10-01' 
        GROUP BY OrderDate 
        ORDER BY OrderDate DESC";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
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
        where OrderDate >= '2017-10-01' 
        GROUP BY OrderDate 
        ORDER BY OrderDate DESC";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
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

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
        <label for="StartDateDrivers">Начальная дата</label>
        <select id="StartDateDrivers" class="form-control" name="StartDateDrivers">
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
    $startDateDriversIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateDriversIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateDriversIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateDrivers">Конечная дата</label>
        <select id="EndDateDrivers" class="form-control" name="EndDateDrivers">
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
    $endDateDriversIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateDriversIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateDriversIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
<div class="row">
    <div class="col">
        <label for="SelDrivers">Водители</label>
            <select id="SelDrivers" class="form-control" name="SelDrivers">
                <option value="0">Все</option>
        ';
$sql=  "SELECT 
            id, 
            voditel 
        FROM voditeli 
        ORDER BY id
        ";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["voditel"].'</option>';
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReportTypeDrivers">Тип отчета</label>
            <select id="ReportTypeDrivers" class="form-control" name="ReportTypeDrivers">
                <option value="0"></option>
                <option value="1" selected>Суммарно</option>
                <option value="2">Детально</option>
            </select>
        </div>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>

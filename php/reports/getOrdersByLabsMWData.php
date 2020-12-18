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
        <label for="StartDateOrdersByLabs">Начальная дата</label>
        <select id="StartDateOrdersByLabs" class="form-control" name="StartDateOrdersByLabs">
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
    $startDateOrdersByLabsIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateOrdersByLabsIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateOrdersByLabsIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateOrdersByLabs">Конечная дата</label>
        <select id="EndDateOrdersByLabs" class="form-control" name="EndDateOrdersByLabs">
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
    $endDateOrdersByLabsIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateOrdersByLabsIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateOrdersByLabsIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
<div class="row">
    <div class="col">
        <label for="LabIdOrdersByLabs">Лаборатория</label>
            <select id="LabIdOrdersByLabs" class="form-control" name="LabIdOrdersByLabs">
                <option value="0"></option>
        ';
$sql=  "SELECT
            id, 
            lab 
        FROM labs 
        ORDER BY id";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["lab"].'</option>';
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReportTypeIdOrdersByLabs">Тип отчета</label>
            <select id="ReportTypeIdOrdersByLabs" class="form-control" name="ReportTypeIdOrdersByLabs">
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

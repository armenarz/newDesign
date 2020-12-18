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
        <label for="StartDateDoctor13">Начальная дата</label>
        <select id="StartDateDoctor13" class="form-control" name="StartDateDoctor13">
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
    $startDateDoctor13Index = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateDoctor13Index == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateDoctor13Index++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateDoctor13">Конечная дата</label>
        <select id="EndDateDoctor13" class="form-control" name="EndDateDoctor13">
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
    $endDateDoctor13Index = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateDoctor13Index == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateDoctor13Index++;
    }
}
$msg .= '
        </select>
    </div>
</div>
<div class="row">
    <div class="col"></div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReportTypeIdDoctor13">Тип отчета</label>
            <select id="ReportTypeIdDoctor13" class="form-control" name="ReportTypeIdDoctor13">
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

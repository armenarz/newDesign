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
        <label for="StartDateOrdersByUsers">Начальная дата</label>
        <select id="StartDateOrdersByUsers" class="form-control" name="StartDateOrdersByUsers">
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
    $startDateOrdersByUsersIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateOrdersByUsersIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateOrdersByUsersIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateOrdersByUsers">Конечная дата</label>
        <select id="EndDateOrdersByUsers" class="form-control" name="EndDateOrdersByUsers">
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
    $endDateOrdersByUsersIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateOrdersByUsersIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateOrdersByUsersIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
<div class="row">
    <div class="col">
        <label for="UserIdOrdersByUsers">Пользователи</label>
            <select id="UserIdOrdersByUsers" class="form-control" name="UserIdOrdersByUsers">
                <option value="0"></option>
        ';
$sql=  "SELECT 
            id, 
            log 
        FROM us22 
        ORDER BY id
        ";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["log"].'</option>';
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReportTypeIdOrdersByUsers">Тип отчета</label>
            <select id="ReportTypeIdOrdersByUsers" class="form-control" name="ReportTypeIdOrdersByUsers">
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

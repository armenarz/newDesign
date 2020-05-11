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
        <label for="StartDateDoctorSelected">Начальная дата</label>
        <select id="StartDateDoctorSelected" class="form-control" name="StartDateDoctorSelected">
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
    $startDateDoctorSelectedIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateDoctorSelectedIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateDoctorSelectedIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateDoctorSelected">Конечная дата</label>
        <select id="EndDateDoctorSelected" class="form-control" name="EndDateDoctorSelected">
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
    $endDateDoctorSelected = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateDoctorSelected == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateDoctorSelected++;
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
            <label for="ReportTypeIdDoctorSelected">Тип отчета</label>
            <select id="ReportTypeIdDoctorSelected" class="form-control" name="ReportTypeIdDoctorSelected">
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

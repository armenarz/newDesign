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
        <label for="StartDateDoctors">Начальная дата</label>
        <select id="StartDateDoctors" class="form-control" name="StartDateDoctors">
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
    $startDateDoctorsIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateDoctorsIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateDoctorsIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateDoctors">Конечная дата</label>
        <select id="EndDateDoctors" class="form-control" name="EndDateDoctors">
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
    $endDateDoctorsIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateDoctorsIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateDoctorsIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none ui-front">
            <label for="DoctorIdDoctors">Врач</label>
            <input type="text" id="DoctorIdDoctors" name="DoctorIdDoctors" class="form-control" placeholder="Для поиска введите Id или имя врача" autocomplete="off" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none ui-front">
            <label for="ReagentIdDoctors">Реагент</label>
            <input type="text" id="ReagentIdDoctors" name="ReagentIdDoctors" class="form-control" placeholder="Для поиска введите Id или название реагента" autocomplete="off" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="WorkplaceIdDoctors">Место работы</label>
            <select id="WorkplaceIdDoctors" class="form-control" name="WorkplaceIdDoctors">
                <option value="0"></option>
                ';
$sql = "SELECT 
            WorkPlaceId,
            WorkPlaceDesc 
        FROM cworkplace 
        ORDER BY WorkPlaceId";

$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["WorkPlaceId"].'">'.FillNonBreak($row["WorkPlaceId"],3).'&nbsp;'.$row["WorkPlaceDesc"].'</option>';
    }
}
        $msg .= '
            </select>
        </div>
    </div>      
    <div class="col">
        <div class="form-group d-print-none">
            <label for="SalesIdDoctors">Sales</label>
            <select id="SalesIdDoctors" class="form-control" name="SalesIdDoctors">';
$userId = $_POST["uu"];
if($userId == 412)
{
    $msg .= '<option value="16">16&nbsp;Сируш</option>';
}
elseif($userId == 484)
{
    $msg .= '<option value="4">4&nbsp;Лусине</option>';
}
elseif($userId == 486)
{
    $msg .= '<option value="2">2&nbsp;Армине</option>';
}
else
{
    $msg .= '<option value="0"></option>';
    $sql =  "SELECT 
                salesId, 
                salesName 
            FROM sales 
            ORDER BY salesId";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            $msg .=  '<option value="'.$row["salesId"].'">'.FillNonBreak($row["salesId"],2).'&nbsp;'.$row["salesName"].'</option>';
        }
    }
}
        $msg .= '
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="UserIdDoctors">Пользователь</label>
            <select id="UserIdDoctors" class="form-control" name="UserIdDoctors">
                <option value="0"></option>
                ';
$receptionists = array(
"reception2"=>"Julianna",
"reception3"=>"Alisa",
"reception4"=>"Mariam",
"reception5"=>"Narine",
"reception6"=>"Alina",
"reception7"=>"Alisa Junior",
"reception8"=>"Anahit"
);
$reportingUserIds =   "1,2,3,4,5,7,10,12,13,22,23,27,28,33,40,49,66,68,112,113,120,128,130,137,143,150,184,198,200,202,212,260,125,374,256,258,392,394,396,398,418,564,566,568,582";

$sql = "SELECT 
            id,
            log 
        FROM us22 
        WHERE id in(".$reportingUserIds.")
        ORDER BY id";
$result = mysqli_query($link,$sql);
$receptionist;
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $receptionist = "";
        foreach ( $receptionists as $key => $value ) 
        {
            if($row["log"] == $key)
            {
                $receptionist = $value;
                break;
            }
        }
        if($receptionist != "")
        {
            $msg .= '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["log"],$receptionist).'</option>';
        }
        else
        {
            $msg .= '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["log"].'</option>';
        }
    }
}
        $msg .= '
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReportTypeIdDoctors">Тип отчета</label>
            <select id="ReportTypeIdDoctors" class="form-control" name="ReportTypeIdDoctors">
                <option value="0"></option>
                <option value="1" selected>Суммарно</option>
                <option value="2">Детально</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col"></div>
    <div class="col">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="DoubleCheckDoctors">
            <label class="form-check-label" for="DoubleCheckDoctors">только Double Check</label>
        </div>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>

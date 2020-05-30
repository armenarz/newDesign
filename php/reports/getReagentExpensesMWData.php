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
        <label for="StartDateReagentExpenses">Начальная дата</label>
        <select id="StartDateReagentExpenses" class="form-control" name="StartDateReagentExpenses">
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
    $startDateReagentExpensesIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($startDateReagentExpensesIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $startDateReagentExpensesIndex++;
    }
}
$msg .= '
        </select>
    </div>
    <div class="col">
        <label for="EndDateReagentExpenses">Конечная дата</label>
        <select id="EndDateReagentExpenses" class="form-control" name="EndDateReagentExpenses">
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
    $endDateReagentExpensesIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($endDateReagentExpensesIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $endDateReagentExpensesIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReagentIdReagentExpenses">Реагент</label>
            <select id="ReagentIdReagentExpenses" class="form-control" name="ReagentIdReagentExpenses[]" multiple>
                <option value="0"></option>
';
$sql = "SELECT 
            ReagentId,
            ReagentDesc,
            ReagentDescRus 
        FROM reagent 
        ORDER BY ReagentDescRus";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["ReagentId"].'">'.FillNonBreak($row["ReagentId"],4).'&nbsp;'.ConcatWithBrackets($row["ReagentDescRus"],$row["ReagentDesc"]).'</option>';
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
            <div class="input-group">
                <input type="text" class="form-control" id="LabelReagentGroupReagentExpenses" placeholder="Группа реагентов: 363,378,379,380,381 и 382" disabled>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" data-group-selected="false" id="SelectReagentGroupReagentExpenses">Выбрать</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none ui-front">
            <label for="DoctorIdReagentExpenses">Врач</label>
            <input type="text" id="DoctorIdReagentExpenses" name="DoctorIdReagentExpenses" class="form-control" placeholder="Для поиска введите Id или имя врача" autocomplete="off" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="WorkplaceIdReagentExpenses">Место работы</label>
            <select id="WorkplaceIdReagentExpenses" class="form-control" name="WorkplaceIdReagentExpenses">
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
            <label for="SalesIdReagentExpenses">Sales</label>
            <select id="SalesIdReagentExpenses" class="form-control" name="SalesIdReagentExpenses">';
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
            <label for="UserIdReagentExpenses">Пользователь</label>
            <select id="UserIdReagentExpenses" class="form-control" name="UserIdReagentExpenses">
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
$reportingUserIds =   "1,2,3,4,5,7,10,12,13,22,23,27,28,33,40,49,66,68,
            112,113,120,128,130,137,143,150,184,198,200,202,212,
            260,125,374, 256, 258, 392, 394, 396, 398, 418";
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
            <label for="ReportTypeIdReagentExpenses">Тип отчета</label>
            <select id="ReportTypeIdReagentExpenses" class="form-control" name="ReportTypeIdReagentExpenses">
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

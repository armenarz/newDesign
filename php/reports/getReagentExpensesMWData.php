<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";
require_once "../user_to_name.php";
require_once "../constants.php";

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
        where OrderDate >= ".START_DATE_REPORT." 
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
        where OrderDate >= ".START_DATE_REPORT." 
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
            $name_date = $row["OrderDate"];
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
        <div class="form-group d-print-none">
            <div class="input-group">
                <input type="text" class="form-control" id="LabelReagentGroupSARSReagentExpenses" placeholder="Группа реагентов SARS: 1142 и 1166" disabled>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" data-group-selected="false" id="SelectReagentGroupSARSReagentExpenses">Выбрать</button>
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
if($uu == 412)
{
    $msg .= '<option value="16">16&nbsp;Сируш</option>';
}
elseif($uu == 484)
{
    $msg .= '<option value="4">4&nbsp;Лусине</option>';
}
elseif($uu == 486)
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
$reportingUserIds = "   1,      2,      3,      4,      5,      7,      10,     12,     13,     16,
                        17,     22,     23,     27,     28,     32,     33,     35,     40,     47,     
                        49,     65,     66,     68,     69,     112,    113,    120,    121,    122,    
                        125,    128,    130,    132,    137,    142,    143,    146,    150,    153,
                        154,    155,    156,    157,    162,    182,    184,    198,    200,    202,
                        210,    212,    220,    222,    256,    258,    260,    264,    270,    356,
                        374,    392,    394,    396,    398,    410,    412,    418,    448,    450,
                        452,    454,    456,    458,    460,    484,    486,    488,    550,    564,
                        566,    568,    570,    572,    574,    576,    582,    624,    630,    644,
                        650,    660,    688,    690,    692,    694,    708,    710,    712,    714,
                        716,    718,    720,    722,    736,    744,	754,	756,    760,    768,
						776, 778, 752, 750, 748, 746";
$sql = "SELECT 
            id,
            log 
        FROM us22 
        WHERE id in(".$reportingUserIds.")
        ORDER BY log";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        //Checking if user id exists in altered_user_names table
        $sql_altered_user_names = " SELECT 
                                        user_name 
                                    FROM altered_user_names 
                                    WHERE user_id='".$row["id"]."'";
        $result_altered_user_names = mysqli_query($link,$sql_altered_user_names);
        if($result_altered_user_names)
        {
            if(mysqli_num_rows($result_altered_user_names) > 0)
            {
                $msg .= '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],3).'&nbsp;'.ConcatWithBrackets($row["log"], usr_to_name($link,$row["id"], $name_date)).'</option>';
            }
            else
            {
                $msg .= '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],3).'&nbsp;'.$row["log"].'</option>';
            }
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
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="LabIdReagentExpenses">Лаборатория</label>
            <select id="LabIdReagentExpenses" class="form-control" name="LabIdReagentExpenses" ';
            if($uu != 12 && $uu != 13 && $uu != 23)
            {
                $msg .= 'disabled ';
            }            
    $msg .='>
                <option value="0"></option>';
    $sql = "SELECT 
                id,
                lab 
            FROM labs
            ORDER BY sorting
            ";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            $msg .= '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["lab"].'</option>';
        }
    }
    $msg .= '
            </select>
        </div>
	</div>
    
	<div class="col">
        <div class="form-group d-print-none">
            <label for="Filial">Филиал</label>
            <select id="Filial" class="form-control" name="Filial" ';
            if($uu != 12 && $uu != 13 && $uu != 23)
            {
                $msg .= 'disabled ';
            }            
    $msg .='>
                <option value="0"></option>
				<option value="3">Все филиалы</option>
				<option value="1" selected>Главный</option>
				<option value="2">Kapan</option>
				<option value="4">Vanadzor</option>';
    
    
    $msg .= '
            </select>
        </div>
	</div>
    
</div>
<div class="row">
    <div class="col" id="div_sars">
		<div class="form-check">
            <input type="checkbox" class="form-check-input" id="SARS-CoV-2CheckReagentExpenses" >
            <label class="form-check-label" for="SARS-CoV-2ReagentExpenses">SARS-CoV-2</label>
        </div>
	</div>
    <div class="col">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="DoubleCheckReagentExpenses">
            <label class="form-check-label" for="DoubleCheckReagentExpenses">только Double Check</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="div_bez_sars">
		<div class="form-check">
            <input type="checkbox" class="form-check-input" id="SARS-CoV-2BezCheckReagentExpenses" >
            <label class="form-check-label" for="SARS-CoV-2BezCheckReagentExpenses">Без COVID-19</label>
        </div>
	</div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>

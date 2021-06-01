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
        <label for="StartDateDoctors">Начальная дата</label>
        <select id="StartDateDoctors" class="form-control" name="StartDateDoctors">
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
        where OrderDate >= ".START_DATE_REPORT." 
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
            $name_date = $row["OrderDate"];
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
    <div class="col">
        <div class="form-group d-print-none">
            <label for="Filiald">Филиал</label>
            <select id="Filiald" class="form-control" name="Filiald" ';
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

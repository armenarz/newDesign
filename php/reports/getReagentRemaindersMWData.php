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
        <div class="form-group d-print-none">
            <label for="ReportDateReagentRemainders">Дата отчета</label>
            <select id="ReportDateReagentRemainders" class="form-control" name="ReportDateReagentRemainders">
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
    <div class="col">
        <div class="form-group d-print-none">
            <label for="MethodIdReagentRemainders">Метод</label>
            <select id="MethodIdReagentRemainders" class="form-control" name="MethodIdReagentRemainders">
                <option value="0"></option>
    ';
$sql= " SELECT 
            MethodId, 
            Method 
        FROM method";
$result = mysqli_query($link, $sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg.= '<option value="'.$row["MethodId"].'">'.FillNonBreak($row["MethodId"],2).'&nbsp;'.$row["Method"].'</option>';
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
            <label for="ProducerIdReagentRemainders">Производитель</label>
            <select id="ProducerIdReagentRemainders" class="form-control" name="ProducerIdReagentRemainders">
                <option value="0"></option>
                ';
    $sql= "SELECT 
        id,
        producerName 
        FROM producers 
        ORDER BY id";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            $msg.=	'<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["producerName"].'</option>';
        }
    }
    $msg .= '
            </select>
        </div> 
    </div>
    <div class="col">
            <div class="form-group d-print-none">
                <label for="CatalogueNumberReagentRemainders">Каталожный номер</label>
                <input type="number" id="CatalogueNumberReagentRemainders" name="CatalogueNumberReagentRemainders" value="0" min="0" class="form-control" placeholder="Положительное число">
            </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ExpirationDateIdReagentRemainders">Срок годности</label>
            <select id="ExpirationDateIdReagentRemainders" class="form-control" name="ExpirationDateIdReagentRemainders">
                <option value="0"></option>
                <option value="1">Осталось больше 30 дней</option>
                <option value="2">Осталось меньше 30 дней</option>
                <option value="3">Срок истек</option>
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ReportTypeIdReagentRemainders">Тип отчета</label>
            <select id="ReportTypeIdReagentRemainders" class="form-control" name="ReportTypeIdReagentRemainders">
                <option value="0"></option>
                <option value="1">Суммарно</option>
                <option value="2">Детально</option>
            </select>
        </div>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>

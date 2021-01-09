<?php
require_once "../connect.php";
require_once "../authorization.php";

$html = "";
$filter = "";

// getting preorderStartDate
if(isset($_POST["preorderStartDate"]))
{
    $preorderStartDate = $_POST["preorderStartDate"];
}
else
{
    $msg = "Начальная дата (preorderStartDate) отсутствует";
    echo $msg;
    return;
}

// getting preorderEndDate
if(isset($_POST["preorderEndDate"]))
{
    $preorderEndDate = $_POST["preorderEndDate"];
}
else
{
    $msg = "Конечная дата (preorderEndDate) отсутствует";
    echo $msg;
    return;
}

// getting searchPreorderId
if(isset($_POST["searchPreorderId"]))
{
    $preorderId = $_POST["searchPreorderId"];
}
else
{
    $msg = "searchPreorderId  отсутствует";
    echo $msg;
    return;
}

// getting generalSelectionId
if(isset($_POST["generalSelectionId"]))
{
    $generalSelectionId = $_POST["generalSelectionId"];
}
else
{
    $msg = "generalSelectionId отсутствует";
    echo $msg;
    return;
}

$filter = "";

if($preorderStartDate != 0 && $preorderEndDate != 0 && $generalSelectionId != 0 && $generalSelectionId != 4)
{
    $filter = "DATE(preorderDate)>='".$preorderStartDate."' AND DATE(preorderDate)<='".$preorderEndDate."' AND preorderStatus='".$generalSelectionId."'";
}
elseif($preorderStartDate != 0 && $preorderEndDate != 0 && $generalSelectionId == 4)
{
    $filter = "DATE(preorderDate)>='".$preorderStartDate."' AND DATE(preorderDate)<='".$preorderEndDate."'";
}
elseif($preorderStartDate == 0 && $preorderEndDate == 0 && $generalSelectionId != 0 && $generalSelectionId != 4)
{
    $filter = "preorderStatus='".$generalSelectionId."'";
}
elseif($preorderStartDate == 0 && $preorderEndDate == 0 && $generalSelectionId != 0 && $generalSelectionId == 4)
{
    $filter = "1";
}
elseif($preorderId != 0)
{
    $filter = "preorderId='".$preorderId."'";
}

$html = '
<table class="table table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <!--00. radio button-->
            <th></th>
            <!--01. number-->
            <th scope="col">#</th>
            <!--02. preorderId-->
            <th scope="col">Id&nbsp;предзаказа</th>
            <!--03. preorderDate-->
            <th scope="col">Дата&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <!--04. customerLastName-->
            <th scope="col">Фамилия</th>
            <!--05. customerFirstName-->
            <th scope="col">Имя</th>
            <!--06. customerMidName-->
            <th scope="col">Отчество</th>
            <!--07. customerPhone-->
            <th scope="col">Телефон</th>
            <!--08. customerAddress-->
            <th scope="col">Адрес</th>
            <!--09. customerEmail-->
            <th scope="col">Email</th>
            <!--10. additionalInfo-->
            <th scope="col">Дополнитьно</th>
            <!--11. preorderStatus-->
            <th scope="col">Статус</th>
            <!--12. statusInfo-->
            <th scope="col">Справка&nbsp;о&nbsp;статусе</th>
            <!--13. оrderId-->
            <th scope="col">Id&nbsp;заказа</th>
        </tr>
    </thead>
    <tbody>';

$sql = "SELECT * FROM preorders
        WHERE ".$filter." 
        ORDER BY preorderId ";

$result = mysqli_query($link, $sql);
if($result)
{
    $i = 0;
    while($row = mysqli_fetch_array($result))
    {
        $i++;
        if($row["preorderStatus"] == 1)
        {
            $preorderStatus = "необработан";
        }
        elseif($row["preorderStatus"] == 2)
        {
            $preorderStatus = "подтвержден";
        }
        elseif($row["preorderStatus"] == 3)
        {
            $preorderStatus = "отклонен";
        }
        
        $html.= '<tr id="r_'.$row["preorderId"].'">
                    <!--00. radio button-->
                    <td><input type="radio" name="radioPreorder" value="'.$row["preorderId"].'" aria-label="Выберите предзаказ"></td>
                    <!--01. number-->
                    <td scope="row"><strong>'.$i.'</strong></td>
                    <!--02. preorderId-->
                    <td>'.$row["preorderId"].'</td>
                    <!--03. preorderDate-->
                    <td>'.$row["preorderDate"].'</td>
                    <!--04. customerLastName-->
                    <td>'.$row["customerLastName"].'</td>
                    <!--05. customerFirstName-->
                    <td>'.$row["customerFirstName"].'</td>
                    <!--06. customerMidName-->
                    <td>'.$row["customerMidName"].'</td>
                    <!--07. customerPhone-->
                    <td>'.$row["customerPhone"].'</td>
                    <!--08. customerAddress-->
                    <td>'.$row["customerAddress"].'</td>
                    <!--09. customerEmail-->
                    <td>'.$row["customerEmail"].'</td>
                    <!--10. additionalInfo-->
                    <td>'.$row["additionalInfo"].'</td>
                    <!--11. preorderStatus-->
                    <td>'.$preorderStatus.'</td>
                    <!--12. statusInfo-->
                    <td>'.$row["statusInfo"].'</td>
                    <!--13. оrderId-->
                    <td>'.$row["orderId"].'</td>
                </tr>';
    }
}

$html.= '
    </tbody>
</table>';

echo $html;
?>
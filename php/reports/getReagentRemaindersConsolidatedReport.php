<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../classes/reagentRemainder.class.php";

$msg = "";

if(!isset($_POST["menuId"]))
{
    $msg .= "The menu id is not defined. menuId=".$_POST["menuId"];
    echo $msg;
    return;
}
$menuId = $_POST["menuId"];

if(!isset($_POST["reportDate"]))
{
    $msg .= "The report date is not defined.";
    echo $msg;
    return;
}
$reportDate = $_POST["reportDate"];

if(!isset($_POST["methodId"]))
{
    $msg .= "The method id is not defined.";
    echo $msg;
    return;
}
$methodId = $_POST["methodId"];

$sql_method = " SELECT 
                    Method 
                FROM method
                WHERE MethodId='".$methodId."'";
$result_method = mysqli_query($link,$sql_method);
if($result_method)
{
    $row_method = mysqli_fetch_array($result_method);
    $method = $row_method["Method"];
}

if(!isset($_POST["producerId"]))
{
    $msg .= "The producer id is not define.";
    echo $msg;
    return;
}
$producerId = $_POST["producerId"];

$sql_producer = "SELECT 
                    id,
                    producerName 
                    FROM producers 
                    WHERE id='".$producerId."'";

$result_producer = mysqli_query($link,$sql_producer);
if($result_producer)
{
    $row_producer = mysqli_fetch_array($result_producer);
    $producerName = $row_producer["producerName"];
}

if(!isset($_POST["catalogueNumber"]))
{
    $msg .= "The catalogue number is not defined.";
    echo $msg;
    return;
}
$catalogueNumber = $_POST["catalogueNumber"];
// echo gettype($catalogueNumber);
// return;
if(!isset($_POST["reportTypeId"]))
{
    $msg .= "The report type id is not defined.";
    echo $msg;
    return;
}
$reportTypeId = $_POST["reportTypeId"];

if(!isset($_POST["expirationDateId"]))
{
    $msg .= "The expiration date id is not defined.";
    echo $msg;
    return;
}
$expirationDateId = $_POST["expirationDateId"];
if($expirationDateId == 1)
{
    $expirationDate = "осталось больше 30 дней";
}
else if($expirationDateId == 2)
{
    $expirationDate = "осталось меньше 30 дней";
}
else if($expirationDateId == 3)
{
    $expirationDate = "срок истек";
}

if(!isset($_POST["user_id"]))
{
    $msg .= "The user id is not defined.";
    echo $msg;
    return;
}
$userId = $_POST["user_id"];

$filter = "";
$reportDescription = "";

if($menuId == "reagentRemaindersLink" && $reportTypeId == 1)
{
    if(     $methodId == 0 && $producerId == 0 && $expirationDateId == 0 && $catalogueNumber == 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно)</span>";
    }
    else if($methodId != 0 && $producerId == 0 && $expirationDateId == 0 && $catalogueNumber == 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ])</span>";
    }
    else if($methodId == 0 && $producerId != 0 && $expirationDateId == 0 && $catalogueNumber == 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по производителю: ".$producerName." [ id: ".$producerId." ])</span>";
    }
    else if($methodId != 0 && $producerId != 0 && $expirationDateId == 0 && $catalogueNumber == 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по производителю: ".$producerName." [ id: ".$producerId." ])</span>";
    }
    else if($methodId == 0 && $producerId == 0 && $expirationDateId != 0 && $catalogueNumber == 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по сроку годности: ".$expirationDate.")</span>";
    }
    else if($methodId != 0 && $producerId == 0 && $expirationDateId != 0 && $catalogueNumber == 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по сроку годности: ".$expirationDate.")</span>";
    }
    else if($methodId == 0 && $producerId != 0 && $expirationDateId != 0 && $catalogueNumber == 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по производителю: ".$producerName." [ id: ".$producerId." ], по сроку годности: ".$expirationDate.")</span>";
    }
    else if($methodId != 0 && $producerId != 0 && $expirationDateId != 0 && $catalogueNumber == 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по производителю: ".$producerName." [ id: ".$producerId." ], по сроку годности: ".$expirationDate.")</span>";
    }
    ////
    else if($methodId == 0 && $producerId == 0 && $expirationDateId == 0 && $catalogueNumber != 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по каталожному номеру: ".$catalogueNumber."</span>";
    }
    else if($methodId != 0 && $producerId == 0 && $expirationDateId == 0 && $catalogueNumber != 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по каталожному номеру: ".$catalogueNumber.")</span>";
    }
    else if($methodId == 0 && $producerId != 0 && $expirationDateId == 0 && $catalogueNumber != 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по производителю: ".$producerName." [ id: ".$producerId." ], по каталожному номеру: ".$catalogueNumber.")</span>";
    }
    else if($methodId != 0 && $producerId != 0 && $expirationDateId == 0 && $catalogueNumber != 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по производителю: ".$producerName." [ id: ".$producerId." ], по каталожному номеру: ".$catalogueNumber.")</span>";
    }
    else if($methodId == 0 && $producerId == 0 && $expirationDateId != 0 && $catalogueNumber != 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по сроку годности: ".$expirationDate.", по каталожному номеру: ".$catalogueNumber.")</span>";
    }
    else if($methodId != 0 && $producerId == 0 && $expirationDateId != 0 && $catalogueNumber != 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по сроку годности: ".$expirationDate.", по каталожному номеру: ".$catalogueNumber.")</span>";
    }
    else if($methodId == 0 && $producerId != 0 && $expirationDateId != 0 && $catalogueNumber != 0)
    {
        $filter_method = "";
        $reportDescription = "<span>(тип отчета: суммарно, по производителю: ".$producerName." [ id: ".$producerId." ], по сроку годности: ".$expirationDate.", по каталожному номеру: ".$catalogueNumber.")</span>";
    }
    else if($methodId != 0 && $producerId != 0 && $expirationDateId != 0 && $catalogueNumber != 0)
    {
        $filter_method = " WHERE MethodId ='".$methodId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по методу: ".$method." [ id: ".$methodId." ], по производителю: ".$producerName." [ id: ".$producerId." ], по сроку годности: ".$expirationDate.", по каталожному номеру: ".$catalogueNumber.")</span>";
    }

    $msg.= '
    <h3>Остатки реагентов на '.$reportDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="reagentRemaindersData">
        <thead>
            <tr>
                <!--Row number-->
                <th scope="col" class="text-right">#</th>
                <!--ReagentId-->
                <th scope="col" class="text-right">Id</th>
                <!--ReagentDesc-->
                <th scope="col" colspan="2">Реагент</th>
                <!--ReagentDescRus-->
                <!--<th scope="col">Реагент</th>-->
                <!--Producer-->
                <th>Произво-дитель</th>
                <!--CatalogueNumber-->
                <th>Ката-ложный номер</th>
                <!--ExpirationDate-->
                <th>Годен&nbsp;до&nbsp;&nbsp;&nbsp;</th>
                <!--ReagentRemainder-->
                <th scope="col" class="text-right">Остаток</th>
            </tr>
        </thead>
        <tbody>
        ';

    $sql_method = " SELECT 
                        MethodId, 
                        Method 
                    FROM method 
                    $filter_method
                ";

    $result_method = mysqli_query($link,$sql_method);
    if($result_method)
    {
        $total = 0;
        while($row_method = mysqli_fetch_array($result_method))
        {
            $sql_reagent = "SELECT 
                                reagent.ReagentId 
                            FROM method 
                            INNER JOIN reagent ON method.Method=reagent.Method
                            WHERE method.MethodId='".$row_method['MethodId']."' and reagent.dilution='1' order by reagent.ReagentId
                            ";
            $result_reagent = mysqli_query($link,$sql_reagent);
            $reagentRowCount = mysqli_num_rows($result_reagent);
            if($reagentRowCount > 0)
            {
                $i = 0;
                $msgReagents = '';

                while($row_reagent = mysqli_fetch_array($result_reagent))
                {
                    $remainder = new RemainderOfReagent($link, $row_reagent["ReagentId"], $reportDate);
                    
                    $diff = strtotime($remainder->GetExpirationDate()) - strtotime($reportDate);
                    $diffDays = floor($diff / (60*60*24));
                    
                    //фильтр по сроку годности
                    //Осталось больше 30 дней
                    if($expirationDateId == 1)
                    {
                        if($diffDays <= 30) continue;
                    }
                    //Осталось меньше 30 дней
                    else if($expirationDateId == 2)
                    {
                        if($diffDays > 30 || $diffDays < 0) continue;
                    }
                    //Истек
                    else if($expirationDateId == 3)
                    {
                        if($diffDays > 0) continue;
                    }

                    //фильтр по производителью
                    if($producerId != 0)
                    {
                        if($producerId != $remainder->GetLastInputProducerId()) continue;
                    }

                    //фильтро по каталожному номеру
                    if($catalogueNumber != 0)
                    {
                        //$lastInputCatalogueNumber = $remainder->GetLastInputCatalogueNumber();
                        if($catalogueNumber != $remainder->GetLastInputCatalogueNumber()) continue;
                    }

                    $i++;
                    $total += $remainder->GetRemainder();
                    $msgReagents.= '
                    <tr>
                        <td class="text-right">'.$i.'</td>
                        <td class="text-right">'.$row_reagent["ReagentId"].'</td>
                        <td>'.$remainder->GetReagentDescEng().'</td>
                        <td>'.$remainder->GetReagentDescRus().'</td>
                        <td>'.$remainder->GetLastInputProducer().'</td>
                        <td>'.$remainder->GetLastInputCatalogueNumber().'</td>
                        <td>'.$remainder->GetExpirationDate().'</td>
                        <td class="text-right">'.$remainder->GetRemainder().'</td>
                    </tr>
                    ';
                }
                if($i > 0) 
                {
                    $msgMethod = '
                    <tr>
                        <td colspan="8"><strong>Метод: '.$row_method["Method"].' [ id: '.$row_method["MethodId"].']</strong></td>
                        <!--<td></td>-->
                        <!--<td></td>-->
                        <!--<td></td>-->
                        <!--<td></td>-->
                        <!--<td></td>-->
                        <!--<td></td>-->
                        <!--<td></td>-->
                    </tr>
                    ';
                    $msg .= $msgMethod.$msgReagents;
                }
            }
        }
        $msg.= '
            <tr>
                <td colspan="7"><strong>Контрольная сумма</strong></td>
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <td class="text-right"><strong>'.$total.'</strong></td>
                
            </tr>
        ';
    }
    
    $msg.= '
        </tbody>
    </table>
    ';
}

echo $msg;
?>
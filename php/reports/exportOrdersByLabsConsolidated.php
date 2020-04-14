<?php
header("Content-Type: application/xls");

require_once "../connect.php";
require_once "../authorization.php";

$utf8_bom = chr(239).chr(187).chr(191);

$msg = $utf8_bom;

if(!isset($_POST["startDate"]) || !isset($_POST["endDate"]))
{
    $msg .= "The reporting period is not defined.";
    echo $msg;
    return;
}
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

if(!isset($_POST["menuId"]))
{
    $msg .= "The menu id is not defined. menuId=".$_POST["menuId"];
    echo $msg;
    return;
}
$menuId = $_POST["menuId"];

if(!isset($_POST["reportTypeId"]))
{
    $msg .= "The report type id is not defined. reportTypeId=".$_POST["reportTypeId"];
    echo $msg;
    return;
}
$reportTypeId = $_POST["reportTypeId"];

if(!isset($_POST["labId"]))
{
    $msg .= "The lab id is not defined. labId=".$_POST["labId"];
    echo $msg;
    return;
}
$labId = $_POST["labId"];
if($labId > 0)
{
    $sql_lab = "SELECT
                    id,
                    lab
                FROM labs
                WHERE id='".$labId."'
                ";
    $result_lab = mysqli_query($link, $sql_lab);
    if($result_lab)
    {
        $row_lab = mysqli_fetch_array($result_lab);
        $lab = $row_lab["lab"];
    }
}


$filter = "";
$reportDescription = "";

if($menuId == "ordersByLabsLink" && $reportTypeId == 1)
{
    if($labId == 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
        $filter_lab = "1";
        $reportDescription = "<span>(тип отчета: суммарно)</span>";
    }
    else if($labId != 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.lab='".$lab."'";
        $filter_lab = "id='".$labId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по лаборатории: ".$lab." [ id: ".$labId." ])</span>";
    }

    $msg.= '
    <table class="table" border="1" id="debtsData">
        <caption>
            <h2>Заказы по лабораториям</h2>
            <h3>с '.$startDate.' по '.$endDate.'</h3>
            <h4>'.$reportDescription.'</h4>
        </caption>
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
                <!--2. Lab-->
                <th scope="col">Лаборатория</th>
                <!--3. Order Count-->
                <th scope="col" class="text-right">Количество заказов</th>
                <!--4. Order Sum-->
                <th scope="col" class="text-right">Сумма заказов</th>
            </tr>
        </thead>
        <tbody>
        ';

        $sql_lab = "SELECT
                id,
                lab
            FROM labs
            WHERE $filter_lab
            ORDER BY id
        ";
        
        $result_lab = mysqli_query($link, $sql_lab);
        if($result_lab)
        {
            $i = 0;
            $total_count = 0;
            $total_sum = 0;

            while($row_lab = mysqli_fetch_array($result_lab))
            {
                $sql_count_sum = "  SELECT 
                                        lab, 
                                        SUM(cena_analizov) as sum, 
                                        COUNT(OrderId) as cnt 
                                    FROM orders 
                                    WHERE orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND lab='".$row_lab["lab"]."';
                                ";
                
                $result_count_sum = mysqli_query($link,$sql_count_sum);
                if($result_count_sum)
                {
                    $row_count_sum = mysqli_fetch_array($result_count_sum);

                    if($row_count_sum["cnt"] == null) $lab_count = 0;
                    else $lab_count = $row_count_sum["cnt"];

                    if($row_count_sum["sum"] == null) $lab_sum = 0;
                    else $lab_sum = $row_count_sum["sum"];
                }

                $i++;
                $msg .= '   <tr>
                                <!--1. Row number-->
                                <td scope="col" class="text-right">'.$i.'</td>
                                <!--2. Lab-->
                                <td scope="col">'.$row_lab["lab"].'</td>
                                <!--3. Order Count-->
                                <td scope="col" class="text-right">'.$lab_count.'</td>
                                <!--4. Order Sum-->
                                <td scope="col" class="text-right">'.$lab_sum.'</td>
                            </tr>
                        ';
                $total_count += $lab_count;
                $total_sum += $lab_sum;
            }
        }

        $msg .= '   <tr>
                        <td scope="col" colspan="2" class="text-right"><strong>ВСЕГО</strong></td>
                        <td scope="col" class="text-right"><strong>'.$total_count.'</strong></td>
                        <td scope="col" class="text-right"><strong>'.$total_sum.'</strong></td>
                    </tr>
                ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

header("Content-Disposition: attachement; filename=ordersByLabsConsolidated.xls");
echo $msg;
?>
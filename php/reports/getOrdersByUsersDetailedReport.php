<?php
require_once "../connect.php";
require_once "../authorization.php";

$msg = "";

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

if(!isset($_POST["userId"]))
{
    $msg .= "The user id is not defined. userId=".$_POST["userId"];
    echo $msg;
    return;
}
$userId = $_POST["userId"];
if($userId > 0)
{
    $sql_user = "SELECT
                    id,
                    log
                FROM us22
                WHERE id='".$userId."'
                ";
    $result_user = mysqli_query($link, $sql_user);
    if($result_user)
    {
        $row_user = mysqli_fetch_array($result_user);
        $user = $row_user["log"];
    }
}


$filter = "";
$reportDescription = "";

if($menuId == "ordersByUsersLink" && $reportTypeId == 2)
{
    if($userId == 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
        $filter_user = "1";
        $reportDescription = "<span>(тип отчета: детально)</span>";
    }
    else if($userId != 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.user_id='".$user_id."'";
        $filter_user = "id='".$userId."'";
        $reportDescription = "<span>(тип отчета: детально, по пользователю: ".$user." [ id: ".$userId." ])</span>";
    }

    $msg.= '
    <h3>Заказы по пользовотелям с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="ordersByUsersDetailedData">
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
                <!--2. Order Id-->
                <th scope="col" class="text-right">Номер заказа</th>
                <!--3. Order Count-->
                <th scope="col">Дата заказа</th>
                <!--4. Order Sum-->
                <th scope="col" class="text-right">Сумма заказа</th>
            </tr>
        </thead>
        <tbody>
        ';

        $sql_user = "SELECT
                id,
                log
            FROM us22
            WHERE $filter_user
            ORDER BY id
        ";
        
        $result_user = mysqli_query($link, $sql_user);
        if($result_user)
        {
            $i = 0;
            $total_sum = 0;

            while($row_user = mysqli_fetch_array($result_user))
            {
                $sql_count_sum = "  SELECT 
                                        user_id, 
                                        SUM(cena_analizov) as sum, 
                                        COUNT(OrderId) as cnt 
                                    FROM orders 
                                    WHERE 
                                        OrderDate>='".$startDate."' 
                                        AND OrderDate<='".$endDate."' 
                                        AND user_id='".$row_user["id"]."';
                                ";
                
                $result_count_sum = mysqli_query($link,$sql_count_sum);
                if($result_count_sum)
                {
                    $row_count_sum = mysqli_fetch_array($result_count_sum);

                    if($row_count_sum["sum"] == null) $user_sum = 0;
                    else $user_sum = $row_count_sum["sum"];
                }

                $msg .= '   <tr>
                                <!--1. Row number-->
                                <td scope="col" colspan="3"><strong>Пользователь: '.$row_user["log"].'</strong></td>
                                <!--2. User-->
                                <!--<td scope="col"></td>-->
                                <!--3. Order Count-->
                                <!--<td scope="col" class="text-right"></td>-->
                                <!--4. Order Sum-->
                                <td scope="col" class="text-right"><strong>'.$user_sum.'</strong></td>
                            </tr>
                        ';
                        
                $total_sum += $user_sum;

                $sql_orders = " SELECT 
                                    OrderId, 
                                    OrderDate,
                                    cena_analizov
                                FROM orders
                                WHERE OrderDate>='".$startDate."' AND OrderDate<='".$endDate."' AND user_id='".$row_user["id"]."'
                            ";
                $result_orders = mysqli_query($link,$sql_orders);
                if($result_orders)
                {
                    $i = 0;
                    while($row_orders = mysqli_fetch_array($result_orders))
                    {
                        $i++;
                        $msg .= '   <tr>
                                        <!--1. Row number -->
                                        <td scope="col" class="text-right">'.$i.'</td>
                                        <td scope="col" class="text-right">'.$row_orders["OrderId"].'</td>
                                        <td scope="col">'.$row_orders["OrderDate"].'</td>
                                        <td scope="col" class="text-right">'.$row_orders["cena_analizov"].'</td>
                                    </tr>
                                ';
                    }
                }
            }
        }

        $msg .= '   <tr>
                        <td scope="col" colspan="3" class="text-right"><strong>ВСЕГО</strong></td>
                        <td scope="col" class="text-right"><strong>'.$total_sum.'</strong></td>
                    </tr>
                ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

echo $msg;
?>
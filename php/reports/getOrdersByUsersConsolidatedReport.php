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

$filter = "";
$reportDescription = "";

if($menuId == "ordersByUsersLink" && $reportTypeId == 1)
{
    if($userId == 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
        $filter_user = "1";
        $reportDescription = "<span>(тип отчета: суммарно)</span>";
    }
    else if($userId != 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.user_id='".$userId."'";
        $filter_user = "id='".$userId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по пользователю: ".$user." [ id: ".$userId." ])</span>";
    }

    $msg.= '
    <h3>Заказы по пользователям с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="debtsData">
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
                <!--2. User-->
                <th scope="col">Пользователь</th>
                <!--3. Order Count-->
                <th scope="col" class="text-right">Количество заказов</th>
                <!--4. Order Sum-->
                <th scope="col" id="th_sum_ord" class="text-right">Сумма заказов</th>
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
            $total_count = 0;
            $total_sum = 0;

            while($row_user = mysqli_fetch_array($result_user))
            {
                $sql_count_sum = "  SELECT 
                                        user_id, 
                                        SUM(cena_analizov) AS sum, 
                                        COUNT(OrderId) as cnt 
                                    FROM orders 
                                    WHERE orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND user_id='".$row_user["id"]."';
                                ";
                // echo $sql_count_sum;
                
                $result_count_sum = mysqli_query($link,$sql_count_sum);
                if($result_count_sum)
                {
                    $row_count_sum = mysqli_fetch_array($result_count_sum);

                    if($row_count_sum["cnt"] == null) $user_count = 0;
                    else $user_count = $row_count_sum["cnt"];

                    if($row_count_sum["sum"] == null) $user_sum = 0;
                    else $user_sum = $row_count_sum["sum"];
                }

                $i++;
				if($user_sum > 0) {
					$msg .= '   <tr>
									<!--1. Row number-->
									<td scope="col" class="text-right">'.$i.'</td>
									<!--2. User-->
									<td scope="col">'.$row_user["log"].'</td>
									<!--3. Order Count-->
									<td scope="col" class="text-right">'.$user_count.'</td>
									<!--4. Order Sum-->
									<td scope="col" class="text-right td_sum_ord">'.$user_sum.'</td>
								</tr>
							';
					$total_count += $user_count;
					$total_sum += $user_sum;
				}
            }
        }

        $msg .= '   <tr>
                        <td scope="col" colspan="2" class="text-right"><strong>ВСЕГО</strong></td>
                        <td scope="col" class="text-right"><strong>'.$total_count.'</strong></td>
                        <td scope="col" id="td_total_sum" class="text-right"><strong>'.$total_sum.'</strong></td>
                    </tr>
                ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

echo $msg;
?>
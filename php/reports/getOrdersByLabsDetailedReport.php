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

if(!isset($_POST["labId"]))
{
    $msg .= "The lab id is not defined. labId=".$_POST["labId"];
    echo $msg;
    return;
}
$labId = $_POST["labId"];

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

$filter = "";
$reportDescription = "";

if($menuId == "ordersByLabsLink" && $reportTypeId == 2)
{
    if($labId == 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
        $filter_lab = "1";
        $reportDescription = "<span>(тип отчета: детально)</span>";
    }
    else if($labId != 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.lab='".$lab."'";
        $filter_lab = "id='".$labId."'";
        $reportDescription = "<span>(тип отчета: детально, по лаборатории: ".$lab." [ id: ".$labId." ])</span>";
    }

    $msg.= '
    <h3>Заказы по лабораториям с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="ordersByLabsDetailedData">
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
				
                <!--2. Lab-->
                <th scope="col">Номер заказа</th>
                <!--3. Order Count-->
                <th scope="col" class="text-right">Дата заказа</th>
                <!--4. Order Sum-->
				<th scope="col" class="text-center">Пациент</th>
				';
				if($uu != 800) {
					$msg.= '<th scope="col" class="text-right">Сумма заказа</th>';
				}
				
            $msg.= '</tr>
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
                                        orders.lab, 
                                        SUM(orders.cena_analizov) as sum, 
                                        COUNT(orders.OrderId) as cnt
                                    FROM orders
								    WHERE 
                                        orders.OrderDate>='".$startDate."' 
                                        AND orders.OrderDate<='".$endDate."' 
                                        AND orders.lab='".$row_lab["lab"]."';
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

                $msg .= '   <tr>
                                <!--1. Row number-->
								<td scope="col" colspan="4"><strong>Лаборатория: '.$row_lab["lab"].'</strong></td>
								
                                <!--2. Lab-->
                                <!--<td scope="col"></td>-->
                                <!--3. Order Count-->
                                <!--<td scope="col" class="text-right"></td>-->
                                <!--4. Order Sum-->
								';
								if($uu != 800) {
									$msg .= '<td scope="col" class="text-right"><strong>'.$lab_sum.'</strong></td>';
								}
                            $msg .= '</tr>
                        ';
                $total_count += $lab_count;
                $total_sum += $lab_sum;

                $sql_orders = " SELECT 
                                    orders.OrderId, 
                                    orders.OrderDate,
                                    orders.cena_analizov,
									orders.pac_id, 
									pacients.FirstName,
									pacients.LastName,
									pacients.MidName
                                FROM orders
								INNER JOIN pacients
								ON orders.pac_id = pacients.id
                                WHERE orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.lab='".$row_lab["lab"]."'
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
                                        <td scope="col" class="text-right"><a href="#" id=o_'.$row_orders["OrderId"].'>'.
										$row_orders["OrderId"].'</a></td>
                                        <td scope="col">'.$row_orders["OrderDate"].'</td>
										<td scope="col">'.
										$row_orders["LastName"]. ' ' .$row_orders["FirstName"]. ' ' .$row_orders["MidName"].
										'( '.$row_orders["pac_id"].' )'.  '</td>';
										if($uu != 800) {
											$msg .= '<td scope="col" class="text-right">'.$row_orders["cena_analizov"].'</td>';
										}
                                    $msg .= '</tr>
                                ';
                    }
                }
            }
        }

        $msg .= '   <tr>
                        <td scope="col" colspan="3" class="text-right"><strong>ВСЕГО</strong></td>
                        <td scope="col" class="text-right"><strong>'.$total_count.'</strong></td>';
						if($uu != 800) {
							$msg .= '<td scope="col" class="text-right"><strong>'.$total_sum.'</strong></td>';
						}
                    $msg .= '</tr>
                ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

echo $msg;
?>
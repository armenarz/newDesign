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

if(!isset($_POST["driverId"]))
{
    $msg .= "The driver id is not defined. driverId=".$_POST["driverId"];
    echo $msg;
    return;
}
$driverId = $_POST["driverId"];
if($driverId > 0)
{
    $sql_driver = "SELECT
                    id,
                    voditel
                FROM voditeli
                WHERE id='".$driverId."'
                ";
    $result_driver = mysqli_query($link, $sql_driver);
    if($result_driver)
    {
        $row_driver = mysqli_fetch_array($result_driver);
        $driver = $row_driver["voditel"];
    }
}

$ar_ordid = array();

$ar_ordid_visidate = array();

$sql = "SELECT
            orderid,
			visitdate
            FROM a516
            WHERE done = 1
			AND date(visitdate) >='$startDate'
			AND date(visitdate) <='$endDate'
        ";
$res = mysqli_query($link, $sql);
if($res)
{	
	while($row = mysqli_fetch_array($res))
	{
		array_push($ar_ordid, $row['orderid']);
		
		if (!array_key_exists($row['orderid'], $ar_ordid_visidate)) {
			$ar_ordid_visidate[$row['orderid']] = $row['visitdate'];
		}
	}
    
}

$sql = "SELECT
            orderid,
			visitdate
            FROM a1014
            WHERE done = 1
			AND date(visitdate) >='$startDate'
			AND date(visitdate) <='$endDate'
        ";
$res = mysqli_query($link, $sql);
if($res)
{	
	while($row = mysqli_fetch_array($res))
	{
		array_push($ar_ordid, $row['orderid']);
		
		if (!array_key_exists($row['orderid'], $ar_ordid_visidate)) {
			$ar_ordid_visidate[$row['orderid']] = $row['visitdate'];
		}
	}
    
}

$filter = "";
$reportDescription = "";

if($menuId == "driversLink" && $reportTypeId == 2)
{
    if($driverId == 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
        $filter_driver = "1";
        $reportDescription = "<span>(тип отчета: детально)</span>";
    }
    else if($driverId != 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.voditel_id='".$driverId."'";
        $filter_driver = "id='".$driverId."'";
        $reportDescription = "<span>(тип отчета: детально, по водителю: ".$driver." [ id: ".$driverId." ])</span>";
    }

    $msg.= '
    <h3>Заказы по водителям с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="DriversDetailedData">
        <thead>
            <tr>
                <th scope="col" class="text-right">#</th>               
                <th scope="col" class="text-left">Номер заказа</th>                
                <th scope="col">Дата заказа</th>
                <th scope="col">Дата визита</th>
				<th scope="col">Ф.И.О. пациента</th>
				<th scope="col">Адрес</th>
				<th scope="col">Комментарии</th>
            </tr>
        </thead>
        <tbody>
        ';

        $sql_driver = "SELECT
                id,
                voditel
            FROM voditeli
            WHERE $filter_driver
            ORDER BY id
        ";
        
        $result_driver = mysqli_query($link, $sql_driver);
        if($result_driver)
        {
            $i = 0;
            $total_sum = 0;
			$total_count = 0;

            while($row_driver = mysqli_fetch_array($result_driver))
            {
                $sql_count_sum = "  SELECT 
                                        voditel_id, 
                                        SUM(cena_analizov) as sum, 
                                        COUNT(OrderId) as cnt 
                                    FROM orders 
                                    WHERE orders.OrderId in(". implode(',', $ar_ordid) .") 
									AND voditel_id='".$row_driver["id"]."';
                                ";
                
                $result_count_sum = mysqli_query($link,$sql_count_sum);
                if($result_count_sum)
                {
                    $row_count_sum = mysqli_fetch_array($result_count_sum);

                    if($row_count_sum["sum"] == null) $driver_sum = 0;
                    else $driver_sum = $row_count_sum["sum"];
					
					if($row_count_sum["cnt"] == null) $driver_count = 0;
                    else $driver_count = $row_count_sum["cnt"];
                }

				if($driver_count > 0) {
					$msg .= '   <tr>
									<td scope="col" colspan="7"><strong>Водитель: '.$row_driver["voditel"].',    Количество заказов- '.$driver_count.'</strong></td>
								</tr>
							';
                }
                $total_sum += $driver_sum;
				$total_count += $driver_count;

                $sql_orders = " SELECT 
                                    orders.OrderId, 
                                    orders.OrderDate,
									orders.OrderTime,
                                    orders.cena_analizov,
									pacients.FirstName,
									pacients.LastName,
									pacients.MidName, 
									pacients.adress, 
									orders.Comment
                                FROM orders
								INNER JOIN pacients ON orders.pac_id = pacients.id
                                WHERE orders.OrderId in(". implode(',', $ar_ordid) .") 
								AND orders.voditel_id='".$row_driver["id"]."'";
                $result_orders = mysqli_query($link,$sql_orders);
                if($result_orders)
                {
                    $i = 0;
                    while($row_orders = mysqli_fetch_array($result_orders))
                    {
                        $i++;
						
						$visidate = '';
						
						if (array_key_exists($row_orders["OrderId"], $ar_ordid_visidate)) {
							$visidate = $ar_ordid_visidate[$row_orders["OrderId"]];
						}
						
                        $msg .= '   <tr>
                                        <td scope="col" class="text-left">'.$i.'</td>
                                        <td scope="col" class="text-left"><a href="#" id=o_'.$row_orders["OrderId"].'>'.$row_orders["OrderId"].'</a></td>                                        
										<td scope="col" class="text-left">'. $row_orders["OrderDate"] . '</td>
										<td scope="col" class="text-left">'. $visidate . '</td>
										<td scope="col" class="text-left">'. $row_orders["LastName"] . ' ' . $row_orders["FirstName"] . ' ' . $row_orders["MidName"] . '</td>
										<td scope="col" class="text-left">'. $row_orders["adress"] . '</td>
										<td scope="col" class="text-right">'. $row_orders["Comment"] . '</td>
									</tr>
                                ';
                    }
                }
            }
        }

        $msg .= '   <tr id="tr_vsevo">
                        <td scope="col" colspan="7" class="text-center"><strong>ВСЕГО: '.$total_count. '</strong></td>
  
                    </tr>
                ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

echo $msg;
?>
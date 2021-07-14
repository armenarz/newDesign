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

if(!isset($_POST["driverId"]))
{
    $msg .= "The driver id is not defined. driverId=".$_POST["driverId"];
    echo $msg;
    return;
}
$driverId = $_POST["driverId"];

$ar_ordid = array();

$sql = "SELECT
            orderid
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
	}
    
}

$sql = "SELECT
            orderid
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
	}
    
}

$filter = "";
$reportDescription = "";

if($menuId == "driversLink" && $reportTypeId == 1)
{
    if($driverId == 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
        $filter_driver = "1";
        $reportDescription = "<span>(тип отчета: суммарно)</span>";
    }
    else if($driverId != 0)
    {
        $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."' AND orders.voditel_id='".$driverId."'";
        $filter_driver = "id='".$driverId."'";
        $reportDescription = "<span>(тип отчета: суммарно, по водителю: ".$driver." [ id: ".$driverId." ])</span>";
    }

    $msg.= '
    <table class="table" border="1" id="DriversConsolidatedData">
        <caption>
            <h2>Заказы по водителям</h2>
            <h3>с '.$startDate.' по '.$endDate.'</h3>
            <h4>'.$reportDescription.'</h4>
        </caption>
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
                <!--2. Driver-->
                <th scope="col">Водитель</th>
                <!--3. Order Count-->
                <th scope="col" class="text-right">Количество заказов</th>
				';
        $msg.= '</tr>
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
            $total_count = 0;
            $total_sum = 0;

            while($row_driver = mysqli_fetch_array($result_driver))
            {
                $sql_count_sum = "  SELECT 
                                        voditel_id, 
                                        SUM(cena_analizov) AS sum, 
                                        COUNT(OrderId) as cnt 
                                    FROM orders 
                                    WHERE orders.OrderId in(". implode(',', $ar_ordid) .") 
									AND voditel_id='".$row_driver["id"]."';
                                ";
                // echo $sql_count_sum;
                
                $result_count_sum = mysqli_query($link,$sql_count_sum);
                if($result_count_sum)
                {
                    $row_count_sum = mysqli_fetch_array($result_count_sum);

                    if($row_count_sum["cnt"] == null) $driver_count = 0;
                    else $driver_count = $row_count_sum["cnt"];

                    if($row_count_sum["sum"] == null) $driver_sum = 0;
                    else $driver_sum = $row_count_sum["sum"];
                }

                $i++;
				if($driver_count > 0) {
					$msg .= '   <tr>
									<!--1. Row number-->
									<td scope="col" class="text-right">'.$i.'</td>
									<!--2. Driver-->
									<td scope="col">'.$row_driver["voditel"].'</td>
									<!--3. Order Count-->
									<td scope="col" class="text-right">'.$driver_count.'</td>
									';
									
							$msg .= '</tr>
							';
					$total_count += $driver_count;
					$total_sum += $driver_sum;
				}
            }
        }

        $msg .= '   <tr>
                        <td scope="col" colspan="2" class="text-right"><strong>ВСЕГО</strong></td>
                        <td scope="col" class="text-right"><strong>'.$total_count.'</strong></td>';
						
                    $msg .= '</tr>
                ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

header("Content-Disposition: attachement; filename=DriverConsolidated.xls");
echo $msg;
?>
<?php
require_once "../connect.php";
require_once "../authorization.php";

set_time_limit(0);
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

$filter = "";
$reportDescription = "";

if($menuId == "doctor13Link" && $reportTypeId == 1)
{
    $first_mes = date('Y-m-01', strtotime($startDate));

    $last_mes0 = date('Y-m-t', strtotime($startDate));

    $pred_last = date('Y-m-d', strtotime($first_mes . ' -1 day'));

    $pred_first = date('Y-m-01', strtotime($pred_last));

    $sql0  = "  SELECT 
                    doctor.DoctorId,
                    cworkplace.WorkPlaceId,
                    cworkplace.WorkPlaceDesc 
                FROM orderresult 
                INNER JOIN orders ON orders.OrderId =orderresult.OrderId 
                LEFT JOIN doctor ON orders.DoctorId = doctor.DoctorId 
                LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
                WHERE (orders.OrderDate >= '".$first_mes."') AND (orders.OrderDate <= '".$last_mes0."') 
                GROUP BY cworkplace.WorkPlaceId 
                ORDER BY cworkplace.WorkPlaceDesc
            ";
    
    $res0 = mysqli_query($link, $sql0);
	$ar_WorkPlaceId0 = array();
	$ar_WorkPlaceDesc0 = array();
	$ar_DoctorId0 = array();

	$array_doctor = array();
	$array_workplace_id = array();

	if($res0)
	{
		while ($row0 = mysqli_fetch_array($res0)) 
		{
			array_push($ar_DoctorId0,$row0["DoctorId"]);
			array_push($ar_WorkPlaceId0,$row0["WorkPlaceId"]);
			array_push($ar_WorkPlaceDesc0,$row0["WorkPlaceDesc"]);
		}
    }
    
    $sql = "SELECT 
                OrderDate 
            FROM orders 
            WHERE OrderDate >= '".$first_mes."' and OrderDate <= '".$last_mes0."' 
            GROUP BY OrderDate 
            ORDER BY OrderDate DESC
            ";

	$res = mysqli_query($link, $sql);
	if($res)
	{
		$row = mysqli_fetch_array($res); 
		$last_mes = $row["OrderDate"];
    }
    
	for($k = 0; $k < count($ar_WorkPlaceId0); $k++)
	{
		$WorkPlaceId = $ar_WorkPlaceId0[$k];
		$WorkPlaceDesc = $ar_WorkPlaceDesc0[$k];
		if($ar_WorkPlaceId0[$k] == 0) $WorkPlaceId=0;
        
        $sql22 ="   SELECT 
                        doctor.DoctorId,
                        CONCAT( doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) AS DocName 
                    FROM orders 
                    INNER JOIN doctor ON orders.DoctorId = doctor.DoctorId 
                    LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
                    WHERE (orders.OrderDate >= '".$first_mes."') AND (orders.OrderDate <= '".$last_mes0."')  and doctor.WorkPlaceId ='".$WorkPlaceId."' 
                    GROUP BY orders.DoctorId ORDER BY cworkplace.WorkPlaceDesc
                ";

		$res22 = mysqli_query($link, $sql22);
		if($res22)
		{
			while ($row22 = mysqli_fetch_array($res22)) 
			{
				$docid = $row22["DoctorId"];
				$docName = $row22["DocName"];
				$sql6 = "   SELECT count(OrderId) as cnt
                            FROM orders 
                            WHERE (orders.OrderDate >= '".$first_mes."') AND (orders.OrderDate <= '".$last_mes0."') AND orders.DoctorId='".$docid."'
                        ";
                
				$res6 = mysqli_query($link, $sql6);
				if($res6)
				{
					$row6 = mysqli_fetch_array($res6); 
					$cnt = $row6["cnt"];
                }
                
				$docid = $row22["DoctorId"];
				$sql =" SELECT 
                            orders.OrderId, 
                            orders.OrderDate, 
                            orders.DoctorDiscount 
                        FROM orders 
                        WHERE (orders.OrderDate >= '".$first_mes."') AND (orders.OrderDate <= '".$last_mes0."') AND orders.DoctorId='".$docid."'
                        ";
                
				$res = mysqli_query($link, $sql);
				if($res)
				{
					$ar_OrderId0 = array();
					$ar_OrderDate0 = array();
					$ar_DoctorDiscount0 = array();
					while ($row = mysqli_fetch_array($res))
					{
						array_push($ar_OrderId0,$row["OrderId"]);
						array_push($ar_OrderDate0,$row["OrderDate"]);
						array_push($ar_DoctorDiscount0,$row["DoctorDiscount"]);
					}
                }
                
                $cena_analisov = 0;
				$cost_all = 0;
				$skidka_vr = 0;
				$vozvrat = 0;
				
				$flag_skidka = true;
				
				$orders_id787 = '';
				
                $pred_last_cur = $pred_last;
                
				$pred_first_cur = $pred_first;
                
				for($j9 = 0; $j9 < 9; $j9++)
				{
					unset($res787);
					$sql787 = " SELECT 
                                    orders_id 
                                FROM doctors_skidki2 
                                WHERE DoctorId = '$docid' AND amis_date >= '$pred_first_cur' AND amis_date <= '$pred_last_cur' 
                                ORDER BY id DESC 
                                LIMIT 0,1 
                                ";
                    
					$res787 = mysqli_query($link, $sql787);
					
					if(!$res787 or mysqli_num_rows($res787) == 0 )
					{
						$pred_last_cur = date('Y-m-d', strtotime($pred_first_cur . ' -1 day'));

                        $pred_first_cur = date('Y-m-01', strtotime($pred_last_cur));

                        $dt_pred_first_cur = date('Y-m-d', strtotime($pred_first_cur));

						if($dt_pred_first_cur < date('Y-m-d', strtotime('2018-04-01')))	break;
						continue;
					}
					else
					{
						if($res787)
						{
							$row787 = mysqli_fetch_array($res787);
							$orders_id787 = $row787["orders_id"];
							unset($row787);
							unset($res787);								
							unset($ar_orders_id787);
							
							if($orders_id787 != '')
							{
								$ar_orders_id787 = json_decode($orders_id787, true);
								$cnt787 = count($ar_orders_id787);
								
								if($cnt787 > 0)
								{
									for($i9 = 0; $i9 < $cnt787; $i9++)
									{
										array_unshift($ar_OrderId0, $ar_orders_id787[$i9]);
										array_unshift($ar_OrderDate0, '2077-06-13');
									}
								}
							}		
							break;
						}						
					}															
				}
				
				for($i=0; $i<count($ar_OrderId0); $i++)
				{
					$orderid=$ar_OrderId0[$i];

					$sql1 = "	SELECT
									doctor.DoctorId,
									CONCAT( doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) as DocName,
									orders.OrderId, 
									CONCAT(pacients.LastName,' ', pacients.FirstName,' ', pacients.MidName ) AS CustName,
									reagent.AnalysisPrice, 
									orders.DoctorDiscount,
									orders.usr, 
									orders.OrderDiscount,
									orders.OrderDate,
									orders.cena_analizov,
									orders.cost,
									orders.dolg,
									orders.Comment, 
									orders.DoctorDiscount + orders.OrderDiscount AS TotalDiscount,
									orderresult.ReagentId,
									orderresult.Price
								FROM orders
								LEFT JOIN doctor ON orders.DoctorId = doctor.DoctorId
								LEFT JOIN pacients ON orders.pac_id = pacients.id
								LEFT JOIN orderresult ON orders.OrderId = orderresult.OrderId
								LEFT JOIN reagent ON orderresult.ReagentId = reagent.ReagentId
								WHERE orders.OrderId='".$orderid."' 
								ORDER BY orders.cena_analizov
							";
					
					$res1 = mysqli_query($link,$sql1);
					$skidka = 0;
					if($res1)
					{
						$ar_OrderId = array();
						$ar_cena_analizov = array();
						$ar_OrderDate = array();
						$ar_OrderDate = array();
						$ar_cost = array();
						$ar_ReagentId = array();
						$ar_CustName = array();
						$ar_Comment = array();
						while ($row1 = mysqli_fetch_array($res1))
						{
							array_push($ar_OrderId,$row1["OrderId"]);
							array_push($ar_cena_analizov,$row1["cena_analizov"]);
							array_push($ar_OrderDate,$row1["OrderDate"]);
							array_push($ar_cost,$row1["cost"]);
							array_push($ar_ReagentId,$row1["ReagentId"]);
							array_push($ar_CustName,$row1["CustName"]);
							array_push($ar_Comment,$row1["Comment"]);
							if($row1["DoctorDiscount"] == 0)
							{
								if($row1["DoctorId"] == 399) $skidka += ($row1["Price"]*30/100);
								elseif($row1["DoctorId"] == 3046)
								{
									if($row1["OrderDate"] >= '2018-12-01') $skidka += ($row1["Price"]*30/100);
									else $skidka += ($row1["Price"]*20/100);
								}
								elseif($row1["OrderId"] == 400916 || $row1["OrderId"] == 401152) $skidka = 55000;
								else
								{
									if($row1["ReagentId"] == 344 || $row1["ReagentId"] == 345 || $row1["ReagentId"] == 346) $skidka += 15000;
									if($row1["ReagentId"] == 798)
									{
										if($row1["OrderId"] < 394072/*$Border798*/) $skidka += 40000;
										if($row1["OrderId"] >= 394072/*$Border798*/ and $row1["OrderId"] <= 500752) $skidka += 30000;
										if($row1["OrderId"] > 500752) $skidka += 40000;
									}
									if($row1["ReagentId"] == 990)
									{
										$skidka += 150000;
									}
									if($row1["ReagentId"] == 992)
									{
										$skidka += 50000;
									}
									if($row1["ReagentId"] == 982)
									{
										$skidka += ($row1["Price"]*10/100);
									}
										
									if($row1["ReagentId"] == 1084 or $row1["ReagentId"] == 1086 or $row1["ReagentId"] == 1088 or $row1["ReagentId"] == 1090)
									{
										$skidka += ($row1["Price"]*10/100);
									}
									
									if($row1["ReagentId"] <> 957 && $row1["ReagentId"] <> 958 && $row1["ReagentId"] <> 959 && $row1["ReagentId"] <> 344 
									&& $row1["ReagentId"] <> 982&& $row1["ReagentId"] <> 1084 && $row1["ReagentId"] <> 1086 && $row1["ReagentId"] <> 1088
									&& $row1["ReagentId"] <> 1090
									&& $row1["ReagentId"] <> 345 && $row1["ReagentId"] <> 346 && $row1["ReagentId"] <> 516 && $row1["ReagentId"] <> 1014
									&& $row1["ReagentId"] <> 798 && ($row1["ReagentId"] < 890 or $row1["ReagentId"] > 900) 
									and $row1["ReagentId"] <> 966 && $row1["ReagentId"] <> 990 && $row1["ReagentId"] <> 992) $skidka += ($row1["Price"] * 20 / 100);
									
									if($row1["ReagentId"] == 516) $skidka += ($row1["Price"] * 0 / 100);
									if($row1["ReagentId"] == 1014) $skidka += ($row1["Price"] * 0 / 100);
									if(($row1["ReagentId"] >= 890 and $row1["ReagentId"]<=900) or $row1["ReagentId"]==966) $skidka += 10000;	
								}
							}
								
							if($row1["OrderDiscount"] >= 50 or $row1["DoctorId"] == 3110) $skidka = 0;
							
							if( ($row1["usr"] == 'Gyumri' or $row1["usr"] == 'Garant_Insurance') and $row1["DoctorDiscount"] != 0)
							{
								if($row1["OrderId"] != 425314 and $row1["OrderId"] != 426076) $skidka += $row1["AnalysisPrice"] / 5;
								else $skidka += 0;
							}
							
							if($row1["usr"] == 'Garant_Assinstance' or $row1["usr"] == 'Nairi' or $row1["usr"] == 'Nairi8302' or $row1["usr"] == 'Nairi8311'
								or $row1["usr"] == 'Nairi8312' or $row1["usr"] == 'Nairi8313')
							{
								$skidka += $row1["AnalysisPrice"]*16/100;
							}
							
						}
							
								
						$sql57 = "  SELECT 
                                        SUM(vozvrat_sum) AS v_vozvrat 
                                    FROM vozvrat 
                                    WHERE orderid = '".$orderid."' AND vozvrat_date <= '".$last_mes0."' and vozvrat_date >= '".$first_mes."'
                                    ";

						$res57 = mysqli_query($link, $sql57);
						
						if($res57)
						{
							$row57 = mysqli_fetch_array($res57); 
							$v_vozvrat57 = $row57["v_vozvrat"];
						}
							
						if($ar_DoctorDiscount0[$i] != 20) $skidka -= (int) ($v_vozvrat57/5);
						
						if(($ar_OrderDate0[$i] >= $first_mes and $ar_OrderDate0[$i] <= $last_mes0) or $ar_OrderDate0[$i] == '2077-06-13') $skidka_vr += $skidka;
					}
					
					$sql5 = "   SELECT 
                                    SUM(dolg) AS v_dolg 
                                FROM vernuli_dolg 
                                WHERE orderid = '".$orderid."' AND vernuli_date <= '".$last_mes0."' AND vernuli_date >= '".$first_mes."'
                            ";

					$res5 = mysqli_query($link,$sql5);
					if($res5)
					{
						$row5 = mysqli_fetch_array($res5); 
						$v_dolg = $row5["v_dolg"];
					}

					$ar_cost[0] += $v_dolg;
					$sql55 = "  SELECT 
                                    SUM(vozvrat_sum) AS v_vozvrat 
                                FROM vozvrat 
                                WHERE orderid = '".$orderid."' AND vozvrat_date <= '".$last_mes0."' AND vozvrat_date >= '".$first_mes."'
                            ";

					$res55 = mysqli_query($link, $sql55);
					if($res55)
					{
						$row55 = mysqli_fetch_array($res55); 
						$v_vozvrat = $row55["v_vozvrat"];
					}
					$cena_analisov0 = $ar_cena_analizov[0];
					if($uu==13)
					{
						$cena_analisov0 -= $v_vozvrat;
                    }
                    
                    $cena_analizov += $cena_analisov0;
                    $cost_all += $ar_cost[0];
				}
				
				$sql88 = "  SELECT 
                                ostatok, 
                                orders_id 
                            FROM doctors_skidki2 
                            WHERE DoctorId = '".$docid."' AND amis_date >= '".$pred_first."' AND amis_date <= '".$pred_last."' 
                            ORDER BY id DESC 
                            LIMIT 0,1 
                        ";

				$res88 = mysqli_query($link,$sql88);
				if($res88)
				{
					$row88 = mysqli_fetch_array($res88);
					$ostatok = $row88["ostatok"];
					$orders_id = $row88["orders_id"];
				}
				
				$json = "";
				
				if($skidka_vr >= 5000)
				{	
					$flag_skidka = true;
					if($last_mes == $last)
					{
						$sql99 = "  INSERT INTO doctors_skidki2 (DoctorId, amis_date, ostatok, orders_id) 
                                    VALUES ('".$docid."', '".$last_mes."', '0', '')
                                ";
                        
						$res99 = mysqli_query($link,$sql99);
					}
				}
				else
				{
					if($orders_id == '') $ar_orders_id = array();
					else
					{
						$ar_orders_id = json_decode($orders_id, true);
					}
					
					$sql90 = "  SELECT 
                                    OrderId 
                                FROM orders 
                                WHERE DoctorId = '".$docid."' AND OrderDate <= '".$last_mes0."' AND OrderDate >= '".$first_mes."'
                            ";
                    
					$res90 = mysqli_query($link, $sql);
					if($res90)
					{
						while ($row90 = mysqli_fetch_array($res90)) 
						{
							array_push($ar_orders_id,$row90["OrderId"]);
						}
					}
					
					$json = json_encode($ar_orders_id);
			
					$flag_skidka = false;
					if($last_mes == $last)
					{
						$sql99 = "  INSERT INTOR doctors_skidki2 (DoctorId, amis_date, ostatok, orders_id) 
                                    VALUES ('$docid', '$last_mes', '$skidka_vr', '$json')
                                ";
                        
						$res99 = mysqli_query($link, $sql99);
					}
				}
				
				$array_data = array();
				array_push($array_data, $WorkPlaceDesc);
				array_push($array_data, $WorkPlaceId);
				array_push($array_data, $docName);
				array_push($array_data, $docid);
				array_push($array_data, $cena_analizov);
				array_push($array_data, $cost_all);
				array_push($array_data, $skidka_vr);

				if($flag_skidka == 1)
				{
					array_push($array_doctor, $array_data);
					array_push($array_workplace_id, $WorkPlaceId);
				}

                $cena_analizov = 0;
            }
			
            $cena_analizov = 0;
            $cost_all = 0;
            $skidka_vr = 0;   
		}
	}
	
	$reportDescription = "<span>(тип отчета: суммарно)</span>";

	$msg.= '
    <h3>Врач13 с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="doctor13Data">
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
                <!--2. Doctor-->
                <th scope="col">Врач</th>
                <!--3. Cost of analyzes-->
                <th scope="col" class="text-right">Стоимость</th>
                <!--4. Payments -->
                <th scope="col" class="text-right">Получено от пациента</th>
                <!--5. Discount-->
                <th scope="col" class="text-right">Скидка</th>
            </tr>
        </thead>
        <tbody>
	';

	//getting unique workplace ids
	$array_workplace_id = array_unique($array_workplace_id);

	//correcting indexes of $array_workplace_id
	$array_temp = $array_workplace_id;
	$array_workplace_id = array();
	while($item = array_pop($array_temp))
	{
		array_push($array_workplace_id, $item);
	}
	$array_workplace_id = array_reverse($array_workplace_id);

	//preparing array for workplace totals
	$array_workplace_totals = array();
	for($i = 0; $i < COUNT($array_workplace_id); $i++)
	{
		$current_workplace_id = $array_workplace_id[$i];

		$array_current_total = array();
		for($j = 0; $j < COUNT($array_doctor); $j++)
		{
			if($array_doctor[$j][1] == $current_workplace_id)
			{
				$current_workplace_desc = $array_doctor[$j][0];
				break;
			}
		}
		array_push($array_current_total, $current_workplace_id, $current_workplace_desc, 0, 0, 0);
		array_push($array_workplace_totals, $array_current_total);
	}
	
	$grand_total_price = 0;
	$grand_total_cost = 0;
	$grand_total_discount = 0;

	for($i = 0; $i < COUNT($array_workplace_totals); $i++)
	{
		$current_workplace_id = $array_workplace_totals[$i][0];
		$current_workplace_desc = $array_workplace_totals[$i][1];
		$msg.= '<tr>
					<td scope="col" colspan="5"><strong>'.$current_workplace_desc.' [ id: '.$current_workplace_id.' ] </strong></td>
				</tr>';
		
		$workplace_found = false;
		$n = 0;
		for($j = 0; $j < COUNT($array_doctor); $j++)
		{
			if($current_workplace_id == $array_doctor[$j][1])
			{
				$n++;
				$workplace_found = true;
				$current_doctor = $array_doctor[$j][2] ;
				$current_doctor_id = $array_doctor[$j][3];
				$current_price = $array_doctor[$j][4];
				$current_cost = $array_doctor[$j][5];
				$current_discount = $array_doctor[$j][6];
				$msg.= '<tr>
							<td scope="col" class="text-right">'.$n.'</td>
							<td scope="col">'.$current_doctor.' [ id: '.$current_doctor_id.' ] </td>
							<td scope="col" class="text-right">'.$current_price.'</td>
							<td scope="col" class="text-right">'.$current_cost.'</td>
							<td scope="col" class="text-right">'.$current_discount.'</td>
						</tr>';
				$array_workplace_totals[$i][2] += $current_price;
				$grand_total_price += $current_price;

				$array_workplace_totals[$i][3] += $current_cost;
				$grand_total_cost += $current_cost;

				$array_workplace_totals[$i][4] += $current_discount;
				$grand_total_discount += $current_discount;
			}
		}
		if($workplace_found)
		{
			$msg.= '<tr>
						<td scope="col" colspan="2" class="text-right"><strong>ИТОГО:</strong></td>
						<td scope="col" class= "text-right"><strong>'.$array_workplace_totals[$i][2].'</strong></td>
						<td scope="col" class= "text-right"><strong>'.$array_workplace_totals[$i][3].'</strong></td>
						<td scope="col" class= "text-right"><strong>'.$array_workplace_totals[$i][4].'</strong></td>
					</tr>
					';
			$workplace_found = false;
		}
	}
	
	$msg.= '<tr>
                <td colspan="2" class="text-right"><strong>ВСЕГО:</strong></td>
                <td class="text-right"><strong>'.$grand_total_price.'</strong></td>
                <td class="text-right"><strong>'.$grand_total_cost.'</strong></td>
                <td class="text-right"><strong>'.$grand_total_discount.'</strong></td>
            </tr>
        </tbody>
    </table>
	';
}

echo $msg;
?>
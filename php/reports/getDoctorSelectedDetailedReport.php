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

$filter = "";
$reportDescription = "";

if($menuId == "doctorSelectedLink" && $reportTypeId == 2)
{
	$sql0 ="SELECT 
				doctor.DoctorId,
				cworkplace.WorkPlaceId,
				cworkplace.WorkPlaceDesc
			FROM orderresult 
			INNER JOIN orders ON orders.OrderId = orderresult.OrderId 
			LEFT JOIN doctor ON orders.DoctorId = doctor.DoctorId 
			LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
			WHERE (orders.OrderDate >= '".$startDate."') AND (orders.OrderDate <= '".$endDate."') AND doctor.visible_in_report='1'
			GROUP BY cworkplace.WorkPlaceId 
			ORDER BY cworkplace.WorkPlaceDesc
			";

    $res0 = mysqli_query($link, $sql0);
	$ar_WorkPlaceId0 = array();
	$ar_WorkPlaceDesc0 = array();
	$ar_DoctorId0 = array();

	$array_doctor = array();
	$array_workplace_id = array();
	$array_order = array();

	if($res0)
	{
		while ($row0 = mysqli_fetch_array($res0)) 
		{
			array_push($ar_DoctorId0,$row0["DoctorId"]);
			array_push($ar_WorkPlaceId0,$row0["WorkPlaceId"]);
			array_push($ar_WorkPlaceDesc0,$row0["WorkPlaceDesc"]);
		}
    }
	
	$cena_analizov_al = 0;
	$cost_al = 0;
	$skidka_al = 0;

	for($k = 0; $k < count($ar_WorkPlaceId0); $k++)
	{
		$WorkPlaceId = $ar_WorkPlaceId0[$k];
		$WorkPlaceDesc = $ar_WorkPlaceDesc0[$k];
		if($ar_WorkPlaceId0[$k] == 0) $WorkPlaceId = 0;

		$cena_analizov_w = 0;
		$cost_w = 0;
		$skidka_w = 0;
        
        $sql22 ="	SELECT 
						doctor.DoctorId,
						CONCAT(doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) AS DocName
					FROM orders 
					INNER JOIN doctor ON orders.DoctorId = doctor.DoctorId 
					LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
					WHERE 
						(orders.OrderDate >= '".$startDate."') AND (orders.OrderDate <= '".$endDate."') AND 
						(doctor.WorkPlaceId ='".$WorkPlaceId."') AND doctor.visible_in_report='1'
					GROUP BY orders.DoctorId 
					ORDER BY cworkplace.WorkPlaceDesc
				";
		$res22 = mysqli_query($link, $sql22);
		if($res22)
		{
			while ($row22 = mysqli_fetch_array($res22)) 
			{
				$docid = $row22["DoctorId"];
				$docName = $row22["DocName"];

				$sql6 = "	SELECT 
								COUNT(OrderId) AS cnt
							FROM orders 
							WHERE (orders.OrderDate >= '".$startDate."') AND (orders.OrderDate <= '".$endDate."') AND orders.DoctorId='".$docid."'
						";
				$res6 = mysqli_query($link, $sql6);
				if($res6)
				{
					$row6 = mysqli_fetch_array($res6); 
					$cnt = $row6["cnt"];
				}

				$sql = "SELECT 
							orders.OrderId, 
							orders.DoctorDiscount
						FROM orders 
						WHERE (orders.OrderDate >= '".$startDate."') AND (orders.OrderDate <= '".$endDate."') AND orders.DoctorId='".$docid."'
						";

				$res = mysqli_query($link, $sql);
				if($res)
				{
					$ar_OrderId0 = array();
					$ar_DoctorDiscount0 = array();
					while ($row = mysqli_fetch_array($res))
					{
						array_push($ar_OrderId0,$row["OrderId"]);
						array_push($ar_DoctorDiscount0,$row["DoctorDiscount"]);
					}
				}

				$cena_analisov = 0;
				$cost_all = 0;
				$skidka_vr = 0;

				for($i = 0; $i < count($ar_OrderId0); $i++)
				{
					$orderid = $ar_OrderId0[$i];

					$sql1="	SELECT 
								doctor.DoctorId,
								CONCAT( doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) AS DocName,
								orders.OrderId,
								CONCAT(orders.CustLastName,' ', orders.CustFirstName,' ', orders.CustMidName ) AS CustName,
								reagent.AnalysisPrice,
								orders.DoctorDiscount,
								orders.usr, 
								orders.OrderDiscount,
								orders.OrderDate,
								orders.cena_analizov,
								orders.cost,
								orders.dolg,
								orders.DoctorDiscount + orders.OrderDiscount AS TotalDiscount,
								orderresult.ReagentId,
								orderresult.Price
							FROM doctor 
							RIGHT JOIN orders ON orders.DoctorId = doctor.DoctorId 
							INNER JOIN orderresult ON orders.OrderId = orderresult.OrderId 
							INNER JOIN reagent ON orderresult.ReagentId = reagent.ReagentId
							WHERE 
								(orders.OrderDate >= '".$startDate."') AND (orders.OrderDate <= '".$endDate."') AND 
								(doctor.DoctorId='".$docid."') AND (orders.OrderId='".$orderid."')
							ORDER BY orders.cena_analizov
							";

					$res1 = mysqli_query($link,$sql1);
					$skidka = 0;
					if($res1)
					{
						$ar_OrderId = array();
						$ar_cena_analizov = array();
						$ar_OrderDate = array();
						$ar_cost = array();
						$ar_ReagentId = array();
						$ar_CustName = array();

						while ($row1 = mysqli_fetch_array($res1))
						{
							array_push($ar_OrderId,$row1["OrderId"]);
							array_push($ar_cena_analizov,$row1["cena_analizov"]);
							array_push($ar_OrderDate,$row1["OrderDate"]);
							array_push($ar_cost,$row1["cost"]);
							array_push($ar_ReagentId,$row1["ReagentId"]);
							array_push($ar_CustName,$row1["CustName"]);

							if($row1["DoctorDiscount"]==0)
							{
							    if($row1["DoctorId"]==399) $skidka+=($row1["Price"]*30/100);
								
								elseif($row1["DoctorId"]==3046){
									if($row1["OrderDate"] >= '2018-12-01')
										$skidka+=($row1["Price"]*30/100);
									else
										$skidka+=($row1["Price"]*20/100);
								}
								
								elseif($row1["OrderId"]==400916 || $row1["OrderId"]==401152)$skidka=55000;
								else
								{
									if($row1["ReagentId"]==344 || $row1["ReagentId"]==345 || $row1["ReagentId"]==346)$skidka+=15000;
									if($row1["ReagentId"]==798)
									{
										if($row1["OrderId"] < 394072/*$Border798*/)
											$skidka += 40000;
										if($row1["OrderId"] >= 394072/*$Border798*/ and $row1["OrderId"] <= 500752)
											$skidka += 30000;
										if($row1["OrderId"] > 500752)
											$skidka += 40000;
									}
									if($row1["ReagentId"]==990)
									{
										$skidka += 150000;
									}
									if($row1["ReagentId"]==992)
									{
										$skidka += 50000;
									}
									
									if($row1["ReagentId"]==982)
									{
										$skidka+=($row1["Price"]*10/100);
									}
									
									if($row1["ReagentId"]==1084 or $row1["ReagentId"]==1086 or $row1["ReagentId"]==1088 or $row1["ReagentId"]==1090)
									{
										$skidka+=($row1["Price"]*10/100);
									}
									
									if($row1["ReagentId"]<>957 && $row1["ReagentId"]<>958 && $row1["ReagentId"]<>959 && $row1["ReagentId"]<>344
									&& $row1["ReagentId"]<>982&& $row1["ReagentId"]<>1084 && $row1["ReagentId"]<>1086 && $row1["ReagentId"]<>1088
									&& $row1["ReagentId"]<>1090
									&& $row1["ReagentId"]<>345 && $row1["ReagentId"]<>346 && $row1["ReagentId"]<>516 
									&& $row1["ReagentId"]<>798 && ($row1["ReagentId"]<890 or $row1["ReagentId"]>900) 
									and $row1["ReagentId"]<>966 && $row1["ReagentId"]<>990 && $row1["ReagentId"]<>992)$skidka+=($row1["Price"]*20/100);
									
									if($row1["ReagentId"]==516)$skidka+=($row1["Price"]*0/100);
									if(($row1["ReagentId"]>=890 and $row1["ReagentId"]<=900) or $row1["ReagentId"]==966)$skidka+=10000;
								}
								
							}
							if($row1["OrderDiscount"]>=50 or $row1["DoctorId"]==3110)$skidka=0;
							
							if( ($row1["usr"]=='Gyumri' or $row1["usr"]=='Garant_Insurance') and $row1["DoctorDiscount"] != 0)
							{
								if($row1["OrderId"]!=425314 and $row1["OrderId"]!=426076)
									$skidka+=$row1["AnalysisPrice"]/5;
								else
									$skidka+=0;
							}
							
							if($row1["usr"]=='Garant_Assinstance' or 
							$row1["usr"]=='Nairi' or 
							$row1["usr"]=='Nairi8302' or 
							$row1["usr"]=='Nairi8311' or 
							$row1["usr"]=='Nairi8312' or 
							$row1["usr"]=='Nairi8313') $skidka+=$row1["AnalysisPrice"]*16/100;
						}
							
						$sql57="SELECT 
									SUM(vozvrat_sum) AS v_vozvrat 
								FROM vozvrat 
								WHERE orderid='".$orderid."' AND vozvrat_date<='".$endDate."' AND vozvrat_date >= '".$startDate."'
								";
						$res57 = mysqli_query($link, $sql57);
						
						if($res57)
						{
							$row57 = mysqli_fetch_array($res57); 
							$v_vozvrat57 = $row57["v_vozvrat"];
						}
						
						if($ar_DoctorDiscount0[$i] != 20)								
							$skidka -= (int) ($v_vozvrat57/5);
					    
						
						$skidka_vr += $skidka;
					}
					$sql5="	SELECT 
								SUM(dolg) AS v_dolg 
							FROM vernuli_dolg 
							WHERE orderid='".$orderid."' AND vernuli_date<='".$endDate."'
							";
					$res5 = mysqli_query($link, $sql5);
					if($res5)
					{
						$row5 = mysqli_fetch_array($res5); 
						$v_dolg = $row5["v_dolg"];
					}
					$ar_cost[0] += $v_dolg;
					
					$sql55="SELECT 
								SUM(vozvrat_sum) AS v_vozvrat 
							FROM vozvrat 
							WHERE orderid = '".$orderid."' AND vozvrat_date<='".$endDate."' AND vozvrat_date >= '".$startDate."'
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
					
					$array_details = array();
					array_push($array_details, $docid);
					array_push($array_details, $ar_OrderId[0]);
					array_push($array_details, $ar_OrderDate[0]);
					array_push($array_details, $ar_CustName[0]);
					array_push($array_details, $cena_analisov0);
					array_push($array_details, $ar_cost[0]);
					array_push($array_details, $skidka);
					array_push($array_details, $ar_Comment[0]);

					array_push($array_order, $array_details);

					$cena_analizov += $cena_analisov0;
					$cost_all += $ar_cost[0];
				}
				
				$array_data = array();
				array_push($array_data, $WorkPlaceDesc);
				array_push($array_data, $WorkPlaceId);
				array_push($array_data, $docName);
				array_push($array_data, $docid);
				array_push($array_data, $cena_analizov);
				array_push($array_data, $cost_all);
				array_push($array_data, $skidka_vr);

				array_push($array_doctor, $array_data);
				array_push($array_workplace_id, $WorkPlaceId);

				$cena_analizov_w += $cena_analizov;
				$cost_w += $cost_all;
				$skidka_w += $skidka_vr; 
				$cena_analizov = 0;
				$cnt_w += $cnt; //Итог по месту работы
			}

			$cena_analizov_al += $cena_analizov_w;
			$cost_al += $cost_w;
			$skidka_al += $skidka_w;
			$cena_analizov = 0;
			$cost_all = 0;
			$skidka_vr = 0;
			$cnt_all += $cnt_w; //Общий итог
			$cnt_w = 0; //Обнуляем итог по месту работы
		}
	}
	mysqli_close($link);
	
	$reportDescription = "<span>(тип отчета: детально)</span>";

	$msg.= '
    <h3>Врач выбранный с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="doctor13Data">
        <thead>
            <tr>
                <!--1. Doctor Row number-->
				<th scope="col" class="text-right">#</th>
				<!--2. Order Row number-->
                <th scope="col" class="text-right"></th>
                <!--3. Order Id-->
                <th scope="col" class="text-right">Номер заказа</th>
                <!--4. Order Date-->
                <th scope="col">Дата&nbsp;заказа</th>
                <!--5. Customer Name -->
                <th scope="col">Пациент</th>
                <!--6. Price-->
				<th scope="col" class="text-right">Стоимость</th>
				<!--7. Cost-->
				<th scope="col" class="text-right">Получено от пациента</th>
				<!--8. Discount-->
				<th scope="col" class="text-right">Скидка</th>
				<!--9. Comments-->
				<th scope="col">Комментарий</th>
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
							<td scope="col" class="text-right"><strong>'.$n.'</strong></td>
							<td scope="col" colspan="8"><strong>'.$current_doctor.' [ id: '.$current_doctor_id.' ] </strong></td>
							<!--<td scope="col"></td>-->
							<!--<td scope="col"></td>-->
							<!--<td scope="col"></td>-->
							<!--<td scope="col"></td>-->
							<!--<td scope="col"></td>-->
							<!--<td scope="col"></td>-->
							<!--<td scope="col"></td>-->
						</tr>';
	
				$m = 0;
				for($k = 0; $k < COUNT($array_order); $k++)
				{
					if($current_doctor_id == $array_order[$k][0])
					{
						$m++;
						$current_order_id = $array_order[$k][1];
						if($current_order_id == null or $current_order_id == '')
						{
							$m--;
							continue;
						}
						$current_order_date = $array_order[$k][2];
						$current_order_cust_name = $array_order[$k][3];
						$current_order_price = $array_order[$k][4];
						$current_order_cost = $array_order[$k][5];
						$current_order_discount = $array_order[$k][6];
						$current_order_comment = $array_order[$k][7];
	
						$msg.= '<tr>
									<td scope="col"></td>
									<td scope="col" class="text-right">'.$m.'</td>
									<td scope="col" class="text-right"><a href="#" id=o_'.$current_order_id.'>'.$current_order_id.'</a></td>
									<td scope="col">'.$current_order_date.'</td>
									<td scope="col">'.$current_order_cust_name.'</td>
									<td scope="col" class="text-right">'.$current_order_price.'</td>
									<td scope="col" class="text-right">'.$current_order_cost.'</td>
									<td scope="col" class="text-right">'.$current_order_discount.'</td>
									<td scope="col">'.$current_order_comment.'</td>
								</tr>';
					}
				}

				$msg.= '<tr>
							<td scope="col" colspan="5" class="text-right"><strong>Итого по доктору [ id: '.$current_doctor_id.' ] </strong></td>
							<td scope="col" class="text-right"><strong>'.$current_price.'</strong></td>
							<td scope="col" class="text-right"><strong>'.$current_cost.'</strong></td>
							<td scope="col" class="text-right"><strong>'.$current_discount.'</strong></td>
							<td scope="col"></td
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
						<td scope="col" colspan="5" class="text-right"><strong>Итого по месту работы [ id: '.$current_workplace_id.' ] </strong></td>
						<td scope="col" class= "text-right"><strong>'.$array_workplace_totals[$i][2].'</strong></td>
						<td scope="col" class= "text-right"><strong>'.$array_workplace_totals[$i][3].'</strong></td>
						<td scope="col" class= "text-right"><strong>'.$array_workplace_totals[$i][4].'</strong></td>
						<td scope="col"></td>
					</tr>
					';
			$workplace_found = false;
		}
	}
	
	$msg.= '<tr>
                <td colspan="5" class="text-right"><strong>ВСЕГО:</strong></td>
                <td class="text-right"><strong>'.$grand_total_price.'</strong></td>
                <td class="text-right"><strong>'.$grand_total_cost.'</strong></td>
				<td class="text-right"><strong>'.$grand_total_discount.'</strong></td>
				<td scope="col"></td>
            </tr>
        </tbody>
    </table>
	';
}

echo $msg;
?>
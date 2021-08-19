<?php
function initialCashRemainderLab($link, $reportDate)
{
	$initialCashRemainder = NULL;
	$firstCashRemainderDate = firstCashRemainderDateLab($link);
    if($reportDate < $firstCashRemainderDate)
    {
        $initialCashRemainder = 0;
    }

    if(isSetInitialCashRemainderLab($link, $reportDate) AND $reportDate >= $firstCashRemainderDate)
    {
		$initialCashRemainder = getCashRemainderLab($link, $reportDate);
        if($initialCashRemainder == -1)
        {
			$previousDay = getPreviousCashDayLab($link, $reportDate);
			$previousInitialCashRemainder = getCashRemainderLab($link, $previousDay);
            if($previousInitialCashRemainder == -1)
            {
                $previousInitialCashRemainder = 0;
			}
			$previousCashPayments = sumPreviousCashPaymentsLab($link, $previousDay);
			$previousTerminalPayments = sumTerminalPaymentsLab($link, $previousDay);
			$previousTerminalRepaidDebts = sumTerminalRepaidDebtsLab($link, $previousDay);
			$previousTerminalPayments += $previousTerminalRepaidDebts;
			$previousSales = sumSalesLab($link, $previousDay);
			$previousInstruments = sumInstrumentsLab($link, $previousDay);
			$previousCashHandovers = sumCashHandoversLab($link, $previousDay);
			$previousRepaidDebts = sumRepaidDebtsLab($link, $previousDay);
			$previousRefunds = sumRefundsLab($link, $previousDay);
			
            $previousFinalCashRemainder = $previousInitialCashRemainder 
                                        + $previousCashPayments
                                        + $previousRepaidDebts
                                        - $previousTerminalPayments
                                        + $previousSales
                                        + $previousInstruments
                                        - $previousRefunds
										- $previousCashHandovers;
			
            $initialCashRemainder = $previousFinalCashRemainder;

			$sql = "INSERT INTO kassa (kassa_day,kassa_) VALUES('$reportDate','$initialCashRemainder')";
			$result = mysqli_query($link, $sql);
        }
    }
    else
    {
        $initialCashRemainder = 0;
	}
    return $initialCashRemainder;
}

function finalCashRemaniderLab($link, $reportDate)
{
    $initialCashRemainder = initialCashRemainderLab($link, $reportDate);
    $cashPayments = sumCashPaymentsLab($link, $reportDate);
    $repaidDebts = sumRepaidDebtsLab($link, $reportDate);
    $terminalPayments = sumTerminalPaymentsLab($link, $reportDate);
    $terminalRepaidDebts = sumTerminalRepaidDebtsLab($link, $reportDate);
    $terminalPayments += $terminalRepaidDebts;
    $sales = sumSalesLab($link, $reportDate);
    $instruments = sumInstrumentsLab($link, $reportDate);
    $refunds = sumRefundsLab($link, $reportDate);
    $cashHandovers = sumCashHandoversLab($link, $reportDate);

    $finalCashRemainder = $initialCashRemainder
                        + $cashPayments
                        + $repaidDebts
                        - $terminalPayments
                        + $sales
                        + $instruments
                        - $refunds
                        - $cashHandovers;
    return $finalCashRemainder;
}

function isSetInitialCashRemainderLab($link, $reportDate)
{
    $sql = "SELECT dn FROM dnevnoj WHERE id=1";

    $result = mysqli_query($link, $sql);
	if($result)
	{
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result); 
            $dn = $row["dn"];
        }
    }

    if($dn == 1) return true;
    else if($dn == 0) return false;
	else return $dn;
}

function firstCashRemainderDateLab($link)
{
    $sql = "SELECT 
                kassa_day 
            FROM kassa 
            ORDER BY id 
            LIMIT 0,1
            ";
    $result = mysqli_query($link, $sql);
    $kassa_day = NULL;
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result); 
            $kassa_day = $row["kassa_day"];
        }
    }
	return $kassa_day;
}

function getCashRemainderLab($link, $reportDate)
{
    $sql = "SELECT 
                kassa_ 
            FROM kassa 
            WHERE 
                kassa_day='$reportDate'  
            ORDER BY id 
            LIMIT 0,1
			";

    $result = mysqli_query($link, $sql);
    $kassa_v_nachale_dnja = -1;
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result); 
            $kassa_v_nachale_dnja = intval($row["kassa_"]);
        }
	}
	return $kassa_v_nachale_dnja;
}

function getPreviousCashDayLab($link, $reportDate)
{
    $sql = "SELECT 
                OrderDate 
            FROM orders 
            GROUP BY OrderDate 
            ORDER BY OrderDate
			";

    $result = mysqli_query($link, $sql);
    $den = NULL;
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            $ar_OrderDate = array();
            while($row = mysqli_fetch_array($result)) 
            {
                array_push($ar_OrderDate, $row["OrderDate"]);
            }

            if($ar_OrderDate[count($ar_OrderDate) - 1] == $reportDate)
            {
                $den = $ar_OrderDate[count($ar_OrderDate) - 2];
            }
            else
            {
                $den = $ar_OrderDate[count($ar_OrderDate) - 1];
            }
        }
	}

    return $den;
}

function sumAnalyzesLab($link, $reportDate)
{
	$cena11 = 0;
	$sql = "SELECT 
                SUM(cena_analizov) AS cena 
            FROM orders 
            WHERE OrderDate='$reportDate' and usr != 'Davinci' and usr != 'ARMMED' and usr != 'Tonoyan' 
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena11 = intval($row["cena"]);
	}

	$cena22 = 0;
	$sql = "SELECT 
                (SUM(cena_analizov)/2) AS cena 
            FROM orders 
            WHERE OrderDate='$reportDate' AND usr = 'Davinci' ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena22 = intval($row["cena"]);
	}

	$cena33 = 0;
	$sql = "SELECT 
                (SUM(cena_analizov) * 0.7) AS cena 
            FROM orders 
            WHERE OrderDate='$reportDate' AND usr = 'ARMMED' ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena33 = intval($row["cena"]);
	}    

	$cena44 = 0;
	$sql = "SELECT 
                (sum(cena_analizov) * 0.7) AS cena 
            FROM orders 
            WHERE OrderDate='$reportDate' AND usr = 'Tonoyan' ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena44 = intval($row["cena"]);
	} 
    
    $cena = $cena11 + $cena22 + $cena33 + $cena44;
    return $cena;
}

function sumRepaidDebtsLab($link, $reportDate)
{
	$sum_vernuli_dolg = 0;
	$sql = "SELECT 
				SUM(dolg) AS sum_vernuli_dolg 
			FROM vernuli_dolg 
			WHERE DATE(vernuli_date)='$reportDate'";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sum_vernuli_dolg = intval($row["sum_vernuli_dolg"]);
	}
	return $sum_vernuli_dolg;
}

/* function optionsHtmlRepaidDebtsLab($link, $reportDate)
{
	$sql = "SELECT 
				vernuli_dolg.orderid,
				vernuli_dolg.dolg,
				us22.id, 
				TIME(vernuli_dolg.vernuli_date) AS vernuli_date 
			FROM vernuli_dolg
	      	INNER JOIN us22 ON vernuli_dolg.uu=us22.id 
			WHERE 
				DATE(vernuli_dolg.vernuli_date)='$reportDate'";
	$result = mysqli_query($link,$sql);
	$html = 0;
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["dolg"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["vernuli_date"].'</option>';
			}
		}
	}
	return $html;
} */

function sumTerminalRepaidDebtsLab($link, $reportDate)
{
    $sum_vernuli_dolg_terminal = 0;
	$sql = "SELECT 
                SUM(dolg) AS sum_vernuli_dolg 
            FROM vernuli_dolg 
            WHERE 
                DATE(vernuli_date)='$reportDate' AND tip_oplati='terminal' 
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sum_vernuli_dolg_terminal = intval($row["sum_vernuli_dolg"]);
    }
	return $sum_vernuli_dolg_terminal;
}

function sumRefundsLab($link, $reportDate)
{
	$sum_vozvrat = 0;
	$sql = "SELECT 
				SUM(vozvrat_sum) AS sum_vozvrat 
			FROM vozvrat 
			WHERE 
				DATE(vozvrat_date)='$reportDate'
			";
	$result = mysqli_query($link, $sql);

	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sum_vozvrat = intval($row["sum_vozvrat"]);
	}
	return $sum_vozvrat;
}

/* function optionsHtmlRefundsLab($link, $reportDate)
{
	$sql = "SELECT 
				vozvrat.orderid,
				vozvrat.vozvrat_sum,
				us22.id, 
				TIME(vozvrat.vozvrat_date) AS vozvrat_date 
			FROM vozvrat
	INNER JOIN us22 ON vozvrat.uu=us22.id 
	WHERE 
		DATE(vozvrat.vozvrat_date)='$reportDate'";
	$result = mysqli_query($link,$sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["vozvrat_sum"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["vozvrat_date"].'</option>';
			}
		}
	}
	return $html;
} */

function sumPartnerDebtsLab($link, $partner, $reportDate)
{
	//var_dump($partner);
	$sumDebts = NULL;
	
	if( $partner == "Profimed" || $partner == "MIM" ||
			$partner == "Manasyan")
	{
		$sql_sumDebts = "SELECT 
								SUM(orders.dolg) AS sumDebts
						FROM orders 
						INNER JOIN us22 ON orders.usr=us22.log
						INNER JOIN partner_users ON us22.id=partner_users.user_id
						INNER JOIN partners ON partner_users.partner_id=partners.id
						WHERE 
							orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
						";

	}
	elseif($partner == "Davinci")
	{
		$sql_sumDebts = "SELECT 
								(SUM(orders.cost) / 2) AS sumDebts
						FROM orders 
						INNER JOIN us22 ON orders.usr=us22.log
						INNER JOIN partner_users ON us22.id=partner_users.user_id
						INNER JOIN partners ON partner_users.partner_id=partners.id
						WHERE 
							orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
						";

	}
	elseif($partner == "Ingo0")
	{
		$sql_sumDebts = "SELECT 
								(SUM(zapl)) AS sumDebts
						FROM zaplatili 
						WHERE 
							date(den)='".$reportDate."' AND uu='582'
						";

	}
	elseif($partner == "ARMMED" || $partner == "Tonoyan" )
	{
		$sql_sumDebts = "SELECT 
								(SUM(orders.cost) * 0.7) AS sumDebts
						FROM orders 
						INNER JOIN us22 ON orders.usr=us22.log
						INNER JOIN partner_users ON us22.id=partner_users.user_id
						INNER JOIN partners ON partner_users.partner_id=partners.id
						WHERE 
							orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
						";
	}
	elseif($partner == "Kapan" )
	{
		$sql_sumDebts = "SELECT 
								(SUM(orders.cost) * 10000/15000) AS sumDebts
						FROM orders 
						INNER JOIN us22 ON orders.usr=us22.log
						INNER JOIN partner_users ON us22.id=partner_users.user_id
						INNER JOIN partners ON partner_users.partner_id=partners.id
						WHERE 
							orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
						";
	}
	else
	{
		$sql_sumDebts = "SELECT 
								SUM(orders.cost) AS sumDebts
						FROM orders 
						INNER JOIN us22 ON orders.usr=us22.log
						INNER JOIN partner_users ON us22.id=partner_users.user_id
						INNER JOIN partners ON partner_users.partner_id=partners.id
						WHERE 
							orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
						";
		//var_dump($sql_sumDebts);
	}
	$result_sumDebts = mysqli_query($link, $sql_sumDebts);
	if($result_sumDebts)
	{
		$row_sumDebts = mysqli_fetch_array($result_sumDebts); 
		$sumDebts = intval($row_sumDebts["sumDebts"]);
	}
	return $sumDebts;
}

function optionsHtmlPartnerDebtsLab($link, $partner, $reportDate)
{
	$html = '';
	
	if($partner == "Davinci")
	{
		$sql = "SELECT 
					OrderId,
					(cena_analizov / 2) AS cen_an
				FROM orders 
				INNER JOIN us22 ON orders.usr=us22.log
				INNER JOIN partner_users ON us22.id=partner_users.user_id
				INNER JOIN partners ON partner_users.partner_id=partners.id
				WHERE 
					orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
				";
		$result = mysqli_query($link, $sql);
		if($result)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.intval($row["cen_an"]).'</option>';
			}
		}
	}
	elseif($partner == "Ingo0")
	{
		$sql = "SELECT 
				orderid, zapl
				FROM zaplatili 
				WHERE 
					date(den)='".$reportDate."' AND uu='582'
				";
		$result = mysqli_query($link, $sql);
		if($result)
		{
			$html = '<option></option>';
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.intval($row["zapl"]).'</option>';
			}
		}
	}
	elseif($partner == "ARMMED" || $partner == "Tonoyan")
	{
		$sql = "SELECT 
					OrderId,
					(cena_analizov * 0.7) AS cen_an
				FROM orders 
				INNER JOIN us22 ON orders.usr=us22.log
				INNER JOIN partner_users ON us22.id=partner_users.user_id
				INNER JOIN partners ON partner_users.partner_id=partners.id
				WHERE 
					orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
				";
		$result = mysqli_query($link, $sql);
		if($result)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.intval($row["cen_an"]).'</option>';
			}
		}                    
	}
	elseif($partner == "Kapan")
	{
		$sql = "SELECT 
					OrderId,
					(cena_analizov * 10000/15000) AS cen_an
				FROM orders 
				INNER JOIN us22 ON orders.usr=us22.log
				INNER JOIN partner_users ON us22.id=partner_users.user_id
				INNER JOIN partners ON partner_users.partner_id=partners.id
				WHERE 
					orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
				";
		$result = mysqli_query($link, $sql);
		if($result)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.intval($row["cen_an"]).'</option>';
			}
		}                    
	} 
	else
	{
		$sql = "SELECT 
					OrderId,
					cena_analizov
				FROM orders 
				INNER JOIN us22 ON orders.usr=us22.log
				INNER JOIN partner_users ON us22.id=partner_users.user_id
				INNER JOIN partners ON partner_users.partner_id=partners.id
				WHERE 
					orders.OrderDate='".$reportDate."' AND partners.partner='".$partner."'
				";
		$result = mysqli_query($link, $sql);
			if($result)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["cena_analizov"].'</option>';
			}
		}
	}
	return $html;
}

function sumDebtsLab($link, $reportDate)
{
	$sql_partner_users = "	SELECT 
								us22.log 
							FROM partner_users
							LEFT JOIN us22 ON partner_users.user_id=us22.id
							";
	$result_partner_users = mysqli_query($link, $sql_partner_users);
	$partner_users_array = array();
	if($result_partner_users)
	{
		if(mysqli_num_rows($result_partner_users) > 0)
		{
			while($row_partner_users = mysqli_fetch_array($result_partner_users))
			{
				array_push($partner_users_array,$row_partner_users["log"]);
			}
		}
	}
	$partner_users = implode("','",$partner_users_array);
	$partner_users = "'".$partner_users."'";

	$obshij_dolg = 0;
	$sql = "SELECT 
				SUM(dolg) AS obobshij_dolg 
			FROM orders 
			WHERE 
				OrderDate='$reportDate' AND dolg!=0 AND usr NOT IN ( $partner_users )";

	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$obshij_dolg = intval($row["obobshij_dolg"]);
	}

	return $obshij_dolg;
}

/* function optionsHtmlDebtsLab($link, $reportDate)
{
	$sql_partner_users = "	SELECT 
								us22.log 
							FROM partner_users
							LEFT JOIN us22 ON partner_users.user_id=us22.id
							";
	$result_partner_users = mysqli_query($link, $sql_partner_users);
	$partner_users_array = array();
	if($result_partner_users)
	{
		if(mysqli_num_rows($result_partner_users) > 0)
		{
			while($row_partner_users = mysqli_fetch_array($result_partner_users))
			{
				array_push($partner_users_array,$row_partner_users["log"]);
			}
		}
	}
	$partner_users = implode("','",$partner_users_array);
	$partner_users = "'".$partner_users."'";

	$sql = "SELECT 
				OrderId,
				cena_analizov,
				dolg 
			FROM orders 
			WHERE 
				dolg!=0 AND OrderDate='$reportDate' AND usr NOT IN ( $partner_users )
			";

	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["dolg"].'</option>';
			}
		}
	}

	return $html;
} */

function sumCashPaymentsLab($link, $reportDate)
{
    $cost_standart = 0;
	$sql = "SELECT 
                SUM(zapl) AS cost_standart_ 
            FROM zaplatili 
            WHERE 
                DATE(den)='$reportDate'
				and uu != 582
			";
	
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cost_standart = intval($row["cost_standart_"]);
	}
	return $cost_standart;
}

function sumTransferPaymentsLab($link, $reportDate)
{
    $cost_standart = 0;
	$sql = "SELECT 
                SUM(zapl) AS cost_standart_ 
            FROM transfer 
            WHERE 
                DATE(den)='$reportDate'
				and uu != 582
				AND transfer.checked=1
				AND transfer.is_last=1
			";
	
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cost_standart = intval($row["cost_standart_"]);
	}
	return $cost_standart;
}

/* function optionsHtmlCashPaymentsLab($link, $reportDate)
{
	$sql = "SELECT 
				zaplatili.orderid,
				zaplatili.zapl,
				us22.id, 
				TIME(zaplatili.den) AS den_zaplatili 
			FROM zaplatili 
			INNER JOIN us22 ON zaplatili.uu=us22.id
			WHERE 
				DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["den_zaplatili"].'</option>';
			}
		}
	}
	return $html;
} */


/* function optionsHtmlPaymentsLab($link, $reportDate)
{
	$sql = "SELECT 
				orders.lab AS lab0,
				zaplatili.orderid,
				zaplatili.zapl,
				us22.id, 
				TIME(zaplatili.den) AS den_zaplatili 
			FROM orders 
			INNER JOIN zaplatili ON orders.OrderId=zaplatili.orderid
			INNER JOIN us22 ON zaplatili.uu=us22.id
			WHERE 
				DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0
			";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["lab0"].' | '.$row["den_zaplatilil"].'</option>';
			}
		}
	}
	return $html;
} */

function sumPreviousCashPaymentsLab($link, $reportDate)
{
	$cost_standart_pred = 0;
	$sql = "SELECT 
                SUM(zapl) AS cost_standart_ 
            FROM zaplatili 
            WHERE 
                DATE(den)='$reportDate'
				and uu != 582
			";
	
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cost_standart_pred = intval($row["cost_standart_"]);
	}
	return $cost_standart_pred;
}

function sumTerminalPaymentsLab($link, $reportDate)
{
    $cost_terminal = 0;
	$sql = "SELECT 
                SUM(zapl) AS cost_terminal_ 
            FROM zaplatili 
            WHERE 
                DATE(den)='$reportDate' AND tip_oplati='terminal'";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cost_terminal = intval($row["cost_terminal_"]);
    }
	return $cost_terminal;
}

/* function optionsHtmlTerminalPaymentsLab($link, $reportDate)
{
	$sql = "SELECT 
				zaplatili.orderid,
				zaplatili.zapl,
				us22.id, 
				TIME(zaplatili.den) AS den_zaplatili 
			FROM zaplatili
			INNER JOIN us22 ON zaplatili.uu=us22.id
			WHERE 
				DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0 AND zaplatili.tip_oplati='terminal'
			";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["den_zaplatili"].'</option>';
			}
		}
	}

	$sql = "SELECT 
				vernuli_dolg.orderid,
				vernuli_dolg.dolg,
				us22.id, 
				TIME(vernuli_dolg.vernuli_date) AS vernuli_date 
			FROM vernuli_dolg
			INNER JOIN us22 ON vernuli_dolg.uu=us22.id
			WHERE 
				DATE(vernuli_dolg.vernuli_date)='$reportDate' AND vernuli_dolg.tip_oplati='terminal'";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["dolg"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["vernuli_date"].'</option>';
			}
		}
	}
	return $html;
} */

function sumSalesLab($link, $reportDate)
{//?
    $prodano_summa = 0;
	$sql = "SELECT 
                SUM(prodano_summa) AS sum_prodano_summa
		    FROM prochee_all 
            WHERE 
				strip_date='$reportDate'
			";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$prodano_summa = intval($row["sum_prodano_summa"]);
    }
	return $prodano_summa;
}

/* function optionsHtmlSalesLab($link, $reportDate)
{
	$sql = "SELECT 
				prochee_all.prodano_summa,
				us22.id, 
				prochee_all.strip_time, 
				labs.lab 
			FROM prochee_all 
			INNER JOIN us22 ON prochee_all.uu=us22.id
			INNER JOIN labs ON prochee_all.lab_id = labs.id
			WHERE 
				prochee_all.strip_date='$reportDate'
			";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				if($row['prodano_summa']!=0)
				{
					$html.= '<option>'.$row["prodano_summa"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["strip_time"].' | '.$row["lab"].'</option>';
				}
			}
		}
	}
	return $html;
} */

function sumInstrumentsLab($link, $reportDate)
{//?
    $instrumenti = 0;
	$sql = "SELECT 
                SUM(instrumenti) AS sum_instrumenti
		    FROM prochee_all 
            WHERE 
                strip_date='$reportDate'
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$instrumenti = intval($row["sum_instrumenti"]);
    }
	return $instrumenti;
}

/* function optionsHtmlInstrumentsLab($link, $reportDate)
{
	$sql = "SELECT 
				prochee_all.instrumenti,
				us22.id, 
				prochee_all.strip_time, 
				labs.lab 
			FROM prochee_all 
			INNER JOIN us22 ON prochee_all.uu = us22.id
			INNER JOIN labs ON prochee_all.lab_id = labs.id
			WHERE 
				prochee_all.strip_date='$reportDate'
			";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result)) 
			{
				if($row['instrumenti'] != 0)
				{
					$html.= '<option>'.$row["instrumenti"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["strip_time"].' | '.$row["lab"].'</option>';
				}
			}
		}
	}
	return $html;
} */

function sumHomeVisitsLab($link, $reportDate)
{
    $count_vizov_nadom = 0;
	$sql_count = "	SELECT 
						COUNT(orderresult.ReagentId) AS count_vizov_nadom 
					FROM orders 
					INNER JOIN orderresult ON orderresult.OrderId=orders.OrderId 
					WHERE 
						orders.OrderDate='$reportDate' AND orderresult.ReagentId=516
					";
	
	$result_count = mysqli_query($link, $sql_count);
	if($result_count)
	{
		if(mysqli_num_rows($result_count) > 0)
		{
			$row_count = mysqli_fetch_array($result_count); 
			$count_vizov_nadom = $row_count["count_vizov_nadom"];
		}
	}
	
	$price_vizov_nadom = 0;
	$sql_price = "	SELECT 
						AnalysisPrice 
					FROM reagent 
					WHERE ReagentId=516
					";
	$result_price = mysqli_query($link, $sql_price);
	if($result_price)
	{
		if(mysqli_num_rows($result_price) > 0)
		{
			$row_price = mysqli_fetch_array($result_price);
			$price_vizov_nadom = $row_price["AnalysisPrice"];
		}
	}

    $vizov_nadom = $count_vizov_nadom * $price_vizov_nadom;
	return $vizov_nadom;
}

/* function optionsHtmlHomeVisitsLab($link, $reportDate)
{
	$sql = "SELECT 
				orders.OrderId,
				orders.cena_analizov 
			FROM orders 
			INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
			WHERE orderresult.ReagentId=516 AND orders.OrderDate='$reportDate'
			";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["cena_analizov"].'</option>';
			}
		}
	}
	return $html;
} */

function sumUrgentCallsLab($link, $reportDate)
{
    $count_sr_vizov = 0;
	$sql_count = "SELECT 
                COUNT(orderresult.ReagentId) AS count_sr_vizov 
            FROM orders 
            INNER JOIN orderresult ON orderresult.OrderId=orders.OrderId 
            WHERE 
				orders.OrderDate='$reportDate' AND orderresult.ReagentId=1014
			";
	$result_count = mysqli_query($link, $sql_count);
	if($result_count)
	{
		if(mysqli_num_rows($result_count) > 0)
		{
			$row_count = mysqli_fetch_array($result_count); 
			$count_sr_vizov = $row_count["count_sr_vizov"];
		}
    }
    
    $sr_vizov_price = 0;
	$sql_price = "SELECT 
                AnalysisPrice 
            FROM reagent 
            where ReagentId='1014'";
	$result_price = mysqli_query($link, $sql_price);
	if($result_price)
	{
		if(mysqli_num_rows($result_price) > 0)
		{
			$row_price = mysqli_fetch_array($result_price); 
			$sr_vizov_price = $row_price["AnalysisPrice"];
		}
    }
    
    $sr_vizov = $count_sr_vizov * $sr_vizov_price;
	return $sr_vizov;
}

/* function optionsHtmlUrgentCallsLab($link, $reportDate)
{
	$sql = "SELECT 
				orders.OrderId,
				orders.cena_analizov 
			FROM orders 
			INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
	 		WHERE 
				 orderresult.ReagentId=1014 AND orders.OrderDate='$reportDate'
			";
   $result = mysqli_query($link, $sql);
   $html = '';
   if($result)
   {
	   if(mysqli_num_rows($result) > 0)
	   {
			while ($row = mysqli_fetch_array($result)) 
			{
				$html.= '<option value="'.$row["OrderId"].'">'.$row["OrderId"].' | '.$row["cena_analizov"].'</option>';
			}
	   }
   }
   return $html;
} */

function sumCashHandoversLab($link, $reportDate)
{//?
    $sdano = 0;
	$sql = "SELECT 
                SUM(sdano) AS sum_sdano
		    FROM prochee_all 
			WHERE strip_date='$reportDate'
			";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sdano = intval($row["sum_sdano"]);
    }
	return $sdano;
}

/* function optionsHtmlCashHandoversLab($link, $reportDate)
{
	$sql = "SELECT 
				prochee_all.sdano,
				us22.id, 
				prochee_all.strip_time, 
				labs.lab 
			FROM prochee_all 
			INNER JOIN us22 ON prochee_all.uu=us22.id
			INNER JOIN labs ON prochee_all.lab_id=labs.id
			WHERE 
				prochee_all.strip_date='$reportDate'";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while ($row = mysqli_fetch_array($result)) 
			{
				if($row['sdano']!=0)
				{
					$html.= '<option>'.$row["sdano"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["strip_time"].' | '.$row["lab"].'</option>';
				}
			}
		}
	}
	return $html;
} */

function sumChecksLab($link, $reportDate)
{
    $summa_checkov = 0;
	$sql = "SELECT 
                SUM(check_vozvrat.summa) AS sm 
            FROM check_vozvrat 
            WHERE 
                DATE(check_vozvrat.check_date)='$reportDate'
            ";
	$result = mysqli_query($link, $sql);
    if($result)
	{
		$row = mysqli_fetch_array($result); 
		$summa_checkov = intval($row["sm"]);	
    }
	return $summa_checkov;
}

/* function optionsHtmlChecksLab($link, $reportDate)
{
	$sql = "SELECT 
				check_vozvrat.orderid, 
				check_vozvrat.summa, 
				check_vozvrat.lab, 
				TIME(check_vozvrat.check_date) AS check_date1, 
				us22.id 
			FROM check_vozvrat 
	        INNER JOIN us22 ON check_vozvrat.usrid=us22.id
        	WHERE 
				DATE(check_vozvrat.check_date)='$reportDate' AND  
			(check_vozvrat.usrid='2' OR check_vozvrat.usrid='137' OR check_vozvrat.usrid='68' OR 
			check_vozvrat.usrid='143' OR check_vozvrat.usrid='202' OR check_vozvrat.usrid='256'	OR 
			check_vozvrat.usrid='10' OR check_vozvrat.usrid='66' OR check_vozvrat.usrid='258' OR 
			check_vozvrat.usrid='198' OR check_vozvrat.usrid='200' OR check_vozvrat.usrid='392' OR 
			check_vozvrat.usrid='394' OR check_vozvrat.usrid='396' OR check_vozvrat.usrid='398'	OR 
			check_vozvrat.usrid='564' OR check_vozvrat.usrid='566' OR check_vozvrat.usrid='568')
			";
	$result = mysqli_query($link, $sql);
	$html = '';
    if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' '.$row["summa"].' '.usr_to_name($link, $row["id"], $reportDate).' '.$row["lab"].' '.$row["check_date1"].'</option>';
			}
		}
	}
	return $html;
} */

function sumCheckRefundsLab($link, $reportDate)
{
    $vozvrat_checkov = 0;
	$sql = "SELECT 
                SUM(check_vozvrat.summa) AS sm 
            FROM check_vozvrat 
            WHERE 
                DATE(check_vozvrat.check_date)='$reportDate' AND check_vozvrat.checked=0";
	$result = mysqli_query($link, $sql);
    if($result)
	{
		$row = mysqli_fetch_array($result); 
		$vozvrat_checkov = intval($row["sm"]);	
    }
	return $vozvrat_checkov;
}

/* function optionsCheckRefundsLab($link, $reportDate)
{
	$sql = "SELECT 
				check_vozvrat.orderid, 
				check_vozvrat.summa, 
				check_vozvrat.lab, 
				TIME(check_vozvrat.check_date) AS check_date1, 
				us22.id 
			FROM check_vozvrat 
			INNER JOIN us22 ON check_vozvrat.usrid=us22.id
			WHERE DATE(check_vozvrat.check_date)='$reportDate' AND check_vozvrat.checked=0 AND 
			(check_vozvrat.usrid='2' OR check_vozvrat.usrid='137' OR check_vozvrat.usrid='68' OR 
			check_vozvrat.usrid='143' OR check_vozvrat.usrid='202' OR check_vozvrat.usrid='256'	OR 
			check_vozvrat.usrid='10' OR check_vozvrat.usrid='66' OR check_vozvrat.usrid='258' OR 
			check_vozvrat.usrid='198' OR check_vozvrat.usrid='200' OR check_vozvrat.usrid='392' OR 
			check_vozvrat.usrid='394' OR check_vozvrat.usrid='396' OR check_vozvrat.usrid='398'	OR 
			check_vozvrat.usrid='564' OR check_vozvrat.usrid='566' OR check_vozvrat.usrid='568')
			";
	$result = mysqli_query($link, $sql);
	$html = '';
	if($result)
	{
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' '.(-$row["summa"]).' '.usr_to_name($link, $row["id"], $reportDate).' '.$row["lab"].' '.$row["check_date1"].'</option>';
			}
		}
	}
	return $html;
} */
?>
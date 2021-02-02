<?php
function initialCashRemainder($link, $lab, $lab_id, $reportDate)
{
    $initialCashRemainder = NULL;
    $firstCashRemainderDate = firstCashRemainderDate($link, $lab_id);
    if($reportDate < $firstCashRemainderDate)
    {
        $initialCashRemainder = 0;
    }

    if(isSetInitialCashRemainder($link, $lab_id) && $reportDate >= $firstCashRemainderDate)
    {
        $initialCashRemainder = getCashRemainder($link, $lab_id, $reportDate);
        if($initialCashRemainder == -1)
        {
            $previousDay = getPreviousCashDay($link, $reportDate);
            $previousInitialCashRemainder = getCashRemainder($link, $lab_id, $previousDay);
            if($previousInitialCashRemainder == -1)
            {
                $previousInitialCashRemainder = 0;
            }
            $previousCashPayments = sumCashPayments($link, $lab, $previousDay);
            $previousTerminalPayments = sumTerminalPayments($link, $lab, $previousDay);
            $previousTerminalRepaidDebts = sumTerminalRepaidDebts($link, $lab, $previousDay);
            $previousTerminalPayments += $previousTerminalRepaidDebts;
            $previousSales = sumSales($link, $lab_id, $previousDay);
            $previousInstruments = sumInstruments($link, $lab_id, $previousDay);
            $previousCashHandovers = sumCashHandovers($link, $lab_id, $previousDay);
            $previousRepaidDebts = sumRepaidDebts($link, $lab, $previousDay);
            $previousRefunds = sumRefunds($link, $lab, $previousDay);
            
            $previousFinalCashRemainder = $previousInitialCashRemainder 
                                        + $previousCashPayments
                                        + $previousRepaidDebts
                                        - $previousTerminalPayments
                                        + $previousSales
                                        + $previousInstruments
                                        - $previousRefunds
                                        - $previousCashHandovers;

            $initialCashRemainder = $previousFinalCashRemainder;

            $sql = "INSERT INTO kassa_all (kassa_day,kassa_,lab_id) VALUES('$reportDate','$initialCashRemainder','$lab_id')";
			$result = mysqli_query($link, $sql);
        }
    }
    else
    {
        $initialCashRemainder = 0;
    }
    return $initialCashRemainder;
}

function finalCashRemanider($link, $lab, $lab_id, $reportDate)
{
    $initialCashRemainder = initialCashRemainder($link, $lab, $lab_id, $reportDate);
    $cashPayments = sumCashPayments($link, $lab, $reportDate);
    $repaidDebts = sumRepaidDebts($link, $lab, $reportDate);
    $terminalPayments = sumTerminalPayments($link, $lab, $reportDate);
    $terminalRepaidDebts = sumTerminalRepaidDebts($link, $lab, $reportDate);
    $terminalPayments += $terminalRepaidDebts;
    $sales = sumSales($link, $lab_id, $reportDate);
    $instruments = sumInstruments($link, $lab_id, $reportDate);
    $refunds = sumRefunds($link, $lab, $reportDate);
    $cashHandovers = sumCashHandovers($link, $lab_id, $reportDate);

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

function isSetInitialCashRemainder($link, $lab_id)
{
    $sql = "SELECT dn FROM dnevnoj_all WHERE lab_id='$lab_id'";

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

function firstCashRemainderDate($link, $lab_id)
{
    $sql = "SELECT 
                kassa_day 
            FROM kassa_all 
            WHERE lab_id='$lab_id' 
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

function getCashRemainder($link, $lab_id, $reportDate)
{
    $sql = "SELECT 
                kassa_ 
            FROM kassa_all 
            WHERE 
                kassa_day='$reportDate' AND lab_id='$lab_id' 
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

function getPreviousCashDay($link, $reportDate)
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

function sumAnalyzes($link, $lab, $reportDate)
{
    $cena = 0;
    $sql = "SELECT SUM(cena_analizov) AS cena FROM orders WHERE OrderDate='$reportDate' AND lab='$lab'";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $row = mysqli_fetch_array($result); 
        $cena = intval($row["cena"]);
    }
    return $cena;
}

function sumRepaidDebts($link, $lab, $reportDate)
{
    $sum_vernuli_dolg = 0;
    $sql = "SELECT SUM(dolg) AS sum_vernuli_dolg FROM vernuli_dolg WHERE DATE(vernuli_date)='$reportDate' AND lab='$lab'";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $row = mysqli_fetch_array($result); 
        $sum_vernuli_dolg = intval($row["sum_vernuli_dolg"]);
    }
    return $sum_vernuli_dolg;
}

function sumTerminalRepaidDebts($link, $lab, $reportDate)
{
    $sum_vernuli_dolg_terminal = 0;
	$sql = "SELECT 
                SUM(dolg) AS sum_vernuli_dolg 
            FROM vernuli_dolg 
            WHERE 
                DATE(vernuli_date)='$reportDate' AND tip_oplati='terminal' AND lab='$lab'
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sum_vernuli_dolg_terminal = intval($row["sum_vernuli_dolg"]);
    }
    return $sum_vernuli_dolg_terminal;
}

function optionsHtmlRepaidDebts($link, $lab, $reportDate)
{
    $sql = "SELECT 
            vernuli_dolg.orderid,
            vernuli_dolg.dolg,
            us22.id,
            TIME(vernuli_dolg.vernuli_date) AS vernuli_date 
        FROM vernuli_dolg
        INNER JOIN us22 ON vernuli_dolg.uu=us22.id 
        WHERE 
            DATE(vernuli_dolg.vernuli_date)='$reportDate' AND vernuli_dolg.lab='$lab'
		ORDER BY vernuli_dolg.vernuli_date";

    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["dolg"].' | '.usr_to_name($link, $row["id"], $reportDate) . ' | ' . $row["vernuli_date"] . '</option>';
            }
        }
    }
    return $html;
}

function sumRefunds($link, $lab, $reportDate)
{
    $sum_vozvrat = 0;
	$sql = "SELECT 
                SUM(vozvrat_sum) AS sum_vozvrat 
            FROM vozvrat 
            WHERE 
                DATE(vozvrat_date)='$reportDate' and lab='$lab'
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sum_vozvrat = intval($row["sum_vozvrat"]);
    }
    return $sum_vozvrat;
}

function optionsHtmlRefunds($link, $lab, $reportDate)
{
    $sql = "SELECT 
                vozvrat.orderid,
                vozvrat.vozvrat_sum,
                us22.id, 
                TIME(vozvrat.vozvrat_date) AS vozvrat_date 
            FROM vozvrat
            INNER JOIN us22 ON vozvrat.uu=us22.id 
            WHERE 
                DATE(vozvrat.vozvrat_date)='$reportDate' AND vozvrat.lab='$lab'
            ORDER BY vozvrat.vozvrat_date";
    $result = mysqli_query($link, $sql);
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
}

function sumDebts($link, $lab, $reportDate)
{
    $obshij_dolg = 0;
	$sql = "SELECT 
                SUM(dolg) AS obobshij_dolg 
            FROM orders 
            WHERE 
                OrderDate='$reportDate' AND dolg!=0 AND lab='$lab'
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$obshij_dolg = intval($row["obobshij_dolg"]);
    }
    return $obshij_dolg;
}

function optionsHtmlDebts($link, $lab, $reportDate)
{
    $sql = "SELECT 
                OrderId,
                cena_analizov,
                dolg 
            FROM orders 
            WHERE dolg!=0 AND OrderDate='$reportDate' AND lab='$lab'
            ORDER BY OrderTime";
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
}

function sumCashPayments($link, $lab, $reportDate)
{
    $cost_standart = 0;
	$sql = "SELECT 
                SUM(zapl) AS cost_standart_ 
            FROM zaplatili 
            WHERE 
                DATE(den)='$reportDate' AND lab='$lab'
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cost_standart = intval($row["cost_standart_"]);
    }
    return $cost_standart;
}

function optionsHtmlCashPayments($link, $lab, $reportDate)
{
    $sql = "SELECT 
                zaplatili.orderid,
                zaplatili.zapl,
                us22.id, 
                TIME(zaplatili.den) AS den_zaplatili 
            FROM zaplatili 
            INNER JOIN us22 ON zaplatili.uu=us22.id
            WHERE 
                DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0 AND zaplatili.lab='$lab'
            ORDER BY zaplatili.den";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link,$row["id"], $reportDate).' | '.$row["den_zaplatili"].'</option>';
            }
        }
    }
    return $html;
}

function optionsHtmlPayments($link, $lab, $reportDate)
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
                DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0 AND zaplatili.lab='$lab' AND orders.lab!='$lab'
            ORDER BY zaplatili.den";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["lab0"].' | '.$row["den_zaplatili"].'</option>';
            }
        }
    }
    return $html;
}

function sumTerminalPayments($link, $lab, $reportDate)
{
    $cost_terminal = 0;
	$sql = "SELECT 
                SUM(zapl) AS cost_terminal_ 
            FROM zaplatili 
            WHERE 
                DATE(den)='$reportDate' AND lab='$lab' AND tip_oplati='terminal'";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cost_terminal = intval($row["cost_terminal_"]);
    }
    return $cost_terminal;
}

function optionsHtmlTerminalPayments($link, $lab, $reportDate)
{
    $sql = "SELECT 
                zaplatili.orderid,
                zaplatili.zapl,
                us22.id, 
                TIME(zaplatili.den) AS den_zaplatili 
            FROM zaplatili
            INNER JOIN us22 ON zaplatili.uu=us22.id
            WHERE 
                DATE(zaplatili.den)='$reportDate' AND zaplatili.zapl!=0 AND zaplatili.lab='$lab' AND zaplatili.tip_oplati='terminal'
            ORDER BY zaplatili.den";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_array($result)) 
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["zapl"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["den_zaplatili"].'</option>';
            }
        }
    }

    $sql = "SELECT 
                vernuli_dolg.orderid,
                vernuli_dolg.dolg,
                us22.id, 
                TIME(vernuli_dolg.vernuli_date) AS date_vernuli_dolg 
            FROM vernuli_dolg
            INNER JOIN us22 ON vernuli_dolg.uu=us22.id
            WHERE 
                DATE(vernuli_dolg.vernuli_date)='$reportDate' AND vernuli_dolg.tip_oplati='terminal' AND vernuli_dolg.lab='$lab'
            ";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' | '.$row["dolg"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["date_vernuli_dolg"].'</option>';
            }
        }
    }
    return $html;
}

function sumSales($link, $lab_id, $reportDate)
{
    $prodano_summa = 0;
	$sql = "SELECT 
                SUM(prodano_summa) AS sum_prodano_summa
		    FROM prochee_all 
            WHERE 
                strip_date='$reportDate' AND lab_id='$lab_id'";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$prodano_summa = intval($row["sum_prodano_summa"]);
    }
    return $prodano_summa;
}

function optionsHtmlSales($link, $lab_id, $reportDate)
{
    $sql = "SELECT 
                prochee_all.prodano_summa,
                us22.id, 
                prochee_all.strip_time 
            FROM prochee_all 
            INNER JOIN us22 ON prochee_all.uu=us22.id
            WHERE 
                prochee_all.strip_date='$reportDate' AND prochee_all.lab_id='$lab_id'
			ORDER BY prochee_all.strip_time";
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
                    $html.= '<option>'.$row["prodano_summa"].' | '.usr_to_name($link, $row["id"], $reportDate)." | ".$row["strip_time"].'</option>';
                }
            }
        }
    }
    return $html;
}

function sumInstruments($link, $lab_id, $reportDate)
{
    $instrumenti = 0;
	$sql = "SELECT 
                SUM(instrumenti) AS sum_instrumenti
		    FROM prochee_all 
            WHERE 
                strip_date='$reportDate' and lab_id='$lab_id'
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$instrumenti = intval($row["sum_instrumenti"]);
    }
    return $instrumenti;
}

function optionsHtmlInstruments($link, $lab_id, $reportDate)
{
    $sql = "SELECT 
                prochee_all.instrumenti,
                us22.log, 
                prochee_all.strip_time 
            FROM prochee_all 
            INNER JOIN us22 ON prochee_all.uu=us22.id
            WHERE 
                prochee_all.strip_date='$reportDate' AND prochee_all.lab_id='$lab_id'
			ORDER BY prochee_all.strip_time";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_array($result)) 
            {
                if($row['instrumenti']!=0)
                {
                    $html.= '<option>'.$row["instrumenti"].' | '.usr_to_name($link, $row["id"], $reportDate).' | '.$row["strip_time"].'</option>';
                }
            }
        }
    }
    return $html;
}

function sumHomeVisits($link, $lab, $reportDate)
{
    $count_vizov_nadom = 0;
	$sql_count = "SELECT 
                COUNT(orderresult.ReagentId) AS count_vizov_nadom 
            FROM orders 
            INNER JOIN orderresult ON orderresult.OrderId=orders.OrderId 
            WHERE 
                orders.OrderDate='$reportDate' AND orderresult.ReagentId=516 AND orders.lab='$lab'
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

function optionsHtmlHomeVisits($link, $lab, $reportDate)
{
    $sql = "SELECT 
                orders.OrderId,
                orders.cena_analizov 
            FROM orders 
            INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
            WHERE 
                orderresult.ReagentId=516 AND orders.OrderDate='$reportDate' AND orders.lab='$lab'
            ORDER BY orders.OrderTime";
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
}

function sumUrgentCalls($link, $lab, $reportDate)
{
    $count_sr_vizov = 0;
	$sql_count = "SELECT 
                COUNT(orderresult.ReagentId) AS count_sr_vizov 
            FROM orders 
            INNER JOIN orderresult ON orderresult.OrderId=orders.OrderId 
            WHERE 
                orders.OrderDate='$reportDate' AND orderresult.ReagentId=1014 AND orders.lab='$lab'";
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

function optionsHtmlUrgentCalls($link, $lab, $reportDate)
{
    $sql = "SELECT 
                orders.OrderId,
                orders.cena_analizov 
            FROM orders 
            INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
            WHERE 
                orderresult.ReagentId=1014 AND orders.OrderDate='$reportDate' and orders.lab='$lab'
			ORDER BY orders.OrderTime";
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
}

function sumCashHandovers($link, $lab_id, $reportDate)
{
    $sdano = 0;
	$sql = "SELECT 
                SUM(sdano) AS sum_sdano
		    FROM prochee_all 
            WHERE strip_date='$reportDate' AND lab_id='$lab_id'";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$sdano = intval($row["sum_sdano"]);
    }
    return $sdano;
}

function optionsHtmlCashHandovers($link, $lab_id, $reportDate)
{
    $sql = "SELECT 
                prochee_all.sdano,
                us22.id, 
                prochee_all.strip_time 
            FROM prochee_all 
            INNER JOIN us22 ON prochee_all.uu=us22.id
            WHERE prochee_all.strip_date='$reportDate' AND prochee_all.lab_id='$lab_id'
			ORDER BY prochee_all.strip_time";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result)) 
            {
                if($row['sdano']!=0)
                {
                    $html.= '<option>'.$row["sdano"].' | '.usr_to_name($link, $row['id'], $reportDate).' | '.$row["strip_time"].'</option>';
                }
            }
        }
    }
    return $html;
}

function sumChecks($link, $lab, $reportDate)
{
    $summa_checkov = 0;
	$sql = "SELECT 
                SUM(check_vozvrat.summa) AS sm 
            FROM check_vozvrat 
            WHERE 
                check_vozvrat.lab='$lab' AND DATE(check_vozvrat.check_date)='$reportDate'
            ";
	$result = mysqli_query($link, $sql);
    if($result)
	{
		$row = mysqli_fetch_array($result); 
		$summa_checkov = intval($row["sm"]);	
    }
    return $summa_checkov;
}

function optionsHtmlChecks($link, $lab, $reportDate)
{
    $sql = "SELECT 
                check_vozvrat.orderid, 
                check_vozvrat.summa, 
                TIME(check_vozvrat.check_date) AS check_date1, 
                us22.id  
            FROM check_vozvrat 
	    	INNER JOIN us22 ON check_vozvrat.usrid=us22.id
        	WHERE 
                check_vozvrat.lab='$lab' AND 
                date(check_vozvrat.check_date)='$reportDate' AND 
			    (check_vozvrat.usrid='2' OR check_vozvrat.usrid='137' OR check_vozvrat.usrid='68' OR 
                check_vozvrat.usrid='143' OR check_vozvrat.usrid='202' OR check_vozvrat.usrid='256'	OR 
                check_vozvrat.usrid='10' OR check_vozvrat.usrid='66' OR check_vozvrat.usrid='258' OR 
                check_vozvrat.usrid='198' OR check_vozvrat.usrid='200' OR check_vozvrat.usrid='392' OR 
                check_vozvrat.usrid='394' OR check_vozvrat.usrid='396' OR check_vozvrat.usrid='398'	OR 
                check_vozvrat.usrid='564' OR check_vozvrat.usrid='566' OR check_vozvrat.usrid='568')
            ORDER BY check_vozvrat.check_date";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
	{
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' '.$row["summa"].' '.usr_to_name($link, $row["id"], $reportDate).' '.$row["check_date1"].'</option>';
            }
        }
    }
    return $html;
}

function sumCheckRefunds($link, $lab, $reportDate)
{
    $vozvrat_checkov = 0;
	$sql = "SELECT 
                SUM(check_vozvrat.summa) AS sm 
            FROM check_vozvrat 
            WHERE 
                check_vozvrat.lab='$lab' AND DATE(check_vozvrat.check_date)='$reportDate' AND check_vozvrat.checked=0";
	$result = mysqli_query($link, $sql);
    if($result)
	{
		$row = mysqli_fetch_array($result); 
		$vozvrat_checkov = intval($row["sm"]);	
    }
    return $vozvrat_checkov;
}

function optionsCheckRefunds($link, $lab, $reportDate)
{
    $sql = "SELECT 
                check_vozvrat.orderid, 
                check_vozvrat.summa, 
                TIME(check_vozvrat.check_date) AS check_date1, 
                us22.id 
            FROM check_vozvrat 
            INNER JOIN us22 ON check_vozvrat.usrid=us22.id
            WHERE 
                check_vozvrat.lab='$lab' AND DATE(check_vozvrat.check_date)='$reportDate' AND check_vozvrat.checked=0 AND 
                (check_vozvrat.usrid='2' OR check_vozvrat.usrid='137' OR check_vozvrat.usrid='68' or 
                check_vozvrat.usrid='143' OR check_vozvrat.usrid='202' OR check_vozvrat.usrid='256' OR 
                check_vozvrat.usrid='10' OR check_vozvrat.usrid='66' OR check_vozvrat.usrid='258' OR 
                check_vozvrat.usrid='198' OR check_vozvrat.usrid='200' OR check_vozvrat.usrid='392' OR 
                check_vozvrat.usrid='394' OR check_vozvrat.usrid='396' OR check_vozvrat.usrid='398' OR 
                check_vozvrat.usrid='564' OR check_vozvrat.usrid='566' OR check_vozvrat.usrid='568')
			ORDER BY check_vozvrat.check_date";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $html = '';
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $html.= '<option value="'.$row["orderid"].'">'.$row["orderid"].' '.(-$row["summa"]).' '.usr_to_name($link, $row["id"], $reportDate).' '.$row["check_date1"].'</option>';
            }
        }
    }
    return $html;
}

function optionsProvekaKassi($link, $lab_id, $reportDate)
{
    $sql = "SELECT 
                usr_id,
                vvod_kassi, 
                real_kassa,
				dtime,
				lab_id
            FROM proverka_kassi 
            WHERE date(dtime)='$reportDate' AND lab_id='$lab_id'
			ORDER BY dtime";
    $result = mysqli_query($link, $sql);
    $html = '';
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result)) 
            {               
				$html.= '<option>'.$row["vvod_kassi"].' | '.$row["real_kassa"].' | '.usr_to_name($link, $row['usr_id'], $reportDate).' | '.$row["dtime"].'</option>';               
            }
        }
    }
    return $html;
}
?>
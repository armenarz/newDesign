<?php
require_once "labs_html_functions.php";

function createLabsHTML($link, $lab, $lab_id, $reportDate)
{
	//$start = microtime(true);
	
    $kassa_v_nachale_dnja = initialCashRemainder($link, $lab, $lab_id, $reportDate);

    $cena = sumAnalyzes($link, $lab, $reportDate);

    $sum_vernuli_dolg = sumRepaidDebts($link, $lab, $reportDate);
    $optionsHtmlRepaidDebts = optionsHtmlRepaidDebts($link, $lab, $reportDate);
	
	$terminalRepaidDebts = sumTerminalRepaidDebts($link, $lab, $reportDate);

    $sum_vozvrat = sumRefunds($link, $lab, $reportDate);
    $optionsHtmlRefunds = optionsHtmlRefunds($link, $lab, $reportDate);

    $obshij_dolg = sumDebts($link, $lab, $reportDate);
    $optionsHtmlDebts = optionsHtmlDebts($link, $lab, $reportDate);

    $cost_standart = sumCashPayments($link, $lab, $reportDate);
	
	$cost_transfer = sumTtansferPayments($link, $lab, $reportDate);
	
	$optionsHtmlTransferPayments = optionsHtmlTransferPayments($link, $lab, $reportDate);
	
    $optionsHtmlCashPayments = optionsHtmlCashPayments($link, $lab, $reportDate);
    $optionsHtmlPayments = optionsHtmlPayments($link, $lab, $reportDate);

    $cost_terminal = sumTerminalPayments($link, $lab, $reportDate);
    $optionsHtmlTerminalPayments = optionsHtmlTerminalPayments($link, $lab, $reportDate);

    $prodano_summa = sumSales($link, $lab_id, $reportDate);
    $optionsHtmlSales = optionsHtmlSales($link, $lab_id, $reportDate);

    $instrumenti = sumInstruments($link, $lab_id, $reportDate);
    $optionsHtmlInstruments = optionsHtmlInstruments($link, $lab_id, $reportDate);

    $vizov_nadom = sumHomeVisits($link, $lab, $reportDate);
    $optionsHtmlHomeVisits = optionsHtmlHomeVisits($link, $lab, $reportDate);

    $sr_vizov = sumUrgentCalls($link, $lab, $reportDate);
    $optionsUrgentCalls = optionsHtmlUrgentCalls($link, $lab, $reportDate);

    $sdano = sumCashHandovers($link, $lab_id, $reportDate);
    $optionsCashHandovers = optionsHtmlCashHandovers($link, $lab_id, $reportDate);

    $kassa_tekushego_dnja = finalCashRemanider($link, $lab, $lab_id, $reportDate);

    $summa_checkov = sumChecks($link, $lab, $reportDate);
    $optionsHtmlChecks = optionsHtmlChecks($link, $lab, $reportDate);

    $vozvrat_checkov = sumCheckRefunds($link, $lab, $reportDate);
    $optionsCheckRefunds = optionsCheckRefunds($link, $lab, $reportDate);
	
	$optionsProvekaKassi = optionsProvekaKassi($link, $lab_id, $reportDate);

    $html = '
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">В&nbsp;начале&nbsp;дня</label></div>        
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$kassa_v_nachale_dnja.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сумма&nbsp;анализов</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cena.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Вернули&nbsp;долг</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sum_vernuli_dolg.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderRepaidDebts" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlRepaidDebts.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Возврат</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sum_vozvrat.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderRefunds" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlRefunds.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Остались&nbsp;в&nbsp;долгу</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$obshij_dolg.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderDebts" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlDebts.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Заплатили</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cost_standart.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderCashPayments" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlCashPayments.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-10 pl-2 pr-0"><label class="form-control form-control-sm mb-1 text-body"></label></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderPayments" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlPayments.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Терминал</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.( $cost_terminal + $terminalRepaidDebts ).'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderTerminal" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlTerminalPayments.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Стрип</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$prodano_summa.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderSales" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlSales.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Прочее</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$instrumenti.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderInstruments" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlInstruments.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Вызов&nbsp;на&nbsp;дому</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$vizov_nadom.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderHomeVisits" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlHomeVisits.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Срочный&nbsp;вызов</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sr_vizov.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderUrgentCalls" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsUrgentCalls.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сдано</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sdano.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderCashHandovers" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsCashHandovers.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Остаток&nbsp;кассы</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$kassa_tekushego_dnja.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сумма&nbsp;чеков</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$summa_checkov.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderChecks" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlChecks.'
            </select>
        </div>
    </div>
	<div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Перечисление</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cost_transfer.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderTransferPayments" class="form-control form-control-sm text-body">
                <option></option>
                '.$optionsHtmlTransferPayments.'
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Возврат&nbsp;чеков</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.(-$vozvrat_checkov).'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderCheckRefunds" class="form-control form-control-sm text-body">
                <option></option>
                <option value="10860">10860</option>
                '.$optionsCheckRefunds.'
            </select>
        </div>
    </div>
	<div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Проверка&nbsp;кассы</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.(0).'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectProvekaKassi" class="form-control form-control-sm text-body">
                '.$optionsProvekaKassi.'
            </select>
        </div>
    </div>
    ';
	
	/*
	$f = fopen("log_dnevnoj.txt", 'a');
	$str ="\r\n" . $lab . " createLabsHTML() " . round(microtime(true) - $start, 4) . ' sec.' . "\r\n";
	fwrite($f, $str); 
	fclose($f);
	*/
	
    return $html;
}
?>
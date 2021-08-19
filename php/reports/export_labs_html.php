<?php
require_once "labs_html_functions.php";

function createLabsHTML($link, $lab, $lab_id, $reportDate)
{
    $kassa_v_nachale_dnja = initialCashRemainder($link, $lab, $lab_id, $reportDate);

    $cena = sumAnalyzes($link, $lab, $reportDate);

    $sum_vernuli_dolg = sumRepaidDebts($link, $lab, $reportDate);

    $sum_vozvrat = sumRefunds($link, $lab, $reportDate);

    $obshij_dolg = sumDebts($link, $lab, $reportDate);

    $cost_standart = sumCashPayments($link, $lab, $reportDate);
	
	$cost_transfer = sumTtansferPayments($link, $lab, $reportDate);

    $cost_terminal = sumTerminalPayments($link, $lab, $reportDate);

    $prodano_summa = sumSales($link, $lab_id, $reportDate);

    $instrumenti = sumInstruments($link, $lab_id, $reportDate);

    $vizov_nadom = sumHomeVisits($link, $lab, $reportDate);

    $sr_vizov = sumUrgentCalls($link, $lab, $reportDate);

    $sdano = sumCashHandovers($link, $lab_id, $reportDate);

    $kassa_tekushego_dnja = finalCashRemanider($link, $lab, $lab_id, $reportDate);

    $summa_checkov = sumChecks($link, $lab, $reportDate);

    $vozvrat_checkov = sumCheckRefunds($link, $lab, $reportDate);

    $html = '
    <table class="table" border="1">
        <tr>
            <td>В&nbsp;начале&nbsp;дня</td><td>'.$kassa_v_nachale_dnja.'</td>
        </tr>
        <tr>
            <td>Сумма&nbsp;анализов</td><td>'.$cena.'</td>
        </tr>
        <tr>
            <td>Вернули&nbsp;долг</td><td>'.$sum_vernuli_dolg.'</td>
        </tr>
        <tr>
            <td>Возврат</td><td>'.$sum_vozvrat.'</td>
        </tr>
        <tr>
            <td>Остались&nbsp;в&nbsp;долгу</td><td>'.$obshij_dolg.'</td>
        </tr>
        <tr>
            <td>Заплатили</td><td>'.$cost_standart.'</td>
        </tr>
        <tr>
            <td></td><td></td>
        </tr>
        <tr>
            <td>Терминал</td><td>'.$cost_terminal.'</td>
        </tr>
		<tr>
            <td>Перечисление</td><td>'.$cost_transfer.'</td>
        </tr>
        <tr>
            <td>Стрип</td><td>'.$prodano_summa.'</td>
        </tr>
        <tr>
            <td>Прочее</td><td>'.$instrumenti.'</td>
        </tr>
        <tr>
            <td>Вызов&nbsp;на&nbsp;дому</td><td>'.$vizov_nadom.'</td>
        </tr>
        <tr>
            <td>Срочный&nbsp;вызов</td><td>'.$sr_vizov.'</td>
        </tr>
        <tr>
            <td>Сдано</td><td>'.$sdano.'</td>
        </tr>
        <tr>
            <td>Остаток&nbsp;кассы</td><td>'.$kassa_tekushego_dnja.'</td>
        </tr>
        <tr>
            <td>Сумма&nbsp;чеков</td><td>'.$summa_checkov.'</td>
        </tr>
        <tr>
            <td>Возврат&nbsp;чеков</td><td>'.(-$vozvrat_checkov).'</td>
        </tr>
    </table>
    ';
    return $html;
}
?>
<?php
require_once "lab_html_functions.php";

function createLabHTML($link, $reportDate)
{
    $kassa_v_nachale_dnja_lab = initialCashRemainderLab($link, $reportDate);

    $cena_lab = sumAnalyzesLab($link, $reportDate);

    $sum_vernuli_dolg_lab = sumRepaidDebtsLab($link, $reportDate);

    $sum_vozvrat_lab = sumRefundsLab($link, $reportDate);

    $obshij_dolg_lab = sumDebtsLab($link, $reportDate);

    $cost_standart_lab = sumCashPaymentsLab($link, $reportDate);

    $cost_terminal_lab = sumTerminalPaymentsLab($link, $reportDate);

    $prodano_summa_lab = sumSalesLab($link, $reportDate);

    $instrumenti_lab = sumInstrumentsLab($link, $reportDate);

    $vizov_nadom_lab = sumHomeVisitsLab($link, $reportDate);

    $sr_vizov_lab = sumUrgentCallsLab($link, $reportDate);

    $sdano_lab = sumCashHandoversLab($link, $reportDate);

    $kassa_tekushego_dnja_lab = finalCashRemaniderLab($link, $reportDate);

    $summa_checkov_lab = sumChecksLab($link, $reportDate);

    $vozvrat_checkov_lab = sumCheckRefundsLab($link, $reportDate);

    $html = '
    <table class="table" border="1">
        <tr>
            <td>В&nbsp;начале&nbsp;дня</td><td>'.$kassa_v_nachale_dnja_lab.'</td>
        </tr>
        <tr>
            <td>Сумма&nbsp;анализов</td><td>'.$cena_lab.'</td>
        </tr>
        <tr>
            <td>Вернули&nbsp;долг</td><td>'.$sum_vernuli_dolg_lab.'</td>
        </tr>
        <tr>
            <td>Возврат</td><td>'.$sum_vozvrat_lab.'</td>
        </tr>
        <tr>
            <td>Остались&nbsp;в&nbsp;долгу</td><td>'.$obshij_dolg_lab.'</td>
        </tr>
        <tr>
            <td>Заплатили</td><td>'.$cost_standart_lab.'</td>
        </tr>
        <tr>
            <td></td><td></td>
        </tr>

        ';
    $sql = "SELECT 
                id, 
                partner 
            FROM partners 
            ORDER BY sorting
            ";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $sumPartnerDebtsLab = sumPartnerDebtsLab($link, $row["partner"], $reportDate);

                $html.='
                <tr>
                    <td>'.$row["partner"].'</td><td>'.$sumPartnerDebtsLab.'</td>
                </tr>
                ';
            }
        }
    }
    $html.='
        <tr>
            <td>Терминал</td><td>'.$cost_terminal_lab.'</td>
        </tr>
        <tr>
            <td>Стрип</td><td>'.$prodano_summa_lab.'</td>
        </tr>
        <tr>
            <td>Прочее</td><td>'.$instrumenti_lab.'</td>
        </tr>
        <tr>
            <td>Вызов&nbsp;на&nbsp;дому</td><td>'.$vizov_nadom_lab.'</td>
        </tr>
        <tr>
            <td>Срочный&nbsp;вызов</td><td>'.$sr_vizov_lab.'</td>
        </tr>
        <tr>
            <td>Сдано</td><td>'.$sdano_lab.'</td>
        </tr>
        <tr>
            <td>Остаток&nbsp;кассы</td><td>'.$kassa_tekushego_dnja_lab.'</td>
        </tr>
        <tr>
            <td>Сумма&nbsp;чеков</td><td>'.$summa_checkov_lab.'</td>
        </tr>
        <tr>
            <td>Возврат&nbsp;чеков</td><td>'.(-$vozvrat_checkov_lab).'</td>
        </tr>
    </table>
    ';
    return $html;
}
?>
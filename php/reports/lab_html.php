<?php
require_once "lab_html_functions.php";

function createLabHTML($link, $reportDate)
{
    $kassa_v_nachale_dnja_lab = initialCashRemainderLab($link, $reportDate);

    $cena_lab = sumAnalyzesLab($link, $reportDate);

    $sum_vernuli_dolg_lab = sumRepaidDebtsLab($link, $reportDate);
    //$optionsHtmlRepaidDebtsLab = optionsHtmlRepaidDebtsLab($link, $reportDate);

    $sum_vozvrat_lab = sumRefundsLab($link, $reportDate);
    //$optionsHtmlRefundsLab = optionsHtmlRefundsLab($link, $reportDate);

    $obshij_dolg_lab = sumDebtsLab($link, $reportDate);
    //$optionsHtmlDebtsLab = optionsHtmlDebtsLab($link, $reportDate);

    $cost_standart_lab = sumCashPaymentsLab($link, $reportDate);
    //$optionsHtmlCashPaymentsLab = optionsHtmlCashPaymentsLab($link, $reportDate);
    //$optionsHtmlPaymentsLab = optionsHtmlPaymentsLab($link, $reportDate);

    $cost_terminal_lab = sumTerminalPaymentsLab($link, $reportDate);
    //$optionsHtmlTerminalPaymentsLab = optionsHtmlTerminalPaymentsLab($link, $reportDate);

    $prodano_summa_lab = sumSalesLab($link, $reportDate);
    //$optionsHtmlSalesLab = optionsHtmlSalesLab($link, $reportDate);

    $instrumenti_lab = sumInstrumentsLab($link, $reportDate);
    //$optionsHtmlInstrumentsLab = optionsHtmlInstrumentsLab($link, $reportDate);

    $vizov_nadom_lab = sumHomeVisitsLab($link, $reportDate);
    //$optionsHtmlHomeVisitsLab = optionsHtmlHomeVisitsLab($link, $reportDate);

    $sr_vizov_lab = sumUrgentCallsLab($link, $reportDate);
    //$optionsUrgentCallsLab = optionsHtmlUrgentCallsLab($link, $reportDate);

    $sdano_lab = sumCashHandoversLab($link, $reportDate);
    //$optionsCashHandoversLab = optionsHtmlCashHandoversLab($link, $reportDate);

    $kassa_tekushego_dnja_lab = finalCashRemaniderLab($link, $reportDate);

    $summa_checkov_lab = sumChecksLab($link, $reportDate);
    //$optionsHtmlChecksLab = optionsHtmlChecksLab($link, $reportDate);

    $vozvrat_checkov_lab = sumCheckRefundsLab($link, $reportDate);
    //$optionsCheckRefundsLab = optionsCheckRefundsLab($link, $reportDate);

    $html = '
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">В&nbsp;начале&nbsp;дня</label></div>        
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$kassa_v_nachale_dnja_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сумма&nbsp;анализов</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cena_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Вернули&nbsp;долг</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sum_vernuli_dolg_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderRepaidDebts" id="selectOrderRepaidDebtsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlRepaidDebtsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Возврат</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sum_vozvrat_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderRefunds" id="selectOrderRefundsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlRefundsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Остались&nbsp;в&nbsp;долгу</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$obshij_dolg_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderDebts" id="selectOrderDebtsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlDebtsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Заплатили</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cost_standart_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderCashPayments" id="selectOrderCashPaymentsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlCashPaymentsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-10 pl-2 pr-0"><label class="form-control form-control-sm mb-1 text-body"></label></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderPayments" id="selectOrderPaymentsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlPaymentsLab.'-->
            </select>
        </div>
    </div>';
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
                //var_dump($sumPartnerDebtsLab);
                //$optionsHtmlPartnerDebtsLab = optionsHtmlPartnerDebtsLab($link, $row["partner"], $reportDate);

                $html.='
                <div class="row">
                    <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">'.$row["partner"].'</label></div>
                    <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sumPartnerDebtsLab.'" disabled></div>
                    <div class="col-2 pl-1 pr-2">
                        <select name="selectOrderLab_'.$row["partner"].'" id="selectOrderLabDebts_'.$row["partner"].'" class="form-control form-control-sm text-body" disabled>
                            <option></option>
                            <!--'.$optionsHtmlPartnerDebtsLab.'-->
                        </select>
                    </div>
                </div>
                ';
            }
        }
    }
    $html.='
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Терминал</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cost_terminal_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderTerminal" id="selectOrderTerminalLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlTerminalPaymentsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Стрип</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$prodano_summa_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderSales" id="selectOrderSalesLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlSalesLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Прочее</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$instrumenti_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderInstruments" id="selectOrderInstrumensLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlInstrumentsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Вызов&nbsp;на&nbsp;дом</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$vizov_nadom_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderHomeVisits" id="selectOrderHomeVisitsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlHomeVisitsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Срочный&nbsp;вызов</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sr_vizov_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderUrgentCalls" id="selectOrderUrgentCallsLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsUrgentCallsLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сдано</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sdano_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderCashHandovers" id="selectOrderCashHandoversLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsCashHandoversLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Остаток&nbsp;кассы</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$kassa_tekushego_dnja_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сумма&nbsp;чеков</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$summa_checkov_lab.'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderChecks" id="selectOrderChecksLab" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsHtmlChecksLab.'-->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Возврат&nbsp;чеков</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.(-$vozvrat_checkov_lab).'" disabled></div>
        <div class="col-2 pl-1 pr-2">
            <select name="selectOrderCheckRefunds" id="selectOrderCheckRefunds" class="form-control form-control-sm text-body" disabled>
                <option></option>
                <!--'.$optionsCheckRefundsLab.'-->
            </select>
        </div>
    </div>
    ';
    return $html;
}
?>
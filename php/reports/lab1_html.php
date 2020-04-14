<?php
require_once "lab1_html_functions.php";

function createLab1HTML($link, $reportDate)
{
    $cena_lab1 = sumAnalyzesLab1($link, $reportDate);

    $html = '
    <div class="row">
        <div class="col-12 pl-2 pr-2"><label class="form-control form-control-sm mb-1"></label></div>
    </div>
    <div class="row">
        <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">Сумма&nbsp;анализов</label></div>
        <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$cena_lab1.'" disabled></div>
        <div class="col-2 pl-1 pr-2"></div>
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
                $optionsHtmlPartnerDebtsLab = optionsHtmlPartnerDebtsLab($link, $row["partner"], $reportDate);

                $html.='
                <div class="row">
                    <div class="col-6 pl-2 pr-1"><label class="form-control form-control-sm mb-1 text-body">'.$row["partner"].'</label></div>
                    <div class="col-4 px-0"><input type="text" class="form-control form-control-sm text-right text-body" value="'.$sumPartnerDebtsLab.'" disabled></div>
                    <div class="col-2 pl-1 pr-2">
                        <select name="selectOrderLab_'.$row["partner"].'" class="form-control form-control-sm text-body">
                            <option></option>
                            '.$optionsHtmlPartnerDebtsLab.'
                        </select>
                    </div>
                </div>
                ';
            }
        }
    }
    $html.='
    ';
    return $html;
}
?>
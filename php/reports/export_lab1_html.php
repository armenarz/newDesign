<?php
require_once "lab1_html_functions.php";

function createLab1HTML($link, $reportDate)
{
    $cena_lab1 = sumAnalyzesLab1($link, $reportDate);

    $html = '
    <table class="table" border="1">
        <tr>
            <td></td><td></td>
        </tr>
        <tr>
            <td>Сумма&nbsp;анализов</td><td>'.$cena_lab1.'</td>
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
    ';
    return $html;
}
?>
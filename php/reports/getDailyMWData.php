<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";
require_once "../constants.php";

$msg = "";

//<!-- BEGIN Tabs HTML Markup -->
$msg = '
<div class="row">
    <div class="col">
        <label for="ReportDateDaily">Дата</label>
        <select id="ReportDateDaily" class="form-control" name="ReportDateDaily">
            <option value="0"></option>
            ';
$sql=  "SELECT 
            OrderDate 
        FROM orders 
        where OrderDate >= ".START_DATE_REPORT." 
        GROUP BY OrderDate 
        ORDER BY OrderDate DESC";
$result = mysqli_query($link,$sql);
if($result)
{
    $reportDateDailyIndex = 0;
    while($row = mysqli_fetch_array($result))
    {
        if($reportDateDailyIndex == 0)
        {
            $msg .=  '<option value="'.$row["OrderDate"].'" selected>'.$row["OrderDate"].'</option>';
        }
        else
        {
            $msg .=  '<option value="'.$row["OrderDate"].'">'.$row["OrderDate"].'</option>';
        }
        $reportDateDailyIndex++;
    }
}
$msg .= '
        </select>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->

echo $msg;
?>

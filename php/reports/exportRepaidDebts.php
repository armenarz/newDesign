<?php
header("Content-Type: application/xls");

require_once "../connect.php";
require_once "../authorization.php";

$utf8_bom = chr(239).chr(187).chr(191);

$msg = $utf8_bom;

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

$filter = "";
$reportDescription = "";

if($menuId == "repaidDebtsLink")
{
    $filter = "vernuli_dolg.vernuli_date>='".$startDate."' AND vernuli_dolg.vernuli_date<='".$endDate."'";

    $msg.= '
    <table class="table" border="1" id="debtsData">
        <caption>
            <h2>Погашенные долги</h2>
            <h3>с '.$startDate.' по '.$endDate.'</h3>
            <h4>'.$reportDescription.'</h4>
        </caption>
        <thead>
            <tr>
                <!--1. Row number-->
                <th scope="col" class="text-right">#</th>
                <!--2. OrderId-->
                <th scope="col" class="text-right">Id заказа</th>
                <!--3. OrderDate-->
                <th scope="col">Дата заказа</th>
                <!--4. Patient-->
                <th scope="col">Пациент</th>
                <!--5. RepaidDebt-->
                <th scope="col">Погашенный долг</th>
                <!--6. Doctor-->
                <th scope="col">Доктор</th>
            </tr>
        </thead>
        <tbody>
        ';
    $sql_repaid_debts = "  SELECT 
                        orders.OrderId, 
                        orders.OrderDate,
                        orders.pac_id,
                        CONCAT(pacients.LastName,' ', pacients.FirstName,' ', pacients.MidName ) AS Patient,
                        SUM(vernuli_dolg.dolg) AS RepaidDebt,
                        orders.DoctorId,
                        CONCAT(doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) AS Doctor                                                                                                 
                    FROM orders
                    LEFT JOIN vernuli_dolg ON orders.OrderId = vernuli_dolg.orderid
                    LEFT JOIN pacients ON orders.pac_id = pacients.id
                    LEFT JOIN doctor ON orders.DoctorId = doctor.DoctorId
                    WHERE vernuli_dolg.dolg!=0 AND $filter
                    GROUP BY orders.OrderId
                    ORDER BY orders.OrderId";

    $result_repaid_debts = mysqli_query($link, $sql_repaid_debts);
    if($result_repaid_debts)
    {
        $i = 0;
        $total_repaid_debts = 0;
        while($row_repaid_debts = mysqli_fetch_array($result_repaid_debts))
        {
            $i++;
            $msg.= '   <tr>
                            <!--Row number-->
                            <td scope="col" class="text-right">'.$i.'</td>
                            <!--2. OrderId-->
                            <td scope="col" class="text-right">'.$row_repaid_debts["OrderId"].'</td>
                            <!--3. OrderDate-->
                            <td scope="col">'.$row_repaid_debts["OrderDate"].'</td>
                            <!--4. Patient-->
                            <td scope="col">'.$row_repaid_debts["Patient"].'</td>
                            <!--5. Debt-->
                            <td scope="col" class="text-right">'.$row_repaid_debts["RepaidDebt"].'</td>
                            <!--6. Doctor-->
                            <td scope="col">'.$row_repaid_debts["Doctor"].'</td>
                        </tr>';
            $total_repaid_debts += $row_repaid_debts["RepaidDebt"];
        }
    }    
    
    $msg.= '
            <tr>
                <td scope="col" colspan="4" class="text-right"><strong>ИТОГО:</strong></td>
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <td scope="col" class="text-right"><strong>'.$total_repaid_debts.'</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    ';
}

header("Content-Disposition: attachement; filename=repaidDebts.xls");
echo $msg;
?>
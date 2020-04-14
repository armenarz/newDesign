<?php
require_once "../connect.php";
require_once "../authorization.php";

$msg = "";

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

if($menuId == "debtsLink")
{
    $filter = "orders.OrderDate>='".$startDate."' AND orders.OrderDate<='".$endDate."'";
    //$reportDescription = "<span>(тип отчета: суммарно)</span>";

    $msg.= '
    <h3>Долги с '.$startDate.' по '.$endDate.'</h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="debtsData">
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
                <!--5. Debt-->
                <th scope="col" class="text-right">Долг</th>
                <!--6. Doctor-->
                <th scope="col">Доктор</th>
                <!--7. RepaidDebt-->
                <th scope="col">Погашенный долг</th>
                <!--8. RepaymentDate-->
                <th scope="col">Дата погашения</th>
            </tr>
        </thead>
        <tbody>
        ';
    $sql_debts = "  SELECT 
                        orders.OrderId, 
                        orders.OrderDate,
                        orders.DoctorId,
                        CONCAT(doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) AS Doctor,
                        orders.pac_id,
                        CONCAT(pacients.LastName,' ', pacients.FirstName,' ', pacients.MidName ) AS Patient,
                        orders.dolg
                    FROM orders 
                    LEFT JOIN pacients ON orders.pac_id = pacients.id 
                    LEFT JOIN doctor on orders.DoctorId = doctor.DoctorId 
                    WHERE $filter 
                        AND orders.dolg != 0
                    ORDER BY orders.dolg DESC";
                    
    $result_debts = mysqli_query($link, $sql_debts);
    if($result_debts)
    {
        $i = 0;
        $total_debts = 0;
        $total_repaid_debts = 0;
        while($row_debts = mysqli_fetch_array($result_debts))
        {
            $i++;
            $sql_repaid_debts = "SELECT 
                                    vernuli_date, 
                                    SUM(dolg) AS RepaidDebt 
                                FROM vernuli_dolg 
                                WHERE orderid='".$row_debts["OrderId"]."'";
            $result_repaid_debts = mysqli_query($link,$sql_repaid_debts);
            if($result_repaid_debts)
            {
                $row_repaid_debts = mysqli_fetch_array($result_repaid_debts);
            }
            $msg.= '   <tr>
                            <!--Row number-->
                            <td scope="col" class="text-right">'.$i.'</td>
                            <!--2. OrderId-->
                            <td scope="col" class="text-right"><a href="#" id=o_'.$row_debts["OrderId"].'>'.$row_debts["OrderId"].'</a></td>
                            <!--3. OrderDate-->
                            <td scope="col">'.$row_debts["OrderDate"].'</td>
                            <!--4. Patient-->
                            <td scope="col">'.$row_debts["Patient"].'</td>
                            <!--5. Debt-->
                            <td scope="col" class="text-right">'.$row_debts["dolg"].'</td>
                            <!--6. Doctor-->
                            <td scope="col">'.$row_debts["Doctor"].'</td>
                            <!--7. RepaidDebt-->
                            <td scope="col">'.$row_repaid_debts["RepaidDebt"].'</td>
                            <!--8. RepaymentDate-->
                            <td scope="col">'.$row_repaid_debts["vernuli_date"].'</td>
                        </tr>';
            $total_debts += $row_debts["dolg"];
            $total_repaid_debts += $row_repaid_debts["RepaidDebt"];
        }
    }    
    
    $msg.= '
            <tr>
                <td scope="col" colspan="4" class="text-right"><strong>ИТОГО:</strong></td>
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <td scope="col" class="text-right"><strong>'.$total_debts.'</strong></td>
                <td></td>
                <td scope="col" class="text-right"><strong>'.$total_repaid_debts.'</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    ';
}

echo $msg;
?>
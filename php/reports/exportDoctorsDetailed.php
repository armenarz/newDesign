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
$reportTypeId = $_POST["reportTypeId"];

$reagentId = $_POST["reagentId"];
if($reagentId > 0)
{
    $sql_reagent = "SELECT 
                        ReagentDescRus
                    FROM reagent
                    WHERE ReagentId='".$reagentId."'";
    $result_reagent = mysqli_query($link,$sql_reagent);
    if($result_reagent)
    {
        $row_reagent = mysqli_fetch_array($result_reagent);
        $reagentDescRus = $row_reagent["ReagentDescRus"];
    }
}

$doctorId = $_POST["doctorId"];
if($doctorId > 0)
{
    $sql_doctor = " SELECT 
                        FirstName,
                        LastName,
                        MidName
                    FROM doctor
                    WHERE DoctorId='".$doctorId."'
                ";
    $result_doctor = mysqli_query($link,$sql_doctor);
    if($result_doctor)
    {
        $row_doctor = mysqli_fetch_array($result_doctor);
        $doctorName = $row_doctor["LastName"]." ".$row_doctor["FirstName"]." ".$row_doctor["MidName"];
    }
}


$workplaceId = $_POST["workplaceId"];
if($workplaceId > 0)
{
    $sql_workplace = "  SELECT 
                            WorkPlaceDesc 
                        FROM cworkplace 
                        WHERE WorkPlaceId='".$workplaceId."'
                    ";
    $result_workplace = mysqli_query($link,$sql_workplace);
    if($result_workplace)
    {
        $row_workplace = mysqli_fetch_array($result_workplace);
        $workplace = $row_workplace["WorkPlaceDesc"];
    }
}

$salesId = $_POST["salesId"];
if($salesId > 0)
{
    $sql_sales = "  SELECT 
                        salesName 
                    FROM sales 
                    WHERE salesId='".$salesId."'
                ";
    $result_sales = mysqli_query($link,$sql_sales);
    if($result_sales)
    {
        $row_sales = mysqli_fetch_array($result_sales);
        $sales = $row_sales["salesName"];
    }
}

$userId = $_POST["userId"];
if($userId > 0)
{
    $sql_user = "   SELECT 
                        log 
                    FROM us22 
                    WHERE id='".$userId."'
                ";
    $result_user = mysqli_query($link,$sql_user);
    if($result_user)
    {
        $row_user = mysqli_fetch_array($result_user);
        $user = $row_user["log"];
    }
}

if(!isset($_POST["doubleCheck"]))
{
    $msg .= "The doubleCheck is not defined. doubleCheck=".$_POST["doubleCheck"];
    echo $msg;
    return;
}

if($_POST["doubleCheck"]=="true")
{
    $doubleCheck = 1;
}
elseif($_POST["doubleCheck"]=="false")
{
    $doubleCheck = 0;
}

$filter = "";
$reportDescription = "";

if($menuId == "doctorsLink" && $reportTypeId == 2)
{
    require_once "doctorsFilter.php";

    $msg.= '
    <table class="table" border="1" id="reagentExpensesData">
        <caption>
            <h2>Врачи</h2>
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
                <!--5. Cost-->
                <th scope="col" class="text-right">Стоимость</th>
                <!--6. ReceivedFromPatient-->
                <th scope="col" class="text-right">Получено от пациента</th>
                <!--7. Comments-->
                <th scope="col" class="text-right">Комментарий</th>
            </tr>
        </thead>
        <tbody>
        ';
        $price_grand_total = 0;
        $cost_grand_total = 0;
        $count_grand_total = 0;

        $sql_workplace = "  SELECT 
                                doctor.WorkPlaceId,
                                cworkplace.WorkPlaceDesc
                            FROM
                                orders
                            LEFT JOIN orderresult ON orders.OrderId = orderresult.OrderId
                            LEFT JOIN doctor on orders.DoctorId = doctor.DoctorId
                            LEFT JOIN cworkplace on doctor.WorkPlaceId = cworkplace.WorkPlaceId
                            WHERE $filter
                            GROUP BY doctor.WorkPlaceId
                            ORDER BY cworkplace.WorkPlaceDesc";
                        
        $result_workplace = mysqli_query($link, $sql_workplace);
        if($result_workplace)
        {
            while($row_workplace = mysqli_fetch_array($result_workplace))
            {
                $price_workplace_total = 0;
                $cost_workplace_total = 0;
                $count_workplace_total = 0;
                $msg.= '
                <tr>
                    <!--1. Row number-->
                    <td colspan="7"><strong>'.$row_workplace["WorkPlaceDesc"].' [ id: '.$row_workplace["WorkPlaceId"].' ]</strong></td>
                    <!--2. OrderId-->
                    <!--<td></td>-->
                    <!--3. OrderDate-->
                    <!--<td></td>-->
                    <!--4. Patient-->
                    <!--<td></td>-->
                    <!--5. Cost-->
                    <!--<td></td>-->
                    <!--6. ReceivedFromPatient-->
                    <!--<td></td>-->
                    <!--7. Comments-->
                    <!--<td></td>-->
                </tr>
                ';
                
                $sql_doctor = " SELECT 
                                    orders.DoctorId,
                                    CONCAT(doctor.LastName,' ', doctor.FirstName,' ', doctor.MidName) AS DocName
                                FROM
                                    orders
                                LEFT JOIN orderresult ON orders.OrderId = orderresult.OrderId
                                LEFT JOIN doctor ON orders.DoctorId = doctor.DoctorId
                                LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId
                                WHERE doctor.WorkPlaceId ='".$row_workplace["WorkPlaceId"]."' AND $filter
                                group by orders.DoctorId
                                order by DocName";

                $result_doctor = mysqli_query($link, $sql_doctor);
                if($result_doctor)
                {
                    $i = 0;
                    while($row_doctor = mysqli_fetch_array($result_doctor))
                    {
                        $i++;
                        $price_doctor_total = 0;
                        $cost_doctor_total = 0;
                        $count_doctor_total = 0;
                        $msg.= '
                        <tr>
                            <!--1. Row number-->
                            <td class="text-right"></td>
                            <!--2. OrderId-->
                            <td colspan="6"><strong>'.$row_doctor["DocName"].' [ id: '.$row_doctor["DoctorId"].' ]</strong></td>
                            <!--3. OrderDate-->
                            <!--<td></td>-->
                            <!--4. Patient-->
                            <!--<td></td>-->
                            <!--5. Cost-->
                            <!--<td class="text-right"></td>-->
                            <!--6. ReceivedFromPatient-->
                            <!--<td class="text-right"></td>-->
                            <!--7. Comments-->
                            <!--<td class="text-right"></td>-->
                        </tr>
                        ';
                        $sql_orders = " SELECT 
                                            orders.OrderId
                                        FROM
                                            orders
                                        LEFT JOIN orderresult ON orders.OrderId = orderresult.OrderId
                                        LEFT JOIN doctor ON orders.DoctorId = doctor.DoctorId
                                        LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId
                                        WHERE orders.DoctorId='".$row_doctor["DoctorId"]."' AND $filter
                                        group by orders.OrderId
                                        order by orders.OrderId";

                        $result_orders = mysqli_query($link, $sql_orders);
                        if($result_orders)
                        {
                            $count_doctor = 0;
                            while($row_orders = mysqli_fetch_array($result_orders))
                            {
                                $sql_orders_data ="	SELECT 
                                                        OrderDate,
                                                        cena_analizov, 
                                                        cost,
                                                        orders.Comment, 
                                                        pac_id
                                                    FROM orders 
                                                    WHERE OrderId='".$row_orders["OrderId"]."'
                                                    ORDER BY orders.cena_analizov";
                                
                                $result_orders_data = mysqli_query($link, $sql_orders_data);
                                if($result_orders_data)
                                {
                                    $row_orders_data = mysqli_fetch_array($result_orders_data);
                                    $price_doctor = $row_orders_data["cena_analizov"];
                                    $cost_doctor = $row_orders_data["cost"];
                                    $count_doctor++;

                                    $sql_patient = "SELECT
                                                        CONCAT(pacients.LastName,' ', pacients.FirstName,' ', pacients.MidName ) AS Patient
                                                    FROM pacients
                                                    WHERE id='".$row_orders_data["pac_id"]."'";
                                    
                                    $result_patient = mysqli_query($link, $sql_patient);
                                    if($result_patient)
                                    {
                                        $row_patient = mysqli_fetch_array($result_patient);
                                    }
                                    $sql_debt_repayment = "SELECT 
								                        SUM(dolg) AS RepaidDebt 
							                        FROM vernuli_dolg 
                                                    WHERE orderid='".$row_orders["OrderId"]."' AND vernuli_date<='".$endDate."'";
                                    $result_debt_repayment = mysqli_query($link,$sql_debt_repayment);
                                    if($result_debt_repayment)
                                    {
                                        $row_debt_repayment = mysqli_fetch_array($result_debt_repayment);
                                        $cost_doctor += $row_debt_repayment["RepaidDebt"];
                                    }
                                    $msg.= '
                                    <tr>
                                        <!--1. Row number-->
                                        <td class="text-right">'.$count_doctor.'</td>
                                        <!--2. OrderId-->
                                        <td class="text-right">'.$row_orders["OrderId"].'</td>
                                        <!--3. OrderDate-->
                                        <td>'.$row_orders_data["OrderDate"].'</td>
                                        <!--4. Patient-->
                                        <td>'.$row_patient["Patient"].'</td>
                                        <!--5. Price-->
                                        <td class="text-right">'.$price_doctor.'</td>
                                        <!--6. ReceivedFromPatient-->
                                        <td class="text-right">'.$cost_doctor.'</td>
                                        <!--7. Comments-->
                                        <td>'.$row_orders_data["Comment"].'</td>
                                    </tr>
                                    ';
                                    $price_doctor_total += $price_doctor;
                                    $cost_doctor_total += $cost_doctor;
                                }
                            }
                            $count_doctor_total += $count_doctor;
                            $msg.= '
                            <tr>
                                <td colspan="4" class="text-right"><strong>ИТОГО ( количество заказов по врачу: '.$count_doctor.' ):</strong></td>
                                <td class="text-right"><strong>'.$price_doctor_total.'</strong></td>
                                <td class="text-right"><strong>'.$cost_doctor_total.'</strong></td>
                                <td class="text-right"></td>
                            </tr>
                            ';
                        }
                        
                        $price_workplace_total += $price_doctor_total;
                        $cost_workplace_total += $cost_doctor_total;
                        $count_workplace_total += $count_doctor_total;
                    }
                    
                    $msg.= '
                    <tr>
                        <td colspan="4" class="text-right"><strong>ИТОГО ( количество заказов по учреждению: '.$count_workplace_total.' ):</strong></td>
                        <td class="text-right"><strong>'.$price_workplace_total.'</strong></td>
                        <td class="text-right"><strong>'.$cost_workplace_total.'</strong></td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                    ';
                }
                $price_grand_total += $price_workplace_total;
                $cost_grand_total += $cost_workplace_total;
                $count_grand_total += $count_workplace_total;
            }
        }
        $msg.= '
        <tr>
            <td colspan="4" class="text-right"><strong>ОБЩИЙ ИТОГ ( количество заказов: '.$count_grand_total.' ):</strong></td>
            <td class="text-right"><strong>'.$price_grand_total.'</strong></td>
            <td class="text-right"><strong>'.$cost_grand_total.'</strong></td>
            <td class="text-right"></td>
        </tr>
        ';
    
    $msg.= '
        </tbody>
    </table>
    ';
}

header("Content-Disposition: attachement; filename=doctorsDetailed.xls");
echo $msg;
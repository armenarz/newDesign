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
$reagentIdArr = json_decode($_POST["reagentIdArr"]);
$doctorId = $_POST["doctorId"];
if($doctorId > 0)
{
    $sql_doctor = " SELECT 
                        FirstName,
                        LastName,
                        MidName
                    FROM doctor
                    WHERE DoctorId='".$doctorId."'";

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

$labId = $_POST["labId"];
$sql_lab = "SELECT lab FROM labs WHERE id='".$labId."'";
$result_lab = mysqli_query($link, $sql_lab);
if($result_lab)
{
    $row_lab = mysqli_fetch_array($result_lab);
    $lab = $row_lab["lab"];
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

if($_POST["BezSARSCheck"]=="true")
{
    $BezSARSCheck = 1;
}
elseif($_POST["BezSARSCheck"]=="false")
{
    $BezSARSCheck = 0;
}

if($_POST["filial"]) {
	$filial = $_POST["filial"];
}
else {
	$filial = 0;
}

$filter = "";
$reportDescription = "";

if($menuId == "reagentExpensesLink" && $reportTypeId == 1)
{

    require_once "reagentExpensesFilter.php";
	
	if($BezSARSCheck == 1) {
		$filter .= " AND orders.is_bez_kov = '$BezSARSCheck'";
	}
	
	if($filial == 2) {
		$filter .= " AND orders.user_id = '762'";
	}
	elseif($filial == 3) {
		$filter .= " AND orders.user_id = '762'";
	}
	else {
		;
	}

    $msg.= '
    <table class="table" border="1" id="reagentExpensesData">
        <caption>
            <h2>Расход реагентов </h2>
            <h3>с '.$startDate.' по '.$endDate.'</h3>
            <h4>'.$reportDescription.'</h4>
        </caption>
        <thead>
            <tr>
                <!--Row number-->
                <th scope="col" class="text-right">#</th>
                <!--Number in group-->
                <th scope="col" class="text-right"># в группе</th>
                <!--ReagentId-->
                <th scope="col" class="text-right">Id</th>
                <!--ReagentDescRus-->
                <th scope="col">Описание</th>
                <!--count_reag-->
                <th scope="col" class="text-right">Количество</th>
            </tr>
        </thead>
        <tbody>
        ';
    
    $sql_group = "  SELECT 
                        reagent.GroupId, 
                        reagentgroup.GroupDescRus,
                        COUNT(reagent.ReagentId) AS ReagentCount
                    FROM orderresult
                    INNER JOIN orders ON orders.OrderId=orderresult.OrderId
                    INNER JOIN reagent ON reagent.ReagentId=orderresult.ReagentId
                    INNER JOIN reagentgroup ON reagentgroup.GroupId=reagent.GroupId
                    INNER JOIN pacients ON pacients.id=orders.pac_id
                    INNER JOIN doctor ON doctor.DoctorId=orders.DoctorId
                    INNER JOIN cworkplace ON cworkplace.WorkPlaceId=Doctor.WorkPlaceId
                    INNER JOIN sales ON sales.salesId=doctor.sales_id
                    INNER JOIN us22 ON us22.id=orders.user_id 
                    WHERE $filter
                    GROUP BY reagent.GroupId
                    ORDER BY reagent.GroupId";
    
    $result_group = mysqli_query($link,$sql_group);
    if($result_group)
    {
        $i = 0;
        $total = 0;
        while($row_group = mysqli_fetch_array($result_group))
        {
            $total += $row_group["ReagentCount"];
            $msg.= '
            <tr>
                <td colspan="4"><strong>Группа '.$row_group["GroupDescRus"].'</strong></td>
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <td class="text-right"><strong>'.$row_group["ReagentCount"].'</strong></td>
            </tr>
            ';
            $sql_reagent = "SELECT 
                                reagent.GroupId,
                                orderresult.ReagentId,
                                reagent.ReagentDescRus, 
                                COUNT(orderresult.ReagentId) AS ReagentCount 
                            FROM orderresult
                            INNER JOIN orders ON orders.OrderId=orderresult.OrderId
                            INNER JOIN reagent ON reagent.ReagentId=orderresult.ReagentId
                            INNER JOIN reagentgroup ON reagentgroup.GroupId=reagent.GroupId
                            INNER JOIN pacients ON pacients.id=orders.pac_id
                            INNER JOIN doctor ON doctor.DoctorId=orders.DoctorId
                            INNER JOIN cworkplace ON cworkplace.WorkPlaceId=Doctor.WorkPlaceId
                            INNER JOIN sales ON sales.salesId=doctor.sales_id
                            INNER JOIN us22 ON us22.id=orders.user_id 
                            WHERE $filter
                            GROUP BY reagent.GroupId, orderresult.ReagentId
                            HAVING reagent.GroupId='".$row_group["GroupId"]."'
                            ORDER BY reagent.GroupId, orderresult.ReagentId";
            $result_reagent = mysqli_query($link,$sql_reagent);
            if($result_reagent)
            {
                $j = 0;
                while($row_reagent = mysqli_fetch_array($result_reagent))
                {
                    $i++;
                    $j++;
                    $msg.= '
                    <tr>
                        <td class="text-right">'.$i.'</td>
                        <td class="text-right">'.$j.'</td>
                        <td class="text-right">'.$row_reagent["ReagentId"].'</td>
                        <td>'.$row_reagent["ReagentDescRus"].'</td>
                        <td class="text-right">'.$row_reagent["ReagentCount"].'</td>
                    </tr>
                    ';
                }
            }
        }
        $msg.= '
            <tr>
                <td colspan="4"><strong>Общее количество</strong></td>
                <!--<td></td>-->
                <!--<td></td>-->
                <!--<td></td>-->
                <td class="text-right"><strong>'.$total.'</strong></td>
            </tr>
        ';
    }
    
    $msg.= '
        </tbody>
    </table>
    ';
}
header("Content-Disposition: attachement; filename=reagentExpensesConsolidated.xls");
echo $msg;
?>
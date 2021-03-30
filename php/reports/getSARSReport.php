<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "extractArmenianName.php";

$msg = "";

if(!isset($_POST["startDate"]) || !isset($_POST["endDate"]))
{
    $msg .= "The reporting period is not defined.";
    echo $msg;
    return;
}
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

$startTime = "";
if(isset($_POST["startTime"]))
{
    $startTime = $_POST["startTime"];
}

$endTime = "";
if(isset($_POST["endTime"]))
{
    $endTime = $_POST["endTime"];
}

if(!isset($_POST["menuId"]))
{
    $msg .= "The menu id is not defined. menuId=".$_POST["menuId"];
    echo $msg;
    return;
}

if($_POST["BezSARSCheck"]=="true")
{
    $BezSARSCheck = 1;
}
elseif($_POST["BezSARSCheck"]=="false")
{
    $BezSARSCheck = 0;
}

if($_POST["onlyArmenian"]=="true")
{
    $onlyArmenian = 1;
}
elseif($_POST["onlyArmenian"]=="false")
{
    $onlyArmenian = 0;
}

$menuId = $_POST["menuId"];

$reportDescription = $startDate." ".$startTime."-ից ".$endDate." ".$endTime." ժամանակաշրջանի համար";
$filter = "";

$doctorId = $_POST["doctorId"];

if($uu == 764) {
	$doctorId = 6306;
}

if($doctorId > 0)
{
    $doctorId = $_POST["doctorId"];
	
	if($uu == 764) {
		$doctorId = 6306;
	}
	
    $sql_doctor = " SELECT 
                        FirstName,
                        LastName,
                        MidName
                    FROM doctor
                    WHERE DoctorId='".$doctorId."'";
    $result_doctor = mysqli_query($link,$sql_doctor);
    $doctorName = "";
    if($result_doctor)
    {
        $row_doctor = mysqli_fetch_array($result_doctor);
        $doctorName = $row_doctor["LastName"]." ".$row_doctor["FirstName"]." ".$row_doctor["MidName"];
    }
    $filter = "orders.DoctorId='".$doctorId."'";
    $reportDescription .= ", ըստ բժշկի` ".$doctorName." [ id:".$doctorId." ]";
}
else
{
    $filter = 1;
}

if($BezSARSCheck == 1) {
	if($filter != "1") {
		$filter .= " AND orders.is_bez_kov = '$BezSARSCheck' ";
	}
	else {
		$filter = " orders.is_bez_kov = '$BezSARSCheck' ";
	}
}

if($uu == 764) {
	$filter .= " AND orders.user_id='762' ";
}

//echo $filter;

if($menuId == "SARSLink")
{
    $msg.= '
    <h3>SARS-CoV-2 ռեագենտի ծախսը </h3>
    '.$reportDescription.'
    <table class="table table-bordered table-hover table-responsive" id="SARSData">
        <thead>
            <tr>
                <!-- 1. Patients First Name-->
                <th scope="col">Անուն</th>
                <!-- 2. Patients Last Name-->
                <th scope="col">Ազգանուն</th>
                <!-- 3. Patients Birthdate-->
                <th scope="col">Ծննդյան&nbsp;ամսաթիվ</th>
                <!-- 4. Social Security Number-->
                <th scope="col">ՀԾՀ</th>
                <!-- 5. Barcode-->
                <th scope="col">Բարկոդ</th>
                <!-- 6. Date-->
                <th scope="col">Ամսաթիվ</th>
                <!-- 7. Date of Response of the Task-->
                <th scope="col">Առաջադրանքի պատասխանի ամսաթիվ</th>
                <!-- 8. Response of Test-->
                <th scope="col">Թեստավորման պատասխան</th>
                <!-- 9. Test Date-->
                <th scope="col">Թեստավորման ամսաթիվ</th>
                <!-- 10. Sampling Date-->
                <th scope="col">Նմուշառման ամսաթիվ</th>
                <!-- 11. Double Testing Difference-->
                <th scope="col">Կրկնակի թեստավորման տարբերություն</th>
                <!-- 12. Double Testing-->
                <th scope="col">Կրկնակի թեստավորում</th>
                <!-- 13. Directing Institution-->
                <th scope="col">Ուղեգրող հաստատություն</th>
                <!-- 14. Registration Address-->
                <th scope="col">Գրանցման հասցե</th>
                <!-- 15. Residence Address-->
                <th scope="col">Բնակության հասցե</th>
                <!-- 16. OrderId-->
                <th scope="col">OrderId</th>
                <!-- 17. Row Number-->
                <th scope="col">Համար</th>
            </tr>
        </thead>
        <tbody>
        ';
    
    $sql = "SELECT 
                pacients.FirstName,
                pacients.LastName,
                pacients.birthday,
                pacients.dopolnitelno,
                orderresult.OrderId,
                orderresult.AnalysisResult,
                orders.DoctorId
            FROM 
            (
                SELECT * FROM 
                (
                    SELECT 
                        orderid, 
                        check_method AS reagent_id, 
                        chkk, 
                        check_date, 
                        block_or_dbl 
                    FROM quality_vvod_d 
                    WHERE 
                        check_date >= '".$startDate." ".$startTime."' AND 
                        check_date <= '".$endDate." ".$endTime."' AND 
                        chkk=1 AND 
                        block_or_dbl='dbl' AND
                        (check_method='1142' or check_method='1166')
                    ORDER BY orderid, check_method, check_date DESC
                ) AS r
                GROUP BY r.orderid, r.reagent_id
                ORDER BY r.orderid, r.reagent_id
            ) AS t
            INNER JOIN orders ON orders.OrderId=t.orderid
            INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
            INNER JOIN doctor ON orders.DoctorId=doctor.DoctorId
            INNER JOIN pacients ON orders.pac_id=pacients.id
            WHERE $filter
			GROUP BY t.orderid
            ORDER BY t.orderid
            ";
    //var_dump($sql);
    $result = mysqli_query($link, $sql);
    if($result)
    {
        $i = 0;
        while($row = mysqli_fetch_array($result))
        {
            $i++;
            $firstName = $row["FirstName"];
            $lastName = $row["LastName"];

            if($onlyArmenian == 1)
            {
                $firstName = extarctArmenianName($firstName);
                $lastName = extarctArmenianName($lastName);
            }
            
            $msg.= '
                <tr>
                    <!-- 1. Patients First Name-->
                    <td scope="col">'.$firstName.'</td>
                    <!-- 2. Patients Last Name-->
                    <td scope="col">'.$lastName.'</td>
                    <!-- 3. Patients Birtddate-->
                    <td scope="col">'.$row["birthday"].'</td>
                    <!-- 4. Social Security Number-->
                    <td scope="col"></td>
                    <!-- 5. Barcode-->
                    <td scope="col"></td>
                    <!-- 6. Date-->
                    <td scope="col"></td>
                    <!-- 7. Date of Response of tde Task-->
                    <td scope="col"></td>
                    <!-- 8. Response of Test-->
                    <td scope="col">';
                    if($row["AnalysisResult"]=="Դրական/ positive/ положительный")
                    {
                        $msg .= "Դրական";
                    }
                    elseif($row["AnalysisResult"]=="Բացասական/ negative/ отрицательный")
                    {
                        $msg .= "Բացասական";
                    }
            $msg.= '</td>
                    <!-- 9. Test Date-->
                    <td scope="col"></td>
                    <!-- 10. Sampling Date-->
                    <td scope="col"></td>
                    <!-- 11. Double Testing Difference-->
                    <td scope="col"></td>
                    <!-- 12. Double Testing-->
                    <td scope="col"></td>
                    <!-- 13. Directing Institution-->
                    <td scope="col">ՊՐՈՄ-ՏԵՍՏ ՍՊԸ</td>
                    <!-- 14. Registration Address-->
                    <td scope="col"></td>
                    <!-- 15. Residence Address-->
                    <td scope="col"></td>
                    <!-- 16. OrderId-->
                    <td scope="col">'.$row["OrderId"].'</td>
                    <!-- 17. Row Number-->
                    <td scope="col">'.$i.'</td>
                </tr>
            ';
        }
    }
    
    $msg.= '
        </tbody>
    </table>
    ';
}

echo $msg;
?>
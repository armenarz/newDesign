<?php
require_once "../connect.php";
require_once "../authorization.php";

//getting doctorId
if(isset($_POST["doctor_id"]))
{
	$doctorId = $_POST["doctor_id"];
}
else
{
	$msg = "Код доктора отсутствует";
	echo $msg;
	return;
}


$sql = "
SELECT * FROM doctor 
LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
LEFT JOIN sales ON doctor.sales_id = sales.salesId 
WHERE DoctorId='".$doctorId."'";

$result = mysqli_query($link,$sql);
if($result)
{
	$row = mysqli_fetch_array($result);

    $msg.= '
        <td><input type="radio" name="radioDoctor" value="'.$row["DoctorId"].'" aria-label="Выберите доктора"></td>
        <td scope="row"><strong></strong></td>
        <td>'.$row["DoctorId"].'</td>
        <td>'.$row["FirstName"].'</td>
        <td>'.$row["LastName"].'</td>
        <td>'.$row["MidName"].'</td>
        <td>'.$row["personality_type"].'</td>
        <td>'.$row["loyalty"].'</td>
        <td>'.$row["BirthDate"].'</td>
        <td>'.$row["Discount"].'</td>
        <td>'.$row["Phone1"].'</td>
        <td>'.$row["Phone2"].'</td>
        <td>'.$row["Phone3"].'</td>
        <td>'.$row["WorkPlaceDesc"].'</td>
        <td>'.$row["Comment"].'</td>
        <td>'.$row["wp"].'</td>
        <td>'.$row["salesName"].'</td>
        <td>'.$row["profession"].'</td>
        <td>
    ';
    if($row["active"] == 1) $msg.='active';
    else if($row["active"] == 0) $msg.='not active';
    $msg.= '
        </td>
    ';
}

echo $msg;
?>
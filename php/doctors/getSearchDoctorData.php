<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../shorten.php";

$arr = array();

$sql = "SELECT WorkPlaceId, WorkPlaceDesc FROM cworkplace";

$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $category = Shorten($row["WorkPlaceDesc"]);

        $sql_doctor = "SELECT DoctorId, FirstName, LastName, MidName FROM doctor WHERE WorkPlaceId='".$row['WorkPlaceId']."' ORDER BY DoctorId";
        $result_doctor = mysqli_query($link,$sql_doctor);
        if($result_doctor)
        {
            while($row_doctor = mysqli_fetch_array($result_doctor))
            {
                $arrIn = array();
                $label = FillNonBreak($row_doctor["DoctorId"],4).' '.$row_doctor["LastName"].' '.$row_doctor["FirstName"].' '.$row_doctor["MidName"]; 
                array_push($arrIn,$label);
                array_push($arrIn,$category);
                array_push($arr,$arrIn);
            }
        }
    }
}
$msg = json_encode($arr);

echo $msg;
return;
?>
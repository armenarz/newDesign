<?php
require_once "../connect.php";
require_once "../authorization.php";

if(isset($_POST["doctor_id"])) $doctor_id = $_POST["doctor_id"];
$sql = "SELECT * FROM doctor WHERE DoctorId='".$doctor_id."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $FirstName = $row["FirstName"];
    $LastName = $row["LastName"];
    $MidName = $row["MidName"];
}
//<!-- BEGIN HTML Markup -->
$msg =  '';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="DoctorIdDelete">DoctorId</label>';
$msg .=                 '<input type="text" id="DoctorIdDelete" class="form-control" placeholder="DoctorId" name="DoctorIdDelete" readonly value="'.$doctor_id.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="FirstNameDelete">FirstName</label>';
$msg .=             '<input type="text" id="FirstNameDelete" class="form-control" placeholder="FirstName" name="FirstNameDelete" readonly value="'.$FirstName.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="LastNameDelete">LastName</label>';
$msg .=             '<input type="text" id="LastNameDelete" class="form-control" placeholder="LastName" name="LastNameDelete" readonly value="'.$LastName.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="MidNameDelete">MidName</label>';
$msg .=             '<input type="text" id="MidNameDelete" class="form-control" placeholder="MidName" name="MidNameDelete" readonly value="'.$MidName.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';

echo $msg;
//<!-- END Tabs HTML Markup -->
?>
